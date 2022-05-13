<?php

namespace App\Modules\Admin\Controllers\Setting;

use App\Bll\Lang;
use App\Bll\Utility;
use App\Http\Controllers\Controller;

use App\Modules\Admin\Models\Settings\Setting;
use App\Modules\Admin\Models\Settings\SettingsData;
use Illuminate\Http\Request;

class StoreOptionController extends Controller
{
    public function index()
    {
        $settings = Setting::findOrFail(1);
        $settings_data = SettingsData::where('lang_id', Lang::getSelectedLangId())->get()->first();
        return view('admin.settings.storeOptions.index', compact('settings', 'settings_data'));
    }

    public function storeMaintenance(Request $request, $id)
    {
        $this->validate($request, [
            'maintenance' => ['sometimes'],
            'maintenance_message' => ['sometimes', 'string', 'min:3', 'max:200'],
            'maintenance_title' => ['sometimes', 'string', 'min:3', 'max:50'],
        ]);

        $setting = Setting::findOrFail($id);
        $setting_data = SettingsData::where('lang_id', Lang::getSelectedLangId())->first();

        if ($request->maintenance == 'on') {
            $maintenance = 1;
        } else {
            $maintenance = 0;
        }

        $setting->update(['maintenance' => $maintenance,]);
        $setting_data->update([
            'maintenance_title'   => $request->maintenance_title,
            'maintenance_message' => $request->maintenance_message,
        ]);

        return redirect()->back()->with('success', _i('Update Successfully !'));

    }

    public function storeOptions(Request $request, $id)
    {
        $settings = Setting::find(1);

        $order_accept = 0;
        $product_rating = 0;
        $product_outStock = 0;
        $discount_codes = 0;
        $product_purchases_count = 0;
        $similar_products = 0;

        if ($request->order_accept == 'on') {
            $order_accept = 1;
        } else {
            $order_accept = 0;
        }

        if ($request->product_rating == 'on') {
            $product_rating = 1;
        } else {
            $product_rating = 0;
        }

        if ($request->product_outStock == 'on') {
            $product_outStock = 1;
        } else {
            $product_outStock = 0;
        }

        if ($request->discount_codes == 'on') {
            $discount_codes = 1;
        } else {
            $discount_codes = 0;
        }

        if ($request->product_purchases_count == 'on') {
            $product_purchases_count = 1;
        } else {
            $product_purchases_count = 0;
        }

        if ($request->similar_products == 'on') {
            $similar_products = 1;
        } else {
            $similar_products = 0;
        }

        // $arr = [
        //     'order_accept' => $order_accept,
        //     'product_rating' => $product_rating,
        //     'product_outStock' => $product_outStock,
        //     'discount_codes' => $discount_codes,
        //     'product_purchases_count' => $product_purchases_count,
        //     'similar_products' => $similar_products,
        // ];
        // print_r($arr);die;
        Setting::where('id', 1)->update([
            'order_accept' => $order_accept,
            'product_rating' => $product_rating,
            'product_outStock' => $product_outStock,
            'discount_codes' => $discount_codes,
            'product_purchases_count' => $product_purchases_count,
            'similar_products' => $similar_products,
        ]);

        return redirect()->back()->with('success', _i('Update Successfully !'));
    }
}
