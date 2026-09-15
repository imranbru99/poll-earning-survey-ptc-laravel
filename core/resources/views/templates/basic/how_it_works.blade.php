@extends($activeTemplate . 'layouts.master')
@section('content')
    <section class="page-hero">
        <div class="container">
            <div class="kicker">Product tour</div>
            <h1>How Poll Earning works</h1>
            <p>A short path from registration to your first approved payout.</p>
        </div>
    </section>
    <section class="section" style="padding-top:0">
        <div class="container">
            <div class="step-grid">
                <div class="glass-card"><h3>Register</h3><p>Create a member account. Use a referral code if you were invited.</p></div>
                <div class="glass-card"><h3>Verify</h3><p>Complete email or SMS checks and optionally turn on 2FA.</p></div>
                <div class="glass-card"><h3>Choose work</h3><p>Open Opinion, News View or Micro Jobs from the sidebar.</p></div>
                <div class="glass-card"><h3>Get paid</h3><p>Earnings land in main or bonus balance. Request a withdraw when you hit the method minimum.</p></div>
            </div>
            <div class="card-grid" style="margin-top:28px">
                <div class="glass-card">
                    <h4>Opinion</h4>
                    <p>Published surveys pay a set amount. History stores every completed attempt.</p>
                </div>
                <div class="glass-card">
                    <h4>News view</h4>
                    <p>Open an ad, wait for confirmation, then collect the view reward.</p>
                </div>
                <div class="glass-card">
                    <h4>Daily check-in</h4>
                    <p>Claim a small bonus once per day from the dashboard and keep a streak.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
