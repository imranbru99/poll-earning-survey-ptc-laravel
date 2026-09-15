<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\UserPlan;
use App\Transaction;
use App\UserConfirmedPlan;
use App\User;
use App\Models\UserNotification;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class CalculatorController extends Controller
{


    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }


    public function calculator(){
        $page_title = 'Choosing Mining Plan ';
        $plans      = UserPlan::all();
        return view(activeTemplate() . 'user.invest.calculator' ,compact('page_title','plans'));
    }

    public function getPercentage(Request $req){
        $plan      = $req->plan;
        $amount    = $req->amount;
        $plans     =  explode('|',$plan);
        $resu      =  explode(' ',$plans[1]);
        $result    = ($plans[0] / 100) * $amount;
        $capital   = $amount + $result;
        if(strtolower($resu[0]) == 'weekly'){
            $daily  = $result/7;
        }elseif(strtolower($resu[0]) == 'monthly'){
            $daily  = $result/30;
        }else{
            $daily  = $result/365;
        }
        return response()->json([
            'net_profit' => $result,
            'daily'      => round($daily,2),
            'capital'    => $capital,
        ]);
    }

    public function confirmedPlan(Request $req){
        // return $req;
        $plan      = $req->plan;
        $plans     =  explode('|',$plan);
        $resu      =  explode(' ',$plans[1]);
        // return auth()->user()->balance;
        if($req->amount <= auth()->user()->balance){
            $cPlan                 = new UserConfirmedPlan;
            $cPlan->user_id        = auth()->user()->id;
            $cPlan->plan           = (isset($resu[0]) ? $resu[0] : '');
            $cPlan->percentage     = (isset($plans[0]) ? $plans[0] : '');
            $cPlan->amount         = $req->amount;
            $cPlan->profit         = $req->net_profit;
            $cPlan->daily_interest = $req->daily;
            $cPlan->save();

            $user     =  User::find(auth()->user()->id);
            $user->balance = $user->balance - $req->amount;
            $user->save();



            $transaction = new Transaction();
            $transaction->user_id = auth()->user()->id;
            $transaction->amount = getAmount($cPlan->amount);
            $transaction->post_balance = getAmount($user->balance);
            $transaction->charge = "0";
            $transaction->trx_type = '-';
            $transaction->details = ' You have Chosen ' . $cPlan->plan . ' interest plan where you invested this amount ' . getAmount($cPlan->amount) . ' , Your daily interest is ' . $cPlan->daily_interest . ' and You will get net profit  ' . $cPlan->profit . ' USD ' ;
            $transaction->trx =  getTrx();
            $transaction->save();

            $userNotifications = new UserNotification();
            $userNotifications->title = 'You have Chosen to the plan';
            $userNotifications->user_id = $user->id;
            $userNotifications->click_url = urlPath('user.calculator');
            $userNotifications->save();

            $notify[] = ['success', 'Your Plan Has Been Successfully Confirmed'];
            return redirect()->back()->withNotify($notify);
        }else{
            $notify[] = ['success', 'Your Account Balance is Insufficient Please Deposit Amount First'];
            return redirect( route('user.deposit') )->withNotify($notify);
        }

    }


    public function history()
    {
        $page_title = "Your Mining History";
        $pl = UserConfirmedPlan::where('user_id', auth()->user()->id)->get();
        return view(activeTemplate() . 'user.invest.history', compact('page_title', 'pl'));
    }
}
