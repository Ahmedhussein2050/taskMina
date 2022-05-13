<?php

namespace App\Modules\portal\Controllers;

use App\Bll\Filter;
use App\Bll\Lang;
use App\Bll\Utility;
use App\Http\Controllers\Controller;
use App\Modules\Admin\Models\MailingList\MailingList;
use App\Modules\Admin\Models\Product\Classification;
use App\Modules\Admin\Models\Products\Category;
use App\Modules\Admin\Models\Products\CategoryData;
use App\Modules\Admin\Models\Section;
use App\Modules\Admin\Models\Settings\Currency;
use App\Modules\Admin\Models\Settings\Setting;
use App\Modules\Admin\Models\Settings\Slider;
use App\Modules\Brands\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Xinax\LaravelGettext\Facades\LaravelGettext;

class CategoryController extends Controller
{


    protected function category($id, Request $request)
    {
        $category = Category::with('products','dataa')->find($id);

        if ($category == null) {
			abort(404);
		}
        $user_currency = Currency::where('is_default', 1)->first();
        $settings = Setting::first();

        $lang_id = Lang::getSelectedLangId();
        $filtreBll = new Filter($settings, $lang_id);
		$filtreBll->search = $request->search;
		$filtreBll->category = [$id];


        if (request()->ajax()) {
        	$arr = $filtreBll->GetProducts();
        	$arr["user_currency"] = $user_currency;
        	return view('portal.filter.product_item', $arr)->render();
        }

        $arr = $filtreBll->Get();
        $arr["user_currency"] = $user_currency;
        $categories =CategoryData::where('category_id',$id)->where('lang_id',Lang::getSelectedLangId())->first();
        $arr["categories"]    =[$categories];

         return view('portal.singlePages.category', compact('category','arr'));
    }


}
