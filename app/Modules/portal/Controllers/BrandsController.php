<?php

namespace App\Modules\portal\Controllers;

use App\Bll\Filter;
use App\Bll\Lang;
use App\Bll\Utility;
use App\Http\Controllers\Controller;
use App\Modules\Admin\Models\MailingList\MailingList;
use App\Modules\Admin\Models\Product\Classification;
use App\Modules\Admin\Models\Products\Category;
use App\Modules\Admin\Models\Section;
use App\Modules\Admin\Models\Settings\Currency;
use App\Modules\Admin\Models\Settings\Setting;
use App\Modules\Admin\Models\Settings\Slider;
use App\Modules\Brands\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Xinax\LaravelGettext\Facades\LaravelGettext;

class BrandsController extends Controller
{


    protected function brand($id, Request $request)
    {
        $brands = Brand::with('products')->find($id);
        //dd($brands);
        if ($brands == null) {
			abort(404);
		}
        $user_currency = Currency::where('is_default', 1)->first();
        $settings = Setting::first();
        $user_id = auth()->check() ? auth()->user()->id : NULL;

        $lang_id = Lang::getSelectedLangId();
        $filtreBll = new Filter($settings, $lang_id);
        $filtreBll->search = $request->search;
        $filtreBll->brand = [$id];


        if (request()->ajax()) {
        	$arr = $filtreBll->GetProducts();
        	$arr["user_currency"] = $user_currency;
        	return view('portal.filter.product_item', $arr)->render();
        }

        $arr = $filtreBll->Get();
        $arr["user_currency"] = $user_currency;
        $arr["brands"] = [];
          // dd($arr['categories']);
        return view('portal.singlePages.brand', compact('brands','arr'));
    }


}
