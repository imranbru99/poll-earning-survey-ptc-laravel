@extends($activeTemplate .'layouts.user')
@section('content')
    @include($activeTemplate.'breadcrumb')
    <form method="POST" action="{{$action}}" enctype="multipart/form-data">
        @method('PUT')
        @csrf
  <div class="container">     
                
                    <div class="col-4 col-md-4 col-lg-4">
                        <input type="hidden" name="microjob_id" value="{{$job->id}}">
                    </div>
                       <br> <br>
                                   <label for="inputState">{{ __('Task Description') }}</label>
                                <textarea name="description"  readonly class="form-control" rows="8">{{$job->description}}</textarea>
                            
                        <br> <br>
                            
                                    <label for="inputState">{{ __('What Is Expected From You') }}</label>
                                    <textarea name="set_of_jobs" readonly class="form-control"  @error('jobs') is-invalid @enderror rows="11">{{$job->set_of_jobs}}
                                </textarea>
                            
                            <br> <br>
                                <label for="inputState">{{ __('Enter The Required Proof Of Task Finished') }}</label>
                               <textarea type="text" name="comment" required autofocus class="form-control @error('title') is-invalid @enderror" rows="7"></textarea>      
                            <br> <br>
                           
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label for="inputAttachments">@lang('The Screenshot Required Proof Of Task Finished')</label>
                                    </div>
                                    <div class="col-9 file-upload">
                                        <input type="file" name="attachments[]" id="inputAttachments" class="form-control form-control" />
                                        <div id="fileUploadsContainer"></div>
                                    </div>
                                    <div class="col-3">
                                        <button type="button" class="btn cmn-btn extraTicketAttachment">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                    <div class="col-sm-12 ticket-attachments-message text-muted">
                                        @lang("Allowed File Extensions: .jpg, .jpeg, .png, .pdf, .doc, .docx")
                                    </div>
                                

                       

                        <div class="col-6 col-md-6 col-lg-6 mt-4">
                            <button type="submit" class="btn-info btn addQuestion">Submit for Review</button>
                        </div>
    </div>            </div> 
    </form>
    <br>
    <br>
@endsection

@push('script')
    <script>
        (function ($) {
            "use strict";
            $('.extraTicketAttachment').click(function(){
                $("#fileUploadsContainer").append('<input type="file" name="attachments[]" class="form-control form-control mt-2" required />')
            });
        })(jQuery);

    </script>
@endpush
