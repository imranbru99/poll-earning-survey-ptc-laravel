@extends($activeTemplate .'layouts.user')
@section('content')
@include($activeTemplate.'breadcrumb')
<form class="container mb-4 mt-4" method="POST" action="{{ route('publisher_user.store') }}">
    @csrf
    <div class="row">
        <div class="col-12">
            @if (Session::has('survey-created'))
            <div class="alert alert-success p-3" role="alert">
                <h4 class="alert-heading"><strong>{{ __('Survey Craeated') }}</strong></h4>
                <hr><br />
                <p>{{ Session::get('survey-created') }} </p>
            </div>
            @endif
        </div>
        <div class="col">
            <label for="inputState">{{ __('Survey Category') }}</label>
            <select id="inputState" class="form-control @error('category_id') is-invalid @enderror" name="category_id">
                <option value="" selected>Choose Survey Category...</option>
                @forelse ($categories as $key => $category)
                <option {{ old('category')==$key ? "selected" : "" }} value="{{ $category->id }}">{{ $category->name }}
                </option>
                @empty
                @endforelse
            </select>
        </div>
        <div class="col">
            <label for="inputState">{{ __('Survey Title') }}</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                placeholder="Survey name" value={{ old('name') }}>
        </div>
    </div>
    <div class="col mt-4">
        <div class="row">
            <div class="col-6">
                <label for="inputState">{{ __('Survey Description') }}</label>
                <input type="text" name="description" class="form-control @error('description') is-invalid @enderror"
                    placeholder="Survey description" value={{ old('description') }}>
            </div>
            <div class="col-6">
                <label for="inputState">Survey amount</label>
                <input type="text" name="amount" class="form-control @error('amount') is-invalid @enderror"
                    placeholder="Survey amount" value={{ old('amount') }}>
            </div>
            <div class="col-3 mt-4 addqwrapper">
                <button type="submit" class="btn-info btn addQuestion">Save Survey</button>
            </div>
        </div>
    </div>
</form>
{{-- contune the design --}}
@endsection
@push('script')
<script>
    $(document).ready(function() {
            //alert("SHSJHS");
        });
</script>
@endpush
