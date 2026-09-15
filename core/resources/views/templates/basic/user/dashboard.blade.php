@extends($activeTemplate . 'layouts.user')
@section('content')
    @include($activeTemplate . 'breadcrumb')
    <div class="dash-wrap">
        <div class="checkin-box glass-card">
            <div>
                <div class="kicker">Daily ritual</div>
                <h3 style="margin:8px 0">Check-in streak: {{ $streak ?? 0 }} day(s)</h3>
                <p style="margin:0;color:#6b7280">Claim $0.10 bonus once every calendar day. Today's earnings: ${{ number_format($todayEarn ?? 0, 2) }}</p>
            </div>
            @if (!empty($checkedIn))
                <span class="btn-teal">Claimed today</span>
            @else
                <form method="post" action="{{ route('user.checkin') }}">
                    @csrf
                    <button class="btn-gold" type="submit">Claim check-in</button>
                </form>
            @endif
        </div>

        <div class="quick-grid">
            <a class="glass-card" href="{{ route('user.survey') }}">Opinions</a>
            <a class="glass-card" href="{{ route('user.ptc.index') }}">News view</a>
            <a class="glass-card" href="{{ route('user.microJobs.index') }}">Micro jobs</a>
            <a class="glass-card" href="{{ route('user.referred') }}">Referrals</a>
        </div>

        <div class="stat-row">
            <div class="stat-card"><span>Bonus balance</span><strong>$ {{ getAmount(auth()->user()->bonus) }}</strong></div>
            <div class="stat-card"><span>Main balance</span><strong>$ {{ getAmount(auth()->user()->balance) }}</strong></div>
            <div class="stat-card"><span>Referred users</span><strong>{{ $user::where('ref_by', $user->id)->count() }}</strong></div>
            <div class="stat-card"><span>Total deposit</span><strong>$ {{ getAmount($data['totalDeposit']) }}</strong></div>
            <div class="stat-card"><span>Plan</span><strong>{{ __($user->plan ? $user->plan->name : 'No Plan') }}</strong></div>
            <div class="stat-card"><span>Total withdraw</span><strong>$ {{ getAmount($data['totalWithdraw']) }}</strong></div>
            <div class="stat-card"><span>Completed opinions</span><strong>{{ $data['ComplatedSurvey'] }}</strong></div>
            <div class="stat-card"><span>Micro jobs</span><strong>{{ $data['total_microjob'] }}</strong></div>
            <div class="stat-card"><span>Pending withdraws</span><strong>{{ $data['pendingWithdraw'] }}</strong></div>
        </div>

        <div class="glass-card" style="margin-top:22px">
            <h4>Recent login</h4>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sr.</th>
                            <th>Username</th>
                            <th>Login IP</th>
                            <th>Login time</th>
                            <th>Browser</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($userLogin as $userlog)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $userlog->user->username ?? $user->username }}</td>
                                <td>{{ $userlog->user_ip }}</td>
                                <td>{{ $userlog->created_at }}</td>
                                <td>{{ $userlog->browser }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
