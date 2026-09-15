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

            <div class="col-md-2">Answer:</div>
            <div class="col-md-2">Yes</div>
            <div class="col-md-2">{{ $yes }}</div>
            <div class="col-md-2">No</div>
            <div class="col-md-2">{{ $no }}</div>
            <hr>

        </div>
    </div>
</div>
@endsection
