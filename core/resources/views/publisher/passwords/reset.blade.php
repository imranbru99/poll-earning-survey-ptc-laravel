
@extends($activeTemplate .'layouts.master')
@section('content')
@include($activeTemplate.'breadcrumb')    
   <div class="pt-120 pb-120">
        <div class="container">
            <div class="row justify-content-center">
    
                <div class="col-md-6">
                    <div class="password-area">
                        <form class="contact-form" action="{{ route('publisher_user.password.update') }}" method="post" onsubmit="return submitUserForm();">
                            @csrf
                            <input type="hidden" name="email" value="{{ $email }}">
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="form-group">
                              <label>@lang('Password')</label>
                              <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                  <div class="input-group-text"><i class="las la-key"></i></div>
                                </div>
                                <input type="password" name="password" class="form-control" placeholder="@lang('Password')">
                              </div>
                            </div><!-- form-group end -->
                            <div class="form-group">
                              <label>@lang('Confirm Password')</label>
                              <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                  <div class="input-group-text"><i class="las la-key"></i></div>
                                </div>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="@lang('Confirm Password')">
                              </div>
                            </div>
                            <div class="form-group text-center">
                              <button type="submit" class="cmn-btn rounded-0 w-100">@lang('Submit')</button>
                              <p class="mt-20"> <a href="{{ url('publisher_user/publisher_user_login') }}">@lang('Back to login')</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection