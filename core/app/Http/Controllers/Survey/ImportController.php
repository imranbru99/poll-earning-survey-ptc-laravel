<?php

namespace App\Http\Controllers\Survey;

use App\ComplatedSurvey;
use App\Http\Controllers\Controller;
use App\Models\Survey\Questionoption;
use App\Models\Survey\SurveyQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
 public function index()
    {

          $ab= DB::table('completed_surveys')
            ->join('users','users.id','=','completed_surveys.user_id')
            ->join('surveys','surveys.id','=','completed_surveys.survey_id')
            ->select('users.username','users.id','surveys.name','surveys.amount','completed_surveys.created_at', 'completed_surveys.status')
            ->groupBy(['completed_surveys.survey_id','completed_surveys.user_id'])
          -> latest()
            ->get();
          return view('survey.surveyResult.complateSuvery', [
                'ab' =>$ab,
                'page_title' => 'Completed Survey'
          ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//        dd($request->question_id);

       $s= SurveyQuestion::where('id',$request->question_id)->with('questionOptions')->get();
       $option = [];
       foreach ($s as $question)
       {
           $data['category_id'] = $question->category_id ;
           $data['survey_id'] = $question->survey_id ;
           $data['questiontype_id'] = $question->questiontype_id ;
           $data['question'] = $question-> question;
           $data['isPublished'] = $question-> isPublished;
           $data['isBeenAnswered'] = $question-> isBeenAnswered;
           $data['link'] = $question->link ;
           $data['point'] = $question-> point;
            $questionId =  SurveyQuestion::create($data);

           foreach ($question->questionOptions as $key => $q){
             $option['survey_question_id'] = $questionId->id ;
             $option['option'] = $q->option ;
             $option['isAnswer'] = $q->isAnswer ;
               Questionoption::create($option);
           }
       }
        $notify[] = ['success', 'Question Imported Successfully'];
       return back()->withNotify($notify);



        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
