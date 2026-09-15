@extends($activeTemplate . 'layouts.user')
@section('content')
    @include($activeTemplate . 'breadcrumb')
    <div class="container-fluid">
        <form class="search-bar" method="get" action="{{ route('user.survey') }}">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Search available opinions">
            <button class="btn-gold" type="submit">Search</button>
        </form>
        <div class="post-grid">
            @forelse ($surveys as $survey)
                @php
                    $count = App\CompletedSurvey::where(['user_id' => Auth::id(), 'Survey_id' => $survey->id])->count();
                @endphp
                @if ($count == 0)
                    <div class="glass-card">
                        <div class="kicker">Opinion</div>
                        <h3>{{ $survey->name }}</h3>
                        <p>{{ $survey->description ?? 'Share your view and collect the published reward.' }}</p>
                        <a class="btn-gold" target="_blank" href="{{ route('user.start.survey', Crypt::encryptString($survey->id)) }}">Start opinion</a>
                    </div>
                @endif
            @empty
                <div class="glass-card">{{ $empty_message }}</div>
            @endforelse
        </div>
        {{ $surveys->links($activeTemplate . 'paginate') }}
    </div>
@endsection
