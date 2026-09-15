@extends($activeTemplate .'layouts.user')
@section('content')
@include($activeTemplate.'breadcrumb')

<form method="POST" enctype="multipart/form-data" action="{{ route('publisher_user.question.store', $survey->id) }}">
    @csrf
    <div class="container-fluid">
    <div class="row my-2  dynamicQuestionAdded">
        <input type="hidden" name="survey_id" value={{$survey->id}}>

        <div class="col-lg-12 mx-auto px-0">
            <div class="card text-center">
                <div class="card-body moreQuestion px-1">
                    {{-- <h4 class="card-title">Survey Questions Add</h4> --}}
                    <div class="row">
                        <div class="col-lg-3 col-sm-12 mx-auto">
                            <div class="row">
                                <div class="ml-auto  mb-3 ">
                                    <div class="d-flex btnholder flex-column">
                                        <button
                                            class="add-another btn btn-warning addCheckBoxQuestion align-content-center flex"
                                            tabindex="1" data-icon="+">Add CheckBox Question
                                        </button>
                                    </div>
                                </div>
                                <div class="ml-auto  mb-3">
                                    <div class="d-flex btnholder flex-column">
                                        <button
                                            class="add-another btn btn-dark addInputBasebtn align-content-center flex"
                                            tabindex="1" data-icon="+">Add Input Base Question
                                        </button>
                                    </div>
                                </div>
                                <div class="ml-auto  mb-3">
                                    <div class="d-flex btnholder flex-column">
                                        <button
                                            class="add-another btn btn-success addYesNoQbtn align-content-center flex"
                                            tabindex="1" data-icon="+">Add YES | No Question
                                        </button>
                                    </div>
                                </div>
                                <div class="ml-auto  mb-3 mt-3">
                                    <div class="d-flex btnholder flex-column">
                                        <button
                                            class="add-another btn btn-info addVideoBaseQbtn align-content-center flex"
                                            tabindex="1" data-icon="+">Add Video Question Base
                                        </button>
                                    </div>
                                </div>
                                <div class="ml-auto  mb-3 mt-3">
                                    <div class="d-flex btnholder flex-column">
                                        <button
                                            class="add-another btn btn-danger addImageBaseQbtn align-content-center flex"
                                            tabindex="1" data-icon="+">Add Image Question Base
                                        </button>
                                    </div>
                                </div>
                                <div class="ml-auto  mb-3 mt-3">
                                    <div class="d-flex btnholder flex-column">
                                        <button
                                            class="add-another btn btn-primary addLinearQbtn align-content-center flex"
                                            tabindex="1" data-icon="+">Add Linear Base Question
                                        </button>
                                    </div>
                                </div>
                                <div class="ml-auto  mb-3 ">
                                    <div class="d-flex btnholder flex-column">
                                        <button
                                            class="add-another btn btn-secondary addIqQuestionbtn align-content-center flex"
                                            tabindex="1" data-icon="+">Add IQ Question
                                        </button>
                                    </div>
                                </div>

                                <div class="ml-auto  mb-3 ">
                                    <div class="d-flex btnholder flex-column">
                                        <button
                                            class="add-another btn btn-warning addMultichoiceQbtn align-content-center flex"
                                            tabindex="1" data-icon="+">Add MultipleChoice Question
                                        </button>
                                    </div>
                                </div>
                                <div class="ml-auto  mb-3 mt-3">
                                    <div class="d-flex btnholder flex-column">
                                        <button
                                            class="add-another btn btn-info addDropDownQbtn align-content-center flex"
                                            tabindex="1" data-icon="+">Add DropDown Question
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9 col-sm-12">
                            <div class="questionWrapperhold">
                                @if (Session::has('created'))
                                <div class="row">
                                    <div class="alert alert-success col-lg-10 mx-auto text-center py-2 px-3"
                                        role="alert">
                                        {{ Session::get('created') }}
                                    </div>
                                </div>
                                @endif
                                <div class="col-auto questionsListsters">
                                    <p class="lead text-center">Select the Question Type you want to setup</p>

                                    {{--
                                    <label class="sr-only" for="inlineFormInputGroup">Username</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" id="inlineFormInputGroup"
                                            placeholder="input qustion here"
                                            name="MultiChoiceQuestions[questions][lists][]"
                                            value="{{old('MultiChoiceQuestions')}}" required>
                                    </div>
                                    <div class="card card-body">
                                        <div class="row">
                                            <div class="col-6 d-flex">
                                                <label for="optionA">Option A
                                                    <input type="text"
                                                        name="MultiChoiceQuestions[questions][options][A][]"
                                                        class="form-control" value="{{old('optionA')}}">
                                                </label>
                                                <label for="answerOptionA" class="mt-3 ml-1">Is answer
                                                    <input value=1 type="checkbox"
                                                        name="MultiChoiceQuestions[questions][answers][optionA][]"
                                                        class="form-control">
                                                </label>
                                            </div>
                                            <div class="col-6 d-flex">
                                                <label for="optionB">Option B
                                                    <input type="text"
                                                        name="MultiChoiceQuestions[questions][options][B][]"
                                                        class="form-control" value="{{old('optionB')}}">
                                                </label>
                                                <label for="answerOptionB" class="mt-3 ml-1">Is answer
                                                    <input value=1 type="checkbox"
                                                        name="MultiChoiceQuestions[questions][answers][optionB][]"
                                                        class="form-control">
                                                </label>
                                            </div>
                                            <div class="col-6 d-flex">
                                                <label for="optionC">Option C
                                                    <input type="text"
                                                        name="MultiChoiceQuestions[questions][options][C][]"
                                                        class="form-control" value="{{old('optionC')}}">
                                                </label>
                                                <label for="answerOptionC" class="mt-3 ml-1">Is answer
                                                    <input value=1 type="checkbox"
                                                        name="MultiChoiceQuestions[questions][answer][optionC][]"
                                                        class="form-control">
                                                </label>
                                            </div>
                                            <div class="col-6 d-flex">
                                                <label for="optionD">Option D
                                                    <input type="text"
                                                        name="MultiChoiceQuestions[questions][options][D][]"
                                                        class="form-control" value="{{old('optionD')}}">
                                                </label>
                                                <label for="answerOptionD" class="mt-3 ml-1">Is answer
                                                    <input value=1 type="checkbox"
                                                        name="MultiChoiceQuestions[questions][answer][optionD][]"
                                                        class="form-control">
                                                </label>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mx-auto my-3">
                                    <button type="submit" disabled
                                        class="btn btn-primary col-12 btn-lg saveQuestionsNow">Save Question</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</form>
@endsection
@push('script')

    <script>
     $(document).ready(function() {
            //alert("SHSJHS");
        });
</script>
@endpush
