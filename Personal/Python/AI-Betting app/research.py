import os
import json
import time
import hashlib
import re
import uuid
import threading
from dataclasses import dataclass
from urllib.parse import urlencode, urlparse

import requests
from bs4 import BeautifulSoup
from dotenv import load_dotenv
from flask import Flask, request, render_template_string, jsonify, redirect, url_for
from requests.adapters import HTTPAdapter
from urllib3.util.retry import Retry

try:
    from readability import Document
except Exception:
    Document = None

# Optional OpenAI extraction
OPENAI_AVAILABLE = False
try:
    from openai import OpenAI
    OPENAI_AVAILABLE = True
except Exception:
    OPENAI_AVAILABLE = False


# -----------------------------
# Config
# -----------------------------
load_dotenv()

SERPAPI_KEY = os.getenv("SERPAPI_KEY")
OPENAI_API_KEY = os.getenv("OPENAI_API_KEY")

USER_AGENT = "Mozilla/5.0 (compatible; SportsResearchBot/1.0)"
HEADERS = {"User-Agent": USER_AGENT, "Accept-Language": "en-CA,en;q=0.9"}

CACHE_DIR = "cache_pages"
os.makedirs(CACHE_DIR, exist_ok=True)

TRUSTED_DOMAINS = {
    "uefa.com": 0.95,
    "fifa.com": 0.95,
    "reuters.com": 0.95,
    "apnews.com": 0.9,
    "bbc.com": 0.88,
    "espn.com": 0.85,
    "skysports.com": 0.82,
    "theathletic.com": 0.8,
    "sportsnet.ca": 0.8,
    "tsn.ca": 0.8,
    "cbssports.com": 0.78,
    "nbcsports.com": 0.78,
}

# Make UWCL explicit so you don't accidentally pull Women's results when you meant Men's (or vice versa)
SPORTS_MENU = {
    "Soccer": ["UEFA Women's Champions League", "UEFA Champions League", "EPL", "MLS"],
    "Basketball": ["NBA", "WNBA", "NCAAB"],
    "Hockey": ["NHL"],
    "Football": ["NFL", "NCAAF"],
    "Baseball": ["MLB"],
    "MMA": ["UFC"],
}

TEAM_VS_REGEX = re.compile(
    r"(?P<a>[A-Za-z0-9\.\-\&' ]{3,})\s+(vs\.?|v\.?)\s+(?P<b>[A-Za-z0-9\.\-\&' ]{3,})",
    re.IGNORECASE
)

INJURY_NEG = re.compile(
    r"\b(ruled out|out|doubtful|questionable|injur(ed|y)|concussion|hamstring|ankle|knee|suspension|suspended)\b",
    re.I
)
INJURY_POS = re.compile(r"\b(cleared|available|returns?|back in (the )?lineup|expected to play|fit)\b", re.I)
OPINION = re.compile(r"\b(prediction|pick|best bet|lean|tip|preview|match preview)\b", re.I)


@dataclass
class SourceDoc:
    title: str
    url: str
    snippet: str
    text: str
    domain: str
    trust: float


# -----------------------------
# Requests session with retries
# -----------------------------
def make_session() -> requests.Session:
    session = requests.Session()
    retry = Retry(
        total=3,
        backoff_factor=0.8,
        status_forcelist=(429, 500, 502, 503, 504),
        allowed_methods=("GET",),
    )
    adapter = HTTPAdapter(max_retries=retry)
    session.mount("http://", adapter)
    session.mount("https://", adapter)
    return session

SESSION = make_session()

OPENAI_CLIENT = None
if OPENAI_AVAILABLE and OPENAI_API_KEY:
    OPENAI_CLIENT = OpenAI(api_key=OPENAI_API_KEY)


# -----------------------------
# Progress job store
# -----------------------------
JOBS = {}
JOBS_LOCK = threading.Lock()

def job_init(job_id: str):
    with JOBS_LOCK:
        JOBS[job_id] = {
            "status": "starting",
            "progress": 0,
            "done": False,
            "error": None,
            "result": None,
            "created_at": time.time()
        }

