<?php

namespace App\Modules\portal\Controllers;

use App\Bll\Filter;
use App\Bll\Lang;
use App\Bll\Utility;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Modules\Admin\Models\MailingList\MailingList;
use App\Modules\Admin\Models\Product\Classification;
use App\Modules\Admin\Models\Products\Category;
use App\Modules\Admin\Models\Products\Product;
use App\Modules\Admin\Models\Products\product_details;
use App\Modules\Admin\Models\Section;
use App\Modules\Admin\Models\Settings\Currency;
use App\Modules\Admin\Models\Settings\Items;
use App\Modules\Admin\Models\Settings\ItemsList;
use App\Modules\Admin\Models\Settings\Setting;
use App\Modules\Admin\Models\Settings\Slider;
use App\Modules\Admin\Models\SitePages\Page;
use App\Modules\Brands\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Xinax\LaravelGettext\Facades\LaravelGettext;

class HomeController extends Controller
{
    protected function index()
    {
        $sliders = Slider::join('sliders_data', 'sliders_data.slider_id', 'sliders.id')
            ->where('published', 1)
            ->where('sliders_data.lang_id', Lang::getSelectedLangId())->get();
            
        $sections = Section::with(['translation', 'Data', 'banners.Data'])
            ->where([
                'published' => 1, 'page' => 'home',
            ])
            ->orderBy('display_order', 'ASC')
            ->get();
        $categories = Utility::mainNav();
        $brands     = Brand::whereHas('translation')->where('published', 1)->get();

        return view('portal.home', compact('sliders', 'sections', 'categories', 'brands'));
    }



    protected function classification($id)
    {
        $classifications = Classification::find($id);
        $categories = Category::where('level', 2)->get();
        if ($classifications == null) {
            abort(404);
        }
        return view('portal.singlePages.classification', compact('classifications', 'categories'));
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = MailingList::where('email', $request->email)->first();
        if ($email == NULL) {
            MailingList::create(['email' => $request->email]);
            return response()->json(['status' => 'success', 'message' => _i('Thank you !')]);
        }
        return response()->json(['status' => 'success', 'message' => _i('Thank you !')]);
    }
    public function switchLang($code)
    {
        Session::forget('locale');
        Session::put('locale', $code);
        LaravelGettext::setLocale($code);
        return redirect()->back();
    }
    protected function auto_search(Request $request)
    {
        if ($request->ajax()) {
            $term = $request->query("term");
            $all = product_details::join("products", "products.id", "product_details.product_id")
                // ->joinSub("select photo,product_id from product_photos where main=1", "photos", "product_details.product_id", "photos.product_id")
                ->where("product_details.title", "like", "%" . $term . "%")
                ->where("products.hidden", "0")
                ->where("products.stock", '>', 0)
                ->where('lang_id', Lang::getSelectedLangId())
                ->select("product_details.product_id as id", "title", "title as value", "products.image")
                ->limit(10)->get();

            $user_currency =  Currency::where('is_default', 1)->first();
            $result = array_map(function ($item) use ($user_currency) {
                $item = (object)$item;
                $item->image = asset($item->image);
                $item->url = route("home_product.show", $item->id);
                return $item;
            }, $all->toArray());

            return response()->json($result);
        }
    }
    public function search(Request $request)
    {
        $user_id = Auth::check() ? auth()->user()->id : NULL;
        $category = $request->category;
        if (empty($category)) {
            $category = NULL;
        } else {
            $category = array_values($category)[0];
        }

        $lang_id = Lang::getSelectedLangId();
        $user_currency = Currency::where('is_default', 1)->first();
        $settings = Setting::first();
        $filtreBll = new Filter($settings, $lang_id);
        $filtreBll->search = $request->search;
        if (request()->ajax()) {
            $arr = $filtreBll->GetProducts();

            $arr["user_currency"] = $user_currency;
            return view('portal.filter.product_item', $arr)->render();
        }
        $arr = $filtreBll->Get();
        $arr["user_currency"] = $user_currency;
        //  dd($arr);

        return view('portal.filter.search', compact('arr'));
    }
    public function getPage(Request $request, $id)
    {
        $page = Page::select('pages.*', 'title', 'content')
            ->join('pages_data', 'pages.id', 'pages_data.page_id')
            ->where('lang_id', Lang::getSelectedLangId())
            ->where('pages.id', $id)
            ->first();

        if (!$page) {
            abort(404);
        }
        $settings = Setting::leftJoin('settings_data', 'settings.id', '=', 'settings_data.setting_id')
            ->select('settings.*', 'settings_data.title as title', 'settings_data.address as address', 'settings_data.header_description as header_description', 'settings_data.description as description', 'settings_data.lang_id as lang_id')
            ->where('settings_data.lang_id', 1)->first();
        $categories = Category::select('categories.*', 'title')
            ->join('categories_data', 'categories.id', 'categories_data.category_id')
            ->where('lang_id', Lang::getSelectedLangId())
            ->orderBy('number', 'desc')
            ->get();
        $products = Product::select('products.*', 'title', 'label', 'description')
            ->join('product_details', 'products.id', 'product_details.product_id')
            ->where('lang_id', Lang::getSelectedLangId())
            ->orderBy('id', 'desc')
            ->get();
        $lists = ItemsList::join('lists_data', 'lists_data.list_id', 'lists.id')
            ->select('lists_data.name', 'lists.id', 'lists.order')
            ->where('lists_data.lang_id', Lang::getSelectedLangId());
        $items = Items::join('items_data', 'items_data.item_id', 'items.id')
            ->select('items_data.name', 'items.*')
            ->where('items_data.lang_id', Lang::getSelectedLangId())
            ->orderBy('id', 'desc');

        return view('portal.singlePages.pages', compact('page', 'settings', 'categories', 'products', 'lists', 'items'));
    }
    public function contact_us()
    {

        $settings = Setting::leftJoin('settings_data', 'settings.id', '=', 'settings_data.setting_id')
            ->select('settings.*', 'settings_data.title as title', 'settings_data.address as address', 'settings_data.header_description as header_description', 'settings_data.description as description', 'settings_data.lang_id as lang_id')
            ->where('settings_data.lang_id', 1)->first();
        return view('portal.singlePages.contactUs', compact('settings'));
    }
    public function contact_us_submit(Request $request)
    {
        // dd($request->all());
        $rules = [
            'name' => ['required', 'string', 'max:255', 'min:3'],
            'email' => ['required', 'string', 'max:255', 'min:3'],
            'message' => ['required', 'string', 'max:1000', 'min:3'],
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'message' => $request->message,
            ]);
            return response('sucsses');
        }
    }
}
