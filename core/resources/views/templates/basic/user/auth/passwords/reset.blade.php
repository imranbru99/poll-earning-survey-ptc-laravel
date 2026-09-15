@extends($activeTemplate . 'layouts.auth')
@section('content')
    <section>
        <div class="pt-120 pb-120">
            <div class="container">
                <div class="row justify-content-center">
                    <br><br><br><br><br><br><br><br><br><br>
                    <div class="col-md-6">
                        <div class="password-area">
                            <form class="contact-form" action="{{ route('user.password.update') }}" method="post"
                                onsubmit="return submitUserForm();">
                                @csrf
                                <input type="hidden" name="email" value="{{ $email }}">
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="form-group">
                                    <label>@lang('Password')</label>
                                    <div class="input-group mb-2">
                                        <input type="password" name="password" class="form-control"
                                            placeholder="@lang('Password')">
                                    </div>
                                </div><!-- form-group end -->
                                <div class="form-group">
                                    <label>@lang('Confirm Password')</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="las la-key"></i></div>
                                        </div>
                                        <input type="password" name="password_confirmation" class="form-control"
                                            placeholder="@lang('Confirm Password')">
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <button type="submit"
                                        class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">@lang('Submit')</button>
                                    <p class="text-center mt-4 font-weight-light"> <a
                                            href="{{ route('user.login') }}">@lang('Back to login')</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