def job_update(job_id: str, *, status=None, progress=None, error=None, result=None, done=None):
    with JOBS_LOCK:
        j = JOBS.get(job_id)
        if not j:
            return
        if status is not None:
            j["status"] = status
        if progress is not None:
            j["progress"] = int(max(0, min(100, progress)))
        if error is not None:
            j["error"] = error
        if result is not None:
            j["result"] = result
        if done is not None:
            j["done"] = bool(done)

def job_get(job_id: str):
    with JOBS_LOCK:
        return JOBS.get(job_id)


# -----------------------------
# Utilities
# -----------------------------
def domain_of(url: str) -> str:
    return urlparse(url).netloc.lower().replace("www.", "")

def trust_score(domain: str) -> float:
    base = 0.55
    for d, score in TRUSTED_DOMAINS.items():
        if domain == d or domain.endswith("." + d):
            return score
    return base

def cache_path(url: str) -> str:
    h = hashlib.sha256(url.encode("utf-8")).hexdigest()[:24]
    return os.path.join(CACHE_DIR, f"{h}.json")

def clamp(x: float, lo: float, hi: float) -> float:
    return max(lo, min(hi, x))

def normalize_team_name(team):
    if isinstance(team, str):
        return team.strip()
    if isinstance(team, dict):
        for key in ("name", "team", "title", "short_name"):
            val = team.get(key)
            if isinstance(val, str) and val.strip():
                return val.strip()
    return None

def normalize_league_context(sport: str, league: str) -> str:
    """
    Prevent common mismatch:
    - User selects 'UEFA Champions League' but Serp returns Women's competition fixtures.
    """
    if sport.lower() != "soccer":
        return league

    l = (league or "").lower()
    if "women" in l:
        return "UEFA Women's Champions League"

    # If user chooses generic UCL, keep it as is (Men's), BUT:
    # your earlier results were UWCL. To avoid surprises, prefer explicit label.
    if l.strip() == "uefa champions league":
        return "UEFA Champions League"

    return league


# -----------------------------
# SerpAPI
# -----------------------------
def serpapi_search(query: str, num: int = 10) -> dict:
    if not SERPAPI_KEY:
        raise RuntimeError("Missing SERPAPI_KEY. Put it in .env")
    params = {"q": query, "engine": "google", "api_key": SERPAPI_KEY, "num": num}
    url = "https://serpapi.com/search.json?" + urlencode(params)
    r = SESSION.get(url, headers=HEADERS, timeout=30)
    r.raise_for_status()
    return r.json()


# -----------------------------
# Fetch + extract readable text
# -----------------------------
def fetch_page_text(url: str, timeout: int = 12) -> str:
    r = SESSION.get(url, headers=HEADERS, timeout=(5, timeout))
    r.raise_for_status()
    html = r.text

    if Document is not None:
        try:
            html = Document(html).summary()
        except Exception:
            pass

    soup = BeautifulSoup(html, "html.parser")
    for tag in soup(["script", "style", "noscript", "header", "footer", "nav", "aside"]):
        tag.decompose()

    text = soup.get_text(separator="\n")
    lines = [ln.strip() for ln in text.splitlines() if ln.strip()]
    return "\n".join(lines[:3500])

def fetch_with_cache(url: str) -> str:
    path = cache_path(url)
    if os.path.exists(path):
        with open(path, "r", encoding="utf-8") as f:
            return json.load(f)["text"]

    text = fetch_page_text(url)
    with open(path, "w", encoding="utf-8") as f:
        json.dump({"url": url, "text": text}, f, ensure_ascii=False)
    return text


# -----------------------------
# Multi-query research pack
# -----------------------------
def build_research_pack(queries, num_sources_per_query: int = 8, delay: float = 0.18, max_total: int = 30) -> list[SourceDoc]:
    if isinstance(queries, str):
        queries = [queries]

    docs: list[SourceDoc] = []
    seen_urls = set()

    for q in queries:
        data = serpapi_search(q, num=num_sources_per_query)
        raw_results = data.get("organic_results", [])[:num_sources_per_query]

        for res in raw_results:
            title = (res.get("title") or "").strip()
            url = (res.get("link") or "").strip()
            snippet = (res.get("snippet") or "").strip()
            if not url or url in seen_urls:
                continue

            dom = domain_of(url)
            trust = trust_score(dom)

            try:
                text = fetch_with_cache(url)
                docs.append(SourceDoc(title=title, url=url, snippet=snippet, text=text, domain=dom, trust=trust))
                seen_urls.add(url)
            except Exception:
                continue

            time.sleep(delay)
            if len(docs) >= max_total:
                break

        if len(docs) >= max_total:
            break

    docs.sort(key=lambda d: d.trust, reverse=True)
    return docs


