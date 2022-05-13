<?php

namespace App\Modules\portal\Controllers;

use App\Bll\Utility;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use App\Mail\CustomerForgotPass;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Mail\CustomerPassReseted;
use App\Models\Language;
use App\Models\User;
use App\Modules\Admin\Models\Products\Country;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Laravel\Socialite\Facades\Socialite;
use Mail;

class AuthController extends Controller
{

    public function showRegisterForm()
    {

        if (auth()->id() != null)
            return redirect("/");

        $countries = Country::with('data')->get();
        return view('portal.user.register', compact('countries'));
    }


    public function register(Request $request)
    {


        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->where(function ($query) {
                return $query;
            })],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'gender' => ['required'],
            'phone' => ['numeric', 'nullable']
        ];

        // // if ($settings->captcha_enabled == 1) {
        // // 	//			$rules['g-recaptcha-response']= 'required|captcha';
        // // }
        $request->validate($rules);
        //dd($request->all());
        $phone = $request->phone ?? null;

        if ($phone !== null) {
            $phone = $request->country . $phone;
        }

        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->lastname,
            'code' => $request->country,
            'phone' => $phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
            'guard' => 'web'
        ]);


        $user->assignRole('web');
        session()->put('just_logged_in', 'true');
        $names = [];
        $text = [];
        foreach (Language::get() as $lang) {
            if ($lang->code == 'ar') {
                $names['ar'] = _i('client added successfuly');
                $text['ar'] = _i('new client has been register');
            }
            if ($lang->code = 'en') {
                $names['en'] = _i('client added successfuly');
                $text['en'] = _i('new client has been register');
            }
        }
        $userData = [
            'name' => $names,
            'text' =>  $text,
            'url' => url('admin/customers/' . $user->id . '/orders'),
            'user_id' => $user->id,

        ];

        Notification::send(User::first(), new \App\Notifications\ClientRegister($userData));

        $remember_me = request('remember_me') == 1 ? true : false;

        if (auth()->guard("web")->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ], $remember_me)) {
            session()->put('just_logged_in', 'true');
            return response()->json('success');
        } else {
            return response()->json(['error' => 'Incorrect Password']);
        }
    }

    public function activate(Request $request, $lang, $token)
    {
        $user = UserVerifyEmail::where([
            'token' => $token,

        ])->first();

        if (empty($user)) return abort(404);

        $user = User::find($user->user_id);
        if (empty($user)) return abort(404);

        $user->update([
            'is_active' => 1,
            'email_verified_at' => Carbon::now()
        ]);

        Auth::guard()->login($user);

        if (!empty(env('TEST_EMAIL'))) {
            \App\Bll\Mail::send(env('TEST_EMAIL'), new CustomerVerifyEmail($user, $request));
        }

        \App\Bll\Mail::send($user->email, new CustomerVerifyEmail($user, $request));

        return redirect()->route('home')->with('success', _i('Your account has been activated successfully !'));
    }

    public function generateToken(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        $user_token = UserVerifyEmail::where('email', $request->email)->first();
        if ($user_token != null) {
            $token = generate_random_string(32);
            UserVerifyEmail::where('email', $request->email)->update([
                'token' => $token
            ]);
            if (!empty(env('TEST_EMAIL'))) {
                \App\Bll\Mail::send(env('TEST_EMAIL'), new CustomerWelcome($user, $request, $token));
            }

            \App\Bll\Mail::send($user->email, new CustomerWelcome($user, $request, $token));
        } else {
            $token = generate_random_string(32);
            UserVerifyEmail::create([
                'user_id' => $user->id,
                'email' => $request->email,
                'token' => $token,
            ]);
            if (!empty(env('TEST_EMAIL'))) {
                \App\Bll\Mail::send(env('TEST_EMAIL'), new CustomerWelcome($user, $request, $token));
            }
            \App\Bll\Mail::send($user->email, new CustomerWelcome($user, $request, $token));
        }
        return response()->json(['success' => _i('Check your Email')]);
    }

    public function showLoginForm()
    {
        if (auth()->id() != null)
            return     redirect("/");
        return view('portal.user.login');
    }

    public function login(Request $request)
    {

        $this->validate($request, [
            'email' => 'required|email|exists:users',
            'password' => 'required|min:6',
        ]);

        $settings = Utility::get_settings();

        if ($settings->captcha_enabled == 1) {
            $request->validate([
                'g-recaptcha-response' => 'required|captcha',

            ]);
        }
        $user = User::where('email', $request->email)->where("guard", "web")->first();
        if ($user == null) {
            return response()->json(['error' => _i('Email is not found')]);
        }
        // if ($user->email_verified_at == null) {
        //     return response()->json(['activate' => _i('Email is not verified')]);
        // }

        $remember_me = request('remember_me') == 1 ? true : false;
        if ($user->status == 0) {
            if (auth()->guard("web")->attempt([
                'email' => $request->email,
                'password' => $request->password,
            ], $remember_me)) {
                session()->put('just_logged_in', 'true');
                return response()->json('success');
            } else {
                return response()->json(['error' => 'Incorrect Password']);
            }
        } else {
            return response()->json(['error' => _i('This Account has been blocked, check our policies')]);
        }


        return response()->json('success');
    }

    public function showForgotForm()
    {
        if (auth()->id() != null)
            return     redirect("/");
        return view('portal.user.forgot');
    }

    public function forgot(Request $request)
    {
        $user = User::where(['email' =>  $request->email])->first();

        if ($user) {
            $token = str_random(60);
            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);

            \App\Bll\Mail::send($user->email, new CustomerForgotPass($user->id, $token));
            // Mail::send('portal.user.forgot', ['token' => $token], function($message) use($request){
            //     $message->to($request->email);
            //     $message->subject('Reset Password');
            // });

            return response()->json('success');
        }

        return response()->json('error');
    }

    public function showResetForm($lang, $token)
    {

        $check_token = \DB::table('password_resets')->where('token', $token)->first();
        if ($check_token) {
            $email = $check_token->email;
            return view('portal.user.reset_form', compact('token', 'email'));
        } else {
            abort(404);
        }

        // return view('web.'.get_default_template().'.'.'reset_form', compact('error'));
    }

    public function resetPassword(Request $request)
    {
        $this->validate($request, [
            'token'    => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password'
        ]);

        $check_token_and_email = DB::table('password_resets')->where(['email' => $request->email, 'token' => $request->token])->first();

        if ($check_token_and_email) {
            $user = User::where(['email' => $request->email])->first();
            $user->update([
                'password' => bcrypt($request->password)
            ]);
            DB::table('password_resets')->where(['email' => $request->email, 'token' => $request->token])->delete();
            // $m = new MailChimp();
            // $m->AddTo($user->email, $user->email);
            // $m->send("", new CustomerPassReseted($user->id));
            \App\Bll\Mail::send($user->email, new CustomerPassReseted($user->id));
            return response()->json('success');
        }
        return response()->json('error');
    }

    public function logout(Request $request)
    {
        // dd(auth()->user());
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('home'));
    }


    public function edit_my_profile(Request $request)
    {
        $this->validate($request, [
            'name'    => 'required',
            'phone' => 'required',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->where(function ($query) use ($request) {
                return $query->where('id', '!=', $request->id);
            })],
            'password' => 'nullable',
        ]);

        if ($request->password) {
            $this->validate($request, ['re-password' => 'required|same:password']);
            $password = bcrypt($request->password);
        } else {
            $password = User::find($request->id)['password'];
        }

        User::where('id', $request->id)->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => $password
        ]);

        return back();
    }



    public function authRedirect()
    {
        return  Socialite::driver('google')->redirect();
    }


    public function authCallback()
    {
        $google_user = Socialite::driver('google')->user();

        $userr = User::where('email', $google_user->getEmail())->first();
        if (isset($userr) || $userr != null) {
            if ($userr->status == 0) {

                if (($userr->email == $google_user->getEmail()) && ($userr->social_id == $google_user->getId())) {

                    Auth::login($userr);

                    return redirect(route('home'));
                } else {
                    $userr->social_id = $google_user->getId();
                    $userr->save();
                    Auth::login($userr);
                    return redirect(route('home'));
                }
            } else {
                return response()->json(["error" => 'This account is blocked, check for our services and policies.']);
            }
        } else {

            $login = User::create([
                'name' => $google_user->getName(),
                'lastname' => $google_user->getNickname(),
                'email' => $google_user->getEmail(),
                'social_token' => $google_user->token,
                'social_id' => $google_user->getId(),
                'social_type' => 'google',
                'guard'       => 'web'

            ]);

            Auth::login($login);
        }



        return redirect(route('home'));
    }
}
