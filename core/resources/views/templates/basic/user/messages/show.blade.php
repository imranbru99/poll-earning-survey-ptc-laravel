@extends($activeTemplate .'layouts.user')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="w-100">
            <h1>{{ $thread->subject }}</h1>
            @each('templates.basic.user.messages.partials.messages', $thread->messages, 'message')

            @include('templates.basic.user.messages.partials.form-message')
        </div>
    </div>
</div>
@endsection
