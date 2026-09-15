<?php

namespace App\Http\Controllers\publisher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PublisherUser;
use App\PtcView;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\PublishUserTaskTransection;
use Auth;
use App\Models\Survey\MicroJob;
use App\Models\Survey\Survey;
use App\Deposit;
use App\Transaction;
use App\Ptc;
use Session;
use App\Rules\FileTypeValidate;
use Image;
use Mail; 
use App\PublishUserVerify;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('PublisherUserLogin');
    // }

    protected function validator(array $data)
    {
        $validate = Validator::make($data, [
            'firstname' => 'sometimes|required|string|max:60',
            'lastname' => 'sometimes|required|string|max:60',
            'email' => 'required|string|email|max:160|unique:publisher_users',
            'mobile' => 'required|string|max:30|unique:publisher_users',
            'password' => 'required|string|min:6|confirmed',
            'username' => 'required|alpha_num|unique:publisher_users|min:6',
            'terms' => 'required',
            'captcha' => 'sometimes|required'
        ]);

        return $validate;
    }

    public function register(Request $request){
        // return 'hello';
        if($request->isMethod('post')){
            
            $this->validator($request->all())->validate();
            if (isset($request->captcha)) {
                if (!captchaVerify($request->captcha, $request->captcha_secret)) {
                    $notify[] = ['error', "Invalid Captcha"];
                    return back()->withNotify($notify)->withInput();
                }
            }

            // return $request;
            $pUser = new PublisherUser;
            $pUser->firstname = $request->firstname;
            $pUser->lastname = $request->lastname;
            $pUser->email = strtolower(trim($request->email));
            $pUser->mobile = $request->mobile;
            $pUser->username = trim($request->username);
            $pUser->password = Hash::make($request->password);
            $pUser->address = [
                'address' => '',
                'state' => '',
                'zip' => '',
                'country' => isset($data['country']) ? $data['country'] : null,
                'city' => ''
            ];
            $pUser->status = 1;
            $pUser->save();
            $token = verificationCode(6);
  
            PublishUserVerify::create([
                  'user_id' => $pUser->id, 
                  'token' => $token
            ]);
      
            Mail::send('publisher.email.email', ['token' => $token], function($message) use($request){
                $message->to($request->email);
                $message->subject('Email Verification Mail');
            });
            Session::Put('PublisherUserLogin',$request->username);
            $user = PublisherUser::where('username',Session::get('PublisherUserLogin'))->first();
            $page_title = 'Email verification form';
           
            return view('publisher.authorize', compact('user', 'page_title'));
            // return redirect()->route('publisher_user.dashboard');
        }

        $page_title = "Sign Up";
        $reference = null;
        return view('publisher.register')->with(compact('page_title','reference'));
    }

    public function EmailVerfiy(Request $request)
    {
        if($request->isMethod('post')){
            // return $request;
            $request->validate([
                'email_verified_code.*' => 'required',
            ], [
                'email_verified_code.required' => 'Email verification code is required',
            ]);


            //$email_verified_code =  str_replace(',','',implode(',',$request->email_verified_code));
            $email_verified_code =  $request->email_verified_code;


            $user = PublisherUser::where('username',Session::get('PublisherUserLogin'))->first();
            $verifyUser = PublishUserVerify::where('user_id', $user->id)->first();
            if($verifyUser->token == $email_verified_code){
                $user->email_verified_at = now();
                $user->save();
                return redirect()->intended(route('publisher_user.dashboard'));
            }
            $notify[] = ['error', "Verification code didn\'t match!"];
            return redirect()->route('publisher_user.email_verify')->withNotify($notify);     
        }
        $user = PublisherUser::where('username',Session::get('PublisherUserLogin'))->first();
        $page_title = 'Email verification form';
        return view('publisher.authorize', compact('user', 'page_title'));
          
    }

    public function sendVerifyCode(Request $request)
    {
        $user = PublisherUser::where('username',Session::get('PublisherUserLogin'))->first();
        $token = verificationCode(6);
        $verifyUser = PublishUserVerify::where('user_id', $user->id)->first();
        $verifyUser->token = $token;
        $verifyUser->save();
        Mail::send('publisher.email.email', ['token' => $token], function($message) use($user){
            $message->to($user->email);
            $message->subject('Email Verification Mail');
        });
        $notify[] = ['success', 'Email verification code sent successfully'];
        return redirect()->route('publisher_user.email_verify')->withNotify($notify);
    }

    public function dashboard(){
        $pUser = PublisherUser::where('username',Session::get('PublisherUserLogin'))->first();
        $page_title = 'Dashboard';
        $totalSurvey = Survey::where('publisher_user_id',$pUser->id)->count();
        $totalMicroJob = MicroJob::where('publisher_user_id',$pUser->id)->count();
        $totalPtc = Ptc::where('publisher_user_id',$pUser->id)->count();
        $PublishUserTaskTransection = PublishUserTaskTransection::where('publisher_user_id',$pUser->id)->count();
        $ptc = PtcView::where('user_id', $pUser->id)->get(['vdt', 'amount']);

        $chart['click'] = $ptc->groupBy('vdt')->map(function ($item, $key) {
            return collect($item)->count();
        })->sort()->reverse()->take(7)->toArray();

        $chart['amount'] = $ptc->groupBy('vdt')->map(function ($item, $key) {
            return collect($item)->sum('amount');
        })->sort()->reverse()->take(7)->toArray();
        $user = $pUser;
        return view('publisher.dashboard', compact('page_title', 'chart', 'user','totalSurvey','totalMicroJob','totalPtc','PublishUserTaskTransection'));
    }

    public function login(Request $request){
        if($request->isMethod('post')){
            $this->validateLogin($request);
            if (isset($request->captcha)) {
                if (!captchaVerify($request->captcha, $request->captcha_secret)) {
                    $notify[] = ['error', "Invalid Captcha"];
                    return back()->withNotify($notify)->withInput();
                }
            }
            // return$request;
            $pUser = PublisherUser::where(['username' => $request->username])->first();
            if ($pUser) {
                if(Hash::check($request->password, $pUser->password)){
                    Session::Put('PublisherUserLogin',$request->username);
                    return redirect()->route('publisher_user.dashboard');
                }else{
                    Session::forget('PublisherUserLogin');
                    return redirect('publisher_user/publisher_user_login')->withErrors(['Your account does not found.']);    
                }
            }else{
                Session::forget('PublisherUserLogin');
                return redirect('publisher_user/publisher_user_login')->withErrors(['Your account does not found.']);
            }
        }
        $page_title = "Sign In";
        return view('publisher.login', compact('page_title'));
    }

    public function username()
    {
        return 'username';
    }

    protected function validateLogin(Request $request)
    {
        $customRecaptcha = \App\Plugin::where('act', 'custom-captcha')->where('status', 1)->first();
        $validation_rule = [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ];
        if ($customRecaptcha) {
            $validation_rule['captcha'] = 'required';
        }
        $request->validate($validation_rule);
    }

    public function logout(Request $request){
        Session::forget('PublisherUserLogin');
        $notify[] = ['success', 'You have been logged out.'];
        return redirect('publisher_user/publisher_user_login')->withNotify($notify);
    }


    public function profile()
    {
        $data['page_title'] = "Profile Setting";
        $data['user'] = PublisherUser::where('username',Session::get('PublisherUserLogin'))->first();
        return view('publisher.profile', $data);
    }

    public function submitProfile(Request $request)
    {   
        $user = PublisherUser::where('username',Session::get('PublisherUserLogin'))->first();
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
        $notify[] = ['success', 'Profile Updated successfully.'];
        return back()->withNotify($notify);
    }

    public function transactions(){
        $page_title = 'Transactions';
        $user = PublisherUser::where('username',Session::get('PublisherUserLogin'))->first();
        $logs = PublishUserTaskTransection::where('publisher_user_id',$user->id)->orderBy('id', 'desc')->paginate(getPaginate());
        $empty_message = 'No transaction history';
        return view('publisher.transection', compact('page_title', 'logs', 'empty_message'));
    }

    public function changePassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'current_password' => 'required',
                'password' => 'required|min:5|confirmed'
            ]);
            try {
                $user = PublisherUser::where('username',Session::get('PublisherUserLogin'))->first();;
                if (Hash::check($request->current_password, $user->password)) {
                    $password = Hash::make($request->password);
                    $user->password = $password;
                    $user->save();
                    $notify[] = ['success', 'Password Changes successfully.'];
                    return back()->withNotify($notify);
                } else {
                    $notify[] = ['error', 'Current password not match.'];
                    return back()->withNotify($notify);
                }
            } catch (\PDOException $e) {
                $notify[] = ['error', $e->getMessage()];
                return back()->withNotify($notify);
            }
        }

        $data['page_title'] = "CHANGE PASSWORD";
        return view('publisher.password', $data);
    }

    public function Guide()
    {
        $page_title = "Advertiser Guide";
        return view('publisher.Guide', compact('page_title'));
    }
}
