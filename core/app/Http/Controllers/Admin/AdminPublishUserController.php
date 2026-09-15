<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PublisherUser;
use App\Models\Survey\MicroJob;
use App\Models\Survey\Survey;
use App\Models\Deposit;
use App\Models\Transaction;
use App\Models\Ptc;
class AdminPublishUserController extends Controller
{
    public function allUsers(){

        $page_title = 'Manage Users';
        $empty_message = 'No user found';
        $users = PublisherUser::latest()->paginate(getPaginate());
        return view('admin.publish_user.list', compact('page_title', 'empty_message', 'users'));
    }

    public function detail($id)
    {
        $page_title = 'User Detail';
        $user = PublisherUser::findOrFail($id);
        $totalSurvey = Survey::where('publisher_user_id',$user->id)->count();
        $totalMicroJob = MicroJob::where('publisher_user_id',$user->id)->count();
        $totalPtc = Ptc::where('publisher_user_id',$user->id)->count();
        $totalTransaction = Transaction::where('publisher_user_id',$user->id)->count();
        $totalDeposit = Deposit::where('publisher_user_id',$user->id)->where('status',1)->sum('amount');
        return view('admin.publish_user.detail', compact('page_title', 'user','totalDeposit', 'totalTransaction', 'totalPtc','totalSurvey','totalMicroJob'));
    }

    public function update(Request $request, $id)
    {
        $user = PublisherUser::findOrFail($id);
        $request->validate([
            'firstname' => 'required|max:60',
            'lastname' => 'required|max:60',
            'email' => 'required|email|max:160|unique:users,email,' . $user->id,
        ]);

        if ($request->email != $user->email && User::whereEmail($request->email)->whereId('!=', $user->id)->count() > 0) {
            $notify[] = ['error', 'Email already exists.'];
            return back()->withNotify($notify);
        }
        if ($request->mobile != $user->mobile && User::where('mobile', $request->mobile)->whereId('!=', $user->id)->count() > 0) {
            $notify[] = ['error', 'Phone number already exists.'];
            return back()->withNotify($notify);
        }

        $user->update([
            'mobile' => $request->mobile,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'address' => [
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => $request->zip,
                'country' => $request->country,
            ],
            'status' => $request->status ? 1 : 0,
        ]);

        $notify[] = ['success', 'User detail has been updated'];
        return redirect()->back()->withNotify($notify);
    }

    public function deposits(Request $request, $id)
    {
        $user = PublisherUser::findOrFail($id);
        if ($request->search) {
            $search = $request->search;
            $page_title = 'Search User Deposits : ' . $user->username;
            $deposits = $user->deposits()->where('trx', $search)->latest()->paginate(getPaginate());
            $empty_message = 'No deposits';
            return view('admin.deposit.log', compact('page_title', 'search', 'user', 'deposits', 'empty_message'));
        }

        $page_title = 'User Deposit : ' . $user->username;
        $deposits = $user->deposits()->latest()->paginate(getPaginate());
        $empty_message = 'No deposits';
        return view('admin.deposit.log', compact('page_title', 'user', 'deposits', 'empty_message'));
    }

    public function PublisherPtc(){
        $page_title = 'PTC Ads';
        $empty_message = 'No Ads Created Yet.';
        $ptcs = Ptc::where('publisher_user_id','!=',null)->latest()->paginate(getPaginate());
        $PublisherPtc = 1;
        return view('admin.ptc.index', compact('page_title', 'empty_message', 'ptcs','PublisherPtc'));
    }

    public function PublisherStatusPtc($id){

        $survey = Ptc::find($id);
        if ($survey->status == 1){
            $survey->update([
                'status' => 0,
            ]);
        }else{
            $survey->update([
                'status' => 1,
            ]);
        }
        $notify[] = ['success', 'Your PTC Status Updated Successfully.'];
        return back()->withNotify($notify);
    }

    public function PublisherSurvey(Request $request)
    {

        // return "okahay";
        $surveys = Survey::where('publisher_user_id','!=',null)->latest()->with(array(
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
        ))->get(); //->paginate(10);
        //this is to make the query more optimized and load fast
        $page_title = 'Surveys';
        // with('questions', 'category')
        $PublisherPtc = 1;
        return view('survey.index', compact('surveys', 'page_title','PublisherPtc'));
    }

    public function PublisherSurveyStaus($id){

        $survey = Survey::find($id);
        if ($survey->active == 1){
            $survey->update([
                'active' => 0,
            ]);
        }else{
            $survey->update([
                'active' => 1,
            ]);
        }
        $notify[] = ['success', 'Your Survey Status Updated Successfully.'];
        return back()->withNotify($notify);
    }

    public function PublishUserMicroJob()
    {
        $jobs = MicroJob::where('publisher_user_id','!=',null)->with('category')->get();

        return view('survey.microjob.index', [
            'PublisherPtc' => 1,
            'jobs' => $jobs,
            'page_title' => "View MicroJobs",
            'action' => route('microJobs.update' , 0)
        ]);

    }

    public function PublisherMicrojobStaus($id){
        $jobs = MicroJob::find($id);
        if ($jobs->status == 1){
            $jobs->update([
                'status' => 0,
            ]);
        }else{
            $jobs->update([
                'status' => 1,
            ]);
        }
        $notify[] = ['success', 'Your Job Status Updated Successfully.'];
        return back()->withNotify($notify);
    }
}
