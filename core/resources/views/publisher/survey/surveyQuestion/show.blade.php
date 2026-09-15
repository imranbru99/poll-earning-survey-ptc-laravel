@extends($activeTemplate .'layouts.user')
@section('content')
@include($activeTemplate.'breadcrumb')
    <div class="container">
        <style>
            .hide {
                display: none
            }

            .myDIV:hover .hide {
                display: inline-block;
            }
        </style>
        <div class="card px-1">
            <div class="card-header"></div>
            @foreach ($surveyQuestions as $surveyQuestion)

                <div class="row">
                    <div class="col-md-12 bg-secondary">
                        Question {{ $loop->index+1 }}
                    </div>
                </div>
                <div class="row myDIV">
                    <div class="col-md-8 p-3">
                        {{ $surveyQuestion->question }}
                    </div>
            
                    <div class="col-md-2">

                    </div>

                    <div class="col-md-10">
                        <div class="row">
                            @if($surveyQuestion->questiontype_id == 1)
                                @foreach($surveyQuestion->questionOptions as $options)
                                    <div class="col-sm-2">
                                        <b>{{ $loop->index+1 }} ).</b>
                                    </div>
                                    <div class="col-sm-4" style="">
                                        {{ $options->option }}
                                    </div>
                                @endforeach
                            @elseif($surveyQuestion->questiontype_id == 2)
                                <div class="col bg-primary">
                                    <span style="color: white"> Input Base Question </span>
                                </div>
                            @elseif($surveyQuestion->questiontype_id == 3)
                                @foreach($surveyQuestion->questionOptions as $options)
                                    <div class="col-sm-2">
                                        <b>{{ $loop->index+1 }} ).</b>
                                    </div>
                                    <div class="col-sm-4" style="">
                                        {{ $options->option }}
                                    </div>

                                @endforeach
                            @elseif($surveyQuestion->questiontype_id == 5)
                                @php
                                    $questionOptions = App\Models\Survey\Questionvalue::where('survey_question_id',
                                    $surveyQuestion->id)->get();
                                @endphp
                                @foreach($questionOptions as $options)
                                    <div class="col-sm-12">
                                        {{ $options->MinVal }}
                                        ,
                                        {{ $options->MaxVal }}
                                    </div>
                                @endforeach
                            @elseif($surveyQuestion->questiontype_id == 6)
                                @foreach($surveyQuestion->questionOptions as $options)
                                    <div class="col-sm-2">
                                        <b>{{ $loop->index+1 }} ).</b>
                                    </div>
                                    <div class="col-sm-4" style="">
                                        {{ $options->option }}
                                    </div>
                                @endforeach
                            @endif

                        </div>
                    </div>
                </div>
                <br>
                <hr>
            @endforeach
        </div>
    </div>
@endsection
