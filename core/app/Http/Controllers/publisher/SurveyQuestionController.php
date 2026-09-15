<?php

namespace App\Http\Controllers\publisher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Survey\Questionimage;
use App\Models\Survey\Survey;
use App\Models\Survey\Questiontype;
use App\Models\Survey\Questionvalue;
use App\Models\Survey\Questionoption;
use App\Models\Survey\SurveyQuestion;
use App\Http\Requests\Survey\SurveyQuestionStoreRequest;
use App\Http\Requests\Survey\SurveyQuestionUpdateRequest;
use App\Http\Requests\Survey\SurveyQuestionShowRequest;

class SurveyQuestionController extends Controller
{
    public function show($id)
    {

        $page_title = 'Show Question';

        $surveyQuestions = SurveyQuestion::with('questionOptions')->where('survey_id', $id)->get();
        // dd($surveyQuestions);

        return view('publisher.survey.surveyQuestion.show', compact('page_title', 'surveyQuestions'));
    }

    public function importQuestion($id)
    {


        $page_title = 'Show Question';

        $surveyQuestions = SurveyQuestion::with('questionOptions')->get();
        // dd($surveyQuestions);

        return view('survey.surveyQuestion.importquestion', compact('page_title','id', 'surveyQuestions'));
    }

    public function importSAveQuestion(Request $request,$id)
    {



        $page_title = 'Show Question';

        $surveyQuestions = SurveyQuestion::with('questionOptions')->get();
        // dd($surveyQuestions);

        return view('survey.surveyQuestion.importquestion', compact('page_title','id', 'surveyQuestions'));
    }


    // i

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $surveyQuestions = SurveyQuestion::all();

