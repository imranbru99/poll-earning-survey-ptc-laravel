@extends($activeTemplate . 'layouts.master')
@section('content')
    <section class="page-hero">
        <div class="container">
            <div class="kicker">Support</div>
            <h1>Talk to the team.</h1>
            <p>Every contact message opens a support ticket so you can follow the conversation.</p>
        </div>
    </section>
    <section class="section" style="padding-top:0">
        <div class="container">
            <div class="hero-grid">
                <div class="glass-card">
                    <h3>Contact info</h3>
                    <p>WhatsApp: +17199643393</p>
                    <p>Email: contact@pollearning.com</p>
                    <p>Telegram: @pollearning</p>
                    <p>Need earning rules? Read the <a href="{{ route('faq') }}" style="color:var(--gold)">FAQ</a> first.</p>
                </div>
                <div class="form-card">
                    <form action="{{ route('contact.send') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <label>Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required>
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required>
                        <label>Subject</label>
                        <input type="text" name="subject" value="{{ old('subject') }}" required>
                        <label>Attachment (optional)</label>
                        <input type="file" name="attachments[]" multiple>
                        <label>Message</label>
                        <textarea name="message" rows="5" required>{{ old('message') }}</textarea>
                        <button class="btn-gold" type="submit" style="margin-top:18px">Send ticket</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
