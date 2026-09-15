<?php

namespace App\Http\Controllers\Auth;

use App\GeneralSetting;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Models\UserNotification;
use App\UserLogin;
use App\Transaction;

use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('regStatus')->except('registrationNotAllowed');

        $this->activeTemplate = activeTemplate();
    }

    public function referralRegister($reference)
    {
        $page_title = "Sign Up";
        session()->put('reference', $reference);
        return view($this->activeTemplate . 'user.auth.register', compact('reference', 'page_title'));
    }

    public function showRegistrationForm()
    {
        $page_title = "Sign Up";
        $reference = null;
        return view($this->activeTemplate . 'user.auth.register', compact('page_title','reference'));
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $validate = Validator::make($data, [
            'firstname' => 'sometimes|required|string|max:20',
            'lastname' => 'sometimes|required|string|max:20',
            'email' => 'required|string|email|max:160|unique:users',
            'mobile' => 'required|string|max:13|unique:users',
            'password' => 'required|string|min:2|confirmed',
            'username' => 'required|alpha_num|unique:users|min:2',
        ]);

        return $validate;
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();


        if (isset($request->captcha)) {
            if (!captchaVerify($request->captcha, $request->captcha_secret)) {
                $notify[] = ['error', "Invalid Captcha"];
                return back()->withNotify($notify)->withInput();
            }
        }

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $gnl = GeneralSetting::first();


        $referBy = session()->get('reference');
        if ($referBy != null) {
            $referUser = User::where('username', $referBy)->first();
            $amt = '10';
            $referUser->bonus = $referUser->bonus + $amt;
            $referUser->save();

            $transaction = new Transaction();
            $transaction->user_id = $referUser->id;
            $transaction->amount = $amt;
            $transaction->post_balance = getAmount($referUser->bonus);
            $transaction->charge = 0;
            $transaction->trx_type = '+';
            $transaction->details = 'Got From Your Refer Register Bonus';
            $transaction->trx =  getTrx();
            $transaction->save();
            $bonus = 50;
        } else {
            $referUser = null;
            $bonus = 10;
        }


        $user = new User();
        $user->firstname = isset($data['firstname']) ? $data['firstname'] : null;
        $user->lastname = isset($data['lastname']) ? $data['lastname'] : null;
        $user->email = strtolower(trim($data['email']));
        $user->password = Hash::make($data['password']);
        $user->username = trim($data['username']);
        $user->name = null;
        $user->l0 = 0;
        $user->ref_by = ($referUser != null) ? $referUser->id : null;
        $user->bonus = $bonus;
        $user->designation = "Registered Member";
        $user->mobile = $data['mobile'];
        $user->address = [
            'address' => '',
            'state' => '',
            'zip' => '',
            'country' => isset($data['country']) ? $data['country'] : null,
            'city' => ''
        ];
        $user->status = 1;
        $user->ev = $gnl->ev ? 0 : 1;
        $user->sv = $gnl->sv ? 0 : 1;
        $user->ts = 0;
        $user->tv = 1;
        $user->save();
      
        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount = $bonus;
        $transaction->post_balance = getAmount($user->bonus);
        $transaction->charge = 0;
        $transaction->trx_type = '+';
        $transaction->details = 'You Got Register Bonus';
        $transaction->trx =  getTrx();
        $transaction->save();


        $userNotifications = new UserNotification();
        $userNotifications->title = 'Welcome To Poll Earning';
        $userNotifications->user_id = $user->id;
        $userNotifications->click_url = urlPath('user.guide');
        $userNotifications->save();



        $info = json_decode(json_encode(getIpInfo()), true);
        $userLogin = new UserLogin();
        $userLogin->user_id = $user->id;
        $userLogin->user_ip = request()->ip();
        $userLogin->longitude = @implode(',', $info['long']);
        $userLogin->latitude = @implode(',', $info['lat']);
        $userLogin->location = @implode(',', $info['city']) . (" - " . @implode(',', $info['area']) . "- ") . @implode(',', $info['country']) . (" - " . @implode(',', $info['code']) . " ");
        $userLogin->country_code = @implode(',', $info['code']);
        $userLogin->browser = @$info['browser'];
        $userLogin->os = @$info['os_platform'];
        $userLogin->country = @implode(',', $info['country']);
        $userLogin->save();


        return $user;
    }

    public function registered()
    {


        return redirect()->route('user.home');
    }

}
