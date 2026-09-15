<?php

namespace App\Http\Controllers\User;

use App\CommissionLog;
use App\GeneralSetting;
use App\Lib\GoogleAuthenticator;
use App\Models\Survey\Questionimage;
use App\Plan;
use App\Deposit;
use App\PtcView;
use App\Referral;
use App\Rules\FileTypeValidate;
use App\Transaction;
use App\User;
use App\WithdrawMethod;
use App\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Image;
use Validator;
use App\Models\Survey\UserMicroJob;
use App\ComplatedSurvey;
use App\Models\Survey\SurveyQuestion;
use App\Models\Survey\Survey;
use Illuminate\Support\Facades\Crypt;
use App\Gateway;
use App\Ptc;
use App\Models\Survey\MicroJob;
use App\Http\Controllers\Controller;


class SurveyController extends Controller
{
    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }


    public function survey(Request $request)
    {
        $empty_message = 'No Data found.';
        $surveys = Survey::where('active', 1)
            ->when($request->q, function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->q.'%');
            })
            ->paginate(getPaginate());
        $page_title = "Opinion";
        return view(activeTemplate() . 'user.survey.index', compact('page_title', 'empty_message', 'surveys'));
    }

    public function history()
    {
        // return('okay');
        $page_title = "Opinion History";
        $surveys = ComplatedSurvey::whereUserId(Auth::id())
        ->groupBy('survey_id')
        ->distinct()
        ->orderBy('created_at','DESC')
        ->get();
        return view(activeTemplate() . 'user.survey.history', compact('page_title', 'surveys'));
    }

    public function startSurvey($id)
    {


        $plan = Plan::find(Auth::user()->plan_id);
        if (Auth::user()->plan_id != 0) {
            $ComplatedSurvey = ComplatedSurvey::where('user_id', Auth::id())->whereDate('created_at', Carbon::today())->get();
            $completed_surveys_count = ComplatedSurvey::where('user_id', Auth::id())->whereDate('created_at', Carbon::today())->distinct('survey_id')->count();
            if ($plan->survey_limit <= $completed_surveys_count) {
                $notify[] = ['success', 'Your Plan Poll limit has completed, To Do More Poll Please Deposit and Upgrade Plan.'];
               return redirect( route('user.deposit') )->withNotify($notify);
            }
        } else {
            $notify[] = ['error', 'Please Subscribe Plan first, Or You can earn free by doing MicroJobs.'];
            return redirect( route('user.deposit') )->withNotify($notify);
        }


        $page_title = "Start Opinion";
        $id     = Crypt::decryptString($id);
        $surveyQuestionsCount = SurveyQuestion::where('survey_id', $id)->count();
        $surveyQuestions = SurveyQuestion::with('questionOptions')->where('survey_id', $id)->oldest()->get();

        ComplatedSurvey::insert(['survey_id' => $id,'user_id' => Auth::id(),'status' => 0,'created_at' => Carbon::now('Asia/Dhaka')]);
        return view(activeTemplate() . 'user.survey.start', compact('page_title', 'surveyQuestions', 'surveyQuestionsCount'));
    }

    public function storeSurvey(Request $request)
    {
        // return$request;
        if (ComplatedSurvey::where('survey_id',$request->survey_id)->where('user_id',Auth::id())->where('status',1)->exists()) {
                $notify[] = ['error', 'You have already completed this Poll'];
                return redirect( route('user.home'))->withNotify($notify);
        }
        $survey = Survey::find($request->survey_id);


        if ($request->has('MultiChoiceQuestions')) {

            foreach ($request->MultiChoiceQuestions['questions']['lists'] as $question) {
                $completed_survey = new ComplatedSurvey;
                $completed_survey->survey_question_id = $question;
                $completed_survey->survey_id = $request->survey_id;
                $completed_survey->user_id = Auth::id();
                $options = '';
                if (isset($request->MultiChoiceQuestions['questions']['options'][$question]['A']))
                    $options .= $request->MultiChoiceQuestions['questions']['options'][$question]['A'];
                if (isset($request->MultiChoiceQuestions['questions']['options'][$question]['B']))
                    $options .= ',' . $request->MultiChoiceQuestions['questions']['options'][$question]['B'];
                if (isset($request->MultiChoiceQuestions['questions']['options'][$question]['C']))
                    $options .= ',' . $request->MultiChoiceQuestions['questions']['options'][$question]['C'];
                if (isset($request->MultiChoiceQuestions['questions']['options'][$question]['D']))
                    $options .= ',' . $request->MultiChoiceQuestions['questions']['options'][$question]['D'];
                $completed_survey->option = $options;
                $completed_survey->status = 1;
                $completed_survey->save();
            }
        }

        if ($request->has('InputBaseQuestions')) {
            $i = 0;
            foreach ($request->InputBaseQuestions['questions']['lists'] as $question) {
                $completed_survey = new ComplatedSurvey;
                $completed_survey->survey_question_id = $question;
                $completed_survey->survey_id = $request->survey_id;
                $completed_survey->user_id = Auth::id();
                $completed_survey->status = 1;
                if (isset($request->InputBaseQuestions['answers']['lists'][$i])) {
                    $completed_survey->option = $request->InputBaseQuestions['answers']['lists'][$i];
                    $completed_survey->save();
                }
                $i++;
            }
        }

        if ($request->has('YesNoQuestions')) {
            foreach ($request->YesNoQuestions['questions']['lists'] as $question) {
                $completed_survey = new ComplatedSurvey;
                $completed_survey->survey_question_id = $question;
                $completed_survey->survey_id = $request->survey_id;
                $completed_survey->user_id = Auth::id();
                $completed_survey->status = 1;
                if (isset($request->YesNoQuestions['questions']['options'][$question])) {
                    $completed_survey->option = $request->YesNoQuestions['questions']['options'][$question];
                    $completed_survey->save();
                }
            }
        }

        if ($request->has('LinearQuestions')) {
            foreach ($request->LinearQuestions['questions']['lists'] as $question) {
                $completed_survey = new ComplatedSurvey;
                $completed_survey->survey_question_id = $question;
                $completed_survey->survey_id = $request->survey_id;
                $completed_survey->user_id = Auth::id();
                $completed_survey->status = 1;
                if (isset($request->LinearQuestions['questions']['options'][$question])) {
                    $completed_survey->option = $request->LinearQuestions['questions']['options'][$question];
                    $completed_survey->save();
                }
            }
        }

        if ($request->has('dropDownQuestions')) {
            foreach ($request->dropDownQuestions['questions']['lists'] as $question) {
                $i = 0;
                foreach ($request->dropDownQuestions['questions']['lists'] as $question) {
                    $completed_survey = new ComplatedSurvey;
                    $completed_survey->survey_question_id = $question;
                    $completed_survey->survey_id = $request->survey_id;
                    $completed_survey->user_id = Auth::id();
                    $completed_survey->status = 1;
                    if (isset($request->dropDownQuestions['questions']['options'][$i])) {
                        $completed_survey->option = $request->dropDownQuestions['questions']['options'][$i];
                        $completed_survey->save();
                    }
                    $i++;
                }
            }
        }

        if ($request->reject !=1){
            $survey = Survey::find($request->survey_id);
            $oldAmount = User::findOrFail(auth()->user()->id);
            $oldAmount->balance = $oldAmount->balance +  $survey->amount;
            $oldAmount->save();
            ComplatedSurvey::where('survey_id',$request->survey_id)->where('user_id',Auth::id())->update(['status' => 1,'created_at' => Carbon::now('Asia/Dhaka')]);

            Transaction::create([
                'user_id'=>$oldAmount->id,
                'amount'=>$survey->amount,
                'trx_type'=>'+',
                'charge'=>0,
                'details'=>'Earn amount from Opinion',
                'remark'=>'earn',
                'post_balance'=>$oldAmount->balance,
                'trx'=>getTrx(),
            ]);

            if ($request->reject == 1) {
                ComplatedSurvey::where('survey_id',$request->survey_id)->where('user_id',Auth::id())->delete();
            }
        }
        $notify[] = ['success', 'Your Opinion is completed Successfully.'];
        return redirect()->route('user.survey')->withNotify($notify);

    }

 
}