# -----------------------------
# Upcoming matches
# -----------------------------
def extract_upcoming_matches_from_serp(league: str, sport: str, limit: int = 12) -> list[dict]:
    league_ctx = normalize_league_context(sport, league)

    queries = [
        f"{league_ctx} fixtures",
        f"{league_ctx} schedule",
        f"site:uefa.com {league_ctx} fixtures" if sport.lower() == "soccer" and "uefa" in league_ctx.lower() else f"{league_ctx} fixtures",
        f"{league_ctx} upcoming matches",
    ]

    matches = []
    seen = set()

    for q in queries:
        data = serpapi_search(q, num=10)

        sr = data.get("sports_results") or {}
        games = sr.get("games") if isinstance(sr, dict) else None

        if isinstance(games, list) and games:
            for g in games:
                teams = g.get("teams") or g.get("team_names") or []

                raw_home = g.get("home_team") or (teams[1] if len(teams) > 1 else None)
                raw_away = g.get("away_team") or (teams[0] if len(teams) > 0 else None)

                home = normalize_team_name(raw_home)
                away = normalize_team_name(raw_away)

                matchup = g.get("matchup") or g.get("name") or ""
                when = g.get("start_time") or g.get("date") or g.get("time") or g.get("commence_time") or ""

                if (not home or not away) and matchup:
                    m = TEAM_VS_REGEX.search(matchup)
                    if m:
                        away = away or m.group("a").strip()
                        home = home or m.group("b").strip()

                if not home or not away:
                    continue

                key = (away.lower(), home.lower(), str(when).strip().lower())
                if key in seen:
                    continue
                seen.add(key)

                matches.append({"home": home, "away": away, "when": str(when)})
                if len(matches) >= limit:
                    return matches[:limit]

        # fallback: snippet parsing (less reliable)
        organic = data.get("organic_results", [])[:10]
        for res in organic:
            snippet = (res.get("snippet") or "")
            title = (res.get("title") or "")
            text = f"{title}\n{snippet}"
            m = TEAM_VS_REGEX.search(text)
            if not m:
                continue
            a = m.group("a").strip()
            b = m.group("b").strip()

            key = (a.lower(), b.lower(), "")
            if key in seen:
                continue
            seen.add(key)

            matches.append({"home": b, "away": a, "when": ""})
            if len(matches) >= limit:
                return matches[:limit]

    return matches[:limit]


# -----------------------------
# Evidence scoring + optional LLM extraction
# -----------------------------
def keyword_signal_score(docs: list[SourceDoc], team: str) -> float:
    tname = team.lower()
    score = 0.0
    for d in docs[:18]:
        blob = (d.title + "\n" + d.snippet + "\n" + d.text[:1800]).lower()
        if tname not in blob:
            continue

        neg = len(INJURY_NEG.findall(blob))
        pos = len(INJURY_POS.findall(blob))
        opn = len(OPINION.findall(blob))

        score -= d.trust * (0.012 * neg)
        score += d.trust * (0.008 * pos)
        score += d.trust * (0.004 * opn)

    return clamp(score, -0.20, 0.20)

