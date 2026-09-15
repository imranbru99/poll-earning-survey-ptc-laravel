
@extends($activeTemplate .'layouts.master')
@section('content')
@include($activeTemplate.'breadcrumb')
    <div class="pt-120 pb-120">
        <div class="container">
            <div class="row justify-content-center">
    
                <div class="col-md-6">
                    <div class="password-area">
                        <h6 class="text-center mb-3">@lang('Enter Verification Code')</h6>
                        <form class="contact-form" action="{{ route('publisher_user.password.verify-code') }}" method="post" onsubmit="return submitUserForm();">
                            @csrf
                            <input type="hidden" name="email" value="{{ $email }}">
                            <div class="form-group">
                        <div id="phoneInput">
                            
                            <div class="field-wrapper">
                                <div class=" phone">
                                    <input type="text" name="code[]" class="letter"
                                           pattern="[0-9]*" inputmode="numeric" maxlength="1">
                                    <input type="text" name="code[]" class="letter"
                                           pattern="[0-9]*" inputmode="numeric" maxlength="1">
                                    <input type="text" name="code[]" class="letter"
                                           pattern="[0-9]*" inputmode="numeric" maxlength="1">
                                    <input type="text" name="code[]" class="letter"
                                           pattern="[0-9]*" inputmode="numeric" maxlength="1">
                                    <input type="text" name="code[]" class="letter"
                                           pattern="[0-9]*" inputmode="numeric" maxlength="1">
                                    <input type="text" name="code[]" class="letter"
                                           pattern="[0-9]*" inputmode="numeric" maxlength="1">
                                </div>
                            </div>
                        </div>
                    </div>
                            <div class="form-group text-center">
                              <button type="submit" class="cmn-btn rounded-0 w-100">@lang('Submit')</button>
                              <p class="mt-20"> <a href="{{ route('publisher_user.password.request') }}">@lang('Try to send again')</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection
@push('script-lib')
    <script src="{{asset('assets/admin/js/jquery.inputLettering.js')}}"></script>
@endpush
@push('style')
    <style>

        #phoneInput .field-wrapper {
            position: relative;
            text-align: center;
        }

        #phoneInput .form-group {
            min-width: 300px;
            width: 50%;
            margin: 4em auto;
            display: flex;
            border: 1px solid rgba(96, 100, 104, 0.3);
        }

        #phoneInput .letter {
            height: 50px;
            border-radius: 0;
            text-align: center;
            max-width: calc((100% / 10) - 1px);
            flex-grow: 1;
            flex-shrink: 1;
            flex-basis: calc(100% / 10);
            outline-style: none;
            padding: 5px 0;
            font-size: 18px;
            font-weight: bold;
            color: red;
            border: 1px solid #0e0d35;
        }

        #phoneInput .letter + .letter {
        }

        @media (max-width: 480px) {
            #phoneInput .field-wrapper {
                width: 100%;
            }

            #phoneInput .letter {
                font-size: 16px;
                padding: 2px 0;
                height: 35px;
            }
        }

    </style>
@endpush

@push('script')
    <script>
        (function ($) {
            "use strict";
            $('#phoneInput').letteringInput({
                inputClass: 'letter',
                onLetterKeyup: function ($item, event) {
                    console.log('$item:', $item);
                    console.log('event:', event);
                },
                onSet: function ($el, event, value) {
                    console.log('element:', $el);
                    console.log('event:', event);
                    console.log('value:', value);
                }
            });
        })(jQuery);
    </script>
@endpush
