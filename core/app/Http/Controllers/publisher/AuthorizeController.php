<?php

namespace App\Http\Controllers\Publisher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\GeneralSetting;
use App\Lib\GoogleAuthenticator;
use App\PublisherUser;
use Session;

class AuthorizeController extends Controller
{
    public function show2faForm()
    {
        $gnl = GeneralSetting::first();
        $ga = new GoogleAuthenticator();
        $user = PublisherUser::where('username',Session::get('PublisherUserLogin'))->first();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . $gnl->sitename, $secret);
        $prevcode = $user->tsc;
        $prevqr = $ga->getQRCodeGoogleUrl($user->username . '@' . $gnl->sitename, $prevcode);
        $page_title = 'Two Factor';
        return view('publisher.twofactor', compact('page_title', 'secret', 'qrCodeUrl', 'prevcode', 'prevqr','user'));
    }

    public function create2fa(Request $request)
    {
        $user = $user = PublisherUser::where('username',Session::get('PublisherUserLogin'))->first();
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

            Mail::send('publisher.email.enable2nf', ['operating_system' => @$userAgent['os_platform'],'browser' => @$userAgent['browser'],'ip' => @$userAgent['ip'],'time' => @$userAgent['time']], function($message) use($request){
                $message->to($request->email);
                $message->subject('Google Two Factor Authentication is now  Enabled for Your Account');
            });

            $notify[] = ['success', 'Google Authenticator Enabled Successfully'];
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

        $user = PublisherUser::where('username',Session::get('PublisherUserLogin'))->first();
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

            Mail::send('publisher.email.disnable2nf', ['operating_system' => @$userAgent['os_platform'],'browser' => @$userAgent['browser'],'ip' => @$userAgent['ip'],'time' => @$userAgent['time']], function($message) use($request){
                $message->to($request->email);
                $message->subject('Google Two Factor Authentication is now  Disable for Your Account');
            });
            

            $notify[] = ['success', 'Two Factor Authenticator Disable Successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong Verification Code'];
            return back()->with($notify);
        }
    }
}