def llm_extract_facts(docs: list[SourceDoc], team_a: str, team_b: str, league: str) -> dict:
    if not OPENAI_CLIENT:
        return {"injuries": [], "opinions": []}

    packed = []
    for d in docs[:10]:
        packed.append({
            "url": d.url,
            "domain": d.domain,
            "trust": d.trust,
            "title": d.title,
            "snippet": d.snippet,
            "text": d.text[:1400],
        })

    schema_prompt = f"""
Extract ONLY from the provided sources. No guessing.
Match: "{team_a} vs {team_b}" | League: "{league}"

Return STRICT JSON:
{{
  "injuries": [
    {{
      "team": "string",
      "player": "string",
      "status": "out|doubtful|questionable|probable|returns|unknown",
      "evidence": "short phrase from text",
      "url": "source url",
      "confidence": 0.0-1.0
    }}
  ],
  "opinions": [
    {{
      "lean": "{team_a}|{team_b}|unknown",
      "reason": "short phrase grounded in text",
      "url": "source url",
      "confidence": 0.0-1.0
    }}
  ]
}}
Rules:
- Use only what is explicitly stated in sources.
- If unclear, set status/lean to "unknown".
"""

    resp = OPENAI_CLIENT.responses.create(
        model="gpt-4.1-mini",
        input=[
            {"role": "system", "content": "You output only valid JSON. No extra text."},
            {"role": "user", "content": schema_prompt + "\n\nSOURCES:\n" + json.dumps(packed, ensure_ascii=False)}
        ],
        temperature=0
    )
    txt = resp.output_text.strip()
    try:
        return json.loads(txt)
    except Exception:
        return {"injuries": [], "opinions": []}

def summarize_evidence(docs: list[SourceDoc], max_items: int = 7) -> list[dict]:
    evidence = []
    for d in docs[:max_items]:
        bullet = d.snippet or (d.text.splitlines()[0] if d.text else "")
        if not bullet:
            continue
        evidence.append({
            "domain": d.domain,
            "trust": d.trust,
            "bullet": bullet[:220],
            "url": d.url
        })
    return evidence

def build_match_queries(team_a: str, team_b: str, league: str, sport: str) -> list[str]:
    league_ctx = normalize_league_context(sport, league)
    match = f"{team_a} vs {team_b}"
    base = [
        f"{match} injury report {league_ctx}",
        f"{match} team news {league_ctx}",
        f"{match} predicted lineup {league_ctx}",
        f"{match} preview {league_ctx}",
        f"{match} prediction {league_ctx}",
        f"{match} best bet {league_ctx}",
        f"{match} odds {league_ctx}",
        f"{team_a} form last 5 {league_ctx}",
        f"{team_b} form last 5 {league_ctx}",
    ]
    if sport.lower() == "soccer" and "uefa" in league_ctx.lower():
        base.append(f"site:uefa.com {match} {league_ctx}")
    return base

def consensus_winner_from_docs(docs: list[SourceDoc], team_a: str, team_b: str) -> tuple[str, float]:
    a = team_a.lower()
    b = team_b.lower()
    a_votes = 0.0
    b_votes = 0.0

    for d in docs[:22]:
        blob = (d.title + "\n" + d.snippet + "\n" + d.text[:1400]).lower()
        if not OPINION.search(blob):
            continue

        a_count = blob.count(a)
        b_count = blob.count(b)

        if a_count > b_count:
            a_votes += d.trust
        elif b_count > a_count:
            b_votes += d.trust

    total = a_votes + b_votes
    if total <= 0:
        return ("PASS", 0.0)

    winner = team_a if a_votes >= b_votes else team_b
    strength = abs(a_votes - b_votes) / total  # 0..1
    return (winner, strength)

