@extends($activeTemplate . 'layouts.master')
@section('content')
    <section class="page-hero">
        <div class="container">
            <div class="kicker">Legal</div>
            <h1>{{ $page_title }}</h1>
        </div>
    </section>
    <section class="section" style="padding-top:0">
        <div class="container">
            <article class="glass-card">
                {!! $item->data_values->content !!}
            </article>
        </div>
    </section>
@endsection
