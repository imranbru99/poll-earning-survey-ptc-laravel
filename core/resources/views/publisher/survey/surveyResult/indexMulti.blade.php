@extends($activeTemplate .'layouts.user')
@section('content')
@include($activeTemplate.'breadcrumb')
    <style>
        span{
            font-size: 10px;
        }
    </style>
    <div class="container">
        <div class="card">
            <div class="row bg-secondary">
                <div class="col-md-2">Question</div>
                <div class="col-md-10">{{ $question }}</div>
                <br>
            </div>
        </div>
        <div class="card">
            <div class="row p-3">
                <div class="col-6">A : <span>( Ratio : {{$result['a']}}/{{$result['total']}} ) </span> </div>
                <div class="col-6">B : <span>( Ratio : {{$result['b']}}/{{$result['total']}} ) </span> </div>
                <div class="col-6">C : <span>( Ratio : {{$result['c']}}/{{$result['total']}} ) </span> </div>
                <div class="col-6">D : <span>( Ratio : {{$result['d']}}/{{$result['total']}} ) </span> </div>
                <hr>
            </div>
        </div>
    </div>
@endsection
