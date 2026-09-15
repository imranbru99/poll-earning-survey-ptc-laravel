
@extends($activeTemplate .'layouts.user')
@section('content')
@include($activeTemplate.'breadcrumb')
<section class="cmn-section py-3">
        <div class="container ">
        <div class="row">

            <div class="col-10 mx-auto">
                <p> Your Bonus Account Balance is  {{ getAmount($user->bonus) }} USD. </p>
                 <h3> Bonus Account withdraw Requirement </h3>

                <li> 30 days need check your activity from registered days, You have joined at {{ $now }},  {{ $need }}</li>
                <li class="text-danger"> You need 5 Refer(Up to Level 3), Your level 3 refer is now {{ $user::where('level',$user->id)->count() }} </li>
                <li> Today is {{ $now }}, You can withdraw your bonus amount {{ $newDateTime }},  {{ $withdraw }}</li>


         <a href="javascript:void(0)"  data-id="{{ $need }}"
            data-resource="{{ $need }}"
            class="btn btn-block  cmn-btn deposit" data-toggle="modal" data-target="#exampleModal">
             @lang('Withdraw Now')</a>

            </div>
        </div>
            <div class="row mb-60-80 justify-content-center">
                <div class="col-md-12 mb-30">


                </div>


            </div>
        </div>
    </section>
    <!-- ========User-Panel-Section Ends Here ========-->
 <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <strong class="modal-title method-name" id="exampleModalLabel">@lang('Withdraw Bonus Amount')</strong>
                    <a href="javascript:void(0)" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <form action="#" method="post">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <input type="hidden" name="method_code" class="edit-method-code  form-control" value="">
                        </div>


                        <div class="form-group">
                            <div class="input-group">
                                <input id="amount" type="text" class="form-control form-control-lg"
                                       onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" name="amount"
                                       placeholder="0.00" required="" value="{{ getAmount($user->bonus) }} USD">
                                       <p class="text-danger"> You need 5 Refer(Up to Level 3), Your Total level 3 refer is now {{ $user::where('level',$user->id)->count() }} people</p>

                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-primary" disabled>@lang('Confirm')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection



