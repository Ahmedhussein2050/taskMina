<?php

namespace App\Modules\Admin\Controllers;

use App\Bll\Lang;
use App\Bll\Utility;
use App\Http\Controllers\Controller;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Permission;

class AdminLoginController extends Controller
{
    public function __construct()
    {
//		$this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
    }
    public function login()
    {
        $settings = Setting::
        Join('settings_data', 'settings.id', 'settings_data.setting_id')
            ->select(
                'settings_data.id as id',
                'settings_data.title as title',
                'settings.id as setting_id',
                'settings_data.lang_id as lang_id',
                'settings.logo as logo',
                'settings.facebook_url as facebook_url',
                'settings.twitter_url as twitter_url',
                'settings.instagram_url as instagram_url')
            ->where('settings_data.lang_id', Lang::getSelectedLangId())->first();

        return view('admin.login', ['settings' => $settings]);
    }

    public function doLogin(Request $request)
    {

        $this->validate($request, [
            'email' => 'required|email|exists:users',
            'password' => 'required|min:6',
        ]);
        $remember_me = request('remember_me') == 1 ? true : false;

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
            return redirect()->to(route('admin.home'));
        }else {
            return redirect(route('admin.login'))
                ->withInput($request->only('email', 'remember'))
                ->withErrors([_i('Data Error !')]);
        }

    }

    public function logout() {
        auth()->logout();
        return redirect('/admin/login');
    }
}
