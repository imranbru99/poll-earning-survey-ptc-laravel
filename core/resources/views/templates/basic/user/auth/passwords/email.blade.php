@extends($activeTemplate . 'layouts.auth')
@section('content')
    <main style="background-image: url('https://trfou.com/assets/templates/basic//assets/img/bread.jpg');">
        <div class="pt-120 pb-120">
            <div class="container">
                <div class=" row">
                    <br><br><br><br><br><br><br><br><br><br>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="password-area">
                            <form class="contact-form" action="{{ route('user.password.email') }}" method="post"
                                onsubmit="return submitUserForm();">
                                @csrf
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <input type="email" name="email" class="form-control"
                                            placeholder="@lang('Email')">
                                    </div>
                                </div><!-- form-group end -->
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
    </main>
@endsection
