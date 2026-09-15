@extends($activeTemplate . 'layouts.master')
@section('content')
    <section class="page-hero">
        <div class="container">
            <div class="kicker">Forum</div>
            <h1>{{ __($page_title) }}</h1>
            <p>Ask questions, share earning tips, and vote on member threads.</p>
        </div>
    </section>
    <section class="section" style="padding-top:0">
        <div class="container">
            <form class="search-bar" method="get" action="{{ route('post.all') }}">
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Search posts">
                <button class="btn-gold" type="submit">Search</button>
                @auth
                    <a class="btn-ghost" href="{{ route('user.post.form') }}">Create post</a>
                @endauth
            </form>
            <div class="post-grid">
                @forelse ($posts as $post)
                    <article class="glass-card">
                        <span class="kicker">{{ __($post->subCategory->name ?? 'General') }}</span>
                        <h3><a href="{{ route('post.details', ['slug' => slug($post->post_title), 'id' => $post->id]) }}">{{ __($post->post_title) }}</a></h3>
                        <p>{{ shortDescription(__($post->description), 180) }}</p>
                        <p style="color:var(--muted);font-size:13px">
                            {{ __($post->user->fullname) }} · {{ $post->created_at->diffForHumans() }} · {{ $post->view }} views · {{ $post->up_vote }} up
                        </p>
                    </article>
                @empty
                    <div class="glass-card">No posts match this search.</div>
                @endforelse
            </div>
            <div class="mt-4">{{ $posts->links($activeTemplate . 'paginate') }}</div>
        </div>
    </section>
@endsection
