@extends('admin.layouts.app')
@section('panel')
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
            @foreach($answers as $answer)
            <div class="col-md-2">Answer {{ $loop->index+1 }}:</div>
            <div class="col-md-10">{{ $answer->option }}</div>
            <hr>
            @endforeach
        </div>
    </div>
</div>
@endsection
