@extends('admin.layouts.app')
@section('panel')
<div class="container">
    <div class="row">
        @include('admin.messages.partials.flash')

        @each('admin.messages.partials.thread', $threads, 'thread', 'admin.messages.partials.no-threads')
    </div>
</div>
@endsection
