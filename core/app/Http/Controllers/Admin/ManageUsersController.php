<?php
namespace App\Http\Controllers\Admin;

use App\CommissionLog;
use App\Deposit;
use App\GeneralSetting;
use App\Http\Controllers\Controller;
use App\Models\Survey\UserMicroJob;
use App\ComplatedSurvey;
use App\SupportTicket;
use App\Transaction;
use App\User;
use App\Post;
use App\UserLogin;
use App\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class ManageUsersController extends Controller
{
    public function allUsers()
    {

        $page_title = 'Manage Users';
        $empty_message = 'No user found';
        $users = User::latest()->paginate(getPaginate());
        return view('admin.users.list', compact('page_title', 'empty_message', 'users'));
    }

    public function activeUsers()
    {
        $page_title = 'Manage Active Users';
        $empty_message = 'No active user found';
        $users = User::active()->latest()->paginate(getPaginate());
        return view('admin.users.list', compact('page_title', 'empty_message', 'users'));
    }

    public function bannedUsers()
    {
        $page_title = 'Banned Users';
        $empty_message = 'No banned user found';
        $users = User::banned()->latest()->paginate(getPaginate());
        return view('admin.users.list', compact('page_title', 'empty_message', 'users'));
    }

    public function emailUnverifiedUsers()
    {
        $page_title = 'Email Unverified Users';
        $empty_message = 'No email unverified user found';
        $users = User::emailUnverified()->latest()->paginate(getPaginate());
        return view('admin.users.list', compact('page_title', 'empty_message', 'users'));
    }
    public function emailVerifiedUsers()
    {
        $page_title = 'Email Verified Users';
        $empty_message = 'No email verified user found';
        $users = User::emailVerified()->latest()->paginate(getPaginate());
        return view('admin.users.list', compact('page_title', 'empty_message', 'users'));
    }


    public function smsUnverifiedUsers()
    {
        $page_title = 'SMS Unverified Users';
        $empty_message = 'No sms unverified user found';
        $users = User::smsUnverified()->latest()->paginate(getPaginate());
        return view('admin.users.list', compact('page_title', 'empty_message', 'users'));
    }
    public function smsVerifiedUsers()
    {
        $page_title = 'SMS Verified Users';
        $empty_message = 'No sms verified user found';
        $users = User::smsVerified()->latest()->paginate(getPaginate());
        return view('admin.users.list', compact('page_title', 'empty_message', 'users'));
    }



    public function search(Request $request, $scope)
    {
        $search = $request->search;
        $users = User::where(function ($user) use ($search) {
            $user->where('username', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('mobile', 'like', "%$search%")
                ->orWhere('firstname', 'like', "%$search%")
                ->orWhere('lastname', 'like', "%$search%");
        });
        $page_title = '';
        switch ($scope) {
            case 'active':
                $page_title .= 'Active ';
                $users = $users->where('status', 1);
                break;
            case 'banned':
                $page_title .= 'Banned';
                $users = $users->where('status', 0);
                break;
            case 'emailUnverified':
                $page_title .= 'Email Unerified ';
                $users = $users->where('ev', 0);
                break;
            case 'smsUnverified':
                $page_title .= 'SMS Unverified ';
                $users = $users->where('sv', 0);
                break;
        }
        $users = $users->paginate(getPaginate());
        $page_title .= 'User Search - ' . $search;
        $empty_message = 'No search result found';
        return view('admin.users.list', compact('page_title', 'search', 'scope', 'empty_message', 'users'));
    }


    public function detail($id)
    {
//        dd($id);
        $jobs = UserMicroJob::where('user_id',$id)
            ->where('is_pending','1')
            ->count();
        $reject =DB::table('user_microjobs')
            ->where('user_id',$id)
            ->where('deleted_at','!=',null)
            ->where('is_pending','0')
//            ->select('deleted_at')
                ->count();
//            ->get();
//        dd($reject);
        $page_title = 'User Detail';
        $user = User::findOrFail($id);
        $totalDeposit = Deposit::where('user_id',$user->id)->where('status',1)->sum('amount');
        $totalWithdraw = Withdrawal::where('user_id',$user->id)->where('status',1)->sum('amount');
        $totalTransaction = Transaction::where('user_id',$user->id)->count();
        $reff = User::where('id',$user->ref_by)->first();
        $totalReferral = User::where('ref_by',$user->id)->count();
        $userSurvey = ComplatedSurvey::whereUserId($id)->distinct('survey_id')->count('survey_id');
        return view('admin.users.detail', compact('page_title', 'user','reject','totalDeposit','totalWithdraw','totalTransaction','reff','totalReferral','jobs','userSurvey'));
    }



    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
        ]);
        $user->mobile = $request->mobile;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->address = [
                            'address' => $request->address,
                            'city' => $request->city,
                            'state' => $request->state,
                            'zip' => $request->zip,
                            'country' => $request->country,
                        ];
        $user->status = $request->status ? 1 : 0;
        $user->ev = $request->ev ? 1 : 0;
        $user->sv = $request->sv ? 1 : 0;
        $user->ts = $request->ts ? 1 : 0;
        $user->tv = $request->tv ? 1 : 0;
        $user->save();

        $notify[] = ['success', 'User detail has been updated'];
        return redirect()->back()->withNotify($notify);
    }

    public function addSubBalance(Request $request, $id)
    {
        $request->validate(['amount' => 'required|numeric|gt:0']);

        $user = User::findOrFail($id);
        $amount = getAmount($request->amount);
        $general = GeneralSetting::first(['cur_text','cur_sym']);
        $trx = getTrx();

        if ($request->act) {
            $user->balance = bcadd($user->balance, $amount);
            $user->save();
            $notify[] = ['success', $general->cur_sym . $amount . ' has been added to ' . $user->username . ' balance'];


            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->amount = $amount;
            $transaction->post_balance = getAmount($user->balance);
            $transaction->charge = 0;
            $transaction->trx_type = '+';
            $transaction->details = 'Added Balance By Manager';
            $transaction->trx =  $trx;
            $transaction->save();


            notify($user, 'BAL_ADD', [
                'trx' => $trx,
                'amount' => $amount,
                'currency' => $general->cur_text,
                'post_balance' => getAmount($user->balance),
            ]);

        } else {
            if ($amount > $user->balance) {
                $notify[] = ['error', $user->username . ' has insufficient balance.'];
                return back()->withNotify($notify);
            }
            $user->balance = bcsub($user->balance, $amount);
            $user->save();



            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->amount = $amount;
            $transaction->post_balance = getAmount($user->balance);
            $transaction->charge = 0;
            $transaction->trx_type = '-';
            $transaction->details = 'Subtract Your Main Balance By Manager';
            $transaction->trx =  $trx;
            $transaction->save();


            notify($user, 'BAL_SUB', [
                'trx' => $trx,
                'amount' => $amount,
                'currency' => $general->cur_text,
                'post_balance' => getAmount($user->balance)
            ]);
            $notify[] = ['success', $general->cur_sym . $amount . ' has been subtracted from ' . $user->username . ' balance'];
        }
        return back()->withNotify($notify);
    }

    public function loginHistory(Request $request)
    {

        if ($request->search) {
            $search = $request->search;
            $page_title = 'User Login History Search - ' . $search;
            $empty_message = 'No search result found.';
            $login_logs = UserLogin::whereHas('user', function ($query) use ($search) {
                $query->where('username', $search);
            })->latest()->paginate(getPaginate());
            return view('admin.users.logins', compact('page_title', 'empty_message', 'search', 'login_logs'));
        }
        $page_title = 'User Login History';
        $empty_message = 'No users login found.';
        $login_logs = UserLogin::latest()->paginate(getPaginate());
        return view('admin.users.logins', compact('page_title', 'empty_message', 'login_logs'));
    }

    public function userLoginHistory($id)
    {
        $user = User::findOrFail($id);
        $page_title = 'User Login History - ' . $user->username;
        $empty_message = 'No users login found.';
        $login_logs = $user->login_logs()->latest()->paginate(getPaginate());
        return view('admin.users.logins', compact('page_title', 'empty_message', 'login_logs'));
    }

    public function loginIpHistory($ip)
    {
        $page_title = 'Login By - ' . $ip;
        $login_logs = UserLogin::where('user_ip',$ip)->latest()->paginate(getPaginate());
        $empty_message = 'No users login found.';
        return view('admin.users.logins', compact('page_title', 'empty_message', 'login_logs'));

    }


    public function showEmailSingleForm($id)
    {
        $user = User::findOrFail($id);
        $page_title = 'Send Email To: ' . $user->username;
        return view('admin.users.email_single', compact('page_title', 'user'));
    }

    public function sendEmailSingle(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:65000',
            'subject' => 'required|string|max:190',
        ]);

        $user = User::findOrFail($id);
        send_general_email($user->email, $request->subject, $request->message, $user->username);
        $notify[] = ['success', $user->username . ' will receive an email shortly.'];
        return back()->withNotify($notify);
    }

    public function transactions(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($request->search) {
            $search = $request->search;
            $page_title = 'Search User Transactions : ' . $user->username;
            $transactions = $user->transactions()->where('trx', $search)->with('user')->latest()->paginate(getPaginate());
            $empty_message = 'No transactions';
            return view('admin.reports.transactions', compact('page_title', 'search', 'user', 'transactions', 'empty_message'));
        }
        $page_title = 'User Transactions : ' . $user->username;
        $transactions = $user->transactions()->with('user')->latest()->paginate(getPaginate());
        $empty_message = 'No transactions';
        return view('admin.reports.transactions', compact('page_title', 'user', 'transactions', 'empty_message'));
    }

    public function deposits(Request $request, $id)
    {
        $user = User::findOrFail($id);
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

    public function withdrawals(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($request->search) {
            $search = $request->search;
            $page_title = 'Search User Withdrawals : ' . $user->username;
            $withdrawals = $user->withdrawals()->where('trx', 'like',"%$search%")->latest()->paginate(getPaginate());
            $empty_message = 'No withdrawals';
            return view('admin.withdraw.withdrawals', compact('page_title', 'user', 'search', 'withdrawals', 'empty_message'));
        }
        $page_title = 'User Withdrawals : ' . $user->username;
        $withdrawals = $user->withdrawals()->latest()->paginate(getPaginate());
        $empty_message = 'No withdrawals';
        return view('admin.withdraw.withdrawals', compact('page_title', 'user', 'withdrawals', 'empty_message'));
    }

    public function showEmailAllForm()
    {
        $page_title = 'Send Email To All Users';
        return view('admin.users.email_all', compact('page_title'));
    }

    public function sendEmailAll(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:65000',
            'subject' => 'required|string|max:190',
        ]);

        foreach (User::where('status', 1)->cursor() as $user) {
            send_general_email($user->email, $request->subject, $request->message, $user->username);
        }

        $notify[] = ['success', 'All users will receive an email shortly.'];
        return back()->withNotify($notify);
    }

    public function totalReferral($id)
    {
        $users = User::where('ref_by',$id)->latest()->paginate(getPaginate());
        $me = User::find($id);
        $page_title = 'Referrals Of - ' . $me->username;
        $empty_message = 'No Referrals found.';
        return view('admin.users.referrals', compact('page_title', 'empty_message', 'users'));
    }


    public function commissions($id)
    {
        $commissionLog = CommissionLog::where('user_id',$id)->latest()->paginate(getPaginate());
        $me = User::find($id);
        $page_title = 'Commissions Of - ' . $me->username;
        $empty_message = 'No Commissions found.';
        return view('admin.users.commissions', compact('page_title', 'empty_message', 'commissionLog'));
    }
    public function jobShow($id){
        $resultShow = DB::table('user_microjobs')->where('user_id','=', $id)
            ->where('is_pending','!=',0)
            ->join('users','users.id','=','user_microjobs.user_id')
            ->join('microjobs','microjobs.id','=','user_microjobs.microjob_id')
            ->select('users.username','user_microjobs.id','user_microjobs.is_pending','microjobs.title','microjobs.amount','microjobs.time')
            ->get();
        return view('admin.userjob.index', [
            'result' => $resultShow,
            'page_title' => 'Complete Microjobs',
        ]);
    }
    public function rejected($id){
        $resultShow = DB::table('user_microjobs')->where('user_id','=', $id)
            ->where('is_pending','=',0)
//            ->where('deleted_at','!=',null)
            ->join('users','users.id','=','user_microjobs.user_id')
            ->join('microjobs','microjobs.id','=','user_microjobs.microjob_id')
            ->select('users.username','user_microjobs.id','user_microjobs.deleted_at','user_microjobs.is_pending','microjobs.title','microjobs.amount','microjobs.time')
            ->get();
        return view('admin.userjob.rejected', [
            'result' => $resultShow,
            'page_title' => 'Complete Microjobs',
        ]);

    }

    public function SurveyHistory($id){

        // return "hello";
        $page_title = "Survey History";
        $surveys = ComplatedSurvey::whereUserId($id)
            ->groupBy(['completed_surveys.survey_id','completed_surveys.user_id'])
        ->latest()->paginate(50);
        return view('admin.userjob.survey_history', compact('page_title', 'surveys'));
    }


    public function posts($id){
        $user = User::findOrFail($id);
        $pageTitle = 'All Posts of '.$user->fullname;

        $posts = Post::where('status', '!=', 3)
                     ->where('user_id', $user->id)
                     ->latest()
                     ->with('user')
                     ->whereHas('subCategory', function($subCat){
                        $subCat->where('status', 1)->whereHas('category', function($cat){
                            $cat->where('status', 1)->whereHas('forum', function($forum){
                                $forum->where('status', 1);
                            });
                        });
                    })
                     ->paginate(getPaginate());

        return view('admin.post.index', compact('pageTitle', 'posts'));
    }

    public function tickets($id){
        $user = User::findOrFail($id);
        $pageTitle = 'Support Tickets of '.$user->username;
        $emptyMessage = 'No Data found.';
        $items = SupportTicket::where('user_id', $user->id)->with('user')->paginate(getPaginate());
        return view('admin.support.tickets', compact('items', 'pageTitle','emptyMessage'));
    }
  
  
   public function login($id){
        $user = User::findOrFail($id);
        Auth::login($user);
        return redirect()->route('user.home');
    }

}
