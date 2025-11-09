# 📚 COMP1054 — Interface Design with CSS
## Midterm Practical Question - Version 2 
---

### 🎯 Overview
Build a **Course Dashboard** that showcases a custom web font with a **fluid type scale**, an accessible color palette, and appropriate line height. Use **Flexbox** for the site navigation and a **Grid** layout for the course cards.

You’ll demonstrate:
- Loading a **custom web font** with `font-display: swap` and fallbacks
- Designing **responsive typography** with `rem` and `clamp()`; unitless line-height
- **Accessible color contrast** using variables
- Appropriate use of **Flexbox** (nav) and **Grid** (cards)

---

### ✅ Requirements
- Add a custom web font (e.g., Google Fonts); set a robust font stack
- Define variable-driven colors in `:root`; ensure good text/background contrast.
- Establish a fluid typographic scale with `rem` and/or `clamp()`; keep line-height unitless.
- Header navigation should use **Flexbox** and wrap gracefully under tight space.
- Course cards should use **CSS Grid** and scale fluidly (e.g., `repeat(auto-fit, minmax(..., 1fr))`).
- Keep CSS semantic, clear, and maintainable (no `!important`).

---

### ✅ Submission Checklist
- [ ] Custom font loaded with `swap`; fallbacks declared
- [ ] Colors via variables; readable contrast
- [ ] Fluid type (clamp/rem) and unitless line-height
- [ ] Flexbox nav + Grid cards
- [ ] Comments and focus-visible styles present

---

### 🧮 Analytic Rubric (20 pts)

| **Area** | **Not Quite (1–2)** | **Good (3–4)** | **Awesome (5)** |
|----------|----------------------|----------------|-----------------|
| **Web Fonts & Typography** | No custom font; fixed px sizes | Font added; mostly rem-based | Font with `swap` + clamp scale; excellent hierarchy |
| **Color & Contrast** | Hard-coded colors; contrast issues | Mostly variable-driven; minor gaps | Fully tokenized; strong contrast throughout |
| **Layout (Flexbox & Grid)** | Misapplied layout; breakage | Works with small quirks | Smooth nav + fluid Grid cards |
| **Readability & Line Height** | Cramped or too loose | Generally readable | Unitless leading; comfortable measures |
| **CSS Structure & Practices** | Messy or redundant | Mostly clean and consistent | Semantic, modular, commented |

**Total:** /20 