        return view('surveyQuestion.index', compact('surveyQuestions'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Survey $survey)
    {
       // dd($request);
        $page_title = 'ADD SURVEY QUESTIONS';
        $types = Questiontype::orderBy('id', 'asc')->get(['id', 'Type']);
        return view('publisher.survey.surveyQuestion.create', compact('page_title', 'types', 'survey'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Survey\SurveyQuestion $surveyQuestion
     * @return \Illuminate\Http\Response
     */


    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Survey\SurveyQuestion $surveyQuestion
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $page_title = 'Edit Question';

        $surveyQuestion = SurveyQuestion::with('questionOptions')->where('id', $id)->first();
        if (empty($surveyQuestion))
            abort('404');
        return view('publisher.survey.surveyQuestion.edit', compact('page_title', 'surveyQuestion'));
    }

    /**
     * @param \App\Http\Requests\Survey\SurveyQuestionUpdateRequest $request
     * @param \App\Models\Survey\SurveyQuestion $surveyQuestion
     * @return \Illuminate\Http\Response
     */


    // SurveyQuestionUpdateRequest

    public function update(Request $request, $id)
    {
        // dd($request->all());
        if ($request->has('MultiChoiceQuestions')) {
            $request->validate([
                'MultiChoiceQuestions' => 'required|array|min:1',
                'MultiChoiceQuestions[options[A.*]]' => 'required|array|min:1',
                'MultiChoiceQuestions[options[B.*]]' => 'required|array|min:1',
                'MultiChoiceQuestions[options[C.*]]' => 'required|array|min:1',
                'MultiChoiceQuestions[options[D.*]]' => 'required|array|min:1',
            ]);
            $mycheck = 0;
            $mymax = 15;
            $aCounts =  count($request->MultiChoiceQuestions['questions']['options']['A']);
            $bCounts =  count($request->MultiChoiceQuestions['questions']['options']['B']);
            $cCounts =  count($request->MultiChoiceQuestions['questions']['options']['C']);
            $dCounts =  count($request->MultiChoiceQuestions['questions']['options']['D']);
            $countList =   count($request->MultiChoiceQuestions['questions']['lists']);
            // return  $countList=   count($request->MultiChoiceQuestions['questions']['lists']);
            $savedQuestion = '';
            $lastsavednow = '';
            $q = 0;
            $s = 0;
            $r = 0;
            $t = 0;
            $lengtOptions = count($request->MultiChoiceQuestions['questions']['options']);
            $optionisAnswer = 0;
            // return    count($request->MultiChoiceQuestions['questions']['A']);
            //
            //return $request->all();
            //
            //
            $optionAisPicked = '';
            $optionBisPicked = '';
            $optionCisPicked = '';
            $optionDisPicked = '';

            if (isset($request->MultiChoiceQuestions['questions']['answers']['optionD'])) {
                $optionDisPicked .= count($request->MultiChoiceQuestions['questions']['answers']['optionD']);
                $dd = 0;
            }
            if (isset($request->MultiChoiceQuestions['questions']['answers']['optionC'])) {
                $optionCisPicked .= count($request->MultiChoiceQuestions['questions']['answers']['optionC']);
                $cc = 0;
            }
            if (isset($request->MultiChoiceQuestions['questions']['answers']['optionB'])) {
                $optionBisPicked .= count($request->MultiChoiceQuestions['questions']['answers']['optionB']);
                $bb = 0;
            }
            if (isset($request->MultiChoiceQuestions['questions']['answers']['optionA'])) {
                $optionAisPicked .= count($request->MultiChoiceQuestions['questions']['answers']['optionA']);
                $aa = 0;
            }

            foreach ($request->MultiChoiceQuestions['questions']['lists'] as $key => $question) {
                $savedQuestion = SurveyQuestion::create([
                    'category_id' => $survey->category_id,
                    'survey_id' => $survey->id,
                    'questiontype_id' => 1,
                    'question' => $question,
                ]);
                if ($q < $aCounts) {
                    if (count($request->MultiChoiceQuestions['questions']['lists']) <= count($request->MultiChoiceQuestions['questions']['options']['A'])) {
                        $qOption = Questionoption::create([
                            'survey_question_id' => $savedQuestion->id,
                            'option' => $request->MultiChoiceQuestions['questions']['options']['A'][$q]
                        ]);
                    }
                    $q++;

                    if (isset($request->MultiChoiceQuestions['questions']['answers']['optionA'])) {
                        if ($aa > $optionAisPicked) {
                            $aa = $optionAisPicked;
                        }
                        if ($request->MultiChoiceQuestions['questions']['answers']['optionA'][$aa] == 1) {
                            $optionisAnswer = 1;
                            $qOption->update(['isAnswer' => $optionisAnswer]);
                        } else {
                            $optionisAnswer = 0;
                            $qOption->update(['isAnswer' => $optionisAnswer]);
                        }
                        $aa++;
                    }
                }

                if ($s < $bCounts) {
                    if (count($request->MultiChoiceQuestions['questions']['lists']) <= count($request->MultiChoiceQuestions['questions']['options']['B'])) {
                        $qOption = Questionoption::create([
                            'survey_question_id' => $savedQuestion->id,
                            'option' => $request->MultiChoiceQuestions['questions']['options']['B'][$s]
                        ]);
                    }
                    $s++;

                    if (isset($request->MultiChoiceQuestions['questions']['answers']['optionB'])) {
                        if ($bb > $optionBisPicked) {
                            $bb = $optionBisPicked;
                        }
                        if ($request->MultiChoiceQuestions['questions']['answers']['optionB'][$bb] == 1) {
                            $optionisAnswer = 1;
                            $qOption->update(['isAnswer' => $optionisAnswer]);
                        } else {
                            $optionisAnswer = 0;
                            $qOption->update(['isAnswer' => $optionisAnswer]);
                        }
                        $bb++;
                    }
                }

                if ($r < $cCounts) {
                    if (count($request->MultiChoiceQuestions['questions']['lists']) <= count($request->MultiChoiceQuestions['questions']['options']['C'])) {
                        $qOption = Questionoption::create([
                            'survey_question_id' => $savedQuestion->id,
                            'option' => $request->MultiChoiceQuestions['questions']['options']['C'][$r]
                        ]);
                    }
                    $r++;

                    if (isset($request->MultiChoiceQuestions['questions']['answers']['optionC'])) {
                        if ($cc > $optionCisPicked) {
                            $cc = $optionCisPicked;
                        }
                        if ($request->MultiChoiceQuestions['questions']['answers']['optionC'][$cc] == 1) {
                            $optionisAnswer = 1;
                            $qOption->update(['isAnswer' => $optionisAnswer]);
                        } else {
                            $optionisAnswer = 0;
                            $qOption->update(['isAnswer' => $optionisAnswer]);
                        }
                        $cc++;
                    }
                }

                if ($t < $dCounts) {
                    if (count($request->MultiChoiceQuestions['questions']['lists']) <= count($request->MultiChoiceQuestions['questions']['options']['D'])) {
                        $qOption = Questionoption::create([
                            'survey_question_id' => $savedQuestion->id,
                            'option' => $request->MultiChoiceQuestions['questions']['options']['D'][$t]
                        ]);
                    }
                    $t++;

                    if (isset($request->MultiChoiceQuestions['questions']['answers']['optionD'])) {
                        if ($dd > $optionDisPicked) {
                            $dd = $optionDisPicked;
                        }
                        if ($request->MultiChoiceQuestions['questions']['answers']['optionD'][$dd] == 1) {
                            $optionisAnswer = 1;
                            $qOption->update(['isAnswer' => $optionisAnswer]);
                        } else {
                            $optionisAnswer = 0;
                            $qOption->update(['isAnswer' => $optionisAnswer]);
                        }
                        $dd++;
                    }
                }
            }
        }

        if ($request->has('InputBaseQuestions')) {
            $request->validate([
                'InputBaseQuestions' => 'required|array|min:1',
            ]);
            foreach ($request->InputBaseQuestions['questions']['lists'] as $key => $question) {
                SurveyQuestion::where(['id' => $request->id])->update([
                    // 'category_id' => $survey->category_id,
                    // 'survey_id' => $survey->id,
                    // 'questiontype_id' => 6,
                    'question' => $question,
                ]);
            }
        }

        if ($request->has('YesNoQuestions')) {
            $request->validate([
                'YesNoQuestions' => 'required|array|min:1',
                'YesNoQuestions[options[YesOptions.*]]' => 'required|array|min:1',
                'YesNoQuestions[options[NoOptions.*]]' => 'required|array|min:1',

            ]);
            $mycheck = 0;
            $mymax = 15;

            if (isset($request->YesNoQuestions['questions']['answers']['NoOptions'])) {
                if ($request->YesNoQuestions['questions']['answers']['NoOptions'][0] == 'on') {
                    $optionisAnswer = 1;
                    //$qOption->update(['isAnswer'=>$optionisAnswer]);
                } else {
                    $optionisAnswer = 0;
                    // $qOption->update(['isAnswer'=>$optionisAnswer]);
                }
                return    $optionisAnswer = 1;
            }





            //return  $YesCounts =  count($request->YesNoQuestions['questions']['options']);
            $YesCounts =  count($request->YesNoQuestions['questions']['options']['YesOptions']);
            $NoCounts =  count($request->YesNoQuestions['questions']['options']['NoOptions']);

            $savedQuestion = '';
            $lastsavednow = '';
            $q = 0;
            $s = 0;
            $lengtOptions = count($request->YesNoQuestions['questions']['options']);
            $optionisAnswer = 0;

            foreach ($request->YesNoQuestions['questions']['lists'] as $question) {
                SurveyQuestion::where(['id' => $request->id])->update([
                    // 'category_id' => $survey->category_id,
                    // 'survey_id' => $survey->id,
                    // 'questiontype_id' => 6,
                    'question' => $question,
                ]);


                $qOptions = Questionoption::where('survey_question_id', $request->id)->get();
                $i = 0;
                foreach ($qOptions as $qOption) {
                    $answer = 0;
                    // if (count($request->YesNoQuestions['questions']['lists']) <= count($request->YesNoQuestions['questions']['options']['B'])) {
                    // dd($request->YesNoQuestions['questions']['answers']);
                    if ($i == 0) {
                        $qOption->update([
                            'option' => $request->YesNoQuestions['questions']['options']['YesOptions'][$s]
                        ]);
                        if (isset($request->YesNoQuestions['questions']['answers']['YesAnswer'][$s]))
                            $qOption->update([
                                'isAnswer' => 1
                            ]);
                        else
                            $qOption->update([
                                'isAnswer' => 0
                            ]);
                    }
                    if ($i == 1) {
                        $qOption->update([
                            'option' => $request->YesNoQuestions['questions']['options']['NoOptions'][$s]
                        ]);
                        if (isset($request->YesNoQuestions['questions']['answers']['NoAnswer'][$s]))
                            $qOption->update([
                                'isAnswer' => 1
                            ]);
                        else
                            $qOption->update([
                                'isAnswer' => 0
                            ]);
                    }
                    $i++;
                    // }
                }
            }
        }

        if ($request->has('LinearQuestions')) {

            $request->validate([
                'LinearQuestions' => 'required|array|min:1',
                'LinearQuestions[options[minVal.*]]' => 'required|array|min:1',
                'LinearQuestions[options[maxVal.*]]' => 'required|array|min:1',
            ]);


            foreach ($request->LinearQuestions['questions']['lists'] as $key => $question) {
                SurveyQuestion::where(['id' => $request->id])->update([
                    'question' => $question,
                ]);
                $qOptions = Questionvalue::where('survey_question_id', $request->id)->get();
                $i = 0;
                foreach ($qOptions as $qOption) {
                    if ($i == 0) {
                        $qOption->update([
                            'MaxVal' => $request->LinearQuestions['questions']['options']['maxVal'][0],
                            'MinVal' => $request->LinearQuestions['questions']['options']['minVal'][0],
                        ]);
                        $i++;
                    }
                }
            }
        }

        if ($request->has('imageBaseQuestions')) {
            $questions = $request->imageBaseQuestions;
            dd($questions);
        }

        if ($request->has('dropDownQuestions')) {
            // $request->validate([
            //     'dropDownQuestions' => 'array|min:1',
            //     'dropDownQuestions[options[A.*]]' => 'array|min:1',
            //     'dropDownQuestions[options[B.*]]' => 'array|min:1',
            //     'dropDownQuestions[options[C.*]]' => 'array|min:1',
            //     'dropDownQuestions[options[D.*]]' => 'array|min:1',
            // ]);
            $mycheck = 0;
            $mymax = 15;
            $aCounts =  count($request->dropDownQuestions['questions']['options']['A']);
            $bCounts =  count($request->dropDownQuestions['questions']['options']['B']);
            $cCounts =  count($request->dropDownQuestions['questions']['options']['C']);
            $dCounts =  count($request->dropDownQuestions['questions']['options']['D']);
            $countList =   count($request->dropDownQuestions['questions']['lists']);
            // return  $countList=   count($request->dropDownQuestions['questions']['lists']);
            $savedQuestion = '';
            $lastsavednow = '';
            $q = 0;
            $s = 0;
            $r = 0;
            $t = 0;
            $lengtOptions = count($request->dropDownQuestions['questions']['options']);
            $optionisAnswer = 0;
            // return    count($request->dropDownQuestions['questions']['A']);
            // dump($request->dropDownQuestions['questions']['lists']);

            foreach ($request->dropDownQuestions['questions']['lists'] as $question) {
                SurveyQuestion::where(['id' => $request->id])->update([
                    // 'category_id' => $survey->category_id,
                    // 'survey_id' => $survey->id,
                    // 'questiontype_id' => 6,
                    'question' => $question,
                ]);


                $qOptions = Questionoption::where('survey_question_id', $request->id)->get();
                $i = 0;
                foreach ($qOptions as $qOption) {
                    $answer = 0;
                    if (count($request->dropDownQuestions['questions']['lists']) <= count($request->dropDownQuestions['questions']['options']['B'])) {
                        // dd($request->dropDownQuestions['questions']['answers']);
                        if ($i == 0) {
                            $qOption->update([
                                'option' => $request->dropDownQuestions['questions']['options']['A'][$s]
                            ]);
                            if (isset($request->dropDownQuestions['questions']['answers']['optionA'][$s]))
                                $qOption->update([
                                    'isAnswer' => 1
                                ]);
                            else
                                $qOption->update([
                                    'isAnswer' => 0
                                ]);
                        }
                        if ($i == 1) {
                            $qOption->update([
                                'option' => $request->dropDownQuestions['questions']['options']['B'][$s]
                            ]);
                            if (isset($request->dropDownQuestions['questions']['answers']['optionB'][$s]))
                                $qOption->update([
                                    'isAnswer' => 1
                                ]);
                            else
                                $qOption->update([
                                    'isAnswer' => 0
                                ]);
                        }
                        if ($i == 2) {
                            $qOption->update([
                                'option' => $request->dropDownQuestions['questions']['options']['C'][$s]
                            ]);
                            if (isset($request->dropDownQuestions['questions']['answers']['optionC'][$s]))
                                $qOption->update([
                                    'isAnswer' => 1
                                ]);
                            else
                                $qOption->update([
                                    'isAnswer' => 0
                                ]);
                        }
                        if ($i == 3) {
                            $qOption->update([
                                'option' => $request->dropDownQuestions['questions']['options']['D'][$s]
                            ]);
                            if (isset($request->dropDownQuestions['questions']['answers']['optionD'][$s]))
                                $qOption->update([
                                    'isAnswer' => 1
                                ]);
                            else
                                $qOption->update([
                                    'isAnswer' => 0
                                ]);
                        }
                        $i++;
                    }
                }
            }
        }

        // return $savedQuestion;
        $request->session()->flash('created', 'Questions created-successfully');
        return redirect()->back();
        // $surveyQuestion->update($request->validated());
        // $request->session()->flash('surveyQuestion.id', $surveyQuestion->id);
        // return redirect()->route('surveyQuestion.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Survey\SurveyQuestion $surveyQuestion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, SurveyQuestion $surveyQuestion)
    {
        $surveyQuestion->delete();

        return redirect()->route('surveyQuestion.index');
    }

    // SurveyQuestionStoreRequest
    public function store(Request $request, Survey $survey)
    {


        if ($request->has('VideoBase')) {
            $request->validate([
                'VideoBase' => 'required|array|min:1',
                'VideoBase[options[A.*]]' => 'required|array|min:1',
                'VideoBase[options[B.*]]' => 'required|array|min:1',
                'VideoBase[options[C.*]]' => 'required|array|min:1',
                'VideoBase[options[D.*]]' => 'required|array|min:1',
            ]);
            $mycheck = 0;
            $mymax = 15;
            $aCounts =  count($request->VideoBase['questions']['options']['A']);
            $bCounts =  count($request->VideoBase['questions']['options']['B']);
            $cCounts =  count($request->VideoBase['questions']['options']['C']);
            $dCounts =  count($request->VideoBase['questions']['options']['D']);
            $countList =   count($request->VideoBase['questions']['lists']);
            // return  $countList=   count($request->MultiChoiceQuestions['questions']['lists']);
            $savedQuestion = '';
            $lastsavednow = '';
            $q = 0;
            $s = 0;
            $r = 0;
            $t = 0;
            $lengtOptions = count($request->VideoBase['questions']['options']);
            $optionisAnswer = 0;
            // return    count($request->MultiChoiceQuestions['questions']['A']);
            //
            //return $request->all();
            //
            //
            $optionAisPicked = '';
            $optionBisPicked = '';
            $optionCisPicked = '';
            $optionDisPicked = '';
            if (isset($request->VideoBase['questions']['answers']['optionD'])) {
                $optionDisPicked .= count($request->VideoBase['questions']['answers']['optionD']);
                $dd = 0;
            }
            if (isset($request->VideoBase['questions']['answers']['optionC'])) {
                $optionCisPicked .= count($request->VideoBase['questions']['answers']['optionC']);
                $cc = 0;
            }
            if (isset($request->VideoBase['questions']['answers']['optionB'])) {
                $optionBisPicked .= count($request->VideoBase['questions']['answers']['optionB']);
                $bb = 0;
            }
            if (isset($request->VideoBase['questions']['answers']['optionA'])) {
                $optionAisPicked .= count($request->VideoBase['questions']['answers']['optionA']);
                $aa = 0;
            }
            foreach ($request->VideoBase['questions']['lists'] as $key => $question) {
                $savedQuestion = SurveyQuestion::create([
                    'category_id' => $survey->category_id,
                    'survey_id' => $survey->id,
                    'questiontype_id' => 8,
                    'question' => $question,
                    'link' => $request->link,
                ]);
                $id = $savedQuestion->id;

                if ($q < $aCounts) {
                    if (count($request->VideoBase['questions']['lists']) <= count($request->VideoBase['questions']['options']['A'])) {
                        $qOption = Questionoption::create([
                            'survey_question_id' => $savedQuestion->id,
                            'option' => $request->VideoBase['questions']['options']['A'][$q]
                        ]);
                    }
                    $q++;

                    if (isset($request->VideoBase['questions']['answers']['optionA'])) {
                        if ($aa > $optionAisPicked) {
                            $aa = $optionAisPicked;
                        }
                        if ($request->VideoBase['questions']['answers']['optionA'][$aa] == 1) {
                            $optionisAnswer = 1;
                            $qOption->update(['isAnswer' => $optionisAnswer]);
                        } else {
                            $optionisAnswer = 0;
                            $qOption->update(['isAnswer' => $optionisAnswer]);
                        }
                        $aa++;
                    }
                }

                if ($s < $bCounts) {
                    if (count($request->VideoBase['questions']['lists']) <= count($request->VideoBase['questions']['options']['B'])) {
                        $qOption = Questionoption::create([
                            'survey_question_id' => $savedQuestion->id,
                            'option' => $request->VideoBase['questions']['options']['B'][$s]
                        ]);
                    }
                    $s++;

                    if (isset($request->VideoBase['questions']['answers']['optionB'])) {
                        if ($bb > $optionBisPicked) {
                            $bb = $optionBisPicked;
                        }
                        if ($request->VideoBase['questions']['answers']['optionB'][$bb] == 1) {
                            $optionisAnswer = 1;
//                            $qOption->update(['isAnswer' => $optionisAnswer]);
                        } else {
                            $optionisAnswer = 0;
//                            $qOption->update(['isAnswer' => $optionisAnswer]);
                        }
                        $bb++;


                    }
                }

                if ($r < $cCounts) {
                    if (count($request->VideoBase['questions']['lists']) <= count($request->VideoBase['questions']['options']['C'])) {
                        $qOption = Questionoption::create([
                            'survey_question_id' => $savedQuestion->id,
                            'option' => $request->VideoBase['questions']['options']['C'][$r]
                        ]);
                    }
                    $r++;

                    if (isset($request->VideoBase['questions']['answers']['optionC'])) {
                        if ($cc > $optionCisPicked) {
                            $cc = $optionCisPicked;
                        }
                        if ($request->VideoBase['questions']['answers']['optionC'][$cc] == 1) {
                            $optionisAnswer = 1;
                            $qOption->update(['isAnswer' => $optionisAnswer]);
                        } else {
                            $optionisAnswer = 0;
                            $qOption->update(['isAnswer' => $optionisAnswer]);
                        }
                        $cc++;
                    }
                }

                if ($t < $dCounts) {
                    if (count($request->VideoBase['questions']['lists']) <= count($request->VideoBase['questions']['options']['D'])) {
                        $qOption = Questionoption::create([
                            'survey_question_id' => $savedQuestion->id,
                            'option' => $request->VideoBase['questions']['options']['D'][$t]
                        ]);
                    }
                    $t++;

                    if (isset($request->VideoBase['questions']['answers']['optionD'])) {
                        if ($dd > $optionDisPicked) {
                            $dd = $optionDisPicked;
                        }
                        if ($request->VideoBase['questions']['answers']['optionD'][$dd] == 1) {
                            $optionisAnswer = 1;
                            $qOption->update(['isAnswer' => $optionisAnswer]);
                        } else {
                            $optionisAnswer = 0;
                            $qOption->update(['isAnswer' => $optionisAnswer]);
                        }
                        $dd++;
                    }
                }
            }


        }



        if ($request->has('IqQuestionbtn')) {
//            dd($request['IqQuestionbtn']);
            $request->validate([
                'IqQuestionbtn' => 'required|array|min:1',
                'IqQuestionbtn[options[A.*]]' => 'required|array|min:1',
                'IqQuestionbtn[options[B.*]]' => 'required|array|min:1',
                'IqQuestionbtn[options[C.*]]' => 'required|array|min:1',
                'IqQuestionbtn[options[D.*]]' => 'required|array|min:1',

            ]);
            $mycheck = 0;
            $mymax = 15;
            $aCounts =  count($request->IqQuestionbtn['questions']['options']['A']);
            $bCounts =  count($request->IqQuestionbtn['questions']['options']['B']);
            $cCounts =  count($request->IqQuestionbtn['questions']['options']['C']);
            $dCounts =  count($request->IqQuestionbtn['questions']['options']['D']);
            $countList =   count($request->IqQuestionbtn['questions']['lists']);
            // return  $countList=   count($request->MultiChoiceQuestions['questions']['lists']);
            $savedQuestion = '';
            $lastsavednow = '';
            $q = 0;
            $s = 0;
            $r = 0;
            $t = 0;
            $lengtOptions = count($request->IqQuestionbtn['questions']['options']);
            $optionisAnswer = 0;
            // return    count($request->MultiChoiceQuestions['questions']['A']);
            //
            //return $request->all();
            //
            //
            $optionAisPicked = '';
            $optionBisPicked = '';
            $optionCisPicked = '';
            $optionDisPicked = '';

            if (isset($request->IqQuestionbtn['questions']['answers']['optionD'])) {
                $optionDisPicked .= count($request->IqQuestionbtn['questions']['answers']['optionD']);
                $dd = 0;
            }
            if (isset($request->IqQuestionbtn['questions']['answers']['optionC'])) {
                $optionCisPicked .= count($request->IqQuestionbtn['questions']['answers']['optionC']);
                $cc = 0;
            }
            if (isset($request->IqQuestionbtn['questions']['answers']['optionB'])) {
                $optionBisPicked .= count($request->IqQuestionbtn['questions']['answers']['optionB']);
                $bb = 0;
            }
            if (isset($request->IqQuestionbtn['questions']['answers']['optionA'])) {
                $optionAisPicked .= count($request->IqQuestionbtn['questions']['answers']['optionA']);
                $aa = 0;
            }

            foreach ($request->IqQuestionbtn['questions']['lists'] as $key => $question) {

                $savedQuestion = SurveyQuestion::create([
                    'category_id' => $survey->category_id,
                    'survey_id' => $survey->id,
                    'questiontype_id' => 7,
                    'question' => $question,
                ]);
                if ($q < $aCounts) {
                    if (count($request->IqQuestionbtn['questions']['lists']) <= count($request->IqQuestionbtn['questions']['options']['A'])) {
                        $qOption = Questionoption::create([
                            'survey_question_id' => $savedQuestion->id,
                            'option' => $request->IqQuestionbtn['questions']['options']['A'][$q]
                        ]);
                    }
                    $q++;

                    if (isset($request->IqQuestionbtn['questions']['answers']['optionA'])) {
                        if ($aa > $optionAisPicked) {
                            $aa = $optionAisPicked;
                        }
                        if ($request->IqQuestionbtn['questions']['answers']['optionA'][$aa] == 1) {
                            $optionisAnswer = 1;
                            $qOption->update(['isAnswer' => $optionisAnswer]);
                        } else {
                            $optionisAnswer = 0;
                            $qOption->update(['isAnswer' => $optionisAnswer]);
                        }
                        $aa++;
                    }
                }

                if ($s < $bCounts) {
                    if (count($request->IqQuestionbtn['questions']['lists']) <= count($request->IqQuestionbtn['questions']['options']['B'])) {
                        $qOption = Questionoption::create([
                            'survey_question_id' => $savedQuestion->id,
                            'option' => $request->IqQuestionbtn['questions']['options']['B'][$s]
                        ]);
                    }
                    $s++;

                    if (isset($request->IqQuestionbtn['questions']['answers']['optionB'])) {
                        if ($bb > $optionBisPicked) {
                            $bb = $optionBisPicked;
                        }
                        if ($request->IqQuestionbtn['questions']['answers']['optionB'][$bb] == 1) {
                            $optionisAnswer = 1;
                            $qOption->update(['isAnswer' => $optionisAnswer]);
                        } else {
                            $optionisAnswer = 0;
                            $qOption->update(['isAnswer' => $optionisAnswer]);
                        }
                        $bb++;
                    }
                }

                if ($r < $cCounts) {
                    if (count($request->IqQuestionbtn['questions']['lists']) <= count($request->IqQuestionbtn['questions']['options']['C'])) {
                        $qOption = Questionoption::create([
                            'survey_question_id' => $savedQuestion->id,
                            'option' => $request->IqQuestionbtn['questions']['options']['C'][$r]
                        ]);
                    }
                    $r++;

                    if (isset($request->IqQuestionbtn['questions']['answers']['optionC'])) {
                        if ($cc > $optionCisPicked) {
                            $cc = $optionCisPicked;
                        }
                        if ($request->IqQuestionbtn['questions']['answers']['optionC'][$cc] == 1) {
                            $optionisAnswer = 1;
                            $qOption->update(['isAnswer' => $optionisAnswer]);
                        } else {
                            $optionisAnswer = 0;
                            $qOption->update(['isAnswer' => $optionisAnswer]);
                        }
                        $cc++;
                    }
                }

                if ($t < $dCounts) {
                    if (count($request->IqQuestionbtn['questions']['lists']) <= count($request->IqQuestionbtn['questions']['options']['D'])) {
                        $qOption = Questionoption::create([
                            'survey_question_id' => $savedQuestion->id,
                            'option' => $request->IqQuestionbtn['questions']['options']['D'][$t]
                        ]);
                    }
                    $t++;

                    if (isset($request->IqQuestionbtn['questions']['answers']['optionD'])) {
                        if ($dd > $optionDisPicked) {
                            $dd = $optionDisPicked;
                        }
                        if ($request->IqQuestionbtn['questions']['answers']['optionD'][$dd] == 1) {
                            $optionisAnswer = 1;
                            $qOption->update(['isAnswer' => $optionisAnswer]);
                        } else {
                            $optionisAnswer = 0;
                            $qOption->update(['isAnswer' => $optionisAnswer]);
                        }
                        $dd++;
                    }
                }
            }
        }


        if ($request->has('MultiChoiceQuestions')) {
            $request->validate([
                'MultiChoiceQuestions' => 'required|array|min:1',
                'MultiChoiceQuestions[options[A.*]]' => 'required|array|min:1',
                'MultiChoiceQuestions[options[B.*]]' => 'required|array|min:1',
                'MultiChoiceQuestions[options[C.*]]' => 'required|array|min:1',
                'MultiChoiceQuestions[options[D.*]]' => 'required|array|min:1',
            ]);
            $mycheck = 0;
            $mymax = 15;
            $aCounts =  count($request->MultiChoiceQuestions['questions']['options']['A']);
            $bCounts =  count($request->MultiChoiceQuestions['questions']['options']['B']);
            $cCounts =  count($request->MultiChoiceQuestions['questions']['options']['C']);
            $dCounts =  count($request->MultiChoiceQuestions['questions']['options']['D']);
            $countList =   count($request->MultiChoiceQuestions['questions']['lists']);
            // return  $countList=   count($request->MultiChoiceQuestions['questions']['lists']);
            $savedQuestion = '';
            $lastsavednow = '';
            $q = 0;
            $s = 0;
            $r = 0;
            $t = 0;
            $lengtOptions = count($request->MultiChoiceQuestions['questions']['options']);
            $optionisAnswer = 0;
            // return    count($request->MultiChoiceQuestions['questions']['A']);
            //
            //return $request->all();
            //
            //
            $optionAisPicked = '';
            $optionBisPicked = '';
            $optionCisPicked = '';
            $optionDisPicked = '';
            if (isset($request->MultiChoiceQuestions['questions']['answers']['optionD'])) {
                $optionDisPicked .= count($request->MultiChoiceQuestions['questions']['answers']['optionD']);
                $dd = 0;
            }
            if (isset($request->MultiChoiceQuestions['questions']['answers']['optionC'])) {
                $optionCisPicked .= count($request->MultiChoiceQuestions['questions']['answers']['optionC']);
                $cc = 0;
            }
            if (isset($request->MultiChoiceQuestions['questions']['answers']['optionB'])) {
                $optionBisPicked .= count($request->MultiChoiceQuestions['questions']['answers']['optionB']);
                $bb = 0;
            }
            if (isset($request->MultiChoiceQuestions['questions']['answers']['optionA'])) {
                $optionAisPicked .= count($request->MultiChoiceQuestions['questions']['answers']['optionA']);
                $aa = 0;
            }

            foreach ($request->MultiChoiceQuestions['questions']['lists'] as $key => $question) {

                $savedQuestion = SurveyQuestion::create([
                    'category_id' => $survey->category_id,
                    'survey_id' => $survey->id,
                    'questiontype_id' => 1,
                    'question' => $question,
                ]);

                if ($q < $aCounts) {
                    if (count($request->MultiChoiceQuestions['questions']['lists']) <= count($request->MultiChoiceQuestions['questions']['options']['A'])) {
                        $qOption = Questionoption::create([
                            'survey_question_id' => $savedQuestion->id,
                            'option' => $request->MultiChoiceQuestions['questions']['options']['A'][$q]
                        ]);
                    }
                    $q++;

                    if (isset($request->MultiChoiceQuestions['questions']['answers']['optionA'])) {
                        if ($aa > $optionAisPicked) {
                            $aa = $optionAisPicked;
                        }
                        if ($request->MultiChoiceQuestions['questions']['answers']['optionA'][$aa] == 1) {
                            $optionisAnswer = 1;
                            $qOption->update(['isAnswer' => $optionisAnswer]);
                        } else {
                            $optionisAnswer = 0;
                            $qOption->update(['isAnswer' => $optionisAnswer]);
                        }
                        $aa++;
                    }
                }

                if ($s < $bCounts) {
                    if (count($request->MultiChoiceQuestions['questions']['lists']) <= count($request->MultiChoiceQuestions['questions']['options']['B'])) {
                        $qOption = Questionoption::create([
                            'survey_question_id' => $savedQuestion->id,
                            'option' => $request->MultiChoiceQuestions['questions']['options']['B'][$s]
                        ]);
                    }
                    $s++;

                    if (isset($request->MultiChoiceQuestions['questions']['answers']['optionB'])) {
                        if ($bb > $optionBisPicked) {
                            $bb = $optionBisPicked;
                        }
                        if ($request->MultiChoiceQuestions['questions']['answers']['optionB'][$bb] == 1) {
                            $optionisAnswer = 1;
//                            $qOption->update(['isAnswer' => $optionisAnswer]);
                        } else {
                            $optionisAnswer = 0;
//                            $qOption->update(['isAnswer' => $optionisAnswer]);
                        }
                        $bb++;


                    }
                }

                if ($r < $cCounts) {
                    if (count($request->MultiChoiceQuestions['questions']['lists']) <= count($request->MultiChoiceQuestions['questions']['options']['C'])) {
                        $qOption = Questionoption::create([
                            'survey_question_id' => $savedQuestion->id,
                            'option' => $request->MultiChoiceQuestions['questions']['options']['C'][$r]
                        ]);
                    }
                    $r++;

                    if (isset($request->MultiChoiceQuestions['questions']['answers']['optionC'])) {
                        if ($cc > $optionCisPicked) {
                            $cc = $optionCisPicked;
                        }
                        if ($request->MultiChoiceQuestions['questions']['answers']['optionC'][$cc] == 1) {
                            $optionisAnswer = 1;
                            $qOption->update(['isAnswer' => $optionisAnswer]);
                        } else {
                            $optionisAnswer = 0;
                            $qOption->update(['isAnswer' => $optionisAnswer]);
                        }
                        $cc++;
                    }
                }

                if ($t < $dCounts) {
                    if (count($request->MultiChoiceQuestions['questions']['lists']) <= count($request->MultiChoiceQuestions['questions']['options']['D'])) {
                        $qOption = Questionoption::create([
                            'survey_question_id' => $savedQuestion->id,
                            'option' => $request->MultiChoiceQuestions['questions']['options']['D'][$t]
                        ]);
                    }
                    $t++;

                    if (isset($request->MultiChoiceQuestions['questions']['answers']['optionD'])) {
                        if ($dd > $optionDisPicked) {
                            $dd = $optionDisPicked;
                        }
                        if ($request->MultiChoiceQuestions['questions']['answers']['optionD'][$dd] == 1) {
                            $optionisAnswer = 1;
                            $qOption->update(['isAnswer' => $optionisAnswer]);
                        } else {
                            $optionisAnswer = 0;
                            $qOption->update(['isAnswer' => $optionisAnswer]);
                        }
                        $dd++;
                    }
                }
            }
        }



        if ($request->has('InputBaseQuestions')) {
            $request->validate([
                'InputBaseQuestions' => 'required|array|min:1',
            ]);
            foreach ($request->InputBaseQuestions['questions']['lists'] as $key => $question) {
                $savedQuestion = SurveyQuestion::create([
                    'category_id' => $survey->category_id,
                    'survey_id' => $survey->id,
                    'questiontype_id' => 2,
                    'question' => $question,
                ]);
            }
        }

        if ($request->has('YesNoQuestions')) {
            // return $request->all();

            $request->validate([
                'YesNoQuestions' => 'required|array|min:1',
                'YesNoQuestions[options[YesOptions.*]]' => 'required|array|min:1',
                'YesNoQuestions[options[NoOptions.*]]' => 'required|array|min:1',

            ]);
            $mycheck = 0;
            $mymax = 15;

            if (isset($request->YesNoQuestions['questions']['answers']['NoOptions'])) {
                if ($request->YesNoQuestions['questions']['answers']['NoOptions'][0] == 'on') {
                    $optionisAnswer = 1;
                    //$qOption->update(['isAnswer'=>$optionisAnswer]);
                } else {
                    $optionisAnswer = 0;
                    // $qOption->update(['isAnswer'=>$optionisAnswer]);
                }
                return    $optionisAnswer = 1;
            }





            //return  $YesCounts =  count($request->YesNoQuestions['questions']['options']);
            $YesCounts =  count($request->YesNoQuestions['questions']['options']['YesOptions']);
            $NoCounts =  count($request->YesNoQuestions['questions']['options']['NoOptions']);

            $savedQuestion = '';
            $lastsavednow = '';
            $q = 0;
            $s = 0;
            $lengtOptions = count($request->YesNoQuestions['questions']['options']);
            $optionisAnswer = 0;

            foreach ($request->YesNoQuestions['questions']['lists'] as $key => $question) {
                $savedQuestion = SurveyQuestion::create([
                    'category_id' => $survey->category_id,
                    'survey_id' => $survey->id,
                    'questiontype_id' => 3,
                    'question' => $question,
                ]);
                if ($q < $YesCounts) {
                    if (count($request->YesNoQuestions['questions']['lists']) <= count($request->YesNoQuestions['questions']['options']['YesOptions'])) {
                        $qOption = Questionoption::create([
                            'survey_question_id' => $savedQuestion->id,
                            'option' => $request->YesNoQuestions['questions']['options']['YesOptions'][$q]
                        ]);
                    }
                    $q++;
                }

                if ($s < $NoCounts) {
                    if (count($request->YesNoQuestions['questions']['lists']) <= count($request->YesNoQuestions['questions']['options']['NoOptions'])) {
                        $qOption = Questionoption::create([
                            'survey_question_id' => $savedQuestion->id,
                            'option' => $request->YesNoQuestions['questions']['options']['NoOptions'][$s]
                        ]);
                    }
                    $s++;
                }

                if (isset($request->YesNoQuestions['questions']['answers']['YesOptions'])) {
                    if ($request->YesNoQuestions['questions']['answers']['YesOptions'][0] == 1) {
                        $optionisAnswer = 1;
                        $qOption->update(['isAnswer' => $optionisAnswer]);
                    } else {
                        $optionisAnswer = 0;
                        $qOption->update(['isAnswer' => $optionisAnswer]);
                    }
                }
                if (isset($request->YesNoQuestions['questions']['answers']['NoOptions'])) {
                    if ($request->YesNoQuestions['questions']['answers']['NoOptions'][0] == 1) {
                        $optionisAnswer = 1;
                        $qOption->update(['isAnswer' => $optionisAnswer]);
                    } else {
                        $optionisAnswer = 0;
                        $qOption->update(['isAnswer' => $optionisAnswer]);
                    }
                }
            }
        }

        if ($request->has('LinearQuestions')) {

            $request->validate([
                'LinearQuestions' => 'required|array|min:1',
                'LinearQuestions[options[minVal.*]]' => 'required|array|min:1',
                'LinearQuestions[options[maxVal.*]]' => 'required|array|min:1',
            ]);
//            dd($request->LinearQuestions);
            $mycheck = 0;
            $mymax = 15;
            $aCounts =  count($request->LinearQuestions['questions']['options']['minVal']);
            $bCounts =  count($request->LinearQuestions['questions']['options']['maxVal']);
            $countList =   count($request->LinearQuestions['questions']['lists']);
            // return  $countList=   count($request->LinearQuestions['questions']['lists']);
            $savedQuestion = '';
            $lastsavednow = '';
            $q = 0;
            $s = 0;

            // return $request->all();

            $lengtOptions = count($request->LinearQuestions['questions']['options']);
            $optionisAnswer = 0;
            // return    count($request->LinearQuestions['questions']['A']);
            foreach ($request->LinearQuestions['questions']['lists'] as $key => $question) {
                $savedQuestion = SurveyQuestion::create([
                    'category_id' => $survey->category_id,
                    'survey_id' => $survey->id,
                    'questiontype_id' => 5,
                    'question' => $question,
                ]);
                if (($q < $aCounts) && ($s < $aCounts)) {
                    if (count($request->LinearQuestions['questions']['lists']) <= count($request->LinearQuestions['questions']['options']['maxVal']) && count($request->LinearQuestions['questions']['lists']) <= count($request->LinearQuestions['questions']['options']['minVal'])) {
                        $qOption = Questionvalue::create([
                            'survey_question_id' => $savedQuestion->id,
                            'MaxVal' => $request->LinearQuestions['questions']['options']['maxVal'][$q],
                            'MinVal' => $request->LinearQuestions['questions']['options']['minVal'][$s],
                        ]);
                    }
                    $q++;
                    $s++;
                }
            }
        }

        if ($request->has('imageBaseQuestions')) {
                $request->validate([
                'imageBaseQuestions' => 'required|array|min:1',
                'imageBaseQuestions[options[A.*]]' => 'required|array|min:1',
                'imageBaseQuestions[options[B.*]]' => 'required|array|min:1',
                'imageBaseQuestions[options[C.*]]' => 'required|array|min:1',
                'imageBaseQuestions[options[D.*]]' => 'required|array|min:1',
            ]);
            $mycheck = 0;
            $mymax = 15;
            $aCounts =  count($request->imageBaseQuestions['questions']['options']['A']);
            $bCounts =  count($request->imageBaseQuestions['questions']['options']['B']);
            $cCounts =  count($request->imageBaseQuestions['questions']['options']['C']);
            $dCounts =  count($request->imageBaseQuestions['questions']['options']['D']);
            $countList =   count($request->imageBaseQuestions['questions']['lists']);
            // return  $countList=   count($request->MultiChoiceQuestions['questions']['lists']);
            $savedQuestion = '';
            $lastsavednow = '';
            $q = 0;
            $s = 0;
            $r = 0;
            $t = 0;
            $lengtOptions = count($request->imageBaseQuestions['questions']['options']);
            $optionisAnswer = 0;
            // return    count($request->MultiChoiceQuestions['questions']['A']);
            //
            //return $request->all();
            //
            //
            $optionAisPicked = '';
            $optionBisPicked = '';
            $optionCisPicked = '';
            $optionDisPicked = '';
            if (isset($request->imageBaseQuestions['questions']['answers']['optionD'])) {
                $optionDisPicked .= count($request->imageBaseQuestions['questions']['answers']['optionD']);
                $dd = 0;
            }
            if (isset($request->imageBaseQuestions['questions']['answers']['optionC'])) {
                $optionCisPicked .= count($request->imageBaseQuestions['questions']['answers']['optionC']);
                $cc = 0;
            }
            if (isset($request->imageBaseQuestions['questions']['answers']['optionB'])) {
                $optionBisPicked .= count($request->imageBaseQuestions['questions']['answers']['optionB']);
                $bb = 0;
            }
            if (isset($request->imageBaseQuestions['questions']['answers']['optionA'])) {
                $optionAisPicked .= count($request->imageBaseQuestions['questions']['answers']['optionA']);
                $aa = 0;
            }
            foreach ($request->imageBaseQuestions['questions']['lists'] as $key => $question) {

                $savedQuestion = SurveyQuestion::create([
                    'category_id' => $survey->category_id,
                    'survey_id' => $survey->id,
                    'questiontype_id' => 4  ,
                    'question' => $question,
                ]);
                $id = $savedQuestion->id;

                if ($q < $aCounts) {
                    if (count($request->imageBaseQuestions['questions']['lists']) <= count($request->imageBaseQuestions['questions']['options']['A'])) {
                        $qOption = Questionoption::create([
                            'survey_question_id' => $savedQuestion->id,
                            'option' => $request->imageBaseQuestions['questions']['options']['A'][$q]
                        ]);
                    }
                    $q++;

                    if (isset($request->imageBaseQuestions['questions']['answers']['optionA'])) {
                        if ($aa > $optionAisPicked) {
                            $aa = $optionAisPicked;
                        }
                        if ($request->imageBaseQuestions['questions']['answers']['optionA'][$aa] == 1) {
                            $optionisAnswer = 1;
                            $qOption->update(['isAnswer' => $optionisAnswer]);
                        } else {
                            $optionisAnswer = 0;
                            $qOption->update(['isAnswer' => $optionisAnswer]);
                        }
                        $aa++;
                    }
                }

                if ($s < $bCounts) {
                    if (count($request->imageBaseQuestions['questions']['lists']) <= count($request->imageBaseQuestions['questions']['options']['B'])) {
                        $qOption = Questionoption::create([
                            'survey_question_id' => $savedQuestion->id,
                            'option' => $request->imageBaseQuestions['questions']['options']['B'][$s]
                        ]);
                    }
                    $s++;

                    if (isset($request->imageBaseQuestions['questions']['answers']['optionB'])) {
                        if ($bb > $optionBisPicked) {
                            $bb = $optionBisPicked;
                        }
                        if ($request->imageBaseQuestions['questions']['answers']['optionB'][$bb] == 1) {
                            $optionisAnswer = 1;
//                            $qOption->update(['isAnswer' => $optionisAnswer]);
                        } else {
                            $optionisAnswer = 0;
//                            $qOption->update(['isAnswer' => $optionisAnswer]);
                        }
                        $bb++;


                    }
                }

                if ($r < $cCounts) {
                    if (count($request->imageBaseQuestions['questions']['lists']) <= count($request->imageBaseQuestions['questions']['options']['C'])) {
                        $qOption = Questionoption::create([
                            'survey_question_id' => $savedQuestion->id,
                            'option' => $request->imageBaseQuestions['questions']['options']['C'][$r]
                        ]);
                    }
                    $r++;

                    if (isset($request->imageBaseQuestions['questions']['answers']['optionC'])) {
                        if ($cc > $optionCisPicked) {
                            $cc = $optionCisPicked;
                        }
                        if ($request->imageBaseQuestions['questions']['answers']['optionC'][$cc] == 1) {
                            $optionisAnswer = 1;
                            $qOption->update(['isAnswer' => $optionisAnswer]);
                        } else {
                            $optionisAnswer = 0;
                            $qOption->update(['isAnswer' => $optionisAnswer]);
                        }
                        $cc++;
                    }
                }

                if ($t < $dCounts) {
                    if (count($request->imageBaseQuestions['questions']['lists']) <= count($request->imageBaseQuestions['questions']['options']['D'])) {
                        $qOption = Questionoption::create([
                            'survey_question_id' => $savedQuestion->id,
                            'option' => $request->imageBaseQuestions['questions']['options']['D'][$t]
                        ]);
                    }
                    $t++;

                    if (isset($request->imageBaseQuestions['questions']['answers']['optionD'])) {
                        if ($dd > $optionDisPicked) {
                            $dd = $optionDisPicked;
                        }
                        if ($request->imageBaseQuestions['questions']['answers']['optionD'][$dd] == 1) {
                            $optionisAnswer = 1;
                            $qOption->update(['isAnswer' => $optionisAnswer]);
                        } else {
                            $optionisAnswer = 0;
                            $qOption->update(['isAnswer' => $optionisAnswer]);
                        }
                        $dd++;
                    }
                }
            }
            if($image=$request->file('image')) {
                $destinationPath = 'uploads/survey/';
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $product['image'] = $profileImage;
                Questionimage::create([
                    'survey_question_id' => $savedQuestion->id,
                    'Image' => $product['image'],
                ]);
            }



        }

        if ($request->has('dropDownQuestions')) {
            $request->validate([
                'dropDownQuestions' => 'required|array|min:1',
                'dropDownQuestions[options[A.*]]' => 'required|array|min:1',
                'dropDownQuestions[options[B.*]]' => 'required|array|min:1',
                'dropDownQuestions[options[C.*]]' => 'required|array|min:1',
                'dropDownQuestions[options[D.*]]' => 'required|array|min:1',
            ]);
            $mycheck = 0;
            $mymax = 15;
            $aCounts =  count($request->dropDownQuestions['questions']['options']['A']);
            $bCounts =  count($request->dropDownQuestions['questions']['options']['B']);
            $cCounts =  count($request->dropDownQuestions['questions']['options']['C']);
            $dCounts =  count($request->dropDownQuestions['questions']['options']['D']);
            $countList =   count($request->dropDownQuestions['questions']['lists']);
            // return  $countList=   count($request->dropDownQuestions['questions']['lists']);
            $savedQuestion = '';
            $lastsavednow = '';
            $q = 0;
            $s = 0;
            $r = 0;
            $t = 0;
            $lengtOptions = count($request->dropDownQuestions['questions']['options']);
            $optionisAnswer = 0;
            // return    count($request->dropDownQuestions['questions']['A']);
            foreach ($request->dropDownQuestions['questions']['lists'] as $key => $question) {
                $savedQuestion = SurveyQuestion::create([
                    'category_id' => $survey->category_id,
                    'survey_id' => $survey->id,
                    'questiontype_id' => 6,
                    'question' => $question,
                ]);
                if ($q < $aCounts) {
                    if (count($request->dropDownQuestions['questions']['lists']) <= count($request->dropDownQuestions['questions']['options']['A'])) {
                        $qOption = Questionoption::create([
                            'survey_question_id' => $savedQuestion->id,
                            'option' => $request->dropDownQuestions['questions']['options']['A'][$q]
                        ]);
                    }
                    $q++;
                }

                if ($s < $bCounts) {
                    if (count($request->dropDownQuestions['questions']['lists']) <= count($request->dropDownQuestions['questions']['options']['B'])) {
                        $qOption = Questionoption::create([
                            'survey_question_id' => $savedQuestion->id,
                            'option' => $request->dropDownQuestions['questions']['options']['B'][$s]
                        ]);
                    }
                    $s++;
                }

                if ($r < $cCounts) {
                    if (count($request->dropDownQuestions['questions']['lists']) <= count($request->dropDownQuestions['questions']['options']['C'])) {
                        $qOption = Questionoption::create([
                            'survey_question_id' => $savedQuestion->id,
                            'option' => $request->dropDownQuestions['questions']['options']['C'][$r]
                        ]);
                    }
                    $r++;
                }

                if ($t < $dCounts) {
                    if (count($request->dropDownQuestions['questions']['lists']) <= count($request->dropDownQuestions['questions']['options']['D'])) {
                        $qOption = Questionoption::create([
                            'survey_question_id' => $savedQuestion->id,
                            'option' => $request->dropDownQuestions['questions']['options']['D'][$t]
                        ]);
                    }
                    $t++;
                }
                if (isset($request->dropDownQuestions['questions']['answers']['optionB'])) {
                    if ($request->dropDownQuestions['questions']['answers']['optionB'][0] == 1) {
                        $optionisAnswer = 1;
                        $qOption->update(['isAnswer' => $optionisAnswer]);
                    } else {
                        $optionisAnswer = 0;
                        $qOption->update(['isAnswer' => $optionisAnswer]);
                    }
                }
                if (isset($request->dropDownQuestions['questions']['answers']['optionA'])) {
                    if ($request->dropDownQuestions['questions']['answers']['optionA'][0] == 1) {
                        $optionisAnswer = 1;
                        $qOption->update(['isAnswer' => $optionisAnswer]);
                    } else {
                        $optionisAnswer = 0;
                        $qOption->update(['isAnswer' => $optionisAnswer]);
                    }
                }
                if (isset($request->dropDownQuestions['questions']['answers']['optionC'])) {
                    if ($request->dropDownQuestions['questions']['answers']['optionC'][0] == 1) {
                        $optionisAnswer = 1;
                        $qOption->update(['isAnswer' => $optionisAnswer]);
                    } else {
                        $optionisAnswer = 0;
                        $qOption->update(['isAnswer' => $optionisAnswer]);
                    }
                }
                if (isset($request->dropDownQuestions['questions']['answers']['optionD'])) {
                    if ($request->dropDownQuestions['questions']['answers']['optionD'][0] == 1) {
                        $optionisAnswer = 1;
                        $qOption->update(['isAnswer' => $optionisAnswer]);
                    } else {
                        $optionisAnswer = 0;
                        $qOption->update(['isAnswer' => $optionisAnswer]);
                    }
                }
            }
        }

        // return $savedQuestion;
        $request->session()->flash('created', 'Questions created-successfully');
        return redirect()->back();
    }

    private function lastsavedID($saveddata)
    {
        return $saveddata;
    }
}

