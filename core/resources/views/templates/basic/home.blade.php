@extends($activeTemplate . 'layouts.master')
@section('content')
    <section class="hero">
        <div class="container">
            <div class="hero-grid">
                <div>
                    <div class="kicker">Poll • News • Microjobs • Referrals</div>
                    <h1>Earn from your <span>opinion</span> with a premium workspace.</h1>
                    <p class="lead">Complete surveys, view news, finish micro jobs, and grow a referral network. Track balances, withdraw securely, and climb the public leaderboard.</p>
                    <div class="hero-cta">
                        @auth
                            <a class="btn-gold" href="{{ route('user.home') }}">Open dashboard</a>
                            <a class="btn-ghost" href="{{ route('user.survey') }}">Start a survey</a>
                        @else
                            <a class="btn-gold" href="{{ route('user.register') }}">Create free account</a>
                            <a class="btn-ghost" href="{{ route('how.it.works') }}">See how it works</a>
                        @endauth
                    </div>
                </div>
                <div class="hero-card">
                    <h3 style="margin-top:0">Live platform pulse</h3>
                    <p class="lead" style="font-size:15px">Transparent activity from members who already earn here.</p>
                    <div class="stat-row" style="margin-top:18px;grid-template-columns:1fr 1fr">
                        <div class="stat-card"><strong>{{ number_format($stats['members'] ?? 0) }}</strong><span>Active members</span></div>
                        <div class="stat-card"><strong>{{ number_format($stats['surveys'] ?? 0) }}</strong><span>Live opinions</span></div>
                        <div class="stat-card"><strong>{{ number_format($stats['jobs'] ?? 0) }}</strong><span>Micro jobs</span></div>
                        <div class="stat-card"><strong>${{ number_format($stats['paid'] ?? 0, 2) }}</strong><span>Paid out</span></div>
                    </div>
                </div>
            </div>
            <div class="stat-row">
                <div class="stat-card"><strong>{{ number_format($stats['ads'] ?? 0) }}</strong><span>News view ads</span></div>
                <div class="stat-card"><strong>{{ number_format($stats['opinions'] ?? 0) }}</strong><span>Completed opinions</span></div>
                <div class="stat-card"><strong>4</strong><span>Earning channels</span></div>
                <div class="stat-card"><strong>24/7</strong><span>Member support</span></div>
            </div>
        </div>
    </section>

    @if (($payouts ?? collect())->count())
        <div class="ticker">
            <div class="ticker-track">
                @foreach ($payouts as $payout)
                    <span class="ticker-item">{{ $payout->user->username ?? 'Member' }} withdrew <b>${{ number_format($payout->amount, 2) }}</b></span>
                @endforeach
                @foreach ($payouts as $payout)
                    <span class="ticker-item">{{ $payout->user->username ?? 'Member' }} withdrew <b>${{ number_format($payout->amount, 2) }}</b></span>
                @endforeach
            </div>
        </div>
    @endif

    <section class="section">
        <div class="container">
            <div class="section-title">
                <div class="kicker">Ways to earn</div>
                <h2>Four premium income streams</h2>
                <p>Use one channel or stack them. Your dashboard keeps bonus, main balance, deposits and withdrawals in one place.</p>
            </div>
            <div class="feature-grid">
                <a class="earn-card" href="{{ route('user.survey') }}">
                    <div class="earn-icon">01</div>
                    <h4>Opinion surveys</h4>
                    <p>Answer published polls and get paid per completed opinion, limited by your plan.</p>
                </a>
                <a class="earn-card" href="{{ route('user.ptc.index') }}">
                    <div class="earn-icon">02</div>
                    <h4>News view</h4>
                    <p>Read approved news ads, confirm the view, and collect PTC rewards in history.</p>
                </a>
                <a class="earn-card" href="{{ route('user.microJobs.index') }}">
                    <div class="earn-icon">03</div>
                    <h4>Micro jobs</h4>
                    <p>Submit proof for short tasks. Admins review, then credit approved work.</p>
                </a>
                <a class="earn-card" href="{{ route('user.referred') }}">
                    <div class="earn-icon">04</div>
                    <h4>Referral network</h4>
                    <p>Share your link, earn register bonuses, and take commission when your team grows.</p>
                </a>
            </div>
        </div>
    </section>

    <section class="section" style="padding-top:0">
        <div class="container">
            <div class="section-title">
                <div class="kicker">Simple path</div>
                <h2>From signup to payout</h2>
            </div>
            <div class="step-grid">
                <div class="glass-card"><h4>1. Create account</h4><p>Register with email, phone and optional referral code.</p></div>
                <div class="glass-card"><h4>2. Pick a plan</h4><p>Unlock higher survey limits and mining calculators.</p></div>
                <div class="glass-card"><h4>3. Complete work</h4><p>Surveys, news views, jobs and daily check-in.</p></div>
                <div class="glass-card"><h4>4. Withdraw</h4><p>Request bonus or main balance through approved methods.</p></div>
            </div>
        </div>
    </section>

    <section class="section" style="padding-top:0">
        <div class="container">
            <div class="section-title">
                <div class="kicker">Leaders</div>
                <h2>Top balances this week</h2>
            </div>
            <div class="leader-wrap">
                @forelse ($leaders ?? [] as $leader)
                    <div class="leader-row">
                        <div class="rank">#{{ $loop->iteration }}</div>
                        <div>
                            <strong>{{ $leader->username }}</strong>
                            <div style="color:var(--muted);font-size:13px">{{ $leader->fullname }}</div>
                        </div>
                        <div class="rank">${{ number_format($leader->balance, 2) }}</div>
                    </div>
                @empty
                    <div class="glass-card">Leaderboard will appear when members start earning.</div>
                @endforelse
            </div>
            <div class="hero-cta"><a class="btn-ghost" href="{{ route('leaderboard') }}">View full leaderboard</a></div>
        </div>
    </section>

    <section class="section" style="padding-top:0">
        <div class="container">
            <div class="section-title">
                <div class="kicker">Community</div>
                <h2>Latest member posts</h2>
            </div>
            <div class="post-grid">
                @forelse ($latestPosts ?? [] as $post)
                    <a class="glass-card" href="{{ route('post.details', ['slug' => slug($post->post_title), 'id' => $post->id]) }}">
                        <h4>{{ $post->post_title }}</h4>
                        <p>{{ \Illuminate\Support\Str::limit(strip_tags($post->description), 120) }}</p>
                        <span style="color:var(--gold)">Read thread →</span>
                    </a>
                @empty
                    <div class="glass-card">No community posts yet.</div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
