@extends($activeTemplate .'layouts.user')
@section('content')
@include($activeTemplate.'breadcrumb')
<div class="container mt-4 mb-4">
    <form method="POST" action="{{ $action }}">
        @method('PUT')
        @csrf
        <div class="container">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-6 col-md-6 col-lg-6 mt-2">
                        <label for="inputState">{{ __(' Job Title') }}</label>
                        <input type="text" name="title" required autofocus class="form-control @error('title') is-invalid @enderror"
                               placeholder="Job Title"  value="{{ old('title', $jobs->title) }}">
                    </div>
                    <div class="col-6 col-md-6 col-lg-6 mt-2">
                        <label for="inputState">{{ __(' Category Title') }}</label>
                        <select id="inputState" required class="form-control @error('category_id') is-invalid @enderror" name="category_id">
                            <option value="" selected disabled>Choose Category Title...</option>
                            @forelse ($categories as $key => $category)
                                <option  value="{{ $category->id }}" {{ ($category->id == old('$category->id', $jobs->category_id))?'selected':'' }}>{{ $category->name }}
                                </option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12 mt-4">
                        <label for="inputState">{{ __('Job Description') }}</label>
<textarea name="description"  class="form-control" required rows="11">{{ old('description', $jobs->description) }}
স্টেপ ভাল করে পড়ুন ও প্রয়োজনীয় তথ্য ডিসক্রিপশন বক্স থেকে কপি করুন।</textarea>
                    </div>
                    <div class="col-4 col-md-4 col-lg-4 mt-4">
                        <label for="inputState">{{ __('Job Completion Time') }}</label>
                        <div class="input-group">
                            <input type="number" name="time" required autofocus class="form-control @error('time') is-invalid @enderror"
                                placeholder="Job Completion Time" value="{{ old('time', $jobs->time) }}">
                            <div class="input-group-prepend">
                                <span class="input-group-text"id="inputGroupPrepend" ><i class="fas fa fa-clock"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 col-md-4 col-lg-4 mt-4">
                        <label for="inputState">Job Limit</label>
                        <input type="number" min="0" name="limit" required autofocus class="form-control @error('amount') is-invalid @enderror"
                               placeholder="Job Limit" value="{{ old('amount', $jobs->limit) }}">
                    </div>
                    <div class="col-4 col-md-4 col-lg-4 mt-4">
                        <label for="inputState">Amount</label>
                        <div class="input-group">
                            <input type="text"  name="amount" required autofocus class="form-control @error('amount') is-invalid @enderror"
                                   placeholder="Amount" value="{{ old('amount', $jobs->amount) }}">
                            <div class="input-group-prepend">
                                <span class="input-group-text"id="inputGroupPrepend" >TK</span>
                            </div>
                        </div>


                    </div>
                    <div class="col-12 col-md-12 col-lg-12 mt-4">
                        <label for="inputState">{{ __('Step Of Jobs') }}</label>
                        <textarea name="set_of_jobs"  class="form-control" required rows="11">{{old('set_of_jobs' ,$jobs->set_of_jobs)}}
নিচের স্টেপ অবশ্যই ভাল করে পড়ুন।
১. 
২. 
৩. 
৪. 
৫. 
৬. কাজ টি শেষ করে আপনার কাজের ছবি আপলোড করুন নিচে এবং আপনার ডিসক্রিপসন বক্সে আপনার কাজের লিংক দিন।
৭. সব ভাল ভাবে শেষ হলে সাবমিট ক্লিক করুন।</textarea>                    </div>
                    <div class="col-2 col-md-2 col-lg-2 mt-4">
                        <button type="submit" class="btn-info btn addQuestion">Save Jobs</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    {{-- contune the design --}}
@endsection
@push('script')
    <script>
        // $(document).ready(function() {
        //     $('input[type=number]').keypress(function (e) {
        //         var charCode = (e.which) ? e.which : event.keyCode
        //         if (String.fromCharCode(charCode).match(/[^0-9]/g))
        //             return false;
        //     });
        // });
    </script>
@endpush
