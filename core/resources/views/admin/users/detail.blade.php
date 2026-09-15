@extends('admin.layouts.app')

@section('panel')
    <div class="row mb-none-30">
        <div class="col-xl-3 col-lg-5 col-md-5 mb-30">
            <div class="card b-radius--10 overflow-hidden box--shadow1">
                <div class="card-body p-0">
                    <div class="p-3 bg--white">
                        <div class="">
                            <img src="{{ getImage('assets/images/user/profile/'. $user->image)}}" alt="profile-image"
                                 class="b-radius--10 w-100">
                        </div>
                        <div class="mt-15">
                            <h4 class="">{{$user->fullname}}</h4>
                            <span class="text--small">@lang('Last Active') <strong>{{date('d M, Y h:i A',strtotime($user->last_seen))}}</strong></span><br>
                           <span class="text--small">@lang('Joined At') <strong>{{date('d M, Y h:i A',strtotime($user->created_at))}}</strong></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card b-radius--10 overflow-hidden mt-30 box--shadow1">
                <div class="card-body">
                    <h5 class="mb-20 text-muted">@lang('User information')</h5>
                    <ul class="list-group">

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Username')
                            <span class="font-weight-bold"><a href="{{ route('admin.users.detail', $user->id) }}"> {{$user->username}}</a></span>
                        </li>


                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Status')
                            @switch($user->status)
                                @case(1)
                                <span class="badge badge-pill bg--success">@lang('Active')</span>
                                @break
                                @case(2)
                                <span class="badge badge-pill bg--danger">@lang('Banned')</span>
                                @break
                            @endswitch
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Balance')
                            <span class="font-weight-bold">{{getAmount($user->balance)}}  {{$general->cur_text}}</span>
                        </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Bonus')
                            <span class="font-weight-bold">{{getAmount($user->bonus)}}  {{$general->cur_text}}</span>
                        </li>
                        @if( $reff != null )
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Referred By')
                            <span class="font-weight-bold"><a href="{{ route('admin.users.detail', $reff->id) }}"> {{ $reff->username }}</a></span>
                        </li>
                        @endif
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Total Referral')
                            <span class="font-weight-bold">
                               <a href="{{ route('admin.users.totalReferral',$user->id) }}"> {{ $totalReferral }} User</a>
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Total Commissions')
                            <span class="font-weight-bold">
                               <a href="{{ route('admin.users.commissions',$user->id) }}"> {{ getAmount($user->commissions->sum('amount')) }} {{ $general->cur_text }}</a>
                            </span>
                        </li>
                        @if($user->plan)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('User Plan')
                            <span class="font-weight-bold">{{ $user->plan->name }}
                            </span>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="card b-radius--10 overflow-hidden mt-30 box--shadow1">
                <div class="card-body">
                    <h5 class="mb-20 text-muted">@lang('User action')</h5>
                    <a data-toggle="modal" href="#addSubModal" class="btn btn--success btn--shadow btn-block btn-lg">
                        @lang('Add/Subtract Balance')
                    </a>
                    <a href="{{ route('admin.users.login.history.single', $user->id) }}"
                       class="btn btn--primary btn--shadow btn-block btn-lg">
                        @lang('Login Logs')
                    </a>
                    <a href="{{route('admin.users.email.single',$user->id)}}"
                       class="btn btn--danger btn--shadow btn-block btn-lg">
                        @lang('Send Email')
                    </a>
                   <a href="{{route('admin.users.login',$user->id)}}" target="_blank" class="btn btn--dark btn--shadow btn-block btn-lg">
                                @lang('Login as User')
                            </a>
                </div>
            </div>
        </div>

        <div class="col-xl-9 col-lg-7 col-md-7 mb-30">
            <div class="row mb-none-30">
                <div class="col-xl-3 col-lg-6 col-sm-6 mb-30">
                    <div class="dashboard-w1 bg--gradi-1 b-radius--10 box-shadow has--link">
                        <a href="{{route('admin.users.deposits',$user->id)}}" class="item--link"></a>
                        <div class="icon">
                            <i class="fa fa-credit-card"></i>
                        </div>
                        <div class="details">
                            <div class="numbers">
                                <span class="amount">{{number_format($totalDeposit,2)}}</span>
                                <span class="currency-sign"> {{$general->cur_sym}}</span>
                            </div>
                            <div class="desciption">
                                <span>@lang('Total Deposit')</span>
                            </div>
                        </div>
                    </div>
                </div><!-- dashboard-w1 end -->
                <div class="col-xl-3 col-lg-6 col-sm-6 mb-30">
                    <div class="dashboard-w1 bg--gradi-15 b-radius--10 box-shadow has--link">
                        <a href="{{route('admin.users.withdrawals',$user->id)}}" class="item--link"></a>
                        <div class="icon">
                            <i class="fa fa-wallet"></i>
                        </div>
                        <div class="details">
                            <div class="numbers">
                                <span class="amount">{{number_format($totalWithdraw,2)}}</span>
                                <span class="currency-sign">{{$general->cur_sym}}</span>
                            </div>
                            <div class="desciption">
                                <span>@lang('Total Withdraw')</span>
                            </div>
                        </div>
                    </div>
                </div><!-- dashboard-w1 end -->
                <div class="col-xl-3 col-lg-6 col-sm-6 mb-30">
                    <div class="dashboard-w1 bg--gradi-21 b-radius--10 box-shadow has--link">
                        <a href="{{route('admin.users.transactions',$user->id)}}" class="item--link"></a>
                        <div class="icon">
                            <i class="la la-exchange-alt"></i>
                        </div>
                        <div class="details">
                            <div class="numbers">
                                <span class="amount">{{$totalTransaction}}</span>
                            </div>
                            <div class="desciption">
                                <span>@lang('Total Transaction')</span>
                            </div>
                        </div>
                    </div>
                </div><!-- dashboard-w1 end -->
                <div class="col-xl-3 col-lg-6 col-sm-6 mb-30">
                    <div class="dashboard-w1 bg--gradi-11 b-radius--10 box-shadow has--link">
                        <a href="javascript:void(0)" class="item--link"></a>
                        <div class="icon">
                            <i class="la la-exchange-alt"></i>
                        </div>
                        <div class="details">
                            <div class="numbers">
                                <span class="amount">{{ $user->clicks->count() }}</span>
                            </div>
                            <div class="desciption">
                                <span>@lang('Total Clicks')</span>
                            </div>
                        </div>
                    </div>
                </div><!-- dashboard-w1 end -->
                {{--total user microjobs                --}}
                <div class="col-xl-3 col-lg-6 col-sm-6 mb-30">
                    <div class="dashboard-w1 bg--gradi-11 b-radius--10 box-shadow has--link">
                        <a href="{{ route('jobs.jobShow', $user->id) }}" class="item--link"></a>
                        <div class="icon">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <div class="details">
                            <div class="numbers">
                                <span class="amount">{{ $jobs }}</span>
                            </div>
                            <div class="desciption">
                                <span>@lang('User Completed MicroJobs')</span>
                            </div>
                        </div>
                    </div>
                </div>
{{--               Rejected jobs --}}
                <div class="col-xl-3 col-lg-6 col-sm-6 mb-30">
                    <div class="dashboard-w1 bg--gradi-11 b-radius--10 box-shadow has--link">
                        <a href="{{ route('jobs.rejected', $user->id) }}" class="item--link"></a>
                        <div class="icon">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <div class="details">
                            <div class="numbers">
                                <span class="amount">{{ $reject }}</span>
                            </div>
                            <div class="desciption">
                                <span>@lang('User Rejected MicroJobs')</span>
                            </div>
                        </div>
                    </div>
                </div>
                {{--total user survey                --}}
                <div class="col-xl-3 col-lg-6 col-sm-6 mb-30">
                    <div class="dashboard-w1 bg--gradi-11 b-radius--10 box-shadow has--link">
                        <a href="{{route('admin.users.survey_history',$user->id)}}" class="item--link"></a>
                        <div class="icon">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <div class="details">
                            <div class="numbers">
                                <span class="amount">{{$userSurvey}}</span>
                            </div>
                            <div class="desciption">
                                <span>@lang('Total User Survey')</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- dashboard-w1 end -->
            </div>
            <div class="card mt-50">
                <div class="card-body">
                    <h5 class="card-title mb-50 border-bottom pb-2">{{$user->fullname}} @lang('Information')</h5>
                  <form action="{{route('admin.users.update',[$user->id])}}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('First Name')</label>
                                    <input type="text" name="firstname" class="form-control form-control-lg" placeholder="@lang('First Name')" value="{{ __($user->firstname) }}"readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Last Name')</label>
                                    <input type="text" name="lastname" class="form-control form-control-lg" placeholder="@lang('Last Name')" value="{{ __($user->lastname) }}"readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Username')</label>
                                    <input type="text" name="username" class="form-control form-control-lg" placeholder="@lang('Username')" value="{{ __($user->username) }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Email')</label>
                                    <input type="text" name="email" class="form-control form-control-lg" placeholder="@lang('Email')" value="{{ __($user->email) }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Mobile')</label>
                                    <input readonly type="text" name="mobile" class="form-control form-control-lg" placeholder="@lang('Mobile')" value="{{ __($user->mobile) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Country')</label>
                                    <select class="form-control form-control-lg" name="country">
                                        <option value="">@lang('-- Select One --')</option>
                                        @include('partials.country')
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Occupation')</label>
                                    <input type="text" name="address" class="form-control form-control-lg" placeholder="@lang('Occupation')" value="{{ __(optional($user->address)->address) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Your City')</label>
                                    <input type="text" name="para" class="form-control form-control-lg" placeholder="@lang('Your City')" value="{{ __(optional($user->address)->para) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Your State')</label>
                                    <input type="text" name="district" class="form-control form-control-lg" placeholder="@lang('Your State')" value="{{ __(optional($user->address)->district) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Your Father Name')</label>
                                    <input type="text" name="upozila" class="form-control form-control-lg" placeholder="@lang('Your Father Name')" value="{{ __(optional($user->address)->upozila) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Your Mother Name')</label>
                                    <input type="text" name="village" class="form-control form-control-lg" placeholder="@lang('Your Mother Name')" value="{{ __(optional($user->address)->village) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('National ID Card Number')</label>
                                    <input type="text" name="state" class="form-control form-control-lg" placeholder="@lang('National ID Card Number')" value="{{ __(optional($user->address)->state) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Zip/Area Code')</label>
                                    <input type="text" name="zip" class="form-control form-control-lg" placeholder="@lang('Zip')" value="{{ __(optional($user->address)->zip) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Your Favourite Crypto Currency Name')</label>
                                    <input type="text" name="city" class="form-control form-control-lg" placeholder="@lang('Your Favourite Crypto Currency Name')" value="{{ __(optional($user->address)->city) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Your Highest Study Degree Name')</label>
                                    <input type="text" name="post_office" class="form-control form-control-lg" placeholder="@lang('Your Highest Study Degree Name')" value="{{ __(optional($user->address)->post_office) }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-xl-4 col-md-6  col-sm-3 col-12">
                                <label class="form-control-label font-weight-bold">@lang('Status') </label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                       data-toggle="toggle" data-on="Active" data-off="Banned" data-width="100%"
                                       name="status"
                                       @if($user->status) checked @endif>
                            </div>
                            <div class="form-group  col-xl-4 col-md-6  col-sm-3 col-12">
                                <label class="form-control-label font-weight-bold">@lang('Email Verification') </label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                       data-toggle="toggle" data-on="Verified" data-off="Unverified" name="ev"
                                       @if($user->ev) checked @endif>
                            </div>
                            <div class="form-group  col-xl-4 col-md-6  col-sm-3 col-12">
                                <label class="form-control-label font-weight-bold">@lang('SMS Verification') </label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                       data-toggle="toggle" data-on="Verified" data-off="Unverified" name="sv"
                                       @if($user->sv) checked @endif>
                            </div>
                            <div class="form-group  col-md-6  col-sm-3 col-12">
                                <label class="form-control-label font-weight-bold">@lang('2FA Status') </label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                       data-toggle="toggle" data-on="Enable" data-off="Disable" name="ts"
                                       @if($user->ts) checked @endif>
                            </div>
                            <div class="form-group  col-md-6  col-sm-3 col-12">
                                <label class="form-control-label font-weight-bold">@lang('2FA Verification') </label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                       data-toggle="toggle" data-on="Verified" data-off="Unverified" name="tv"
                                       @if($user->tv) checked @endif>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn--primary btn-block btn-lg">@lang('Save Changes')
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
 



    {{-- Add Sub Balance MODAL --}}
    <div id="addSubModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Add / Subtract Balance')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.users.addSubBalance', $user->id)}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <input type="checkbox" data-width="100%" data-height="44px" data-onstyle="-success"
                                       data-offstyle="-danger" data-toggle="toggle" data-on="Add Balance"
                                       data-off="Subtract Balance" name="act" checked>
                            </div>


                            <div class="form-group col-md-12">
                                <label>@lang('Amount')<span class="text-danger">*</span></label>
                                <div class="input-group has_append">
                                    <input type="text" name="amount" class="form-control"
                                           placeholder="Please provide positive amount">
                                    <div class="input-group-append">
                                        <div class="input-group-text">{{ $general->cur_sym }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--success">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>
        (function($){
            "use strict";
            $("select[name=country]").val("{{ @$user->address->country }}");
        })(jQuery);
    </script>
@endpush
