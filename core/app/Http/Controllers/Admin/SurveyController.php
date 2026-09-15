<?php

namespace App\Http\Controllers\Survey;

use App\Models\Survey\Questionoption;
use App\User;
use Carbon\Carbon;
use App\ComplatedSurvey;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Survey\Survey;
use App\Models\Survey\Category;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Survey\SurveyQuestion;
use App\Http\Requests\Survey\SurveyStoreRequest;
use App\Http\Requests\Survey\SurveyUpdateRequest;
use Excel;
use App\Exports\SurveyExport;

use App\Exports\AllSurveyExport;
class SurveyController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        $surveys = Survey::latest()->with(array(
            'questions' => function ($query) {
                $query->select(
                    'category_id',
                    'survey_id',
                    'questiontype_id',
                    'question',
                    'isPublished',
                    'isBeenAnswered'
                );
            },
            'category' => function ($query) {
                $query->select('id', 'name');
            }, 'attempts'
        ))->get() ;
        $page_title = 'Surveys';
        // with('questions', 'category')

        $empty_message = 'No Data found.';
        return view('survey.index', compact('surveys', 'empty_message', 'page_title'));
    }

    public function ExportSurvey(Request $request)
    {
        $ab= DB::table('completed_surveys')
            ->join('users','users.id','=','completed_surveys.user_id')
            ->join('surveys','surveys.id','=','completed_surveys.survey_id')
            ->select('users.username','users.id','surveys.name','surveys.amount','completed_surveys.created_at','completed_surveys.survey_id','completed_surveys.user_id')
            ->groupBy(['completed_surveys.survey_id','completed_surveys.user_id'])
            ->orderBy('created_at','DESC')->get();
          return view('survey.export_survey', [
                'ab' =>$ab,
                'page_title' => 'Export Survey'
          ]);
    }

    public function ExportSurveyUser($id){
        return Excel::download(new SurveyExport($id), 'survey.xlsx');
    }

    public function ExportSurveyAllUser(){
        return Excel::download(new AllSurveyExport, 'All_survey.xlsx');
    }

    public function status($id)
    {
        $survey = Survey::find($id);
        if ($survey->active == 1)
            $survey->update([
                'active' => 0,
            ]);
        else
            $survey->update([
                'active' => 1,
            ]);
        return back();
    }
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $categories = Category::orderBy('name', 'asc')->get(['id', 'name']);
        $page_title = 'Survery Setup';
        return view('survey.create', compact(['page_title', 'categories']));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Survey\survey $survey
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show(Request $request, Survey $survey)
    {
        return view('survey.show', compact('survey'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Survey\survey $survey
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Survey $survey)
    {
        return view('survey.edit', compact('survey'));
    }

    /**
     * @param \App\Http\Requests\Survey\SurveyUpdateRequest $request
     * @param \App\Survey\survey $survey
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function update(SurveyUpdateRequest $request, Survey $survey)
    {
        $survey->update($request->validated());

        $request->session()->flash('survey.id', $survey->id);

        return redirect()->route('survey.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Survey\survey $survey
     * @return Survey|\App\Survey\survey|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, Survey $survey)
    {

        $survey->delete();
        $notify[] = ['success', 'Your Survey Deleted Successfully.'];
        return back()->withNotify($notify);
    }

    /**
     * @param \App\Http\Requests\Survey\SurveyStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SurveyStoreRequest $request)
    {
        $setupSurvey = Survey::create($request->validated() + ['surveySlug' => Str::slug($request['name'])]);
        $request->session()->flash('survey-created', 'Survey created successfully');
        return redirect()->route('admin.survey.create');
    }

    //Import

    public function import($id){
        $find = Survey::findOrFail($id);
        $data['category_id'] = $find->category_id;
        $data['name'] = $find->name;
        $data['active'] = $find->active;
        $data['amount'] = $find->amount;
        $data['surveySlug'] = $find->surveySlug;
        $data['description'] = $find->description;
       $a = Survey::create($data);
        $notify[] = ['success', 'Your Survey Imported Successfully.'];
        return back()->withNotify($notify);


    }


    // Survey Result

    public function indexResult($id)
    {
        $page_title = 'Result';
        $answers =  ComplatedSurvey::where('survey_question_id', $id)->get();
        $question = SurveyQuestion::find($id)->question;
        return view('survey.surveyResult.index', compact('page_title', 'question', 'answers'));
    }

    public function indexInputResult($id)
    {
        $page_title = 'Result';
        $answers =  ComplatedSurvey::where('survey_question_id', $id)->get();
        $question = SurveyQuestion::find($id)->question;
        return view('survey.surveyResult.indexInput', compact('page_title', 'question', 'answers'));
    }


    public function indexMultiResult($id)
    {

        $page_title = 'Result';
        $result = $this->ratio($id);
//        dd($result);
        $question = SurveyQuestion::find($id)->question;
        return view('survey.surveyResult.indexMulti', compact('page_title', 'question', 'result'));
    }

    public function indexYesno($id)
    {
        $page_title = 'Result';
        $yes =  ComplatedSurvey::where('survey_question_id', $id)->where('option',  "yes")->count();
        $no =  ComplatedSurvey::where('survey_question_id', $id)->where('option',  "no")->count();
        $question = SurveyQuestion::find($id)->question;
        return view('survey.surveyResult.indexYesno', compact('page_title', 'question', 'yes', 'no'));
    }
    public function iqQuestion($id)
    {
        $page_title = 'Result';
        $answers =  ComplatedSurvey::where('survey_question_id', $id)->where('option', '!=', "")->get();
        $question = SurveyQuestion::find($id)->question;

        return view('survey.surveyResult.indexIq', compact('page_title', 'question', 'answers'));
    }
    public function indexDropDown($id){

        $page_title = 'Result';
        $question = SurveyQuestion::find($id)->question;
        $answers =  ComplatedSurvey::where('survey_question_id', $id)->where('option', '!=', "")->get();

//        dd($answers);
        return view('survey.surveyResult.indexdropdown', compact('page_title', 'question', 'answers'));
    }
    private function ratio ($id){
        $data = ['a' => 0, 'b' => 0, 'c' => 0, 'd' => 0, 'total' => 0];
        $answers =  ComplatedSurvey::where('survey_question_id', $id)->where('option', '!=', "")->get();
        foreach ($answers as $key=> $ans){

            $answer =  Questionoption::where('id', $ans->option)->get();
            if ($answer[0]['option'] == 1){
                $data['a'] += 1;
            }
            else if($answer[0]['option'] == 2){
                $data['b'] += 1;
            }
            else if($answer[0]['option'] == 3){
                $data['c'] += 1;
            }
            else if($answer[0]['option'] == 4){
                $data['d'] += 1;
            }
            $data['total'] = $key+1;
        }
        return $data;
    }
}
