<div class="container-fluid">
    <div class="row mb-none-3">
        <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--dark b-radius--10 box-shadow">
                <div class="icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{getAmount(auth()->user()->bonus)}}</span>
                        <span class="currency-sign">{{$general->cur_text}}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Bonus Balance')</span>
                    </div>
                    <a href="{{ route('user.bonus') }}"
                       class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('Withdraw Now')</a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--11 b-radius--10 box-shadow">
                <div class="icon">
                    <i class="las la-arrow-alt-circle-right"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{getAmount(auth()->user()->balance)}} {{ $general->cur_text }}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Basic Balance')</span>
                    </div>
                    <a href="{{ route('user.withdraw') }}"
                       class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('Withdraw Now')</a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--primary b-radius--10 box-shadow">
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{getAmount($data['totalDeposit'])}}</span>
                        <span class="currency-sign">{{$general->cur_text}}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total Deposit')</span>
                    </div>
                    <a href="{{ route('user.deposit.history') }}"
                       class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--3 b-radius--10 box-shadow">
                <div class="icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{getAmount($data['totalWithdraw'])}}</span>
                        <span class="currency-sign">{{$general->cur_text}}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total Withdraw')</span>
                    </div>
                    <a href="{{ route('user.withdraw.history') }}"
                       class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--6 b-radius--10 box-shadow">
                <div class="icon">
                    <i class="las la-wallet"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{ auth()->user()->clicks->count() }}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total Web View')</span>
                    </div>
                    <a href="{{ route('user.ptc.clicks') }}"
                       class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div>


            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
                <div class="dashboard-w1 bg--10 b-radius--10 box-shadow">
                    <div class="icon">
                        <i class="las la-cloud-download-alt"></i>
                    </div>
                    <div class="details">
                        <div class="numbers">
                            <span class="amount">{{ auth()->user()->clicks->where('vdt',Date('Y-m-d'))->count() }}</span>
                        </div>
                        <div class="desciption">
                            <span class="text--small">@lang('Today\'s Web View')</span>
                        </div>
                        <a href="{{ route('user.ptc.clicks') }}"
                           class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                    </div>
                </div>
            </div>
        <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--13 b-radius--10 box-shadow">
                <div class="icon">
                    <i class="las la-hand-holding-usd"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{ __($user->plan ? $user->plan->name : 'No Plan') }}</span>
                        <span class="currency-sign"></span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Your Plan')</span>
                    </div>
                    <a href="{{ route('user.plans') }}"
                       class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('Upgrade')</a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--20 b-radius--10 box-shadow">
                <div class="icon">
                    <i class="las la-users"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{ $user::where('ref_by',$user->id)->count() }}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total Referral')</span>
                    </div>
                    <a href="{{ route('user.referred') }}"
                       class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div>
    </div>

</div>