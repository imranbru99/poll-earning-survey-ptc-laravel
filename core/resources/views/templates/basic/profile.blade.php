@extends($activeTemplate . 'layouts.master')
@section('content')
    <section class="page-hero">
        <div class="container">
            <div class="kicker">Member profile</div>
            <h1>{{ __($user->fullname) }}</h1>
            <p>Public posts and community reputation for this member.</p>
        </div>
    </section>
    <div class="profile-section">
        <div class="bg-image">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 text-center text-dark">
                        <div class="profile-thumb">
                            <img src="{{ $user->photo }}" alt="image">
                        </div>
                        <h3 class="profile-name text-dark mt-3">{{ __($user->fullname) }}</h3>
                        <ul
                            class="profile-info-list d-flex flex-wrap align-items-center text-dark justify-content-center mt-1">
                            <li><i class="las la-flag"></i> {{ __($user->address->country) }}</li>
                            <li><i class="las la-user-clock"></i> @lang('Since')
                                {{ showDateTime($user->created_at, 'Y') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>



        <div class="profile-details-wrapper">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        @forelse($posts as $post)
                            <div class="single-post">
                                <span class="forum-badge">
                                    {{ __($post->subCategory->name) }}
                                </span>
                                <div class="single-post__thumb">
                                    <a
                                        href="{{ route('user', ['username' => $post->user->username, 'id' => $post->user->id]) }}">
                                        <img src="{{ getImage(imagePath()['profile']['user']['path'] . '/' . @$post->user->image, imagePath()['profile']['user']['size']) }}"
                                            alt="@lang('image')">
                                    </a>
                                </div>
                                <div class="single-post__content">
                                    <h3 class="single-post__title">
                                        <a
                                            href="{{ route('post.details', ['slug' => slug($post->post_title), 'id' => $post->id]) }}">
                                            Post Title: {{ __($post->post_title) }}
                                        </a>
                                    </h3>
                                    <div class="text-center">
                                        <ul class="single-post__meta d-flex align-items-center mt-1">
                                            <li class="text-center">
                                                @lang('Posted By')
                                                <i class="las la-user"></i>
                                                <a
                                                    href="{{ route('user', ['username' => $post->user->username, 'id' => $post->user->id]) }}">
                                                    {{ __($post->user->fullname) }}
                                                </a>
                                            </li>
                                            <li><i class="las la-clock"></i> {{ $post->created_at->diffforhumans() }}</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="single-post__footer">
                                    <p class="mt-3">{{ shortDescription(__($post->description), 400) }}</p>

                                    <div class="single-post__action-list d-flex flex-wrap align-items-center mt-3">
                                        <ul class="left">
                                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Up Vote')">
                                                <a href="{{ route('post.details', ['slug' => slug($post->post_title), 'id' => $post->id]) }}"
                                                    class="text--success c-none">
                                                    <i class="las la-arrow-up text--success"></i>
                                                    {{ $post->up_vote }}
                                                </a>
                                            </li>
                                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Down Vote')">
                                                <a href="{{ route('post.details', ['slug' => slug($post->post_title), 'id' => $post->id]) }}"
                                                    class="c-none">
                                                    <i class="las la-arrow-down"></i>
                                                    {{ $post->down_vote }}
                                                </a>
                                            </li>
                                        </ul>
                                        <ul class="right">
                                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Total Views')">
                                                <a href="{{ route('post.details', ['slug' => slug($post->post_title), 'id' => $post->id]) }}"
                                                    class="c-none">
                                                    <i class="las la-eye"></i>
                                                    {{ $post->view }} @lang('Views')
                                                </a>
                                            </li>
                                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Total Comments')">
                                                <a
                                                    href="{{ route('post.details', ['slug' => slug($post->post_title), 'id' => $post->id]) }}">
                                                    <i class="las la-comments"></i>
                                                    {{ $post->comment }} @lang('Comments')
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div><!-- single-post end -->
                        @empty
                            <div class="single-post text-center d-block">
                                @lang('Data Not Found')!
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- profile section end -->
@endsection

@push('script')
    <script></script>
@endpush
@push('style-lib')
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . '/app/css/post.css') }}">
    <style>

    </style>
@endpush
