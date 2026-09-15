@extends($activeTemplate . 'layouts.master')
@section('content')
    <section class="page-hero">
        <div class="container">
            <div class="kicker">Journal</div>
            <h1>Insights for earners</h1>
            <p>Guides, product notes and earning education from the team.</p>
        </div>
    </section>
    <section class="section" style="padding-top:0">
        <div class="container">
            <div class="blog-grid">
                @forelse ($blogs as $blog)
                    <a class="glass-card" href="{{ route('blogDetail', [$blog->id, slug($blog->data_values->title)]) }}">
                        <img src="{{ get_image('assets/images/frontend/blog/' . $blog->data_values->image) }}" alt="{{ $blog->data_values->title }}" style="border-radius:16px;margin-bottom:16px">
                        <div class="kicker">{{ $blog->created_at->format('d M Y') }}</div>
                        <h3>{{ __($blog->data_values->title) }}</h3>
                        <p>{{ __($blog->data_values->preview) }}</p>
                        <span style="color:var(--gold)">Read article →</span>
                    </a>
                @empty
                    <div class="glass-card">No articles published yet.</div>
                @endforelse
            </div>
            <div class="mt-4">{{ $blogs->links($activeTemplate . 'paginate') }}</div>
        </div>
    </section>
@endsection
