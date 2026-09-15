<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\UserPlan;
use App\Http\Controllers\Controller;

class UserPlanController extends Controller
{
    public function index(){

        $page_title = 'User Plans';
        $userPlans  = UserPlan::all();
        return view('admin.plan.index')->with(compact('page_title','userPlans'));
    }

    public function addUserPlan(Request $request){
        if ($request->isMethod('post')) {
            // return $request;
            $plan         = new UserPlan;
            $plan->title  = $request->title;
            $plan->value  = $request->value;
            $plan->save();
            $notify[] = ['success', 'Plan Created Successfully'];
            return redirect( route('admin.user_plans') )->withNotify($notify);
        }
        $page_title = 'User Plans';

        return view('admin.plan.add')->with(compact('page_title'));
    }

    public function editUserPlan($id , Request $request){
        if ($request->isMethod('post')) {
            // return $request;
            $plan         = UserPlan::find($id);
            $plan->title  = $request->title;
            $plan->value  = $request->value;
            $plan->save();
            $notify[] = ['success', 'Plan Updated Successfully'];
            return redirect( route('admin.user_plans') )->withNotify($notify);
        }
        $page_title = 'Edit User Plans';
        $userPlan   = UserPlan::find($id);
        return view('admin.plan.edit')->with(compact('page_title','userPlan','id'));
    }


    public function deleteUserPlan($id){
        $userPlan   = UserPlan::find($id);
        $userPlan->delete();
        $notify[] = ['success', 'Plan Deleted Successfully'];
        return redirect( route('admin.plan') )->withNotify($notify);
    }
}
