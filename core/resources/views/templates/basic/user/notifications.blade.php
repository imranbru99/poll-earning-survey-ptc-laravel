@extends($activeTemplate.'layouts.user')
@section('content')
<div class="container">
    <div class="notify__area">
    	@foreach($notifications as $notification)
        <a class="notify__item @if($notification->read_status == 0) unread--notification @endif" href="{{ route('user.notification.read',$notification->id) }}">
            <div class="notify__thumb bg--primary">
                <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'.@$notification->user->image,imagePath()['profile']['user']['size'])}}">
            </div>
            <div class="notify__content">
                <h6 class="title">{{ __($notification->title) }}</h6>
                <span class="date"><i class="las la-clock"></i> {{ $notification->created_at->diffForHumans() }}</span>
            </div>
        </a>
        @endforeach
        {{-- {{ paginateLinks($notifications) }} --}}
    </div>
</div>
@endsection
@push('breadcrumb-plugins')
<a href="{{ route('user.notifications.readAll') }}" class="btn btn--primary">@lang('Mark all as read')</a>
@endpush
