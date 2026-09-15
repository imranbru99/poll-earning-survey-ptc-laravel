<?php

namespace App\Http\Controllers\User;

use App\Ptc;
use App\PtcView;
use App\Transaction;
use App\Trx;
use App\GeneralSetting;
use App\PublisherUser;
use App\PublishUserTaskTransection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;

class PtcController extends Controller
{
	public function index(){
    	$page_title = "Webview List";
        $ads = Ptc::where('remain','>', 0)
                    ->where('status',1)
                    ->inRandomOrder()->orderBy('remain','ASC')->paginate(getPaginate());

    	$viewed = PtcView::where('user_id',auth()->user()->id)->where('vdt',Date('Y-m-d'))->pluck('ptc_id')->toArray();

    	$empty_message = "We are developing Webview";
    	return view(activeTemplate().'user.ptc.index',compact('ads','page_title','empty_message','viewed'));
    }

    public function show($hash){

	$decrypted = Crypt::decryptString($hash);
	$dcdata  = explode('|', $decrypted);
	$id = $dcdata[0];

		if($dcdata[1] != auth()->user()->id){
			$notify[] = ['error',"Opps! You are not aligable for this link"];
			return redirect()->route('user.home')->withNotify($notify);
		}
    	$page_title = "Show ads";
    	$ptc = Ptc::where('id',$id)->where('remain','>',0)->where('status',1)->firstOrFail();

    	$viewads = PtcView::where('user_id',auth()->user()->id)->where('vdt',Date('Y-m-d'))->get();
        if($viewads->count() == auth()->user()->dpl){
            $notify[] = ['error','Opps! You did not choose upgrade plan, Please deposit and upgrade your plan'];
            return redirect( route('user.deposit') )->withNotify($notify);
        }
        if ($viewads->where('ptc_id',$ptc->id)->first()) {
            $notify[] = ['error','You cannot see this add before 24 hour'];
            return back()->withNotify($notify);
        }
    	return view(activeTemplate().'user.ptc.show',compact('ptc','page_title'));
    }

    public function confirm($hash)
    {


        $user = auth()->user();
        $decrypted = Crypt::decryptString($hash);
        $dcdata  = explode('|', $decrypted);
        $id = $dcdata[0];
        if($dcdata[1] != $user->id){
            $notify[] = ['error',"Opps! You are not aligable for this link"];
            return redirect()->route('user.home')->withNotify($notify);
        }

        $CheckPtcPUserBalance = Ptc::where('id',$id)->firstOrFail();

        if($CheckPtcPUserBalance->publisher_user_id != null){
            $user = PublisherUser::findOrFail($CheckPtcPUserBalance->publisher_user_id);
            if ($user->balance == null) {
                $notify[] = ['success', 'News Publisher User Has Unsufficient Balance'];
                return redirect( route('user.home'))->withNotify($notify);
            }elseif($user->balance < $CheckPtcPUserBalance->amount){
                $notify[] = ['success', 'Survey Publisher User Has Unsufficient Balance'];
                return redirect( route('user.home'))->withNotify($notify);
            }
        }

        $ptc = Ptc::where('id',$id)->where('remain','>',0)->where('status',1)->firstOrFail();
        $viewads = PtcView::where('user_id',$user->id)->where('vdt',Date('Y-m-d'))->get();
        if($viewads->count() >= $user->dpl){
            $notify[] = ['error','Opps! Your Plan limit is over. You cannot see more News View today'];
            return back()->withNotify($notify);
        }
        if ($viewads->where('ptc_id',$ptc->id)->first()) {
            $notify[] = ['error','You cannot see this News before 24 hour'];
            return back()->withNotify($notify);
        }
        $ptc->increment('showed');
        $ptc->decrement('remain');
        $ptc->save();

        $user->balance += $ptc->amount;
        $user->save();
        if($ptc->publisher_user_id != null){
            $pUser = PublisherUser::where('id',$ptc->publisher_user_id)->first();
            $pUser->balance -= $ptc->amount;
            $pUser->save();

            PublishUserTaskTransection::create([
                'publisher_user_id'    =>  $ptc->publisher_user_id,
                'username'             =>  $user->username,
                'task_name'            =>  $ptc->title,
                'task_type'            =>  'ptc',
                'cost'                 =>  $ptc->amount,
            ]);
        }
        Transaction::create([
            'user_id'=>$user->id,
            'amount'=>$ptc->amount,
            'trx_type'=>'+',
            'charge'=>0,
            'details'=>'Earn amount from News',
            'remark'=>'earn',
            'post_balance'=>$user->balance,
            'trx'=>getTrx(),
        ]);
        PtcView::create([
            'ptc_id'=>$ptc->id,
            'user_id'=>$user->id,
            'amount'=>$ptc->amount,
            'vdt'=>Date('Y-m-d'),
            'created_at'=>Carbon::now(),
        ]);
        // $gnl = GeneralSetting::first();
        // if ($gnl->ref_ptc == 1) {
        //         levelCommision($user->id, $ptc->amount, $commissionType = 'Ads View Commssion');
        //     }

        $notify[] = ['success','Successfully viewed this News View, USD has been added in your balance'];
        return redirect()->route('user.ptc.index')->withNotify($notify);
    }

    public function clicks()
    {
        $page_title = "News History";
        $ptc = PtcView::where('user_id',auth()->user()->id)->get();
        $viewads = $ptc->groupBy('vdt')->map(function ($item,$key) {
            $data['clicks'] = collect($item)->count();
            $data['amount'] = collect($item)->sum('amount');
            $data['date'] = $key;
            return $data;
        })->sort()->reverse()->paginate(getPaginate());
        $empty_message = "You didn't View Any News Yet";
        return view(activeTemplate().'user.ptc.clicks',compact('viewads','page_title','empty_message'));
    }


}