def pick_for_match(team_a: str, team_b: str, league: str, sport: str) -> dict:
    queries = build_match_queries(team_a, team_b, league, sport)

    docs = build_research_pack(
        queries=queries[:9],
        num_sources_per_query=8,
        delay=0.18,
        max_total=30
    )

    if len(docs) < 3:
        return {
            "match": f"{team_a} vs {team_b}",
            "verdict": "PASS",
            "pick": "PASS",
            "confidence": 0.0,
            "signals": {team_a: 0.0, team_b: 0.0},
            "reason": "Not enough sources returned for this matchup.",
            "evidence": summarize_evidence(docs, max_items=5),
            "extracted_facts": None,
        }

    a_sig = keyword_signal_score(docs, team_a)
    b_sig = keyword_signal_score(docs, team_b)

    facts = llm_extract_facts(docs, team_a, team_b, league) if OPENAI_CLIENT else {"injuries": [], "opinions": []}

    op_nudge_a = 0.0
    op_nudge_b = 0.0
    for op in facts.get("opinions", [])[:10]:
        lean = (op.get("lean") or "unknown").strip()
        conf = float(op.get("confidence") or 0.0)
        if lean == team_a:
            op_nudge_a += 0.02 * conf
        elif lean == team_b:
            op_nudge_b += 0.02 * conf

    op_nudge_a = clamp(op_nudge_a, -0.07, 0.07)
    op_nudge_b = clamp(op_nudge_b, -0.07, 0.07)

    edge_a = a_sig + op_nudge_a - (b_sig * 0.20)
    edge_b = b_sig + op_nudge_b - (a_sig * 0.20)

    best_edge = max(edge_a, edge_b)
    winner = team_a if edge_a >= edge_b else team_b

    PASS_THRESHOLD = 0.008

    if best_edge < PASS_THRESHOLD:
        consensus_pick, strength = consensus_winner_from_docs(docs, team_a, team_b)
        if consensus_pick == "PASS":
            verdict = "PASS"
            pick = "PASS"
            conf = 0.0
            reason = "Signals weak and no clear consensus from preview sources."
        else:
            verdict = "WINNER"
            pick = consensus_pick
            conf = clamp(0.25 + 0.55 * strength, 0.20, 0.75)
            reason = "Signals weak, but consensus from preview/prediction sources favored this side."
    else:
        verdict = "WINNER"
        pick = winner
        conf = clamp(best_edge * 5.0, 0.25, 0.92)
        reason = "Winner estimated from injuries/availability + preview signals + source trust."

    return {
        "match": f"{team_a} vs {team_b}",
        "verdict": verdict,
        "pick": pick,
        "confidence": round(conf, 3),
        "signals": {team_a: round(edge_a, 4), team_b: round(edge_b, 4)},
        "reason": reason,
        "evidence": summarize_evidence(docs, max_items=7),
        "extracted_facts": facts if OPENAI_CLIENT else None,
    }


# -----------------------------
# Flask app templates
# -----------------------------
app = Flask(__name__)

