<?php

namespace App\Modules\Admin\Controllers;

use App\Bll\Lang;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Contact;
use App\Models\User;
use App\Setting;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Xinax\LaravelGettext\Facades\LaravelGettext;

class DashboardController extends Controller
{

    public function changeLang($locale = null)
    {
        LaravelGettext::setLocale($locale);
        session()->put('locale', $locale);
        return (request()->header('referer')) ? redirect()->back() : redirect()->home();
    }
    public function index()
    {

        $settings = Setting::
        leftJoin('settings_data', 'settings.id', '<=', 'settings_data.id')
            ->select(
                'settings_data.id as id',
                'settings_data.title as title',
                'settings.id as setting_id',
                'settings_data.lang_id as lang_id',
                'settings.logo as logo',
                'settings.facebook_url as facebook_url',
                'settings.twitter_url as twitter_url',
                'settings.instagram_url as instagram_url')
            ->where('settings_data.lang_id', Lang::getLang(session('locale')))

            ->first();

        $users = User::query()->where('guard', 'web')->get()->count();
        $admins = Admin::query()->where('guard', 'admin')->get()->count();
        $contacts = Contact::all()->count();
        return view(
            'admin.dashboard',
            compact('users', 'admins', 'contacts', 'settings')
        );
    }
}
