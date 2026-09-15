@extends('admin.layouts.app')
@section('panel')
<form method="POST" action="{{ route('admin.survey.question.update', $surveyQuestion->survey_id) }}">
    @csrf
    <div class="row my-2  dynamicQuestionAdded">
        {{-- <input type="hidden" name="survey_id" value={{$surveyQuestion->survey_id}}> --}}
        <input type="hidden" name="id" value={{ $surveyQuestion->id }}>
        <div class="col-lg-12 mx-auto px-0">
            <div class="card text-center">
                <div class="card-body moreQuestion px-1">
                    {{-- <h4 class="card-title">Survey Questions</h4> --}}
                    <div class="row">
                        {{-- <div class="col-lg-3 col-sm-12 mx-auto">
                            <div class="row">
                                <div class="ml-auto  mb-3 ">
                                    <div class="d-flex btnholder flex-column">
                                        <button
                                            class="add-another btn btn-warning addMultichoiceQbtn align-content-center flex"
                                            tabindex="1" data-icon="+">Add Multichoice Question
                                        </button>
                                    </div>
                                </div>
                                <div class="ml-auto  mb-3">
                                    <div class="d-flex btnholder flex-column">
                                        <button
                                            class="add-another btn btn-primary addInputBasebtn align-content-center flex"
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
                                <div class="ml-auto  mb-3 mt-3">
                                    <div class="d-flex btnholder flex-column">
                                        <button
                                            class="add-another btn btn-info addDropDownQbtn align-content-center flex"
                                            tabindex="1" data-icon="+">Add DropDown Question
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div> --}}
                        <div class="col-lg-12 col-sm-12">
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
                                    @if($surveyQuestion->questiontype_id == 4)
                                    <div class="addtionalQstns">
                                        <div class="col-auto questionHolders mt-3"><label class="sr-only"
                                                for="inlineFormInputGroup">'+'Username'+'</label>
                                            <div class="input-group mb-2"><input required class="form-control"
                                                    id="inlineFormInputGroup"
                                                    name="imageBaseQuestions[questions][lists][]"
                                                    placeholder="input question here" type="text" /></div>
                                            <div class="input-group mb-2">
                                                <div class="card card-body">
                                                    <div class="row">
                                                        <div class="col-12 d-flex">
                                                            <div class="custom-file"><input type="file" required
                                                                    class="custom-file-input" name="ImageQuestion[]"
                                                                    id="customFile"><label class="custom-file-label"
                                                                    for="customFile">Choose file</label></div>
                                                        </div>
                                                        <div class="card card-body">
                                                            <div class="row">
                                                                <div class="col-6 d-flex"><label for="optionA">Option
                                                                        A<input type="text"
                                                                            name="imageBaseQuestions[questions][options][A][]"
                                                                            class="form-control"></label><label
                                                                        for="answerOptionA" class="mt-3 ml-1">Is
                                                                        answer<input type="checkbox"
                                                                            name="[questions][answers][optionA][]"
                                                                            class="form-control"></label></div>
                                                                <div class="col-6 d-flex"><label for="optionA">Option
                                                                        B<input type="text"
                                                                            name="imageBaseQuestions[questions][options][B][]"
                                                                            class="form-control"></label><label
                                                                        for="answerOptionB" class="mt-3 ml-1">Is
                                                                        answer<input type="checkbox"
                                                                            name="[questions][answers][optionB][]"
                                                                            class="form-control"></label></div>
                                                                <div class="col-6 d-flex"><label for="optionC">Option
                                                                        C<input type="text"
                                                                            name="imageBaseQuestions[questions][options][C]"
                                                                            class="form-control"></label><label
                                                                        for="answerOptionC" class="mt-3 ml-1">Is
                                                                        answer<input type="checkbox"
                                                                            name="[questions][answers][optionC][]"
                                                                            class="form-control"></label></div>
                                                                <div class="col-6 d-flex"><label for="optionD">Option
                                                                        D<input type="text"
                                                                            name="IimageBaseQuestions[questions][options][D]"
                                                                            class="form-control"></label><label
                                                                        for="answerOptionD" class="mt-3 ml-1">Is
                                                                        answer<input type="checkbox"
                                                                            name="[questions][answers][optionD][]"
                                                                            class="form-control"></label></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    @elseif($surveyQuestion->questiontype_id == 1)
                                    <div class="addtionalQstns">
                                        <div class="col-auto questionHolders mt-3"><label class="sr-only"
                                                for="inlineFormInputGroup">Username</label>
                                            <div class="input-group mb-2"><input type="text" class="form-control"
                                                    value="{{ $surveyQuestion->question }}" id="inlineFormInputGroup"
                                                    placeholder="input qustion here" required
                                                    name="MultiChoiceQuestions[questions][lists][]"></div>
                                            <div class="card card-body">
                                                <div class="row">
                                                    <div class="col-6 d-flex"><label for="optionA">Option A <input
                                                                type="text"
                                                                value="{{ $surveyQuestion->questionOptions[0]->option }}"
                                                                name="MultiChoiceQuestions[questions][options][A][]"
                                                                class="form-control"></label>
                                                        <div class="col-5 mt-2"><label for="answerOptionA">Is answer
                                                                <input value=1 type="checkbox"
                                                                    @if($surveyQuestion->questionOptions[0]->isAnswer ==
                                                                1)
                                                                checked
                                                                @endif
                                                                name="MultiChoiceQuestions[questions][answers][optionA][]"
                                                                class="form-control"></label></div>
                                                    </div>
                                                    <div class="col-6 d-flex"><label for="optionB">Option B<input
                                                                type="text"
                                                                name="MultiChoiceQuestions[questions][options][B][]"
                                                                value="{{ $surveyQuestion->questionOptions[1]->option }}"
                                                                class="form-control"></label>
                                                        <div class="col-5 mt-2"><label for="answerOptionB">Is answer
                                                                <input value=1 type="checkbox"
                                                                    @if($surveyQuestion->questionOptions[1]->isAnswer ==
                                                                1)
                                                                checked
                                                                @endif
                                                                name="MultiChoiceQuestions[questions][answers][optionB][]"
                                                                class="form-control"></label></div>
                                                    </div>
                                                    <div class="col-6 d-flex"><label for="optionC">Option C <input
                                                                type="text"
                                                                name="MultiChoiceQuestions[questions][options][C][]"
                                                                value="{{ $surveyQuestion->questionOptions[2]->option }}"
                                                                class="form-control"></label>
                                                        <div class="col-5 mt-2"><label for="answerOptionC">Is answer
                                                                <input value=1 type="checkbox"
                                                                    name="MultiChoiceQuestions[questions][answers][optionC][]"
                                                                    @if($surveyQuestion->questionOptions[2]->isAnswer ==
                                                                1)
                                                                checked
                                                                @endif
                                                                class="form-control"></label></div>
                                                    </div>
                                                    <div class="col-6 d-flex"><label for="optionD">Option D<input
                                                                type="text"
                                                                name="MultiChoiceQuestions[questions][options][D][]"
                                                                value="{{ $surveyQuestion->questionOptions[3]->option }}"
                                                                class="form-control"></label>
                                                        <div class="col-5 mt-2"><label for="answerOptionD">Is answer
                                                                <input value=1 type="checkbox"
                                                                    name="MultiChoiceQuestions[questions][answers][optionD][]"
                                                                    @if($surveyQuestion->questionOptions[3]->isAnswer ==
                                                                1)
                                                                checked
                                                                @endif
                                                                class="form-control"></label></div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    @elseif($surveyQuestion->questiontype_id == 2)
                                    <div class="addtionalQstns">
                                        <div class="col-auto questionHolders mt-3"><label class="sr-only"
                                                for="inlineFormInputGroup">'+'Username'+'</label>
                                            <div class="input-group mb-2">
                                                <input required class="form-control" id="inlineFormInputGroup"
                                                    name="InputBaseQuestions[questions][lists][]"
                                                    value="{{ $surveyQuestion->question }}"
                                                    placeholder="input question here" type="text" />
                                            </div>
                                        </div>
                                    </div>
                                    @elseif($surveyQuestion->questiontype_id == 3)
                                    <div class="addtionalQstns">
                                        <div class="col-auto questionHolders mt-3"><label class="sr-only"
                                                for="inlineFormInputGroup">'+'Username'+'</label>
                                            <div class="input-group mb-2"><input required class="form-control"
                                                    id="inlineFormInputGroup" name="YesNoQuestions[questions][lists][]"
                                                    placeholder="input question here"
                                                    value="{{ $surveyQuestion->question }}" type="text" />
                                            </div>
                                            <div class="card card-body">
                                                <div class="row">
                                                    <div class="col-6 d-flex">
                                                        <label for="optionA">Yes Option <input required type="text"
                                                                name="YesNoQuestions[questions][options][YesOptions][]"
                                                                value="{{ $surveyQuestion->questionOptions[0]->option }}"
                                                                class="form-control"></label>
                                                        <div class="col-5 mt-2">
                                                            <label for="answerOptionYes">Is
                                                                answer <input type="checkbox"
                                                                    @if($surveyQuestion->questionOptions[1]->isAnswer ==
                                                                1)
                                                                checked
                                                                @endif
                                                                name="YesNoQuestions[questions][answers][Yesanswer][]"
                                                                class="form-control"></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 d-flex">
                                                        <label for="optionB">No Option <input required type="text"
                                                                name="YesNoQuestions[questions][options][NoOptions][]"
                                                                value="{{ $surveyQuestion->questionOptions[1]->option }}"
                                                                class="form-control"></label>
                                                        <div class="col-5 mt-2"><label for="answerOptionB">Is answer
                                                                <input type="checkbox"
                                                                    @if($surveyQuestion->questionOptions[1]->isAnswer ==
                                                                1) checked @endif
                                                                name="YesNoQuestions[questions][answers][Noanswer][]"
                                                                class="form-control"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @elseif($surveyQuestion->questiontype_id == 5)
                                    <div class="addtionalQstns">
                                        <div class="col-auto questionHolders mt-3"><label class="sr-only"
                                                for="inlineFormInputGroup">'+'Username'+'</label>
                                            <div class="input-group mb-2"><input class="form-control"
                                                    id="inlineFormInputGroup" name="LinearQuestions[questions][lists][]"
                                                    value="{{ $surveyQuestion->question }}" required
                                                    placeholder="input question here" type="text" /></div>
                                            <div class="input-group mb-2">
                                                <div class="card card-body">
                                                    <div class="row">
                                                        @php
                                                        $options =
                                                        App\Models\Survey\Questionvalue::where('survey_question_id',
                                                        $surveyQuestion->id)->first();
                                                        @endphp
                                                        <div class="col-6 d-flex"><label for="minVal">Minimum
                                                                Value <input class="form-control" required
                                                                    name="LinearQuestions[questions][options][minVal][]"
                                                                    value="{{ $options->MinVal }}"
                                                                    type="text" /></label>
                                                        </div>
                                                        <div class="col-6 d-flex">
                                                            <label for="optionB"> Maximum
                                                                Value <input required class="form-control"
                                                                    name="LinearQuestions[questions][options][maxVal][]"
                                                                    value="{{ $options->MaxVal }}"
                                                                    type="text" /></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @elseif($surveyQuestion->questiontype_id == 6)
                                    <div class="addtionalQstns">
                                        <div class="col-auto questionHolders mt-3"><label class="sr-only"
                                                for="inlineFormInputGroup">Username</label>
                                            <div class="input-group mb-2"><input type="text" class="form-control"
                                                    id="inlineFormInputGroup" value="{{ $surveyQuestion->question }}"
                                                    placeholder="DROP DOWN SELECT FORM QUESTION: input qustion here"
                                                    required name="dropDownQuestions[questions][lists][]">
                                            </div>
                                            <div class="card card-body">
                                                <div class="row">
                                                    <div class="col-6 d-flex"><label for="optionA">Option A
                                                            <input type="text"
                                                                name="dropDownQuestions[questions][options][A][]"
                                                                value="{{ $surveyQuestion->questionOptions[0]->option }}"
                                                                class="form-control"></label>
                                                        <div class="col-5 mt-2"><label for="answerOptionA">Is
                                                                answer <input value=1 type="checkbox"
                                                                    @if($surveyQuestion->questionOptions[0]->isAnswer ==
                                                                1)
                                                                checked
                                                                @endif
                                                                name="dropDownQuestions[questions][answers][optionA][]"
                                                                class="form-control"></label></div>
                                                    </div>
                                                    <div class="col-6 d-flex"><label for="optionB">Option
                                                            B<input type="text"
                                                                name="dropDownQuestions[questions][options][B][]"
                                                                value="{{ $surveyQuestion->questionOptions[1]->option }}"
                                                                class="form-control"></label>
                                                        <div class="col-5 mt-2"><label for="answerOptionB">Is
                                                                answer <input value=1 type="checkbox"
                                                                    @if($surveyQuestion->questionOptions[1]->isAnswer ==
                                                                1)
                                                                checked
                                                                @endif
                                                                name="dropDownQuestions[questions][answers][optionB][]"
                                                                class="form-control"></label></div>
                                                    </div>
                                                    <div class="col-6 d-flex"><label for="optionC">Option C
                                                            <input type="text"
                                                                name="dropDownQuestions[questions][options][C][]"
                                                                value="{{ $surveyQuestion->questionOptions[2]->option }}"
                                                                class="form-control"></label>
                                                        <div class="col-5 mt-2"><label for="answerOptionC">Is
                                                                answer <input value=1 type="checkbox"
                                                                    @if($surveyQuestion->questionOptions[2]->isAnswer ==
                                                                1)
                                                                checked
                                                                @endif
                                                                name="dropDownQuestions[questions][answers][optionC][]"
                                                                class="form-control"></label></div>
                                                    </div>
                                                    <div class="col-6 d-flex"><label for="optionD">Option
                                                            D<input type="text"
                                                                name="dropDownQuestions[questions][options][D][]"
                                                                value="{{ $surveyQuestion->questionOptions[3]->option }}"
                                                                class="form-control"></label>
                                                        <div class="col-5 mt-2"><label for="answerOptionD">Is
                                                                answer <input value=1 type="checkbox"
                                                                    @if($surveyQuestion->questionOptions[3]->isAnswer ==
                                                                1)
                                                                checked
                                                                @endif
                                                                name="dropDownQuestions[questions][answers][optionD][]"
                                                                class="form-control"></label></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    {{-- <p class="lead text-center">Select the Question Type you want to setup
                                    </p> --}}
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
                                    <button type="submit" {{-- disabled --}}
                                        class="btn btn-primary col-12 btn-lg saveQuestionsNow">Save
                                        Question</button>
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