TEMPLATE = """
<!doctype html>
<html>
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Sports Picks Research</title>
  <style>
    body{font-family:system-ui,-apple-system,Segoe UI,Roboto,Arial; margin:24px; background:#0b0f17; color:#e7eefc;}
    .card{background:#121a2a; border:1px solid #1f2a44; border-radius:14px; padding:16px; margin:14px 0;}
    .row{display:flex; gap:12px; flex-wrap:wrap;}
    label{display:block; font-size:12px; opacity:.85; margin-bottom:6px;}
    select,input{padding:10px 12px; border-radius:10px; border:1px solid #2a3a63; background:#0f1626; color:#e7eefc;}
    button{padding:10px 14px; border-radius:10px; border:1px solid #2a3a63; background:#1a2a55; color:#e7eefc; cursor:pointer;}
    button:hover{filter:brightness(1.1);}
    .tag{display:inline-block; padding:4px 8px; border-radius:999px; border:1px solid #2a3a63; margin-right:8px; font-size:12px;}
    .winner-badge{display:inline-block; padding:6px 10px; border-radius:999px; border:1px solid #2a3a63; background:#14301d; font-weight:700;}
    .pass-badge{display:inline-block; padding:6px 10px; border-radius:999px; border:1px solid #2a3a63; background:#2a1a12; font-weight:700;}
    a{color:#9fc2ff; text-decoration:none;}
    a:hover{text-decoration:underline;}
    .muted{opacity:.8;}
    .error{color:#ffb4b4;}

    .progress-wrap{margin-top:12px; display:none;}
    .progress-outer{height:14px; border-radius:999px; border:1px solid #2a3a63; background:#0f1626; overflow:hidden;}
    .progress-inner{height:100%; width:0%; background:#2d6cdf; transition: width 0.25s ease;}
    .progress-text{margin-top:8px; font-size:13px; opacity:.85;}
  </style>
</head>
<body>
  <h1>Sports Picks Research</h1>
  <p class="muted">Web-evidence based suggestions (SerpAPI). Not guaranteed winners.</p>

  <div class="card">
      <div class="row">
        <div>
          <label>Sport</label>
          <select id="sport" required>
            {% for s in sports %}
              <option value="{{s}}" {% if s==sport %}selected{% endif %}>{{s}}</option>
            {% endfor %}
          </select>
        </div>

        <div>
          <label>League</label>
          <select id="league" required>
            {% for l in leagues %}
              <option value="{{l}}" {% if l==league %}selected{% endif %}>{{l}}</option>
            {% endfor %}
          </select>
        </div>

        <div>
          <label># Winners</label>
          <input id="num_picks" type="number" min="1" max="25" value="{{num_picks}}" required/>
        </div>

        <div style="align-self:end;">
          <button id="genBtn">Generate</button>
        </div>
      </div>

      <div class="progress-wrap" id="progressWrap">
        <div class="progress-outer">
          <div class="progress-inner" id="progressBar"></div>
        </div>
        <div class="progress-text" id="progressText">Starting…</div>
      </div>

      {% if error %}
        <p class="error">{{error}}</p>
      {% endif %}
  </div>

<script>
const SPORTS_MENU = {{ sports_menu_json | safe }};

function repopulateLeagues() {
  const sportSel = document.getElementById("sport");
  const leagueSel = document.getElementById("league");
  const sport = sportSel.value;
  const leagues = SPORTS_MENU[sport] || [];
  const current = leagueSel.value;

  leagueSel.innerHTML = "";
  for (const l of leagues) {
    const opt = document.createElement("option");
    opt.value = l; opt.textContent = l;
    if (l === current) opt.selected = true;
    leagueSel.appendChild(opt);
  }
  if (!leagueSel.value && leagues.length) leagueSel.value = leagues[0];
}
document.getElementById("sport").addEventListener("change", repopulateLeagues);

async function startJob() {
  const sport = document.getElementById("sport").value;
  const league = document.getElementById("league").value;
  const num_picks = parseInt(document.getElementById("num_picks").value || "5", 10);

  const btn = document.getElementById("genBtn");
  btn.disabled = true;
  btn.textContent = "Working…";

  const wrap = document.getElementById("progressWrap");
  const bar = document.getElementById("progressBar");
  const text = document.getElementById("progressText");
  wrap.style.display = "block";
  bar.style.width = "0%";
  text.textContent = "Starting…";

  const res = await fetch("/api/start", {
    method: "POST",
    headers: {"Content-Type": "application/json"},
    body: JSON.stringify({sport, league, num_picks})
  });
  const data = await res.json();

  if (!res.ok) {
    text.textContent = data.error || "Failed to start job";
    btn.disabled = false;
    btn.textContent = "Generate";
    return;
  }

  const job_id = data.job_id;

  const poll = setInterval(async () => {
    const sres = await fetch(`/api/status/${job_id}`);
    const sdata = await sres.json();

    if (!sres.ok) {
      text.textContent = sdata.error || "Error checking status";
      clearInterval(poll);
      btn.disabled = false;
      btn.textContent = "Generate";
      return;
    }

    bar.style.width = `${sdata.progress}%`;
    text.textContent = sdata.status;

    if (sdata.done) {
      clearInterval(poll);
      if (sdata.error) {
        text.textContent = sdata.error;
        btn.disabled = false;
        btn.textContent = "Generate";
      } else {
        window.location.href = `/results/${job_id}`;
      }
    }
  }, 450);
}

document.getElementById("genBtn").addEventListener("click", startJob);
</script>

</body>
</html>
"""

