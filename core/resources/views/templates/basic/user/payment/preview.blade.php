
@extends($activeTemplate .'layouts.user')
@section('content')
<section>
    <div class="container">

        <div class="row  justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <ul class="list-group text-center">

                            <li class="list-group-item p-prev-list">
                                <img src="{{ $data->gateway_currency()->methodImage() }}"/>
                            </li>
                            <p class="list-group-item">
                                @lang('Amount'):
                                <strong>{{getAmount($data->amount)}} </strong> {{$general->cur_text}}
                            </p>
                            @if($data->gateway->crypto==1)
                                <p class="list-group-item">
                                    @lang('Conversion with')
                                    <b> {{ $data->method_currency }}</b> @lang('and final value will Show on next step')
                                </p>
                            @endif
                        </ul>
                        <div class="row  justify-content-center">
                        @if($data->method_code<1000)
                        <a href="{{route('user.deposit.confirm')}}" class="btn btn-block py-3 font-weight-bold mt-4 cmn-btn">@lang('Pay Now')</a>
                        @else
                        <a href="{{route('user.deposit.manual.confirm')}}" class="btn btn-block py-3 font-weight-bold mt-4 cmn-btn">@lang('Pay Now')</a>
                        @endif
                    </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>


@endsection

@push('style')
<style type="text/css">
    .p-prev-list img{
        max-width:100px;
        max-height:100px;
        margin:0 auto;
    }
</style>
@endpush
