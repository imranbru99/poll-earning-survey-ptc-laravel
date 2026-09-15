@extends($activeTemplate . 'layouts.master')
@section('content')
    <section class="page-hero">
        <div class="container">
            <div class="kicker">Member guide</div>
            <h1>Rules, bonuses and earning paths</h1>
            <p>The original help center, now presented in the premium layout. For a shorter version visit <a href="{{ route('faq') }}" style="color:var(--gold)">FAQ</a>.</p>
        </div>
    </section>
    <section class="section" style="padding-top:0">
        <div class="container" style="max-width:860px">
            <details class="faq-item" open>
                <summary>How to earn</summary>
                <ul>
                    <li>Opinion surveys</li>
                    <li>News view ads</li>
                    <li>Micro jobs</li>
                    <li>Referral commissions</li>
                    <li>Daily check-in and mining plans</li>
                </ul>
            </details>
            <details class="faq-item">
                <summary>Referral bonus</summary>
                <p>Share your link. Registration, plan purchases and deposits from your team can generate bonus and commission according to admin settings.</p>
            </details>
            <details class="faq-item">
                <summary>Deposits and withdrawals</summary>
                <p>Minimum amounts depend on the selected gateway or withdraw method. Track every request from the member wallet pages.</p>
            </details>
            <details class="faq-item">
                <summary>Support</summary>
                <p>Open a ticket from Contact or the Ticket menu. Attach images or PDF if needed.</p>
            </details>
        </div>
    </section>
@endsection
