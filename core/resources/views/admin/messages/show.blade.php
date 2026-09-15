@extends('admin.layouts.app')
@section('panel')
<div class="container">
    <div class="row justify-content-center">
        <div class="w-100">
            <h1>{{ $thread->subject }}</h1>
            @each('admin.messages.partials.messages', $thread->messages, 'message')

            @include('admin.messages.partials.form-message')
        </div>
    </div>
</div>
@endsection