RESULTS_TEMPLATE = """
<!doctype html>
<html>
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Results</title>
  <style>
    body{font-family:system-ui,-apple-system,Segoe UI,Roboto,Arial; margin:24px; background:#0b0f17; color:#e7eefc;}
    .card{background:#121a2a; border:1px solid #1f2a44; border-radius:14px; padding:16px; margin:14px 0;}
    .tag{display:inline-block; padding:4px 8px; border-radius:999px; border:1px solid #2a3a63; margin-right:8px; font-size:12px;}
    .winner-badge{display:inline-block; padding:6px 10px; border-radius:999px; border:1px solid #2a3a63; background:#14301d; font-weight:700;}
    .pass-badge{display:inline-block; padding:6px 10px; border-radius:999px; border:1px solid #2a3a63; background:#2a1a12; font-weight:700;}
    a{color:#9fc2ff; text-decoration:none;}
    a:hover{text-decoration:underline;}
    .muted{opacity:.8;}
    .error{color:#ffb4b4;}
    button{padding:10px 14px; border-radius:10px; border:1px solid #2a3a63; background:#1a2a55; color:#e7eefc; cursor:pointer;}
    button:hover{filter:brightness(1.1);}
  </style>
</head>
<body>
  <h1>Results</h1>
  <p class="muted">{{sport}} — {{league}} — {{generated_at}}</p>

  <div class="card">
    <button onclick="window.location.href='/'">← Back</button>
    <span class="tag">Winners shown: <b>{{num_winners}}</b></span>
    <span class="tag">Passes: <b>{{num_passes}}</b></span>
  </div>

  {% if error %}
    <div class="card"><p class="error">{{error}}</p></div>
  {% endif %}

  {% if upcoming %}
    <div class="card">
      <h2>Upcoming Matches</h2>
      <ol>
        {% for m in upcoming %}
          <li>{{m.away}} vs {{m.home}}{% if m.when %} <span class="muted">({{m.when}})</span>{% endif %}</li>
        {% endfor %}
      </ol>
    </div>
  {% endif %}

  {% if picks %}
    <div class="card">
      <h2>Winner Picks</h2>
      {% for p in picks %}
        <div class="card" style="background:#0f1626;">
          <div>
            <span class="winner-badge">🏆 Predicted Winner: {{p.pick}}</span>
            <span class="tag">Confidence: <b>{{p.confidence}}</b></span>
          </div>

          <h3 style="margin-top:10px;">{{p.match}}</h3>
          <p class="muted">{{p.reason}}</p>
          <p class="muted">Signals: {{p.signals}}</p>

          <h4>Evidence</h4>
          <ul>
            {% for ev in p.evidence %}
              <li>
                <span class="muted">({{ev.domain}} | trust {{ev.trust}})</span>
                {{ev.bullet}}
                — <a href="{{ev.url}}" target="_blank" rel="noopener">source</a>
              </li>
            {% endfor %}
          </ul>
        </div>
      {% endfor %}
    </div>
  {% endif %}

  {% if passes %}
    <div class="card">
      <h2>Passes</h2>
      {% for p in passes %}
        <div class="card" style="background:#0f1626;">
          <div>
            <span class="pass-badge">⛔ PASS</span>
            <span class="tag">Why: <b>{{p.reason}}</b></span>
          </div>
          <h3 style="margin-top:10px;">{{p.match}}</h3>
          <p class="muted">Signals: {{p.signals}}</p>
        </div>
      {% endfor %}
    </div>
  {% endif %}
</body>
</html>
"""


# -----------------------------
# Routes
# -----------------------------
@app.route("/", methods=["GET"])
def index():
    sport = request.args.get("sport") or "Soccer"
    leagues = SPORTS_MENU.get(sport, ["UEFA Women's Champions League"])
    league = request.args.get("league") or leagues[0]
    if league not in leagues:
        league = leagues[0]

    try:
        num_picks = int(request.args.get("num_picks") or 5)
    except Exception:
        num_picks = 5
    num_picks = max(1, min(25, num_picks))

    return render_template_string(
        TEMPLATE,
        sports=list(SPORTS_MENU.keys()),
        sport=sport,
        leagues=leagues,
        league=league,
        num_picks=num_picks,
        error=None,
        sports_menu_json=json.dumps(SPORTS_MENU),
    )


