@extends($activeTemplate . 'layouts.master')
@section('content')
    <section class="page-hero">
        <div class="container">
            <div class="kicker">Rankings</div>
            <h1>Public leaderboard</h1>
            <p>Members ranked by current main balance. Usernames only — no private contact data.</p>
        </div>
    </section>
    <section class="section" style="padding-top:0">
        <div class="container">
            <div class="leader-wrap">
                @forelse ($leaders as $leader)
                    <div class="leader-row">
                        <div class="rank">#{{ $loop->iteration }}</div>
                        <div>
                            <strong>{{ $leader->username }}</strong>
                            <div style="color:var(--muted);font-size:13px">{{ $leader->opinions_count ?? 0 }} opinions completed</div>
                        </div>
                        <div class="rank">${{ number_format($leader->balance, 2) }}</div>
                    </div>
                @empty
                    <div class="glass-card">No ranking data yet.</div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
