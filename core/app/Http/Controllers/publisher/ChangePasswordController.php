<?php

namespace App\Http\Controllers\Publisher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PublishUserChangePassword;
use App\PublisherUser;
use App\GeneralSetting;
use Mail; 

class ChangePasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        $page_title = "Forgot Password";
        return view('publisher.passwords.email', compact('page_title'));
    }

    public function sendResetLinkEmail(Request $request)
    {
        // $this->validateEmail($request);

        $user = PublisherUser::where('email', $request->email)->first();
        if (!$user) {
            $notify[] = ['error', 'Advertiser not found.'];
            return back()->withNotify($notify);
        }

        PublishUserChangePassword::where('email', $user->email)->delete();
        $code = verificationCode(6);
        PublishUserChangePassword::create([
            'email' => $user->email,
            'token' => $code,
            'created_at' => \Carbon\Carbon::now(),
        ]);

        $userAgent = getIpInfo();
        Mail::send('publisher.email.password', ['code' => $code,'operating_system' => @$userAgent['os_platform'],'browser' => @$userAgent['browser'],'ip' => @$userAgent['ip'],'time' => @$userAgent['time']], function($message) use($request){
            $message->to($request->email);
            $message->subject('Password Reset');
        });

        $page_title = 'Account Recovery';
        $email = $user->email;
        $notify[] = ['success', 'Password reset email sent successfully'];
        return view('publisher.passwords.code_verify', compact('page_title', 'email'))->withNotify($notify);
    }

    public function verifyCode(Request $request)
    {
        $request->validate(['code.*' => 'required', 'email' => 'required']);
        $code =  str_replace(',','',implode(',',$request->code));

        if (PublishUserChangePassword::where('token', $code)->where('email', $request->email)->count() != 1) {
            $notify[] = ['error', 'Invalid token'];
            return redirect()->route('publisher_user.password.request')->withNotify($notify);
        }
        $notify[] = ['success', 'You can change your password.'];
        session()->flash('fpass_email', $request->email);
        return redirect()->route('publisher_user.password.reset', $code)->withNotify($notify);
    }

    public function showResetForm(Request $request, $token = null)
    {

        $email = session('fpass_email');
        $token = session()->has('token') ? session('token') : $token;
        if (PublishUserChangePassword::where('token', $token)->where('email', $email)->count() != 1) {
            $notify[] = ['error', 'Invalid token'];
            return redirect()->route('publisher_user.password.request')->withNotify($notify);
        }
        return view('publisher.passwords.reset')->with(
            ['token' => $token, 'email' => $email, 'page_title' => 'Reset Password']
        );
    }

    public function reset(Request $request)
    {
        // return $request;
        session()->put('fpass_email', $request->email);
        $request->validate($this->rules());
        $reset = PublishUserChangePassword::where('token', $request->token)->orderBy('created_at', 'desc')->first();
        if (!$reset) {
            $notify[] = ['error', 'Invalid Verification Code'];
            return redirect('publisher_user/publisher_user_login')->withNotify($notify);
        }

        $user = PublisherUser::where('email', $reset->email)->first();
        $user->password = bcrypt($request->password);
        $user->save();

        $general = GeneralSetting::first(['en', 'sn']);


        $userAgent = getIpInfo();
        Mail::send('publisher.email.confirm_password', ['operating_system' => @$userAgent['os_platform'],'browser' => @$userAgent['browser'],'ip' => @$userAgent['ip'],'time' => @$userAgent['time']], function($message) use($request){
            $message->to($request->email);
            $message->subject('Password Reset Confirmation');
        });


        $notify[] = ['success', 'Password Changed'];
        return redirect('publisher_user/publisher_user_login')->withNotify($notify);
    }

    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ];
    }
}
