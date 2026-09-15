
@extends($activeTemplate .'layouts.master')
@section('content')
<section class="page-hero">
    <div class="container">
        <div class="kicker">Page</div>
        <h1>{{ $page_title }}</h1>
    </div>
</section>
<section class="section" style="padding-top:0">
    <div class="container">
    @if($sections->secs != null)
        @foreach(json_decode($sections->secs) as $sec)
            @include($activeTemplate.'sections.'.$sec)
        @endforeach
    @endif
    </div>
</section>
@endsection