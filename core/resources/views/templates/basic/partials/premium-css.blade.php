<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root {
    --navy: #071018;
    --ink: #0c1824;
    --panel: #122232;
    --line: rgba(232, 195, 106, 0.16);
    --gold: #e8c36a;
    --gold-2: #c9a24a;
    --teal: #3ee0c0;
    --paper: #f7f3ea;
    --muted: #93a0b3;
    --white: #f8f6f1;
    --shadow: 0 24px 60px rgba(3, 8, 16, 0.35);
    --radius: 22px;
}
[data-theme="light"] {
    --navy: #f6f2e9;
    --ink: #ffffff;
    --panel: #ffffff;
    --line: rgba(12, 24, 36, 0.08);
    --paper: #0c1824;
    --muted: #5b6574;
    --white: #102033;
    --shadow: 0 18px 40px rgba(16, 32, 51, 0.08);
}
* { box-sizing: border-box; }
html { scroll-behavior: smooth; }
body.site-body {
    margin: 0;
    font-family: "Plus Jakarta Sans", sans-serif;
    background: radial-gradient(1200px 600px at 10% -10%, rgba(232,195,106,.12), transparent 45%),
                radial-gradient(900px 500px at 110% 10%, rgba(62,224,192,.08), transparent 40%),
                var(--navy);
    color: var(--white);
    min-height: 100vh;
}
a { color: inherit; text-decoration: none; }
img { max-width: 100%; }
.site-header {
    position: sticky;
    top: 0;
    z-index: 50;
    backdrop-filter: blur(18px);
    background: rgba(7, 16, 24, 0.78);
    border-bottom: 1px solid var(--line);
}
[data-theme="light"] .site-header { background: rgba(255,255,255,.86); }
.site-nav {
    display: flex;
    align-items: center;
    justify-content: space-between;
    min-height: 84px;
    gap: 20px;
}
.brand {
    display: flex;
    align-items: center;
    gap: 12px;
    font-weight: 800;
    letter-spacing: -.03em;
}
.brand img { height: 42px; width: auto; }
.nav-links {
    display: flex;
    align-items: center;
    gap: 8px;
    list-style: none;
    margin: 0;
    padding: 0;
}
.nav-links a {
    padding: 10px 14px;
    border-radius: 999px;
    color: var(--muted);
    font-weight: 600;
    font-size: 14px;
}
.nav-links a:hover, .nav-links a.active { color: var(--gold); background: rgba(232,195,106,.08); }
.nav-actions { display: flex; align-items: center; gap: 10px; }
.btn-gold, .btn-ghost, .btn-teal {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    border: 0;
    border-radius: 999px;
    padding: 12px 20px;
    font-weight: 700;
    cursor: pointer;
    transition: .25s ease;
}
.btn-gold { background: linear-gradient(135deg, var(--gold), var(--gold-2)); color: #1a1408; }
.btn-gold:hover { transform: translateY(-1px); box-shadow: 0 10px 24px rgba(232,195,106,.28); }
.btn-ghost { background: transparent; color: var(--white); border: 1px solid var(--line); }
.btn-teal { background: rgba(62,224,192,.12); color: var(--teal); }
.menu-toggle {
    display: none;
    background: transparent;
    border: 1px solid var(--line);
    color: var(--white);
    width: 44px;
    height: 44px;
    border-radius: 12px;
}
.hero {
    padding: 88px 0 40px;
    position: relative;
    overflow: hidden;
}
.hero:before {
    content: "";
    position: absolute;
    width: 420px;
    height: 420px;
    right: -80px;
    top: -80px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(232,195,106,.18), transparent 68%);
    pointer-events: none;
}
.hero-grid {
    display: grid;
    grid-template-columns: 1.15fr .85fr;
    gap: 48px;
    align-items: center;
}
.kicker {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 12px;
    border-radius: 999px;
    background: rgba(232,195,106,.1);
    color: var(--gold);
    font-size: 12px;
    font-weight: 700;
    letter-spacing: .12em;
    text-transform: uppercase;
}
.hero h1, .page-hero h1, .section-title h2 {
    font-size: clamp(36px, 5vw, 68px);
    line-height: 1.05;
    letter-spacing: -.04em;
    margin: 16px 0;
}
.hero h1 span { color: var(--gold); }
.lead { color: var(--muted); font-size: 18px; max-width: 560px; line-height: 1.7; }
.hero-cta { display: flex; gap: 12px; flex-wrap: wrap; margin: 28px 0 18px; }
.hero-card {
    background: linear-gradient(180deg, rgba(255,255,255,.06), rgba(255,255,255,.02));
    border: 1px solid var(--line);
    border-radius: 28px;
    padding: 24px;
    box-shadow: var(--shadow);
}
.stat-row, .feature-grid, .card-grid, .step-grid, .blog-grid, .post-grid {
    display: grid;
    gap: 18px;
}
.stat-row { grid-template-columns: repeat(4, 1fr); margin-top: 56px; }
.feature-grid { grid-template-columns: repeat(4, 1fr); }
.card-grid { grid-template-columns: repeat(3, 1fr); }
.step-grid { grid-template-columns: repeat(4, 1fr); }
.blog-grid, .post-grid { grid-template-columns: repeat(3, 1fr); }
.stat-card, .glass-card, .earn-card, .faq-item, .leader-row, .form-card {
    background: rgba(18, 34, 50, 0.72);
    border: 1px solid var(--line);
    border-radius: var(--radius);
}
[data-theme="light"] .stat-card,
[data-theme="light"] .glass-card,
[data-theme="light"] .earn-card,
[data-theme="light"] .faq-item,
[data-theme="light"] .leader-row,
[data-theme="light"] .form-card { background: #fff; }
.stat-card { padding: 22px; }
.stat-card strong { display: block; font-size: 28px; color: var(--gold); }
.stat-card span { color: var(--muted); font-size: 13px; }
.section { padding: 80px 0; }
.section-title { max-width: 640px; margin-bottom: 36px; }
.section-title p { color: var(--muted); }
.earn-card, .glass-card { padding: 26px; transition: .25s ease; }
.earn-card:hover, .glass-card:hover { transform: translateY(-4px); border-color: rgba(232,195,106,.4); }
.earn-icon {
    width: 52px; height: 52px; border-radius: 16px;
    display: grid; place-items: center;
    background: rgba(232,195,106,.12); color: var(--gold); font-size: 22px; margin-bottom: 16px;
}
.ticker {
    overflow: hidden;
    border-top: 1px solid var(--line);
    border-bottom: 1px solid var(--line);
    padding: 14px 0;
    white-space: nowrap;
}
.ticker-track { display: inline-flex; gap: 28px; animation: ticker 28s linear infinite; }
.ticker-item { color: var(--muted); font-size: 14px; }
.ticker-item b { color: var(--teal); }
@keyframes ticker { from { transform: translateX(0); } to { transform: translateX(-50%); } }
.page-hero { padding: 72px 0 28px; }
.page-hero p { color: var(--muted); max-width: 640px; }
.faq-item { margin-bottom: 12px; overflow: hidden; }
.faq-item summary {
    cursor: pointer; padding: 18px 22px; font-weight: 700; list-style: none;
}
.faq-item p, .faq-item ul { padding: 0 22px 20px; color: var(--muted); }
.leader-wrap { display: grid; gap: 12px; }
.leader-row {
    display: grid; grid-template-columns: 70px 1fr auto; align-items: center;
    padding: 16px 20px;
}
.rank { color: var(--gold); font-weight: 800; }
.search-bar {
    display: flex; gap: 10px; margin-bottom: 24px;
}
.search-bar input, .form-card input, .form-card textarea, .form-card select {
    width: 100%;
    background: rgba(255,255,255,.04);
    border: 1px solid var(--line);
    color: var(--white);
    border-radius: 14px;
    padding: 14px 16px;
}
.form-card { padding: 28px; }
.form-card label { display: block; margin: 14px 0 8px; font-weight: 600; }
.site-footer {
    margin-top: 80px;
    padding: 56px 0 24px;
    border-top: 1px solid var(--line);
    background: rgba(0,0,0,.18);
}
.footer-grid { display: grid; grid-template-columns: 1.4fr 1fr 1fr 1.2fr; gap: 28px; }
.site-footer h5 { margin: 0 0 14px; }
.site-footer a, .site-footer p { color: var(--muted); line-height: 1.8; }
.cookie-bar {
    position: fixed; left: 16px; right: 16px; bottom: 16px; z-index: 80;
    display: none; align-items: center; justify-content: space-between; gap: 16px;
    padding: 16px 20px; border-radius: 18px;
    background: #122232; border: 1px solid var(--line); box-shadow: var(--shadow);
}
.theme-fab, .to-top {
    position: fixed; right: 18px; z-index: 70; width: 46px; height: 46px;
    border-radius: 50%; border: 1px solid var(--line); background: var(--panel); color: var(--gold);
}
.theme-fab { bottom: 80px; }
.to-top { bottom: 24px; display: grid; place-items: center; }
.auth-shell {
    min-height: 100vh; display: grid; grid-template-columns: 1.05fr .95fr;
}
.auth-side {
    padding: 48px; display: flex; flex-direction: column; justify-content: space-between;
    background:
        linear-gradient(160deg, rgba(7,16,24,.2), rgba(7,16,24,.72)),
        url('{{ asset($activeTemplateTrue . "/assets/images/slider/1.jpg") }}') center/cover;
}
.auth-form-wrap { display: grid; place-items: center; padding: 40px 24px; }
.auth-card { width: min(440px, 100%); }
.dash-wrap .stat-row { grid-template-columns: repeat(3, 1fr); margin-top: 0; }
.quick-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin: 22px 0; }
.quick-grid a { padding: 16px; text-align: center; font-weight: 700; }
.checkin-box { display: flex; justify-content: space-between; align-items: center; gap: 16px; padding: 22px; margin-bottom: 22px; }
.main-panel .glass-card, .main-panel .stat-card, .main-panel .checkin-box, .main-panel .form-card {
    background: #fff;
    color: #122232;
    box-shadow: 0 12px 32px rgba(16,32,51,.08);
}
.main-panel .stat-card strong { color: #b8892d; }
.main-panel .kicker { color: #b8892d; }
@media (max-width: 991px) {
    .menu-toggle { display: grid; place-items: center; }
    .nav-links, .nav-actions { display: none; }
    .nav-links.open, .nav-actions.open {
        display: flex; flex-direction: column; width: 100%;
    }
    .site-nav { flex-wrap: wrap; }
    .hero-grid, .stat-row, .feature-grid, .card-grid, .step-grid, .blog-grid, .post-grid, .footer-grid, .auth-shell, .quick-grid, .dash-wrap .stat-row {
        grid-template-columns: 1fr;
    }
}
</style>
