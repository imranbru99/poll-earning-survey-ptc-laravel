
@extends($activeTemplate .'layouts.user')
@section('content')
@include($activeTemplate.'breadcrumb')
<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group glass-card" style="margin-bottom:22px">
                    <label>@lang('Referral Link')</label>
                    <div class="input-group">
                        <input type="text" value="{{ route('user.refer.register',$user->username) }}"
                        class="form-control form-control-lg" id="referralURL"
                        readonly>
                        <div class="input-group-append copytextDiv">
                            <span class="input-group-text copytext" id="copyBoard"> <i class="fa fa-copy"></i> </span>
                        </div>
                    </div>
                    <div class="hero-cta" style="margin-top:16px">
                        <a class="btn-ghost" target="_blank" href="https://wa.me/?text={{ urlencode(route('user.refer.register',$user->username)) }}">Share on WhatsApp</a>
                        <a class="btn-ghost" target="_blank" href="https://t.me/share/url?url={{ urlencode(route('user.refer.register',$user->username)) }}">Share on Telegram</a>
                        <a class="btn-ghost" target="_blank" href="https://twitter.com/intent/tweet?url={{ urlencode(route('user.refer.register',$user->username)) }}">Share on X</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-9 mb-30">
                <div class="card table-card">
                    <div class="card-body p-0">
                        <div class="table-responsive--sm">
                              Your All Referral Details is provided below
                            <table class="table table-striped">
                                <thead class="thead-dark">
                                <tr>
                                    <th>@lang('Full Name')</th>
                                    <th>@lang('User Name')</th>
                                    <th>@lang('Email')</th>
                                    <th>@lang('Mobile')</th>
                                    <th>@lang('Plan')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($refUsers) >0)
                                    @forelse($refUsers as $log)
                                    <tr>
                                        <td data-label="@lang('Full Name')">{{ __($log->fullname) }}</td>
                                        <td data-label="@lang('User Name')">{{ __($log->username) }}</td>
                                        <td data-label="@lang('Email')">{{ $log->email }}</td>
                                        <td data-label="@lang('Phone')">{{ $log->mobile }}</td>
                                        <td data-label="@lang('Plan')">{{ __($log->plan ? $log->plan->name : "No Package") }}</td>
                                    </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="100%" class="text-center"> @lang('No results found')!</td>
                                            </tr>
                                        @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{$refUsers->links($activeTemplate.'paginate')}}
            </div>
        </div>
    </div>
</section>
@endsection
@push('style')
<style type="text/css">
    .copytextDiv{
        border:1px solid #0000007a;
        cursor: pointer;
    }
    #referralURL{
        border-right: 1px solid #0000007a;
    }
    .bg-success-custom{
        background-color: #28a7456e!important;
    }
    .brd-success-custom{
        border: 1px dashed #28a745;
    }
</style>
@endpush
@push('script')
<script type="text/javascript">
    (function ($) {
        "use strict";
        $('#copyBoard').click(function(){
            var copyText = document.getElementById("referralURL");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            /*For mobile devices*/
            document.execCommand("copy");
            iziToast.success({message: "Copied: " + copyText.value, position: "topRight"});
        });
    })(jQuery);
</script>
@endpush
