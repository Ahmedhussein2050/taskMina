<?php

namespace App\Modules\Admin\Controllers\Settings;

use App\Bll\Lang;
use App\DefaultImage;
use App\Http\Controllers\Controller;
use App\ImageAccount;
use App\Models\Language;
use App\Modules\Admin\Models\Products\Category;
use App\Modules\Admin\Models\Settings\City;
use App\Setting;
use App\SettingData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;

class SettingsController extends Controller
{
    protected function index()
    {
        return view('admin.settings.index');
    }

    protected function getlang(Request $request)
    {
        $lang = Language::where('id',$request->lang_id)->first();
        if ($lang){
            return Response::json($lang->title);
        }
    }

    protected function get_settings()
    {
        $site_settings = Setting::leftJoin('settings_data', 'settings.id', '=', 'settings_data.setting_id')
            ->select('settings.*', 'settings_data.title as title', 'settings_data.description as description', 'settings_data.lang_id as lang_id')
            ->where('settings_data.lang_id', 1)

            ->first();
        $categories = Category::select('categories.*', 'title')
            ->join('categories_data', 'categories.id', 'categories_data.category_id')
            ->where('lang_id', Lang::getSelectedLangId())

            ->orderBy('number', 'asc')
            ->get();
        $languages = Language::all();
        $images = DefaultImage::first();

        $images->favicon = asset('/uploads/default_images/' .  $images->favicon);
        $images->header = asset('/uploads/default_images/' .  $images->header);
        $images->footer = asset('/uploads/default_images/' .  $images->footer);
        $images->not_found = asset('/uploads/default_images/' .  $images->not_found);

        $image_account = ImageAccount::first();
        if( empty( $image_account ) )
        {
            $image_account = ImageAccount::create([

            ]);
        }
        $image_account_id = $image_account->id;
        $image_account->image_account = asset('/uploads/image_accounts/' .  $image_account->image_account);

        return view('admin.settings.edit', compact('site_settings', 'categories', 'languages', 'images' ,'image_account' ,'image_account_id'));
    }

//    protected function saveDomain( Request $request )
//    {
//        $request->validate([
//            'full_domain' => ['required'],
//            'subdomain' => ['required'],
//        ]);
//
//        $store_id = Utility::getStoreId();
//        $store = Store::first();
//        if( $store->domain != $request->full_domain )
//        {
//            $store->update([
//                'domain' => $request->full_domain,
//                'domain_changed_at' => Carbon::now()
//            ]);
//        }
//        $store->update([
//            'domain_status' => 0,
//            // 'subdomain' => $request->subdomain,
//        ]);
//
//        return response()->json('success');
//    }

//    protected function check()
//    {
//        $resonse = \App\Bll\Domain::CheckDomain(request()->input("domain"));
//        return response()->json($resonse);
//    }

    protected function updateSettings(Request $request)
    {
        $settings = Setting::first();
        if ($settings != null) {
            $settings->email = $request->email;
            $settings->phone1 = $request->phone1;
            $settings->phone2 = $request->phone2;
            $settings->facebook_url = $request->facebook_url;
            $settings->instagram_url = $request->instagram_url;
            $settings->twitter_url = $request->twitter_url;
            $settings->youtube_url = $request->youtube_url;
            $settings->mail_url = $request->mail_url;
            $settings->snapchat_url = $request->snapchat_url;
            $settings->work_time = $request->work_time;
            //$settings->address = $request->address;
            $settings->chat_mode = $request->chat_mode ?? 0;
            $settings->captcha_enabled = $request->captcha ?? 0;
            $settings->terms_page = $request->terms;


            $settings->chat_code = $request->chat_code ;
            $settings->myfatoorah_type = $request->myfatoorah_type ? 'sandbox' : 'live';
            $settings->myfatoorah_token = $request->myfatoorah_token ;
            $settings->customer_count = $request->customer_count ;
            $settings->projects_count = $request->projects_count ;
            $settings->save();
            Cache::forget('setting');

        }else{
            $settings = Setting::create([
                'email' => $request->email,
                'phone1' => $request->phone1,
                'phone2' => $request->phone2,
                'facebook_url' => $request->facebook_url,
                'instagram_url' => $request->instagram_url,
                'twitter_url' => $request->twitter_url,
                'youtube_url' => $request->youtube_url,
                'mail_url' => $request->mail_url,
                'snapchat_url' => $request->snapchat_url,
                'work_time' => $request->work_time,
                'chat_mode' => $request->chat_mode ?? 0,
                'chat_code' => $request->chat_code,
                'myfatoorah_token' => $request->myfatoorah_token,
                'customer_count' => $request->customer_count,
                'projects_count' => $request->projects_count,
            ]);
        }
        if ($request->has('logo')) {
            $image = $request->file('logo');

            if ($image && $file = $image->isValid()) {
                $request->validate([
                    'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                ]);

                $destinationPath = public_path('uploads/settings/site_settings');
                $fileName = $image->getClientOriginalName();
                $image->move($destinationPath, $fileName);
                $request->logo = $fileName;

                if (!empty($settings->logo)) {
                    $file = public_path('uploads/settings/site_settings/') . $settings->logo;
                    @unlink($file);
                }
            }
            $settings->logo = $request->logo;
        }
        return redirect()->back()->with('flash_message', _i('Updated Successfully !'));
    }

    protected function getSettingsTranslation(Request $request)
    {
        $rowData = SettingData::where('lang_id', $request->lang_id)
            ->first(['title','description', 'keywords', 'footer_description', 'working_hours']);
        if (!empty($rowData)){
            return Response::json(['data' => $rowData]);
        }else{
            return Response::json(['data' => false]);
        }
    }

    protected function updateSettingsTranslation(Request $request)
    {
        $rowData = SettingData::where('lang_id', $request->lang_id)
            ->first();
        if ($rowData != null) {
            $rowData->update([
                'title' => $request->title,
                'description' => $request->input('description'),
                'keywords' => $request->input('keywords'),
                'footer_description' => $request->input('footer_description'),
                'working_hours' => $request->input('working_hours'),
            ]);
            Cache::forget('setting');
        }else{
            TypeData::create([

                'title' => $request->title,
                'description' => $request->input('description'),
                'keywords' => $request->input('keywords'),
                'footer_description' => $request->input('footer_description'),
                'working_hours' => $request->input('working_hours'),
                'lang_id' => $request->lang_id,
            ]);
        }
        return \response()->json("SUCCESS");
    }
}
