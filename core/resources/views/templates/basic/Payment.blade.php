
@extends($activeTemplate .'layouts.master')
@section('content')
<section class="page-hero">
    <div class="container">
        <div class="kicker">Proof of payouts</div>
        <h1>Latest deposits and withdrawals</h1>
        <p>Public activity so members can see the platform settling real balances.</p>
    </div>
</section>

@php
    $latestTrx = getContent('transaction.content', true);
    $deposits = App\Deposit::latest()->where('status', 1)->take(10)->with('user')->get();
    $withdraws = App\Withdrawal::latest()->where('status', 1)->take(10)->with('user')->get();
    $empty_message = 'No Data found.';
@endphp

<section>
    <div class="container-fluid">

          <ul class="nav nav-tab justify-content-center transaction-tab-menu">
            <li class="nav-item">
               <h2>Latest Withdrawls</h2>
            </li>
        </ul>
           <div class="tab-content">
            <div class="tab-pane show fade active" id="withdraw">
                <div class="transaction-table">
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>@lang('Name')</th>
                                <th>@lang('Date & Time')</th>
                                <th>@lang('Amount')</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($withdraws as $withdraw)
                            <tr>
                                <td data-input="@lang('Name')">
                                    <div class="author">
                                        <div class="content">
                                            {{@$withdraw->user->fullName}}
                                        </div>
                                    </div>
                                </td>
                                 <td data-label="@lang('Date')">{{ showDateTime($withdraw->created_at) }}</td>
                                <td data-input="@lang('Amount')">{{getAmount($withdraw->amount)}} {{$general->cur_text}}</td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{ $empty_message }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<br>

<section>
    <div class="container-fluid">
            <ul class="nav nav-tab justify-content-center transaction-tab-menu">
                <li class="nav-item">
                    <h2>Highest Amount Member </h2>
                    @php
                    $User = App\User::take(10)->with('balance')->orderBy('balance', 'DESC')->get();
                    @endphp
                </li>
            </ul>
            <div class="tab-content">
                    <div class="tab-pane show fade active" id="Ptc">
                            <div class="transaction-table">
                                <table class="table table-striped">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col">@lang('Name')</th>
                                                    <th scope="col">@lang('Amount')</th>
                                                    <th scope="col">@lang('Last Login Date')</th>
                                                </tr>
                                            </thead>
                                            @forelse($User as $User)
                                            <tr>
                                                <td data-input="@lang('Name')">
                                                    <div class="author">
                                                        <div class="content">{{@$User->fullName}}</div>
                                                    </div>
                                                </td>
                                                <td data-label="@lang('Browser')">{{ $User->balance}}</td>
                                                <td data-label="@lang('Date')">{{ showDateTime($User->updated_at) }}</td>
                                            </tr>
                                            @empty
                                                <tr>
                                                    <td class="text-muted text-center" colspan="100%">{{ $empty_message }}</td>
                                                </tr>
                                            @endforelse
                                </table>
                            </div>
                    </div>
            </div>
    </div>
</section>
<br>

<section>
    <div class="container-fluid">
        <ul class="nav nav-tab justify-content-center transaction-tab-menu">
            <li class="nav-item">
                <h2>Latest User Login Details</h2>
                 @php
                $UserLogin = App\UserLogin::latest()->take(10)->with('user')->get();
                @endphp
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane show fade active" id="Ptc">
                <div class="transaction-table">
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">@lang('Name')</th>
                                <th scope="col">@lang('Date & Time')</th>
                                <th scope="col">@lang('OS')</th>
                                <th scope="col">@lang('Location')</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($UserLogin as $UserLogin)
                        <tr>
                            <td data-input="@lang('Name')">
                                <div class="author">
                                    <div class="content">{{@$UserLogin->user->fullName}}</div>
                                </div>
                            </td>
                            <td data-label="@lang('Date')">{{ showDateTime($UserLogin->created_at) }}</td>

                             <td data-label="@lang('Browser')">{{ $UserLogin->os}}</td>
                            <td data-label="@lang('Location')">{{ $UserLogin->location }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-muted text-center" colspan="100%">{{ $empty_message }}</td>
                        </tr>
                    @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

    @if($sections->secs != null)
        @foreach(json_decode($sections->secs) as $sec)
            @include($activeTemplate.'sections.'.$sec)
        @endforeach
    @endif
@endsection
