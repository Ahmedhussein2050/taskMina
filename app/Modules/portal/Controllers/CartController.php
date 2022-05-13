<?php

namespace App\Modules\Portal\Controllers;

use App\Bll\Cart;
use App\Bll\Lang;
use App\Bll\Utility;
use App\Http\Controllers\Controller;
use App\Models\AbandonedCart;
use App\Modules\Admin\Models\Products\countries_data;
use App\Modules\Admin\Models\Products\Product;
use App\Modules\Admin\Models\Settings\Setting;
use App\Modules\Orders\Models\Shipping\Shipping_option;
use App\Modules\Orders\Models\Shipping\Shipping_type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use mysql_xdevapi\Session;

class CartController extends Controller
{
    protected function index(Request $request)
    {
        $products = AbandonedCart::whereHas('product',function($q){
            $q->where('hidden',0);
        })->where('user_id', auth()->user()->id)->get();
        $settings = Setting::join('settings_data', 'settings_data.setting_id', 'settings.id')
            ->where('settings_data.lang_id', Lang::getSelectedLangId())
            ->first();
        // dd($products);
        $countries = countries_data::where('lang_id', lang::getSelectedLangId())->get();
        return view('portal.products.cart', compact('countries', 'products', 'settings'));
    }

    protected function add(Request $request)
    {

        if (Auth::check()) {
            $product  = Product::find($request->id);
            $cart = new Cart($product);
            $items = $cart->addToCart();

            $content = [
                'fail' => false,
                'product' => $items,
                'message' =>  _i('Add To Cart Successfully')
            ];
            return response($content);
        } else {
            $content = [
                'fail' => true,
                'product' => null,
                'message' => _i('You Must login first')
            ];
            return response($content);
        }
    }

    protected function increase(Request $request)
    {
        //  dd($request->all());
        if (Auth::check()) {
            $product  = Product::find($request->id);
            $cart  = new Cart($product);
            $items = $cart->increase();

            $content = [
                'fail' => false,
                'product' => $items,
                'message' =>  _i('Add To Cart Successfully')
            ];
            return response($content);
        } else {
            $content = [
                'fail' => true,
                'product' => null,
                'message' => _i('You Must login first')
            ];
            return response($content);
        }
    }

    protected function decrease(Request $request)
    {

        if (Auth::check()) {
            $product  = Product::find($request->id);
            $cart  = new Cart($product);
            $items = $cart->decrease();

            $content = [
                'fail' => false,
                'product' => $items,
                'message' =>  _i('Add To Cart Successfully')
            ];
            return response($content);
        } else {
            $content = [
                'fail' => true,
                'product' => null,
                'message' => _i('You Must login first')
            ];
            return response($content);
        }
    }

    protected function items(Request $request)
    {
        if (Auth::user()) {
            $cart = new Cart();
            $items = $cart->cartitems();
        } else {
            $items = 0;
        }

        $content = [
            'fail'    => false,
            'product' =>  $items,
            'message' =>  null
        ];
        return response($content);
    }

    protected function destroy($id)
    {

        $product = AbandonedCart::find($id)->delete();
        return response('success');

    }

    protected function get_available_shipping_methods(Request $request)
    {
        $region_id = $request->input("region_id");
        $country_id =  $request->input("country_id");
        $city_id = $request->input("city_id");

        //dd($country_id);
        if ($country_id . $city_id == "")
            return [];

        if ($region_id == "")
            $region_id = 0;
        if ($city_id == "")
            $city_id = 0;


        $available = [];
        $lang_id = Lang::getSelectedLangId();

        //old code
        $cart_products = AbandonedCart::with('product.translation')->where('user_id', auth()->user()->id)->get();


        $weight = 0;
        $quantity = 0;
        foreach ($cart_products as $cart_product) {
            $quantity += $cart_product->quantity;
            if ($cart_product->is_free_shipping != 1) $free_shipping = 0;
            if ($cart_product->weight_unit == 'g') $weight += $cart_product->weight / 1000;
            if ($cart_product->weight_unit == 'kg') $weight += $cart_product->weight;
        }
        //	dd(session()->all());

        $options = Shipping_option::whereHas("company", function ($q) {
            $q->where("is_active", 1)->where("api", 0);
        })
            ->with(["company.Data"])
            ->Leftjoin("shipping_option_cities", "shipping_option_cities.shipping_option_id", "shipping_options.id")
            ->Where(function ($q) use ($country_id) {
                $q->whereNull("country_id")->orWhere("country_id", $country_id);
            })

            ->select("shipping_options.*")->get();


        foreach ($options as $option) {
            $company = $option->company;
            //dd($option);
            $data = $company->Data->where('lang_id', $lang_id)->first();
            if ($data == null)
                $data = $company->Data->first();

            $shipping_type = Shipping_type::where('shipping_option_id', $option->id)->whereNotNull('no_kg')->first();
            $option->cash_delivery_commission = $option->cash_delivery_commission == NULL ? 0 : ($option->cash_delivery_commission);
            $option->cost = $option->cost == NULL ? 0 : ($option->cost);
            $option->minimum_purchases = $option->minimum_purchases == NULL ? 0 : ($option->minimum_purchases);
            $option->cost_text = $option->cost . ' ' . Utility::get_default_currency()->code;

            $option->cost_by_weight = 0;
            if ($shipping_type != NULL) {
                if ($weight < $shipping_type->no_kg) $option->cost_by_weight = ($shipping_type->cost_no_kg);
                if ($weight > $shipping_type->no_kg) {
                    $option->cost_by_weight = ($shipping_type->cost_no_kg);
                    $weight_after = $weight - $shipping_type->no_kg;
                    $option->cost_by_weight = (($weight_after / $shipping_type->cost_increase) * $shipping_type->kg_increase) + ($shipping_type->cost_no_kg);
                }

                if ($option->cost_by_weight != 0) {
                    $option->cost = $option->cost_by_weight;
                    $option->cost_text = $option->cost . ' ' . Utility::get_default_currency()->code;
                }
            }

            $available[] = [
                'company_id' => $company->id,
                'company_title' => $data->title,
                'company_logo' => $company->logo,
                'company_cost' => $option->cost,
                'company_cost_text' => $option->cost_text,
                'company_delay' =>  _i('Shipping in') . $option->delay . _i(' Working Days'),
                'company_cash_delivery_commission' => $option->cash_delivery_commission,
                'shipping_type' => '',
                'shipping_company_type' => $option->company->shipping_type,
                'minimum_purchases' => $option->minimum_purchases,
                'option_id' => $option->id,
            ];
        }
        //		    // api aramex
        $optionsApi = Shipping_option::whereHas("company", function ($q) {
            $q->where("is_active", 1)->where("api", 1);
        })->with(["company.Data"])
            ->Leftjoin("shipping_option_cities", "shipping_option_cities.shipping_option_id", "shipping_options.id")
            ->Where(function ($q) use ($country_id) {
                $q->whereNull("country_id")->orWhere("country_id", $country_id);
            })
            ->whereIn("shipping_options.id", function ($q) use ($city_id, $country_id) {
                $q->from("shipping_option_cities")->whereNull("city_id")->orWhere("city_id", $city_id)->where("country_id", $country_id)->select("shipping_option_id");
            })
            ->leftjoin("shipping_regions", "shipping_regions.shipping_option_id", "shipping_options.id")
            ->Where(function ($q) use ($region_id) {
                $q->whereNull("shipping_regions.region_id")->orWhere("shipping_regions.region_id", $region_id);
            })->select("shipping_options.*")->get();


        return $available;
    }
}
