@extends($activeTemplate.'layouts.auth')
@section('content')
<main style="background-image: url('https://trfou.com/assets/templates/basic//assets/img/bread.jpg');">
  <br><br><br><br><br><br><br><br><br><br>
<div class="ptb-15">
    @if(!$user->status)
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card shadow-inset  border-0">
                              <h4 class="red-text" style="color: red;">Your Account Has Been banned because of Your Worst Activities </h4>
                        </div>
                    </div>
            </div>
    @elseif(!$user->ev)
        <div class="container py-5">
                <div class="row justify-content-center">
                  
                <div class="col-md-10 mx-auto login-area">
                    <form method="POST" action="{{route('user.verify_email')}}" class="mb-4">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-md-6 text-center">
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" readonly value="{{auth()->user()->email}}">
                                </div>
                                <div class="form-group">
                                    <input  name="email_verified_code" placeholder="@lang('Enter Your Email Verification Code here')" class="form-control">

                                    @if ($errors->has('email_verified_code'))
                                        <small class="text-danger">{{ $errors->first('email_verified_code') }}</small>
                                    @endif
                                </div>
                                <div class="form-group text-center">
                                  <button type="submit" class="slide-btn login-btn">@lang('Submit')</button>
                                  <p class="mt-20">@lang('Please check including your Junk/Spam Folder. if not found, you can ') <a href="{{route('user.send_verify_code')}}?type=email"> @lang('Resend code Again')</a></p>
                                  <br>  <br>
                                  
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    @elseif(!$user->sv)
        <div class="container py-5">
            <div class="row">
                <div class="col-md-10 mx-auto login-area">
                    <form method="POST" action="{{route('user.verify_sms')}}" class="mb-4">
                        @csrf
                        <h3 class="text-center  pb-4 text-uppercase"> @lang($page_title)</h3>
                        <div class="row justify-content-center">
                            <div class="col-md-6 text-center">
                                <div class="form-group">
                                    <input type="text" name="mobile" class="form-control" readonly value="{{auth()->user()->mobile}}">
                                </div>
                                <div class="form-group">
                                    <input  name="sms_verified_code" placeholder="@lang('Code')" class="form-control">

                                    @if ($errors->has('sms_verified_code'))
                                        <small class="text-danger">{{ $errors->first('sms_verified_code') }}</small>
                                    @endif
                                </div>
                                <div class="form-group text-center">
                                  <button type="submit" class="slide-btn login-btn">@lang('Submit')</button>
                                  <p class="mt-20">@lang('No code on your phone Yet ? ') <a href="{{route('user.send_verify_code')}}?type=phone"> @lang('Resend code Again')</a></p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @elseif(!$user->tv)
        <div class="container py-5">
            <div class="row">
                <div class="col-md-10 mx-auto login-area">
                    <form class="contact-form" method="POST" action="{{route('user.go2fa.verify') }}">
                        @csrf
                        <h3 class="text-center  pb-4 text-uppercase"> @lang('2FA VERIFICATION')</h3>

                        <div class="row justify-content-center">
                            <div class="form-group ">
                                <strong> @lang('Current Time') : {{\Carbon\Carbon::now()}}</strong>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-md-6 text-center">

                                <div class="form-group">

                                    <p class="mb-3"> @lang("Google Authenticator Code") </p>

                                    <input  name="code" placeholder="@lang('Enter Google Authenticator Code')" class="form-control">
                                    @if ($errors->has('code'))
                                        <small class="text-danger">{{ $errors->first('code') }}</small>
                                    @endif
                                </div>
                                <div class="form-group text-center">
                                  <button type="submit" class="slide-btn login-btn">@lang('Submit')</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    @endif
  </main>
@endsection

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap-pincode-input.css') }}"/>
<style>

    .pincode-input-container{
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .pincode-input-container .pincode-input-text {
        /*margin-left: 5px;*/
        text-align: center;
        font-weight: 600;
        font-size: 40px;
        border: 2px striped #{{$general->bclr}};
        color: #{{$general->bclr}};
    }
    .login-area .login-form .frm-grp input {
        padding:inherit;
    }
    .pincode-input-text, .form-control.pincode-input-text {
        width: 46px;
        height: 46px !important;
    }
</style>
@endpush

@push('script')
    <script src="{{ asset('assets/admin/js/bootstrap-pincode-input.js') }}"></script>
    <script>
        (function ($) {
            "use strict";
            $('#pincode-input').pincodeInput({
                inputs:6,
                placeholder:"- - - - - -",
                hidedigits:false
            });
        })(jQuery);
    </script>
@endpush
