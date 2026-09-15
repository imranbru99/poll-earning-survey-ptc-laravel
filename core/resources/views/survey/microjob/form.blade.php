@extends('admin.layouts.app')
@section('panel')
    <form method="POST" action="{{ $action }}">
        @method('PUT')
        @csrf
        <div class="container">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-6 col-md-6 col-lg-6 mt-2">
                        <label for="inputState">{{ __(' Job Title') }}</label>
                        <input type="text" name="title" required autofocus class="form-control @error('title') is-invalid @enderror"
                               placeholder="Job Title"  value="Refer and Earn">
                    </div>
                    <div class="col-12 col-md-12 col-lg-12 mt-4">
                        <label for="inputState">{{ __('Job Description') }}</label>
<textarea name="description"  class="form-control" required rows="11">{{ old('description', $jobs->description) }}
Read Instructions and Work Attentively to get Approved your task
Refer and Earn                      
 </textarea>
                    </div>
                    <div class="col-4 col-md-4 col-lg-4 mt-4">
                        <label for="inputState">{{ __('Job Completion Time') }}</label>
                        <div class="input-group">
                            <input type="number" name="time" required autofocus class="form-control @error('time') is-invalid @enderror"
                                placeholder="Job Completion Time" value="1000">
                            <div class="input-group-prepend">
                                <span class="input-group-text"id="inputGroupPrepend" ><i class="fas fa fa-clock"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 col-md-4 col-lg-4 mt-4">
                        <label for="inputState">Job Limit</label>
                        <input type="number" min="0" name="limit" required autofocus class="form-control @error('amount') is-invalid @enderror"
                               placeholder="Job Limit" value="1000">
                    </div>
                    <div class="col-4 col-md-4 col-lg-4 mt-4">
                        <label for="inputState">Amount</label>
                        <div class="input-group">
                            <input type="text"  name="amount" required autofocus class="form-control @error('amount') is-invalid @enderror"
                                   placeholder="Amount" value="1000">
                            <div class="input-group-prepend">
                                <span class="input-group-text"id="inputGroupPrepend" >USD</span>
                            </div>
                        </div>


                    </div>
                    <div class="col-12 col-md-12 col-lg-12 mt-4">
                        <label for="inputState">{{ __('Instructions') }}</label>
                        <textarea name="set_of_jobs"  class="form-control" required rows="11">{{old('set_of_jobs' ,$jobs->set_of_jobs)}}
Read Attentively these step of this job
1. Refer from Your Refer link
2.  Then confirm your refer deposit 100 USD
3. Then Confirm Silver Plan
4. Then confirm your refer username.
5. When You completed Your task, Then provide the essential document what I demanded above.
6. When You completed uploading and everything done, Then You can submit Your task.
</textarea>                    </div>
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
