# Poll Earning — Surveys, PTC News Views & Micro-Jobs Platform (Laravel)

[![Laravel](https://img.shields.io/badge/Laravel-9.x-FF2D20?style=flat&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=flat&logo=php)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)

An all-in-one Laravel 9 earning platform for **opinion surveys**, **paid news views (PTC)**, **micro jobs**, **referral commissions**, **plans/mining**, and an interactive **member community**. Members complete work, track two balances (main and bonus), deposit through automated/manual gateways, and withdraw through admin-approved methods. Administrators manage users, content, wallets, surveys, jobs, forums, and site settings.

## Stack

- PHP 8.2+, Laravel 9, MySQL
- Blade templates (`resources/views/templates/basic`)
- Payment SDKs: Stripe, Razorpay, Mollie, CoinGate
- Email: SendGrid, Mailjet
- Excel import/export for surveys
- Messenger package for member conversations

Default public template path: `templates.basic.*`  
Static assets: `assets/templates/basic/`

---

## Public website

| Feature | What it does |
|---|---|
| Premium marketing site | Dark luxury layout, gold accents, sticky nav, mobile menu, theme toggle (dark/light), cookie notice |
| Home | Live member/survey/job/payout stats, latest withdrawal ticker, earning channels, 4-step path, top balances, latest community posts |
| How it works | Product tour from register → verify → work → withdraw |
| Leaderboard | Public ranking by main balance and completed opinions (usernames only) |
| FAQ | Short answers for earning, plans, referrals, payouts, security |
| Member guide | Longer help content for bonuses, deposits and support |
| About | Mission, value creation and trust layer |
| Blog | Article list and detail pages with recent posts |
| Community | Searchable forum posts, votes, comments, member profiles |
| Contact / tickets | Contact form creates a support ticket with optional attachments |
| Newsletter | Footer email subscribe stored in `subscribers` |
| Payments page | Latest successful deposits and withdrawals |
| Language switch | `change-lang/{code}` |
| Policy pages | Dynamic footer/policy content |
| Auth | Split-screen login and register with password privacy and referral lock-in |

---

## Member workspace

### Wallet and account
- Dashboard cards for bonus, main balance, referrals, deposits, plan, withdrawals, opinions and jobs
- Daily check-in: $0.10 bonus once per calendar day, streak counter, sidebar action
- Quick links to opinions, news view, jobs and referrals
- Recent login history (IP, browser, time)
- Profile, password change, Google 2FA
- Email / SMS / 2FA authorization gates
- Notifications inbox with read-all
- Transaction log and commission log

### Opinion surveys
- List of active surveys with search
- Start survey (encrypted id), submit answers, history
- Plan-based daily survey limits
- Reward posted to main balance with a transaction remark

### News view (PTC)
- Browse ads, view, confirm, and collect the view reward
- Click history
- Publisher ads can debit the publisher wallet

### Micro jobs
- Start jobs, submit proof, job history
- Admin review (pending / submitted / reject / delete)

### Referrals and plans
- Unique referral URL, copy button, WhatsApp / Telegram / X share
- Referred user table (name, email, mobile, plan)
- Multi-level referral settings from admin
- Membership plans and buy-plan flow
- Mining / interest calculator, confirm plan, mining history

### Deposits and withdrawals
- Automatic and manual deposit gateways
- Deposit preview, confirm, history
- Withdraw bonus balance or main balance
- Withdraw preview, method fields, history

### Community and support
- Create / edit / delete posts, reactions, comments
- Private messages (threads)
- Support tickets: open, reply, download attachment

---

## Admin panel (`/admin`)

- Dashboard, cache clear, profile and password
- Users: active/banned, email/SMS status, search, impersonate login, add/sub balance, email one or all, login history, surveys, deposits, withdrawals, referrals, commissions
- Publisher users: PTC, surveys and micro jobs status
- Deposits: pending/approved/rejected, gateway and manual methods
- Withdrawals: pending/approved/rejected, withdraw methods
- Surveys: create, questions (multiple types), publish, results (pie, input, multi, yes/no, IQ, dropdown), import/export
- IQV tests, questions, publish and results
- Micro jobs moderation
- Forum categories, subcategories, posts (pending/approve/reject), comments
- Plans and user plans
- PTC ads and PTC view reports
- Referrals configuration
- Tickets, subscribers, messages
- Languages and translation keys
- General settings, logo/icon, plugins, SEO
- Email and SMS templates + test send
- Frontend section editor and page builder
- Reports: transactions, invest, referral commission

---

## New features added in this refresh

1. **Premium public UI** — modern dark/gold marketing site instead of the old store template  
2. **Dark / light theme toggle** stored in the browser  
3. **Cookie consent bar**  
4. **Live homepage stats** (members, surveys, jobs, ads, opinions, paid out)  
5. **Recent payout ticker**  
6. **Public leaderboard**  
7. **How it works** page  
8. **FAQ** page  
9. **Newsletter subscribe**  
10. **Community search**  
11. **Survey search**  
12. **Daily check-in + streak**  
13. **Dashboard quick actions and extra totals**  
14. **Referral social share**  
15. **Password show/hide** on login  
16. **Contact form CSRF** and optional multi-file attachments  
17. **This README** documents every product feature  

---

## Main routes

| URL | Name |
|---|---|
| `/` | `home` |
| `/how-it-works` | `how.it.works` |
| `/leaderboard` | `leaderboard` |
| `/faq` | `faq` |
| `/guide` | `guide` |
| `/community` | `post.all` |
| `/blog` | `blog` |
| `/contact` | `contact` |
| `/login` `/register` | `user.login` `user.register` |
| `/member/dashboard` | `user.home` |
| `/member/daily-checkin` | `user.checkin` |
| `/admin` | `admin.login` |

---

## Local setup

```bash
composer install
cp .env.example .env
php artisan key:generate
# set DB_* and APP_URL in .env
php artisan migrate
php artisan serve
```

Point the web root so `assets/` (sibling of `core/`) is publicly reachable, the same way the original deploy is configured.

Admin login lives at `/admin`. Member login lives at `/login`.

---

## Let's Build Something Exceptional

I'm actively open to: **Remote Senior Full-Stack Roles · Freelance Contracts · Technical Partnerships · Long-Term Collaborations**

in Laravel · WordPress · React/Next.js · AI-powered Platforms · Security Audits · SaaS Architecture

- Timezone: **UTC+6 (Dhaka/Rangpur)** — flexible overlap for US, EU & Asia
- Available: **Immediately** · Production-first · Fast delivery · Transparent communication

| Platform | Link |
|---|---|
| Portfolio | [imrandev.bd](https://imrandev.bd) |
| LinkedIn | [linkedin.com/in/imranbru99](https://linkedin.com/in/imranbru99) |
| GitHub | [github.com/imranbru99](https://github.com/imranbru99) |
| X / Twitter | [@imrandev_bd](https://x.com/imrandev_bd) |
| YouTube | [@ImranDevBD](https://youtube.com/@ImranDevBD) |
| Instagram | [@imranbru99](https://instagram.com/imranbru99) |
| Facebook | [ExpertImranDev](https://facebook.com/ExpertImranDev) |
| TikTok | [@imrandev_bd](https://tiktok.com/@imrandev_bd) |
| Threads | [@imranbru99](https://www.threads.net/@imranbru99) |
| Pinterest | [@imrandev_bd](https://pinterest.com/imrandev_bd) |
| WhatsApp | [+880 1576-918420](https://wa.me/8801576918420) |
| Email | [me@imrandev.bd](mailto:me@imrandev.bd) |
| All Links | [linktr.ee/ExpertImranDev](https://linktr.ee/ExpertImranDev) |

> "Security isn't an add-on — it's the foundation. Scale, speed, and trust drive every line of code I write."
>
> — Imran Ahmed
