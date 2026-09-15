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
                            <span class="font-weight-bold">{{$user->username}}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Balance')
                            <span class="font-weight-bold">{{getAmount($user->balance)}}  {{$general->cur_text}}</span>
                        </li>
                        
                    </ul>
                </div>
            </div>
            
        </div>

        <div class="col-xl-9 col-lg-7 col-md-7 mb-30">

            <div class="row mb-none-30">
                <div class="col-xl-3 col-lg-6 col-sm-6 mb-30">
                    <div class="dashboard-w1 bg--gradi-1 b-radius--10 box-shadow has--link">
                        <a href="{{route('admin.publisher.users.deposits',$user->id)}}" class="item--link"></a>
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
                          <a href="#" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                        </div>
                    </div>
                </div><!-- dashboard-w1 end -->
       <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
                    <div class="dashboard-w1 bg--gradi-8 b-radius--10 box-shadow has--link">
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{$totalPtc}}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total PTC')</span>
                    </div>
                    <a href="#" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        
               <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
                    <div class="dashboard-w1 bg--gradi-3 b-radius--10 box-shadow has--link">
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{$totalSurvey}}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total Survey')</span>
                    </div>
                    <a href="#" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        
        <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
                    <div class="dashboard-w1 bg--gradi-2 b-radius--10 box-shadow has--link">
                <div class="icon">
                    <i class="la la-phone"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{$totalMicroJob}}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total Microjob')</span>
                    </div>

                    <a href="#" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
                <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
                    <div class="dashboard-w1 bg--gradi-9 b-radius--10 box-shadow has--link">
                <div class="icon">
                    <i class="la la-alert"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">Working</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total Cost')</span>
                    </div>

                    <a href="#" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
                <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
                    <div class="dashboard-w1 bg--gradi-15 b-radius--10 box-shadow has--link">
                <div class="icon">
                    <i class="la la-bag"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{$totalTransaction}}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Transaction')</span>
                    </div>

                    <a href="#" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
            </div>


            <div class="card mt-50">
                <div class="card-body">
                    <h5 class="card-title mb-50 border-bottom pb-2">{{$user->fullname}} @lang('Information')</h5>

                    <form action="{{route('admin.publisher.users.update',[$user->id])}}" method="POST"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('First Name') <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="firstname"
                                           value="{{$user->firstname}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label  font-weight-bold">@lang('Last Name') <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="lastname" value="{{$user->lastname}}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('Email') <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="email" name="email" value="{{$user->email}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label  font-weight-bold">@lang('Mobile Number') <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="mobile" value="{{$user->mobile}}">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                       <div class="row mt-4">
                            <div class="col-xl-3 col-md-6">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('Country') </label>
                                    <select name="country" class="form-control"> @include('partials.country') </select>
                                </div>
                            </div>
                             </div>
                               <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('Student/Employee')</label>
                                        <input type="text" name="address" class="form-control form-control-lg" placeholder="@lang('Employee')" value="{{ __(optional($user->address)->address) }}">        
                                    </div>
                                </div>
                                       <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('Division')</label>
                                        <input type="text" name="para" class="form-control form-control-lg" placeholder="@lang('Division')" value="{{ __(optional($user->address)->para) }}">        
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('District')</label>
                                        <input type="text" name="district" class="form-control form-control-lg" placeholder="@lang('District')" value="{{ __(optional($user->address)->district) }}">        
                                    </div>
                                </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('Upozila')</label>
                                        <input type="text" name="upozila" class="form-control form-control-lg" placeholder="@lang('Upozila')" value="{{ __(optional($user->address)->upozila) }}">        
                                    </div>
                                </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('Village Name')</label>
                                        <input type="text" name="village" class="form-control form-control-lg" placeholder="@lang('village')" value="{{ __(optional($user->address)->village) }}">        
                                    </div>
                                </div>
                           
                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('NID/Birth Registation')</label>
                                        <input type="text" name="state" class="form-control form-control-lg" placeholder="@lang('NID/Birth Registation')" value="{{ __(optional($user->address)->state) }}">        
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
                                        <label>@lang('City')</label>
                                        <input type="text" name="city" class="form-control form-control-lg" placeholder="@lang('City')" value="{{ __(optional($user->address)->city) }}">        
                                    </div>
                                </div>
                                    <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('Highest Study')</label>
                                        <input type="text" name="post_office" class="form-control form-control-lg" placeholder="@lang('Highest Study')" value="{{ __(optional($user->address)->post_office) }}">        
                                    </div>
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
