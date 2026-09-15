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
use App\UserLogin;
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
use App\Models\UserNotification;
use App\Models\Survey\SurveyQuestion;
use App\Models\Survey\Survey;
use Illuminate\Support\Facades\Crypt;
use App\Gateway;
use App\Ptc;
use App\Models\Survey\MicroJob;
use App\Http\Controllers\Controller;


class UserController extends Controller
{
    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }
    public function home()
    {
        $page_title = 'Dashboard';
        $ptc = PtcView::where('user_id', auth()->user()->id)->get(['vdt', 'amount']);
        $data['total_microjob']       = UserMicroJob::where('user_id', auth()->id())->count();
        $data['Completed_microjob']       = UserMicroJob::where('user_id', auth()->id())->where('is_pending', 1)->count();
        $data['Rejected_microjob']       = UserMicroJob::where('user_id', auth()->id())->where('deleted_at')->count();
        $data['ComplatedSurvey']       = ComplatedSurvey::where('user_id', auth()->id())->groupBy('survey_id')->where('status', 1)->count();
        $data['RejectedSurvey']       = ComplatedSurvey::where('user_id', auth()->id())->groupBy('survey_id')->where('status', 0)->count();
        $data['totalDeposit']       = Deposit::where('user_id', auth()->id())->where('status', 1)->sum('amount');
        $data['pendingDeposit']    = Deposit::where('user_id', auth()->id())->where('status', 2)->sum('amount');
        $data['rejectDeposit']     = Deposit::where('user_id', auth()->id())->where('status', 3)->sum('amount');
        $data['totalWithdraw']      = Withdrawal::where('user_id', auth()->id())->where('status', 1)->sum('amount');
        $data['completeWithdraw']   = Withdrawal::where('user_id', auth()->id())->where('status', 1)->count();
        $data['pendingWithdraw']    = Withdrawal::where('user_id', auth()->id())->where('status', 2)->count();
        $data['rejectWithdraw']     = Withdrawal::where('user_id', auth()->id())->where('status', 3)->count();
        $data['total_ref']          = User::where('ref_by', auth()->id())->count();
        $data['amount']             = $ptc->groupBy('vdt')->map(function ($item,$key) {
            return collect($item)->sum('amount');
        })->sort()->reverse()->take(7)->toArray();

        $chart['click'] = $ptc->groupBy('vdt')->map(function ($item, $key) {
            return collect($item)->count();
        })->sort()->reverse()->take(7)->toArray();

        $chart['amount'] = $ptc->groupBy('vdt')->map(function ($item, $key) {
            return collect($item)->sum('amount');
        })->sort()->reverse()->take(7)->toArray();
        $user = auth()->user();
        $userLogin = UserLogin::where('user_id', auth()->id())->latest()->take(8)->get();
        $todayEarn = Transaction::where('user_id', $user->id)
            ->where('trx_type', '+')
            ->whereDate('created_at', Carbon::today())
            ->sum('amount');
        $checkedIn = Transaction::where('user_id', $user->id)
            ->where('details', 'Daily check-in bonus')
            ->whereDate('created_at', Carbon::today())
            ->exists();
        $streak = 0;
        for ($i = 0; $i < 14; $i++) {
            $day = Carbon::today()->subDays($i);
            $has = Transaction::where('user_id', $user->id)
                ->where('details', 'Daily check-in bonus')
                ->whereDate('created_at', $day)
                ->exists();
            if (!$has) {
                break;
            }
            $streak++;
        }
        return view($this->activeTemplate . 'user.dashboard', compact('page_title','data', 'chart', 'user', 'userLogin', 'todayEarn', 'checkedIn', 'streak'));
    }

    public function dailyCheckin()
    {
        $user = auth()->user();
        $already = Transaction::where('user_id', $user->id)
            ->where('details', 'Daily check-in bonus')
            ->whereDate('created_at', Carbon::today())
            ->exists();

        if ($already) {
            $notify[] = ['error', 'You already claimed today\'s check-in bonus.'];
            return back()->withNotify($notify);
        }

        $amount = 0.10;
        $user->bonus = getAmount($user->bonus) + $amount;
        $user->save();

        Transaction::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'trx_type' => '+',
            'charge' => 0,
            'details' => 'Daily check-in bonus',
            'remark' => 'checkin',
            'post_balance' => $user->bonus,
            'trx' => getTrx(),
        ]);

        $notify[] = ['success', 'Daily check-in claimed. $0.10 added to your bonus balance.'];
        return back()->withNotify($notify);
    }

    public function profile()
    {
        $data['page_title'] = "Profile Setting";
        $data['user'] = Auth::user();
        return view($this->activeTemplate . 'user.profile', $data);
    }

    public function submitProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'firstname' => 'required|max:160',
            'lastname' => 'required|max:160',
            'address' => 'nullable|max:160',
            'city' => 'nullable|max:160',
            'state' => 'nullable|max:160',
            'district' => 'nullable|max:160',
            'upozila' => 'nullable|max:160',
            'post_office' => 'nullable|max:160',
            'village' => 'nullable|max:160',
            'para' => 'nullable|max:160',
            'zip' => 'nullable|max:160',
            'country' => 'nullable|max:160',
            'image' => ['nullable', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
        ], [
            'firstname.required' => 'First Name Field is required',
            'lastname.required' => 'Last Name Field is required'
        ]);


        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->mobile = str_replace('-', '', $request->mobile);

        $user->address = [
            'address' => $request->address,
            'state' => $request->state,
            'district' => $request->district,
            'upozila' => $request->upozila,
            'post_office' => $request->post_office,
            'village' => $request->village,
            'para' => $request->para,
            'zip' => $request->zip,
            'country' => $request->country,
            'city' => $request->city,
        ];


        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $user->username . '.jpg';
            $location = 'assets/images/user/profile/' . $filename;
            $user->image = $filename;

            $path = './assets/images/user/profile/';
            $link = $path . $user->image;
            if (file_exists($link)) {
                @unlink($link);
            }
            Image::make($image)->save($location);
        }
        $user->save();
        $notify[] = ['success', 'Your Profile Updated successfully.'];
        return back()->withNotify($notify);
    }

    public function changePassword()
    {
        $data['page_title'] = "CHANGE PASSWORD";
        return view($this->activeTemplate . 'user.password', $data);
    }

    public function submitPassword(Request $request)
    {

        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|min:5|confirmed'
        ]);
        try {
            $user = auth()->user();
            if (Hash::check($request->current_password, $user->password)) {
                $password = Hash::make($request->password);
                $user->password = $password;
                $user->save();
                $notify[] = ['success', 'Your Password Changes successfully.'];
                return back()->withNotify($notify);
            } else {
                $notify[] = ['error', 'Your Current password not match.'];
                return back()->withNotify($notify);
            }
        } catch (\PDOException $e) {
            $notify[] = ['error', $e->getMessage()];
            return back()->withNotify($notify);
        }
    }

    /*
     * Deposit History
     */
    public function depositHistory()
    {
        $page_title = 'Deposit History';
        $empty_message = 'No history found.';
        $logs = auth()->user()->deposits()->with(['gateway'])->latest()->paginate(getPaginate());
        return view($this->activeTemplate . 'user.deposit_history', compact('page_title', 'empty_message', 'logs'));
    }

    /*
     * Withdraw Operation
     */

    public function withdrawMoney()
    {
        $data['user'] = Auth::user();
        $data['withdrawMethod'] = WithdrawMethod::whereStatus(1)->get();
        $data['page_title'] = "Withdraw Money";
        return view(activeTemplate() . 'user.withdraw.methods', $data);
    }

    public function withdrawStore(Request $request)
    {
        
        $data['empty_message'] = "No Data Found!";
        $this->validate($request, [
            'method_code' => 'required',
            'amount' => 'required|numeric'
        ]);
        $method = WithdrawMethod::where('id', $request->method_code)->where('status', 1)->firstOrFail();
        $user = auth()->user();
        if ($request->amount < $method->min_limit) {
            $notify[] = ['error', 'Your Requested Amount is lower Than Minimum Amount.'];
            return back()->withNotify($notify);
        }
        if ($request->amount > $method->max_limit) {
            $notify[] = ['error', 'Your Requested Amount is greater Than Maximum Amount.'];
            return back()->withNotify($notify);
        }

        if ($request->amount > $user->balance) {
            $notify[] = ['error', 'You do not have enough Main Balance For Withdraw.'];
            return back()->withNotify($notify);
        }


        $charge = $method->fixed_charge + ($request->amount * $method->percent_charge / 100);
        $afterCharge = $request->amount - $charge;
        $finalAmount = getAmount($afterCharge * $method->rate);

        $w['method_id'] = $method->id; // wallet method ID
        $w['user_id'] = $user->id;
        $w['amount'] = getAmount($request->amount);
        $w['currency'] = $method->currency;
        $w['rate'] = $method->rate;
        $w['charge'] = $charge;
        $w['final_amount'] = $finalAmount;
        $w['after_charge'] = $afterCharge;
        $w['trx'] = getTrx();
        $result = Withdrawal::create($w);
        session()->put('wtrx', $result->trx);
        return redirect()->route('user.withdraw.preview');
    }

    public function withdrawPreview()
    {
        $data['withdraw'] = Withdrawal::with('method', 'user')->where('trx', session()->get('wtrx'))->where('status', 0)->latest()->firstOrFail();
        $data['page_title'] = "Withdraw Preview";
        return view($this->activeTemplate . 'user.withdraw.preview', $data);
    }


    public function withdrawSubmit(Request $request)
    {
        $general = GeneralSetting::first();
        $withdraw = Withdrawal::with('method', 'user')->where('trx', session()->get('wtrx'))->where('status', 0)->latest()->firstOrFail();
        // witdraw history
        $rules = [];
        $inputField = [];
        if ($withdraw->method->user_data != null) {
            foreach ($withdraw->method->user_data as $key => $cus) {
                $rules[$key] = [$cus->validation];
                if ($cus->type == 'file') {
                    array_push($rules[$key], 'image');
                    array_push($rules[$key], 'mimes:jpeg,jpg,png');
                    array_push($rules[$key], 'max:2048');
                }
                if ($cus->type == 'text') {
                    array_push($rules[$key], 'max:191');
                }
                if ($cus->type == 'textarea') {
                    array_push($rules[$key], 'max:300');
                }
                $inputField[] = $key;
            }
        }
        $this->validate($request, $rules);
        $user = auth()->user();

        if (getAmount($withdraw->amount) > $user->balance) {
            $notify[] = ['error', 'Your Request Amount is Larger Then Your Current Balance.'];
            return back()->withNotify($notify);
        }
        // return Auth::user()->withdrawals();
        //this s[part doe thats right yes
        // return  $withdrawals->id;
        // if ($withdrawals->where('user_id',$withdrawals->id)->week()) {
        //     $notify[] = ['error','You cannot withdraw in this week, please try next week'];
        //     return back()->withNotify($notify);
        // }

        $directory = date("Y") . "/" . date("m") . "/" . date("d");
        $path = imagePath()['verify']['withdraw']['path'] . '/' . $directory;
        $collection = collect($request);
        $reqField = [];
        if ($withdraw->method->user_data != null) {
            foreach ($collection as $k => $v) {
                foreach ($withdraw->method->user_data as $inKey => $inVal) {
                    if ($k != $inKey) {
                        continue;
                    } else {
                        if ($inVal->type == 'file') {
                            if ($request->hasFile($inKey)) {
                                try {
                                    $reqField[$inKey] = [
                                        'field_name' => $directory . '/' . uploadImage($request[$inKey], $path),
                                        'type' => $inVal->type,
                                    ];
                                } catch (\Exception $exp) {
                                    $notify[] = ['error', 'Could not upload your ' . $request[$inKey]];
                                    return back()->withNotify($notify)->withInput();
                                }
                            }
                        } else {
                            $reqField[$inKey] = $v;
                            $reqField[$inKey] = [
                                'field_name' => $v,
                                'type' => $inVal->type,
                            ];
                        }
                    }
                }
            }
            $withdraw['withdraw_information'] = $reqField;
        } else {
            $withdraw['withdraw_information'] = null;
        }


        $withdraw->status = 2;
        $withdraw->save();
        $user->balance  -=  $withdraw->amount;
        $user->update();



        $transaction = new Transaction();
        $transaction->user_id = $withdraw->user_id;
        $transaction->amount = getAmount($withdraw->amount);
        $transaction->post_balance = getAmount($user->balance);
        $transaction->charge = getAmount($withdraw->charge);
        $transaction->trx_type = '-';
        $transaction->details = getAmount($withdraw->final_amount) . ' ' . $withdraw->currency . ' Withdraw Via ' . $withdraw->method->name;
        $transaction->trx =  $withdraw->trx;
        $transaction->save();

        notify($user, 'WITHDRAW_REQUEST', [
            'method_name' => $withdraw->method->name,
            'method_currency' => $withdraw->currency,
            'method_amount' => getAmount($withdraw->final_amount),
            'amount' => getAmount($withdraw->amount),
            'charge' => getAmount($withdraw->charge),
            'currency' => $general->cur_text,
            'rate' => getAmount($withdraw->rate),
            'trx' => $withdraw->trx,
            'post_balance' => getAmount($user->balance),
            'delay' => $withdraw->method->delay
        ]);

        $notify[] = ['success', 'Your Withdraw amount will be send very soon'];
        return redirect()->route('user.withdraw.history')->withNotify($notify);
    }

    public function withdrawLog()
    {
        $data['page_title'] = "Withdraw History";
        $data['withdraws'] = Withdrawal::where('user_id', Auth::id())->where('status', '!=', 0)->with('method')->latest()->paginate(getPaginate());
        $data['empty_message'] = "No Data Found!";
        return view($this->activeTemplate . 'user.withdraw.log', $data);
    }
    // go to that method we are b4



    public function show2faForm()
    {
        $gnl = GeneralSetting::first();
        $ga = new GoogleAuthenticator();
        $user = auth()->user();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . $gnl->sitename, $secret);
        $prevcode = $user->tsc;
        $prevqr = $ga->getQRCodeGoogleUrl($user->username . '@' . $gnl->sitename, $prevcode);
        $page_title = 'Two Factor';
        return view($this->activeTemplate . 'user.twofactor', compact('page_title', 'secret', 'qrCodeUrl', 'prevcode', 'prevqr'));
    }

    public function create2fa(Request $request)
    {
        $user = auth()->user();
        $this->validate($request, [
            'key' => 'required',
            'code' => 'required',
        ]);

        $ga = new GoogleAuthenticator();
        $secret = $request->key;
        $oneCode = $ga->getCode($secret);

        if ($oneCode === $request->code) {
            $user->tsc = $request->key;
            $user->ts = 1;
            $user->tv = 1;
            $user->save();


            $userAgent = getIpInfo();
            send_email($user, '2FA_ENABLE', [
                'operating_system' => $userAgent['os_platform'],
                'browser' => $userAgent['browser'],
                'ip' => $userAgent['ip'],
                'time' => $userAgent['time']
            ]);
            send_sms($user, '2FA_ENABLE', [
                'operating_system' => $userAgent['os_platform'],
                'browser' => $userAgent['browser'],
                'ip' => $userAgent['ip'],
                'time' => $userAgent['time']
            ]);


            $notify[] = ['success', 'Your Google Authenticator Enabled Successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong Verification Code'];
            return back()->withNotify($notify);
        }
    }


    public function disable2fa(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
        ]);

        $user = auth()->user();
        $ga = new GoogleAuthenticator();

        $secret = $user->tsc;
        $oneCode = $ga->getCode($secret);
        $userCode = $request->code;

        if ($oneCode == $userCode) {

            $user->tsc = null;
            $user->ts = 0;
            $user->tv = 1;
            $user->save();


            $userAgent = getIpInfo();
            send_email($user, '2FA_DISABLE', [
                'operating_system' => $userAgent['os_platform'],
                'browser' => $userAgent['browser'],
                'ip' => $userAgent['ip'],
                'time' => $userAgent['time']
            ]);
            send_sms($user, '2FA_DISABLE', [
                'operating_system' => $userAgent['os_platform'],
                'browser' => $userAgent['browser'],
                'ip' => $userAgent['ip'],
                'time' => $userAgent['time']
            ]);


            $notify[] = ['success', 'Two Factor Authenticator Disable Successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong Verification Code'];
            return back()->with($notify);
        }
    }

    public function transactions()
    {
        $page_title = 'Transactions';
        $logs = auth()->user()->transactions()->orderBy('id', 'desc')->paginate(getPaginate());
        $empty_message = 'No transaction history';
        return view(activeTemplate() . 'user.transactions', compact('page_title', 'logs', 'empty_message'));
    }


    public function plans()
    {
        $page_title = "Choosing Plan";
        $plans = Plan::where('status', 1)->get();
        return view(activeTemplate() . 'user.Packages', compact('plans', 'page_title'));
    }


    public function buyPlan(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        $plan = Plan::findOrFail($request->id);
        $user = auth()->user();
        if ($plan->id == $user->plan_id) {
            $notify[] = ['error', "Opps! you can't buy your current plan"];
            return back()->withNotify($notify);
        }
        if ($plan->price > $user->balance) {
            $notify[] = ['error', 'Opps! your balance is not sufficient, Deposit and Try Again'];
           return redirect( route('user.deposit') )->withNotify($notify);
        }
        $user->balance -= $plan->price;
        $user->dpl = $plan->daily_limit;
        $user->plan_id = $plan->id;
        $user->save();
        $trx = getTrx();
        Transaction::create([
            'user_id' => $user->id,
            'amount' => $plan->price,
            'charge' => 0,
            'trx_type' => '-',
            'details' => 'Subscribed to ' . $plan->name . ' Plan',
            'remark' => 'buy_plan',
            'trx' => $trx,
            'post_balance' => $user->balance
        ]);
        $gnl = GeneralSetting::first();
        if ($gnl->ref_upgr == 1) {
            levelCommision($user->id, $plan->price, $commissionType = 'Your Refer has chosen a plan and you got Commission');
        }
        notify($user, 'BUY_PLAN', [
            'plan_name' => $plan->name,
            'amount' => getAmount($plan->price),
            'currency' => $gnl->cur_text,
            'trx' => $trx,
            'post_balance' => $user->balance + 0
        ]);

        $userNotifications = new UserNotification();
        $userNotifications->title = 'You have Chosen to the plan';
        $userNotifications->user_id = $user->id;
        $userNotifications->click_url = urlPath('user.plans');
        $userNotifications->save();

        $notify[] = ['success', 'You have Chosen to the plan successfully'];
        return back()->withNotify($notify);
    }



    public function develop()
    {
        $page_title = "develop";
        return view(activeTemplate() . 'user.develop', compact('page_title'));
    }

    public function Guide()
    {
        $page_title = "Guide";
        return view(activeTemplate() . 'user.Guide', compact('page_title'));
    }

    public function notice()
    {
        $page_title = "notice";
        return view(activeTemplate() . 'user.notice', compact('page_title'));
    }

    public function commissions()
    {
        $page_title = "Commissions";
        $commissions = CommissionLog::where('user_id', auth()->user()->id)->with('userFrom')->paginate(getPaginate());
        return view(activeTemplate() . 'user.commissions', compact('page_title', 'commissions'));
    }

    public function referredUsers()
    {
        $page_title = "Referred Users";
        $refUsers = User::where('ref_by', auth()->user()->id)->with('plan')->paginate(getPaginate());
        $levels = Referral::get();
        $user = auth()->user();
        return view(activeTemplate() . 'user.referred', compact('page_title', 'refUsers', 'levels', 'user'));
    }

    public function notifications(){
        $notifications = UserNotification::where('user_id', auth()->user()->id)->paginate(getPaginate());
        $page_title = 'Notifications';
        return view(activeTemplate() .'user.notifications',compact('page_title','notifications'));
    }


    public function notificationRead($id){
        $notification = UserNotification::where('user_id', auth()->user()->id)->first();;
        $notification->read_status = 1;
        $notification->save();
        return redirect($notification->click_url);
    }


    public function readAll(){
        UserNotification::where('user_id', auth()->user()->id)->where('read_status',0)->update([
            'read_status'=>1
        ]);
        $notify[] = ['success','Notifications read successfully'];
        return back()->withNotify($notify);
    }

    public function bonus()
    {
        $user = auth()->user();
        $now = Carbon::now()->format('d-m-Y, h:i:s A');
        $diff = auth()->user()->created_at->format('d-m-Y, h:i:s A');



        $newDateTime = auth()->user()->created_at->addDays(30)->format('d-m-Y, h:i:s A');

        $need = auth()->user()->created_at->diffForHumans();

        $withdraw = auth()->user()->created_at->addDays(30)->diffForHumans();

        $page_title = 'Withdrawl Bonus';
        return view($this->activeTemplate . 'user.withdraw.bonus', compact('user', 'now', 'need', 'withdraw', 'newDateTime', 'diff', 'page_title'));
    }
}
