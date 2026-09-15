@extends($activeTemplate . 'layouts.user')
@section('content')
    @include($activeTemplate . 'breadcrumb')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    @php
        $openText = 0;
    @endphp
    <form action="{{ route('user.store.survey') }}" method="post">
        @csrf
        <input type="hidden" name="survey_id" value="{{ $surveyQuestions[0]->survey_id }}">
        @foreach ($surveyQuestions as $surveyQuestion)
            @php
                $i = $loop->index;
            @endphp
            <div class="tab-pane {{ $i == 0 ? 'active' : '' }}" style="{{ $i == 0 ? '' : 'display: none' }}"
                id="tab{{ $i }}">
                <div class="container">
                    <div class="card">
                        <div class="card-header">
                            <div class="text-center">
                                Poll Earning
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row bg-secondary p-1" style="color:white">
                                <div class="col-12">
                                    Question {{ $loop->index + 1 }}:
                                </div>
                            </div>
                            <div class="row p-1">
                                <div class="col-12">
                                    {{ $surveyQuestion->question }}
                                </div>
                            </div>
                            <div class="row p-1">
                                <div class="col-12">
                                    @if ($surveyQuestion->questiontype_id == 1)
                                        <div class="addtionalQstns">
                                            <div class="col-auto questionHolders mt-3">
                                                <div class="input-group mb-2">
                                                    <input type="hidden" class="form-control"
                                                        value="{{ $surveyQuestion->id }}" id="inlineFormInputGroup"
                                                        placeholder="input qustion here"
                                                        name="MultiChoiceQuestions[questions][lists][]">
                                                </div>
                                                <div class="card card-body">
                                                    <div class="row">
                                                        <div class="col-6 d-flex">
                                                            <input type="radio"
                                                                name="MultiChoiceQuestions[questions][options][{{ $surveyQuestion->id }}][A]"
                                                                onclick="checkCho('A',{{ $surveyQuestion->id }},{{ $i }})"
                                                                value="{{ $surveyQuestion->questionOptions[0]->option }}">
                                                            &nbsp;{{ $surveyQuestion->questionOptions[0]->option }}
                                                        </div>
                                                        <div class="col-6 d-flex">
                                                            <input type="radio"
                                                                name="MultiChoiceQuestions[questions][options][{{ $surveyQuestion->id }}][B]"
                                                                onclick="checkCho('B',{{ $surveyQuestion->id }},{{ $i }})"
                                                                value="{{ $surveyQuestion->questionOptions[1]->option }}">
                                                            &nbsp;{{ $surveyQuestion->questionOptions[1]->option }}
                                                        </div>
                                                        <div class="col-6 d-flex">
                                                            <input type="radio"
                                                                name="MultiChoiceQuestions[questions][options][{{ $surveyQuestion->id }}][C]"
                                                                onclick="checkCho('C',{{ $surveyQuestion->id }},{{ $i }})"
                                                                value="{{ $surveyQuestion->questionOptions[2]->option }}">
                                                            &nbsp;{{ $surveyQuestion->questionOptions[2]->option }}
                                                        </div>
                                                        <div class="col-6 d-flex">
                                                            <input type="radio"
                                                                name="MultiChoiceQuestions[questions][options][{{ $surveyQuestion->id }}][D]"
                                                                onclick="checkCho('D',{{ $surveyQuestion->id }},{{ $i }})"
                                                                value="{{ $surveyQuestion->questionOptions[3]->option }}">
                                                            &nbsp;{{ $surveyQuestion->questionOptions[3]->option }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            var j = 0;

                                            function checkCho(op, id, i) {

                                                document.getElementById('next' + i).style.display = "";
                                                var inc = i + 1;
                                                document.getElementById('next' + inc).style.display = "none";

                                                // var c = false;

                                                // c = document.getElementsByName("MultiChoiceQuestions[questions][options]["+id+"]["+op+"]")[0].checked;
                                                // if(c === true){
                                                //     document.getElementById('next'+i).style.display="";
                                                //     j++;
                                                // }
                                                // else{
                                                //     j--;
                                                //     if(j===0 ){
                                                //     document.getElementById('next'+i).style.display="none";
                                                //     }
                                                // }
                                            }
                                        </script>
                                    @elseif($surveyQuestion->questiontype_id == 7)
                                        <div class="addtionalQstns">
                                            <div class="col-auto questionHolders mt-3">
                                                <input type="hidden" value="{{ $i }}"
                                                    id="MultiChoiceQuestions">
                                                <div class="input-group mb-2">
                                                    <input type="hidden" class="form-control"
                                                        value="{{ $surveyQuestion->id }}" id="inlineFormInputGroup"
                                                        placeholder="input qustion here"
                                                        name="MultiChoiceQuestions[questions][lists][]">
                                                </div>
                                                <div class="card card-body">
                                                    <div class="row">
                                                        <div class="col-6 d-flex">
                                                            <input type="radio" class="MultiChoiceQuestions"
                                                                name="MultiChoiceQuestions[questions][options][{{ $surveyQuestion->id }}][A]"
                                                                onclick="c('A',{{ $surveyQuestion->id }},{{ $i }}, {{ $surveyQuestion->questionOptions[0]->isAnswer ? $surveyQuestion->questionOptions[0]->isAnswer : 'false' }})"
                                                                value="{{ $surveyQuestion->questionOptions[0]->option }}">
                                                            &nbsp;{{ $surveyQuestion->questionOptions[0]->option }}
                                                        </div>
                                                        <div class="col-6 d-flex">
                                                            <input type="radio" class="MultiChoiceQuestions"
                                                                name="MultiChoiceQuestions[questions][options][{{ $surveyQuestion->id }}][A]"
                                                                onclick="c('B',{{ $surveyQuestion->id }},{{ $i }}, {{ $surveyQuestion->questionOptions[1]->isAnswer ? $surveyQuestion->questionOptions[1]->isAnswer : 'false' }})"
                                                                value="{{ $surveyQuestion->questionOptions[1]->option }}">
                                                            &nbsp;{{ $surveyQuestion->questionOptions[1]->option }}
                                                        </div>
                                                        <div class="col-6 d-flex">
                                                            <input type="radio" class="MultiChoiceQuestions"
                                                                name="MultiChoiceQuestions[questions][options][{{ $surveyQuestion->id }}][A]"
                                                                onclick="c('C',{{ $surveyQuestion->id }},{{ $i }}, {{ $surveyQuestion->questionOptions[2]->isAnswer ? $surveyQuestion->questionOptions[2]->isAnswer : 'false' }})"
                                                                value="{{ $surveyQuestion->questionOptions[2]->option }}">
                                                            &nbsp;{{ $surveyQuestion->questionOptions[2]->option }}
                                                        </div>
                                                        <div class="col-6 d-flex">
                                                            <input type="radio" class="MultiChoiceQuestions"
                                                                name="MultiChoiceQuestions[questions][options][{{ $surveyQuestion->id }}][A]"
                                                                onclick="c('D',{{ $surveyQuestion->id }},{{ $i }}, {{ $surveyQuestion->questionOptions[3]->isAnswer ? $surveyQuestion->questionOptions[3]->isAnswer : 'false' }})"
                                                                value="{{ $surveyQuestion->questionOptions[3]->option }}">
                                                            &nbsp;{{ $surveyQuestion->questionOptions[3]->option }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            // $(document).on('click','.MultiChoiceQuestions',function(){
                                            //     var i = parseInt($('#MultiChoiceQuestions').val());
                                            //     alert(i)
                                            //     document.getElementById('next'+i).style.display = "block";
                                            // });
                                            function c(p1, p2, p3, cr) {
                                                if (cr == 1) {
                                                    document.getElementById('next' + p3).style.display = "";
                                                    var inc = p3 + 1;
                                                    document.getElementById('next' + inc).style.display = "none";
                                                } else {
                                                    window.location.href = "{{ route('user.survey') }}";
                                                    document.getElementById('next' + p3).style.display = "none";
                                                }


                                                // if (typeof(cr) === "undefined"){
                                                //     document.getElementById('next'+p3).style.display="";
                                                //     document.getElementById('next'+p3).style.display="none";
                                                // } else {
                                                //     document.getElementById('next'+p3).style.display="none";
                                                //     document.getElementById('next'+p3).style.display="";
                                                // }
                                            }
                                            var j = 0;
                                            // function check(op,id,i){
                                            //     var c = false;
                                            //     c = document.getElementsByName("MultiChoiceQuestions[questions][options]["+id+"]["+op+"]")[0].checked;
                                            //     if(c === true){
                                            //         document.getElementById('next'+i).style.display="";
                                            //         j++;
                                            //     }
                                            //     else{
                                            //         j--;
                                            //         if(j===0 ){
                                            //             document.getElementById('next'+i).style.display="none";
                                            //         }
                                            //     }
                                            // }
                                        </script>
                                    @elseif($surveyQuestion->questiontype_id == 8)
                                        <div class="addtionalQstns">
                                            <div class="col-auto questionHolders mt-3">
                                                <div class="input-group mb-2">
                                                    <input type="hidden" class="form-control"
                                                        value="{{ $surveyQuestion->id }}" id="inlineFormInputGroup"
                                                        placeholder="input qustion here"
                                                        name="MultiChoiceQuestions[questions][lists][]">
                                                </div>
                                                <div class="card card-body">
                                                    <div class="row">
                                                        <div class="col-6">

                                                            <iframe width="420" height="345"
                                                                src="{{ $surveyQuestion->link }} ">
                                                            </iframe>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card card-body">
                                                    <div class="row">
                                                        <div class="col-6 d-flex">
                                                            <input type="radio"
                                                                name="MultiChoiceQuestions[questions][options][{{ $surveyQuestion->id }}][A]"
                                                                onclick="checkVideo('A',{{ $surveyQuestion->id }},{{ $i }})"
                                                                value="{{ $surveyQuestion->questionOptions[0]->option }}">
                                                            &nbsp;{{ $surveyQuestion->questionOptions[0]->option }}
                                                        </div>
                                                        <div class="col-6 d-flex">
                                                            <input type="radio"
                                                                name="MultiChoiceQuestions[questions][options][{{ $surveyQuestion->id }}][A]"
                                                                onclick="checkVideo('B',{{ $surveyQuestion->id }},{{ $i }})"
                                                                value="{{ $surveyQuestion->questionOptions[1]->option }}">
                                                            &nbsp;{{ $surveyQuestion->questionOptions[1]->option }}
                                                        </div>
                                                        <div class="col-6 d-flex">
                                                            <input type="radio"
                                                                name="MultiChoiceQuestions[questions][options][{{ $surveyQuestion->id }}][A]"
                                                                onclick="checkVideo('C',{{ $surveyQuestion->id }},{{ $i }})"
                                                                value="{{ $surveyQuestion->questionOptions[2]->option }}">
                                                            &nbsp;{{ $surveyQuestion->questionOptions[2]->option }}
                                                        </div>
                                                        <div class="col-6 d-flex">
                                                            <input type="radio"
                                                                name="MultiChoiceQuestions[questions][options][{{ $surveyQuestion->id }}][A]"
                                                                onclick="checkVideo('D',{{ $surveyQuestion->id }},{{ $i }})"
                                                                value="{{ $surveyQuestion->questionOptions[3]->option }}">
                                                            &nbsp;{{ $surveyQuestion->questionOptions[3]->option }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            var j = 0;

                                            function checkVideo(op, id, i) {
                                                document.getElementById('next' + i).style.display = "";
                                                var inc = i + 1;
                                                document.getElementById('next' + inc).style.display = "none";

                                                // var c = false;
                                                // c = document.getElementsByName("MultiChoiceQuestions[questions][options]["+id+"]["+op+"]")[0].checked;
                                                // if(c === true){
                                                //     document.getElementById('next'+i).style.display="";
                                                //     j++;
                                                // }
                                                // else{
                                                //     j--;
                                                //     if(j===0 ){
                                                //         document.getElementById('next'+i).style.display="none";
                                                //     }
                                                // }
                                            }
                                        </script>
                                    @elseif($surveyQuestion->questiontype_id == 2)
                                        @php
                                            $openText++;
                                        @endphp
                                        <div class="addtionalQstns">
                                            <div class="col-auto questionHolders mt-3">
                                                <div class="input-group mb-2">
                                                    <textarea class="form-control d-none" id="inlineFormInputGroup" name="InputBaseQuestions[questions][lists][]"
                                                        value="{{ $surveyQuestion->id }}" placeholder="input answer here" type="hidden"></textarea>
                                                    <textarea class="form-control" id="inlineFormInputGroup"
                                                        onkeyup="ontext({{ $surveyQuestion->id }},{{ $i }},{{ $openText }})"
                                                        name="InputBaseQuestions[answers][lists][]" placeholder="input answer here" cols="30" rows="5"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            function ontext(id, i, openText) {
                                                if (document.getElementsByName("InputBaseQuestions[answers][lists][" + openText + "]").value != '') {
                                                    document.getElementById('next' + i).style.display = "";
                                                    var inc = i + 1;
                                                    document.getElementById('next' + inc).style.display = "none";
                                                } else
                                                    document.getElementById('next' + i).style.display = "none";
                                            }
                                        </script>
                                    @elseif($surveyQuestion->questiontype_id == 3)
                                        <div class="addtionalQstns">
                                            <div class="col-auto questionHolders mt-3">
                                                <div class="input-group mb-2"><input class="form-control"
                                                        id="inlineFormInputGroup"
                                                        name="YesNoQuestions[questions][lists][]"
                                                        value="{{ $surveyQuestion->id }}" type="hidden" />
                                                    <div class="card card-body">
                                                        <div class="row">
                                                            <div class="align-self-start">
                                                                <input type="radio"
                                                                    onclick="radio('A',{{ $surveyQuestion->id }}, {{ $i }})"
                                                                    name="YesNoQuestions[questions][options][{{ $surveyQuestion->id }}]"
                                                                    style="height: 20px">
                                                                <label for="optionA">
                                                                    {{ $surveyQuestion->questionOptions[0]->option }}
                                                                </label>
                                                            </div>
                                                            <div class="align-self-stretch">
                                                                <input type="radio"
                                                                    onclick="radio('B',{{ $surveyQuestion->id }}, {{ $i }})"
                                                                    name="YesNoQuestions[questions][options][{{ $surveyQuestion->id }}]"
                                                                    style="height: 20px">
                                                                <label for="optionB">
                                                                    {{ $surveyQuestion->questionOptions[1]->option }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            var j = 0;

                                            function radio(op, id, i) {
                                                document.getElementById('next' + i).style.display = "";
                                                var inc = i + 1;
                                                document.getElementById('next' + inc).style.display = "none";

                                                // var c = false;
                                                // c = document.getElementsByName("YesNoQuestions[questions][options]["+id+"]")[0].checked;
                                                // if(c == true){
                                                //     document.getElementById('next'+i).style.display="";
                                                //     j++;
                                                // }
                                                // else{
                                                //     j--;
                                                //     if(j==0 ){
                                                //     document.getElementById('next'+i).style.display="none";
                                                //     }
                                                // }
                                            }
                                        </script>
                                    @elseif($surveyQuestion->questiontype_id == 4)
                                        <div class="addtionalQstns">
                                            <div class="col-auto questionHolders mt-3">
                                                <div class="input-group mb-2">
                                                    <input type="hidden" class="form-control"
                                                        value="{{ $surveyQuestion->id }}" id="inlineFormInputGroup"
                                                        placeholder="input qustion here"
                                                        name="MultiChoiceQuestions[questions][lists][]">
                                                </div>
                                                <div class="card card-body">
                                                    <div class="row">
                                                        <div>
                                                            @php
                                                                $opt = App\Models\Survey\Questionimage::where('survey_question_id', $surveyQuestion->id)->pluck('Image');
                                                            @endphp

                                                            <img src="{{ asset('uploads/survey/' . substr($opt, 2, -2)) }}"
                                                                style="margin-left: 10px" height="50%" width="50%"
                                                                alt="Product Image">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card card-body">
                                                    <div class="row">
                                                        <div class="col-6 d-flex">
                                                            <input type="checkbox"
                                                                name="MultiChoiceQuestions[questions][options][{{ $surveyQuestion->id }}][A]"
                                                                onclick="check('A',{{ $surveyQuestion->id }},{{ $i }})"
                                                                value="{{ $surveyQuestion->questionOptions[0]->option }}">
                                                            &nbsp;{{ $surveyQuestion->questionOptions[0]->option }}
                                                        </div>
                                                        <div class="col-6 d-flex">
                                                            <input type="checkbox"
                                                                name="MultiChoiceQuestions[questions][options][{{ $surveyQuestion->id }}][B]"
                                                                onclick="check('B',{{ $surveyQuestion->id }},{{ $i }})"
                                                                value="{{ $surveyQuestion->questionOptions[1]->option }}">
                                                            &nbsp;{{ $surveyQuestion->questionOptions[1]->option }}
                                                        </div>
                                                        <div class="col-6 d-flex">
                                                            <input type="checkbox"
                                                                name="MultiChoiceQuestions[questions][options][{{ $surveyQuestion->id }}][C]"
                                                                onclick="check('C',{{ $surveyQuestion->id }},{{ $i }})"
                                                                value="{{ $surveyQuestion->questionOptions[2]->option }}">
                                                            &nbsp;{{ $surveyQuestion->questionOptions[2]->option }}
                                                        </div>
                                                        <div class="col-6 d-flex">
                                                            <input type="checkbox"
                                                                name="MultiChoiceQuestions[questions][options][{{ $surveyQuestion->id }}][D]"
                                                                onclick="check('D',{{ $surveyQuestion->id }},{{ $i }})"
                                                                value="{{ $surveyQuestion->questionOptions[3]->option }}">
                                                            &nbsp;{{ $surveyQuestion->questionOptions[3]->option }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            var j = 0;

                                            function check(op, id, i) {
                                                document.getElementById('next' + i).style.display = "";
                                                var inc = i + 1;
                                                document.getElementById('next' + inc).style.display = "none";

                                                // var c = false;

                                                // c === document.getElementsByName("MultiChoiceQuestions[questions][options]["+id+"]["+op+"]")[0].checked;
                                                // if(c === true){
                                                //     document.getElementById('next'+i).style.display="";
                                                //     j++;
                                                // }
                                                // else{
                                                //     j--;
                                                //     if(j==0 ){
                                                //         document.getElementById('next'+i).style.display="none";
                                                //     }
                                                // }
                                            }
                                        </script>
                                    @elseif($surveyQuestion->questiontype_id == 5)
                                        <div class="addtionalQstns">
                                            <div class="col-auto questionHolders mt-3">
                                                <div class="input-group mb-2"><input class="form-control"
                                                        id="inlineFormInputGroup"
                                                        name="LinearQuestions[questions][lists][]"
                                                        value="{{ $surveyQuestion->id }}"
                                                        placeholder="input question here" type="hidden" />
                                                </div>
                                                <div class="input-group mb-2">
                                                    <div class="card card-body">
                                                        <div class="row">
                                                            @php
                                                                $options = App\Models\Survey\Questionvalue::where('survey_question_id', $surveyQuestion->id)->first();
                                                            @endphp
                                                            Lower
                                                            @for ($j = $options->MinVal; $j <= $options->MaxVal; $j++)
                                                                <div class="col-1 d-flex">
                                                                    <input style="height: 20px"
                                                                        id="vv{{ $surveyQuestion->id }}2{{ $j }}"
                                                                        onclick="vaal({{ $surveyQuestion->id }},{{ $i }},{{ $j }})"
                                                                        name="LinearQuestions[questions][options][{{ $surveyQuestion->id }}]"
                                                                        type="radio"
                                                                        value="{{ $j }}" />{{ $j }}
                                                                </div>
                                                            @endfor
                                                            Higher
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            function vaal(id, i, j) {
                                                document.getElementById('next' + i).style.display = "";
                                                var inc = i + 1;
                                                document.getElementById('next' + inc).style.display = "none";

                                                // var c = false;
                                                // c = document.getElementById("vv"+id+"2"+j).checked;
                                                // if(c == true){
                                                //     document.getElementById('next'+i).style.display="";
                                                // }
                                                // else{
                                                //     document.getElementById('next'+i).style.display="none";
                                                // }
                                            }
                                        </script>
                                    @elseif($surveyQuestion->questiontype_id == 6)
                                        <div class="addtionalQstns">
                                            <div class="col-auto questionHolders mt-3">
                                                <div class="input-group mb-2"><input type="hidden" class="form-control"
                                                        id="inlineFormInputGroup" value="{{ $surveyQuestion->id }}"
                                                        name="dropDownQuestions[questions][lists][]">
                                                </div>
                                                <div class="card">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <select name="dropDownQuestions[questions][options][]"
                                                                class="form-control"
                                                                onchange="DropDownQuestion({{ $i }})">
                                                                <option
                                                                    value="{{ $surveyQuestion->questionOptions[0]->option }}">
                                                                    {{ $surveyQuestion->questionOptions[0]->option }}
                                                                </option>
                                                                <option
                                                                    value="{{ $surveyQuestion->questionOptions[1]->option }}">
                                                                    {{ $surveyQuestion->questionOptions[1]->option }}
                                                                </option>
                                                                <option
                                                                    value="{{ $surveyQuestion->questionOptions[2]->option }}">
                                                                    {{ $surveyQuestion->questionOptions[2]->option }}
                                                                </option>
                                                                <option
                                                                    value="{{ $surveyQuestion->questionOptions[3]->option }}">
                                                                    {{ $surveyQuestion->questionOptions[3]->option }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <script type="text/javascript">
                                            function DropDownQuestion(i) {
                                                document.getElementById('next' + i).style.display = "";
                                                var inc = i + 1;
                                                document.getElementById('next' + inc).style.display = "none";

                                            }
                                        </script>
                                    @endif
                                    <hr>
                                    <div class="row">
                                        <div class="col-12">
                                            @if ($i != $surveyQuestions->count() - 1)
                                                <a onclick="nextActive({{ $i }},{{ $i + 1 }})"
                                                    id="next{{ $i }}" class="btn btn-primary btnNext"
                                                    style="color: white; @if (
                                                        $surveyQuestion->questiontype_id == 1 ||
                                                            $surveyQuestion->questiontype_id == 2 ||
                                                            $surveyQuestion->questiontype_id == 3 ||
                                                            $surveyQuestion->questiontype_id == 4 ||
                                                            $surveyQuestion->questiontype_id == 5 ||
                                                            $surveyQuestion->questiontype_id == 6 ||
                                                            $surveyQuestion->questiontype_id == 7 ||
                                                            $surveyQuestion->questiontype_id == 8) display:none @endif">Next</a>


                                                <button id="n{{ $i }}" class="btn btn-primary btnNext"
                                                    style="color: white;display:none" name="reject" value="1"
                                                    type="submit">Next</button>
                                            @endif

                                            @if (!$loop->first)
                                                @if ($i != $surveyQuestions->count() - 1 || $i == $surveyQuestions->count() - 1)
                                                    <a id="pre"
                                                        onclick="preActive({{ $i }},{{ $i - 1 }})"
                                                        class="btn btn-primary btnPrevious"
                                                        style="color: white">Previous</a>
                                                    @if ($loop->last)
                                                        <input type="submit" id="next{{ $i }}"
                                                            value="Submit" style="display: none;"
                                                            class="btn btn-primary btn-sm">
                                                    @endif
                                                @endif
                                            @elseif($loop->last)
                                                <input type="submit" id="next{{ $i }}"
                                                    style="display: none;" value="Submit" class="btn btn-primary btn-sm">
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </form>

    <script>
        function nextActive(oid, id) {
            $('#tab' + oid).removeClass("active")
            $('#tab' + oid).css('display', "none")
            $('#tab' + id).css('display', "")
            $('#tab' + id).addClass("active")
        }

        function preActive(oid, id) {
            $('#tab' + oid).removeClass("active")
            $('#tab' + oid).css('display', "none")
            $('#tab' + id).css('display', "")
            $('#tab' + id).addClass("active")
        }

        $(document).ready(function() {

            //Disable cut copy paste

            $(document).bind('cut copy paste', function(e) {

                e.preventDefault();

            });

            //Disable mouse right click

            $(document).on("contextmenu", function(e) {

                return false;

            });

        });
    </script>
    <script type="text/javascript">
        //Logout clears all visited pages for Back Button
        function noBack() {
            window.history.forward();
        }
        noBack();
        window.onload = noBack;
        window.onpageshow = function(evt) {
            if (evt.persisted) noBack();
        }
        window.onunload = function() {
            void(0);
        }

        document.addEventListener('visibilitychange', function() {
            if (document.visibilityState === 'hidden') {
                document.body.innerHTML = `
                               <div class="d-flex flex-wrap justify-content-center align-items-center clear-msg">
                                    <h3 class="text-danger text-center">@lang('Sorry You can\'t go anywhere from Poll Earning POLL tab while doing a POLL')</h3>
                                </div>
                            `;
            }
        });

        function disableF5(e) {
            if ((e.which || e.keyCode) == 116 || (e.which || e.keyCode) == 82) e.preventDefault();
        };

        $(document).ready(function() {
            $(document).on("keydown", disableF5);
        });
    </script>
@endsection