def run_generation_job(job_id: str, sport: str, league: str, num_picks: int):
    try:
        job_update(job_id, status="Finding upcoming matches…", progress=5)
        upcoming = extract_upcoming_matches_from_serp(league=league, sport=sport, limit=12)

        if not upcoming:
            out = {
                "sport": sport,
                "league": league,
                "generated_at": time.strftime("%Y-%m-%d %H:%M:%S"),
                "upcoming": [],
                "picks": [],
                "passes": [],
                "all_results": [],
            }
            job_update(job_id, status="No upcoming matches found. Try another league.", progress=100, result=out, done=True)
            return

        max_to_process = min(len(upcoming), max(6, num_picks * 2))
        results = []

        job_update(job_id, status=f"Researching {max_to_process} matches…", progress=10)

        for i, m in enumerate(upcoming[:max_to_process], 1):
            home = normalize_team_name(m.get("home")) or ""
            away = normalize_team_name(m.get("away")) or ""
            if not home or not away:
                continue

            job_update(
                job_id,
                status=f"Analyzing {away} vs {home} ({i}/{max_to_process})…",
                progress=10 + int((i / max_to_process) * 75),
            )

            res = pick_for_match(away, home, league, sport)
            results.append(res)

        job_update(job_id, status="Ranking winners + collecting passes…", progress=90)

        winners = [r for r in results if r.get("verdict") == "WINNER"]
        passes = [r for r in results if r.get("verdict") == "PASS"]

        winners.sort(key=lambda x: x.get("confidence", 0.0), reverse=True)
        picks = winners[:num_picks]

        out = {
            "sport": sport,
            "league": league,
            "generated_at": time.strftime("%Y-%m-%d %H:%M:%S"),
            "upcoming": upcoming,
            "picks": picks,
            "passes": passes,
            "all_results": results,
        }

        with open(f"picks_report_{job_id}.json", "w", encoding="utf-8") as f:
            json.dump(out, f, indent=2, ensure_ascii=False)

        job_update(job_id, status="Done ✅", progress=100, result=out, done=True)

    except Exception as e:
        job_update(job_id, status="Error", progress=100, error=str(e), done=True)


@app.route("/api/start", methods=["POST"])
def api_start():
    payload = request.get_json(force=True, silent=True) or {}
    sport = payload.get("sport") or "Soccer"
    league = payload.get("league") or (SPORTS_MENU.get(sport, ["UEFA Women's Champions League"])[0])

    try:
        num_picks = int(payload.get("num_picks") or 5)
    except Exception:
        num_picks = 5
    num_picks = max(1, min(25, num_picks))

    if sport not in SPORTS_MENU:
        return jsonify({"error": "Invalid sport"}), 400
    if league not in SPORTS_MENU[sport]:
        return jsonify({"error": "Invalid league for selected sport"}), 400

    job_id = uuid.uuid4().hex[:12]
    job_init(job_id)

    t = threading.Thread(target=run_generation_job, args=(job_id, sport, league, num_picks), daemon=True)
    t.start()

    return jsonify({"job_id": job_id})


@app.route("/api/status/<job_id>", methods=["GET"])
def api_status(job_id: str):
    j = job_get(job_id)
    if not j:
        return jsonify({"error": "Job not found"}), 404
    return jsonify({
        "status": j["status"],
        "progress": j["progress"],
        "done": j["done"],
        "error": j["error"]
    })


@app.route("/results/<job_id>", methods=["GET"])
def results(job_id: str):
    j = job_get(job_id)
    if not j:
        return "Job not found", 404
    if not j["done"]:
        return redirect(url_for("index"))
    if j["error"]:
        return render_template_string(
            RESULTS_TEMPLATE,
            sport="",
            league="",
            generated_at="",
            upcoming=[],
            picks=[],
            passes=[],
            num_winners=0,
            num_passes=0,
            error=j["error"]
        )

    out = j["result"] or {}
    picks = out.get("picks", [])
    passes = out.get("passes", [])

    return render_template_string(
        RESULTS_TEMPLATE,
        sport=out.get("sport", ""),
        league=out.get("league", ""),
        generated_at=out.get("generated_at", ""),
        upcoming=out.get("upcoming", []),
        picks=picks,
        passes=passes,
        num_winners=len(picks),
        num_passes=len(passes),
        error=None
    )


if __name__ == "__main__":
    # Run: python app.py
    # Open: http://127.0.0.1:5000
    app.run(debug=True, host="127.0.0.1", port=5000)
