@extends($activeTemplate . 'layouts.master')
@section('content')
    <section class="page-hero">
        <div class="container">
            <div class="kicker">{{ $blog->created_at->format('d M Y') }}</div>
            <h1>{{ __($blog->data_values->title) }}</h1>
        </div>
    </section>
    <section class="section" style="padding-top:0">
        <div class="container">
            <div class="hero-grid">
                <article class="glass-card">
                    <img src="{{ asset('assets/images/frontend/blog/' . $blog->data_values->image) }}" alt="" style="border-radius:16px;margin-bottom:20px">
                    <div>{!! $blog->data_values->description !!}</div>
                </article>
                <aside>
                    <div class="glass-card">
                        <h4>Recent posts</h4>
                        @foreach ($blogs->sortByDesc('id')->take(5) as $recent)
                            <p><a href="{{ route('blogDetail', [$recent->id, slug($recent->data_values->title)]) }}" style="color:var(--gold)">{{ __($recent->data_values->title) }}</a></p>
                        @endforeach
                    </div>
                </aside>
            </div>
        </div>
    </section>
@endsection
