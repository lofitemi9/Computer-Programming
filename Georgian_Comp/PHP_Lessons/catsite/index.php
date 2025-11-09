<?php
// attaching config.php that has api key
require_once __DIR__ . '\config.php';

// defining how a url should be structured according to the docs
function cat_api_request($endpoint, $params = [])
{
    $url = CAT_API_URL . $endpoint . (empty($params) ? '' : '?' . http_build_query($params));
    $ch = curl_init($url);
    curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_HTTPHEADER => ['x-api-key: ' . CAT_API_KEY]]);
    $res = curl_exec($ch);
    curl_close($ch);
    return json_decode($res, true);
}
$breeds = cat_api_request('/breeds') ?? [];
$first = cat_api_request('/images/search', ['limit' => 1, 'has_breeds' => 1]) ?? [];
$cat = $first[0] ?? null;
$breed = $cat['breeds'][0] ?? null;
?>


<!doctype html>

<html lang="en">

<head>
    <!-- metadata -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="This is a random cat generator website, every page refresh is a new cate">
    <title>Catcyclopedia</title>
    <!-- linking css page -->
    <link rel="stylesheet" href="assets/styles.css">
</head>

<body>
    <header>
        <h1>Catcyclopedia</h1>
    </header>

    <main>
        <section id="random">
            <!-- making the cat name appear above the image -->
            <h2><?= htmlspecialchars($breed['name']) ?></h2>
            <img id="catImg" src="<?= htmlspecialchars($cat['url'] ?? '') ?>" alt="Random Cat Generator">
            <div>
                <!-- reloads the page when butto nis clicked -->
                <button onclick="location.reload()" id="refreshBtn">Random Cat</button>
            </div>
            <div id="catDetails">
                <!-- displaying the cat details -->
                <?php if ($breed): ?>
                    <h3><?= htmlspecialchars($breed['name']) ?></h3>
                    <p><?= htmlspecialchars($breed['description']) ?></p>
                <?php endif; ?>
            </div>
        </section>

    </main>
</body>

</html>