<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Referral;

class PlanController extends Controller
{

    public function index()
    {
        $page_title = 'Membership Plans';
        $empty_message = 'No Plan Created Yet.';
        $plans = Plan::orderBy('id')->paginate(getPaginate());
        $refs = Referral::get();
        return view('admin.plans', compact('page_title', 'empty_message', 'plans', 'refs'));
        // is it working now,, yes
    }


    public function update(Request $request) {

        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|min:0',
            'daily_limit' => 'required|numeric|min:0',
            'survey_limit' => 'required|numeric|min:0',
            'daily_income' => 'required|numeric|min:0',
            'refer_monthly' => 'required|numeric|min:0',
            'refer_commission' => 'required',
            'ref_level' => 'required|numeric|min:0',
        ]);

        if($request->id == 0){
            $plan = new Plan();
        }else{
            $plan = Plan::findOrFail($request->id);
        }
        $plan->name = $request->name;
        $plan->price = $request->price;
        $plan->daily_limit = $request->daily_limit;
        $plan->survey_limit = $request->survey_limit;
        $plan->daily_income = $request->daily_income;
        $plan->refer_monthly = $request->refer_monthly;
        $plan->monthly_income = $request->monthly_income;
        $plan->refer_commission = $request->refer_commission;
        $plan->ref_level = $request->ref_level;
        $plan->status = isset($request->status) ? 1:0;
        $plan->save();

        $notify[] = ['success', 'Plan has been Updated Successfully.'];
        return back()->withNotify($notify);
    }


}
