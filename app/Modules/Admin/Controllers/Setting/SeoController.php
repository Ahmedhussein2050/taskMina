<?php

namespace App\Modules\Admin\Controllers\Setting;

use App\Bll\Utility;
use App\Http\Controllers\Controller;

use App\Modules\Admin\Models\Settings\Setting;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    public function StoreSeo()
    {
        return view('admin.settings.seo.index');
    }

    public function settingStore(Request $request)
    {
        $setting = Setting::findOrFail($request->item_id);
        $seo = Seo::where('itemable_id', $setting->id)->where('itemable_type', get_class($setting))->first();
        if ($seo == null) {
            $seo = Seo::create([
                'itemable_id' => $setting->id,
                'itemable_type' => get_class($setting),
                'store_id' => session()->get('StoreId'),
            ]);

            SeoTranslation::create([
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'seo_id' => $seo->id,
                'lang_id' => getLang(session('adminlang')),
            ]);
        } else {
            $seo->update([
                'itemable_id' => $setting->id,
                'itemable_type' => get_class($setting),
                'store_id' => session()->get('StoreId'),
            ]);

            SeoTranslation::where('seo_id', $seo->id)->update([
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'seo_id' => $seo->id,
                'lang_id' => getLang(session('adminlang')),
            ]);
        }
        return redirect()->back()->with('success', _i('Added Successfully !'));
    }




}
