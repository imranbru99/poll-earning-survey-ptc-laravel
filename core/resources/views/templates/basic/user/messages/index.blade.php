@extends($activeTemplate .'layouts.user')

@section('content')
<div class="container">
    <div class="row">
        @include('templates.basic.user.messages.partials.flash')

        @each('templates.basic.user.messages.partials.thread', $threads, 'thread', 'templates.basic.user.messages.partials.no-threads')
    </div>
</div>
@endsection
