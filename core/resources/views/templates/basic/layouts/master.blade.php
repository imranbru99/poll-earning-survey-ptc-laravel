<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ $general->sitename($page_title) }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset(imagePath()['logoIcon']['path'] . '/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . '/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . '/assets/css/LineIcons.css') }}">
    @include($activeTemplate . 'partials.premium-css')
    @include('partials.seo')
    @stack('style-lib')
    @stack('style')
</head>
<body class="site-body" data-theme="dark">
    <header class="site-header">
        <div class="container">
            <nav class="site-nav">
                <a class="brand" href="{{ route('home') }}">
                    <img src="{{ asset(imagePath()['logoIcon']['path'] . '/logo.png') }}" alt="{{ $general->sitename }}">
                    <span>{{ $general->sitename }}</span>
                </a>
                <button class="menu-toggle" type="button" id="menuToggle" aria-label="Open menu">☰</button>
                <ul class="nav-links" id="navLinks">
                    <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
                    <li><a href="{{ route('how.it.works') }}">How it works</a></li>
                    <li><a href="{{ route('leaderboard') }}">Leaderboard</a></li>
                    <li><a href="{{ route('post.all') }}">Community</a></li>
                    @foreach ($pages as $page)
                        @if ($page->slug != 'home' && $page->slug != 'blog' && $page->slug != 'contact' && $page->slug != 'about')
                            <li><a href="{{ route('home.pages', $page->slug) }}">{{ __($page->name) }}</a></li>
                        @endif
                    @endforeach
                    <li><a href="{{ route('blog') }}">Blog</a></li>
                    <li><a href="{{ route('faq') }}">FAQ</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
                <div class="nav-actions" id="navActions">
                    @auth
                        <a class="btn-ghost" href="{{ route('user.home') }}">Dashboard</a>
                    @else
                        <a class="btn-ghost" href="{{ route('user.login') }}">Login</a>
                        <a class="btn-gold" href="{{ route('user.register') }}">Start earning</a>
                    @endauth
                </div>
            </nav>
        </div>
    </header>

    <main class="site-main">
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <a class="brand" href="{{ route('home') }}">
                        <img src="{{ asset(imagePath()['logoIcon']['path'] . '/logo.png') }}" alt="Logo">
                    </a>
                    <p class="mt-3">A premium poll, news-view, microjob and referral platform. Share opinions, complete tasks, and withdraw earnings with a professional member workspace.</p>
                </div>
                <div>
                    <h5>Earn</h5>
                    <p><a href="{{ route('user.survey') }}">Opinion surveys</a></p>
                    <p><a href="{{ route('user.ptc.index') }}">News view</a></p>
                    <p><a href="{{ route('user.microJobs.index') }}">Micro jobs</a></p>
                    <p><a href="{{ route('user.referred') }}">Referral program</a></p>
                </div>
                <div>
                    <h5>Help</h5>
                    <p><a href="{{ route('how.it.works') }}">How it works</a></p>
                    <p><a href="{{ route('faq') }}">FAQ</a></p>
                    <p><a href="{{ route('guide') }}">Member guide</a></p>
                    <p><a href="{{ route('about') }}">About</a></p>
                    <p><a href="{{ route('contact') }}">Support</a></p>
                </div>
                <div>
                    <h5>Newsletter</h5>
                    <p>Get earning tips and new survey alerts.</p>
                    <form action="{{ route('subscribe') }}" method="post" class="search-bar">
                        @csrf
                        <input type="email" name="email" placeholder="Your email" required>
                        <button class="btn-gold" type="submit">Join</button>
                    </form>
                    <p>WhatsApp: +17199643393<br>Email: contact@pollearning.com</p>
                </div>
            </div>
            <p class="text-center mt-5" style="color:var(--muted)">© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </footer>

    <div class="cookie-bar" id="cookieBar">
        <span>We use cookies to keep your session secure and improve earning reports.</span>
        <button class="btn-gold" type="button" id="acceptCookies">Accept</button>
    </div>
    <button class="theme-fab" type="button" id="themeToggle" title="Toggle theme">◐</button>
    <a href="#" class="to-top">↑</a>

    @include('admin.partials.notify')
    @include('partials.plugins')
    <script src="{{ asset($activeTemplateTrue . '/assets/js/vendor/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . '/assets/js/bootstrap.min.js') }}"></script>
    <script>
        (function () {
            var stored = localStorage.getItem('pe-theme') || 'dark';
            document.body.setAttribute('data-theme', stored);
            var toggle = document.getElementById('themeToggle');
            if (toggle) {
                toggle.addEventListener('click', function () {
                    var next = document.body.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
                    document.body.setAttribute('data-theme', next);
                    localStorage.setItem('pe-theme', next);
                });
            }
            var menu = document.getElementById('menuToggle');
            if (menu) {
                menu.addEventListener('click', function () {
                    document.getElementById('navLinks').classList.toggle('open');
                    document.getElementById('navActions').classList.toggle('open');
                });
            }
            if (!localStorage.getItem('pe-cookie')) {
                document.getElementById('cookieBar').style.display = 'flex';
            }
            document.getElementById('acceptCookies').addEventListener('click', function () {
                localStorage.setItem('pe-cookie', '1');
                document.getElementById('cookieBar').style.display = 'none';
            });
        })();
    </script>
    @stack('script-lib')
    @stack('script')
</body>
</html>
