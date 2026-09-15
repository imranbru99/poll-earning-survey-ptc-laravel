@extends($activeTemplate . 'layouts.master')
@section('content')
    <section class="page-hero">
        <div class="container">
            <div class="kicker">FAQ</div>
            <h1>Answers before you start earning.</h1>
            <p>Clear rules for surveys, referrals, deposits, withdrawals and support.</p>
        </div>
    </section>
    <section class="section" style="padding-top:0">
        <div class="container" style="max-width:860px">
            @php
                $faqs = [
                    ['How do I earn?', 'Complete opinion surveys, view news ads, finish micro jobs, claim daily check-in, and invite people with your referral link.'],
                    ['Do I need a plan?', 'A plan increases daily survey limits and unlocks mining tools. You can still try micro jobs without a paid plan.'],
                    ['How do referrals work?', 'Anyone who registers from your link is attached to you. You can earn a register bonus and commission when they deposit or buy a plan.'],
                    ['How fast are withdrawals?', 'Approved methods are reviewed by admin. Automated gateways can settle quickly after approval.'],
                    ['What is the minimum deposit or withdraw?', 'Typical minimum is $10, depending on the selected method.'],
                    ['How do I get help?', 'Open a support ticket from Contact or the member ticket menu. Attachments up to 2MB are accepted.'],
                    ['Is my account protected?', 'Enable email/SMS verification and Google 2FA from the member security page.'],
                ];
            @endphp
            @foreach ($faqs as $faq)
                <details class="faq-item">
                    <summary>{{ $faq[0] }}</summary>
                    <p>{{ $faq[1] }}</p>
                </details>
            @endforeach
        </div>
    </section>
@endsection
