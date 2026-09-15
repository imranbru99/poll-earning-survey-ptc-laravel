@extends('admin.layouts.app')
@section('panel')
    <form method="POST" action="{{ route('admin.add_user_plan') }}">
        @csrf
        <div class="container">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-6 col-md-6 col-lg-6 mt-2">
                        <label for="inputState">{{ __('Plan Title') }}</label>
                        <input type="text" name="title" required autofocus class="form-control"
                               placeholder="Plan Title">
                    </div>
                    <div class="col-6 col-md-6 col-lg-6 mt-2">
                        <label for="inputState">{{ __('Percentage') }}</label>
                        <input type="number" name="value"  required autofocus class="form-control"
                               placeholder="Enter Value">
                    </div>
                    <div class="col-2 col-md-2 col-lg-2 mt-4">
                        <button type="submit" class="btn-info btn addQuestion">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

