<?php

namespace App\Modules\Admin\Controllers\Shipping;

use App\Bll\Lang;
 use App\Bll\Utility;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Modules\Admin\Models\Orders;
use App\Modules\Admin\Models\Products\Country;
use App\Modules\Admin\Models\Settings\City;
use App\Modules\Orders\Models\Shipping\Cities_shipping_option;
use App\Modules\Orders\Models\Shipping\Shipping_option;
use App\Modules\Orders\Models\Shipping\Shipping_type;
use App\Modules\Orders\Models\Shipping\shippingCompanies;
use App\Modules\Orders\Models\Shipping\ShippingCompaniesData;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ShippingController extends Controller
{
    public function index()
    {
        $languages = Language::get();

        $countries = Country::join('countries_data', 'countries_data.country_id', 'countries.id')
            ->select('countries_data.title', 'countries.id')->where('countries_data.lang_id', Lang::getSelectedLangId());
        $cities = City::join('city_datas', 'city_datas.city_id', 'cities.id')
            ->select('city_datas.title', 'cities.id')->where('city_datas.lang_id', Lang::getSelectedLangId());

        $companies =shippingCompanies::leftJoin('shipping_companies_data', 'shipping_companies_data.shipping_company_id', 'shipping_companies.id')
            ->select(
                'shipping_companies.id',
                "shipping_companies.is_active",
                "shipping_companies.shipping_type",
                'shipping_companies.logo',
                'shipping_companies_data.title',
                'shipping_companies_data.description',
                'shipping_companies_data.lang_id',
                'shipping_companies.api'
            )
//            ->where('shipping_companies.api', null)
            ->where('shipping_companies.api', 0)->orWhere('shipping_companies.api', null)
        //->where('shipping_type','!=', "Free")
            ->where('shipping_companies_data.source_id', null)
            ->orderBy('order')
            ->get();
         return view('admin.shipping.companies.index', compact(
            'countries',
            'cities',
            'companies',
            'languages'
        ));
    }

    protected function api(Request $request)
    {


        $languages = Language::get();

        $countries = Country::join('countries_data', 'countries_data.country_id', 'countries.id')
            ->select('countries_data.title', 'countries.id')->where('countries_data.lang_id', Lang::getSelectedLangId());
        $cities = City::join('city_datas', 'city_datas.city_id', 'cities.id')
            ->select('city_datas.title', 'cities.id')->where('city_datas.lang_id', Lang::getSelectedLangId());

        $companies = shippingCompanies::leftJoin('shipping_companies_data', 'shipping_companies_data.shipping_company_id', 'shipping_companies.id')
            ->select(
                'shipping_companies.id',
                "shipping_companies.is_active",
                "shipping_companies.shipping_type",
                'shipping_companies.logo',
                'shipping_companies_data.title',
                'shipping_companies_data.description',
                'shipping_companies_data.lang_id',
                'shipping_companies.api'
            )
            ->where('shipping_companies.api', 1)
            ->where('shipping_companies_data.source_id', null)
            ->orderBy('order')
            ->get();

        $response = [
            'status' => "ok",
            'companies' => $companies,
        ];

		return view('admin.shipping.companies.index', compact(
            'countries',
            'cities',
            'companies',
            'languages'
        ));

    }

    protected function freeStatus(Request $request, $id)
    {
        $find = shippingCompanies::find($id);
        if ($find != null) {
            $find->shipping_type = ($find->shipping_type == "free") ? "paid" : "free";
            $find->save();
            return response()->json(["status" => "ok"]);
        }
        return response()->json(["status" => "fail", "msg" => "not found"]);
    }

    public function create()
    {
        $languages = Language::get();

        $countries = Country::select('countries.id', 'countries_data.title')
            ->join('countries_data', 'countries.id', 'countries_data.country_id')
            ->where('lang_id', Lang::getSelectedLangId())
            ->get();

        $cities = City::join('city_datas', 'city_datas.city_id', 'cities.id')
            ->select('city_datas.title', 'cities.id')->where('city_datas.lang_id', Lang::getSelectedLangId())->get();

        $shipping_company = shippingCompanies::join('shipping_companies_data', 'shipping_companies_data.shipping_company_id', 'shipping_companies.id')
            ->select(
                'shipping_companies.id',
                'shipping_companies.is_active',
                'shipping_companies.logo',
                'shipping_companies_data.title',
                'shipping_companies_data.lang_id',
                'shipping_companies_data.description'
            )
            ->where('shipping_companies_data.title', 'like', "Free Shipping")
            ->first();
        if ($shipping_company != null) {
            $shipping_options = Shipping_option::where('company_id', $shipping_company->id)->get();
        } else {
            $shipping_options = null;
        }

        $companies = shippingCompanies::leftJoin('shipping_companies_data', 'shipping_companies_data.shipping_company_id', 'shipping_companies.id')
            ->select(
                'shipping_companies.id',
                'shipping_companies.logo',
                'shipping_companies_data.title',
                'shipping_companies_data.description',
                'shipping_companies_data.lang_id'
            )
            ->where('title', '!=', "Free Shipping")->where('shipping_companies_data.source_id', null)->get();
        // dd($companies);
		$response = [
			'status' => "ok",
			'companies' => $companies,
		];


        return view('admin.shipping.companies.create', compact('countries', 'cities', 'shipping_options', 'shipping_company', 'companies', 'languages'));
    }

    public function edit($id)
    {
        $languages = Language::get();
        $countries = Country::join('countries_data', 'countries_data.country_id', 'countries.id')
            ->select('countries_data.title', 'countries.id')->where('countries_data.lang_id', Lang::getSelectedLangId())->get();
        /*
        $cities = cities::join('city_datas','city_datas.city_id','cities.id')
        ->select('city_datas.title','cities.id')->where('city_datas.source_id' , null)->get();
        ->select('city_datas.title','cities.id')->where('city_datas.lang_id' , Lang::getSelectedLangId());
         */

        $company = shippingCompanies::leftJoin('shipping_companies_data', 'shipping_companies_data.shipping_company_id', 'shipping_companies.id')
            ->select(
                'shipping_companies.id',
                'shipping_companies.shipping_type',
                'shipping_companies.is_active',
                'shipping_companies.order',
                'shipping_companies.logo',
                'shipping_companies_data.title',
                'shipping_companies_data.description',
                'shipping_companies_data.lang_id'
            )
            ->where('shipping_companies_data.source_id', null)->where("shipping_companies.id", $id)
            ->first();
        if ($company == null) {
            return view("admin.not_found");
        }

        return view('admin.shipping.companies.edit', compact('countries', 'company', 'languages'));
    }

    public function get_cities(Request $request)
    {
        $cities = City::join('city_datas', 'city_datas.city_id', 'cities.id')
            ->select('city_datas.title', 'cities.id')->where('city_datas.lang_id', Lang::getSelectedLangId())
            ->where('cities.country_id', $request->country_id)->get();
        return response()->json($cities);
    }

//    public function get_regions(Request $request)
//    {
//        $regions = Region::join('region_data', 'region_data.region_id', 'regions.id')
//            ->join('region_stores', 'region_stores.region_id', 'regions.id')
//            ->select('region_data.title', 'regions.id')->where('region_data.lang_id', Lang::getSelectedLangId())
//            ->where('regions.city_id', $request->city_id)->get();
//        return response()->json($regions);
//    }

    public function save_shipping_company(Request $request)
    {

        $shipping_type = "paid";
        if ($request->free_shipping == "1") {
            $shipping_type = "free";
        }

        $is_active = 0;
        if ($request->is_active != null) {
            $is_active = 1;
        }

        $langId = Lang::getSelectedLangId();

        $shipping_company = shippingCompanies::create([

            'order' => $request->order,
            'is_active' => $is_active,
            'shipping_type' => $shipping_type,
        ]);
        $shipping_company_data = ShippingCompaniesData::create([

            'title' => $request->company_name,
            'description' => $request->description,
            'shipping_company_id' => $shipping_company->id,
            'lang_id' => $langId,
        ]);

        if ($request->hasFile('logo')) {
            $request->validate([
                'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            ]);

            $image = $request->file('logo');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $request->logo->move(public_path('uploads/shipping_company/' . $shipping_company->id), $filename);

            $shipping_company->logo = '/uploads/shipping_company/' . $shipping_company->id . '/' . $filename;
            $shipping_company->save();
        }
        //$old_shipping_options = Shipping_option::where('company_id', $shipping_company->id)->delete();
        $this->saveOptions($request, $shipping_company, $langId);

        return redirect()->route('shipping.index')->with('success', _i('Saved Successfully !'));
    }
    private function saveOptions($request, $shipping_company, $langId)
    {
        //dd($request->all());
        if ($request->country_id != null) {
            foreach ($request->country_id as $i => $country) {
                if ($request['delivery_method'][$i] == "available") {
                    $comission = $request['cash_delivery_commission'][$i];
                } else {
                    $comission = null;
                }

                if ($request['pricing_type'][$i] == "fixed") {
                    $cost = $request['cost'][$i];
                    $no_kg = null;
                    $cost_no_kg = null;
                    $cost_increase = null;
                    $kg_increase = null;
                } else {
                    $cost = null;
                    $no_kg = $request['no_kg'][$i];
                    $cost_no_kg = $request['cost_no_kg'][$i];
                    $cost_increase = $request['cost_increase'][$i];
                    $kg_increase = $request['kg_increase'][$i];
                }

                if ($request['country_id'][$i] == "all") {
                    $country = null;
                } else {
                    $country = $request['country_id'][$i];
                }
                var_dump($request['delay'][$i]);

                $shipping_options = Shipping_option::create([

                    'company_id' => $shipping_company->id,
                    'country_id' => $country,
                    'cash_delivery_commission' => $comission,
                    'cost' => $cost,
                    'currency_id' => Utility::get_default_currency(true)->currency_id,
                    'delay' => $request['delay'][$i],
                    'lang_id' => $langId,
                ]);
                $shipping_types = Shipping_type::create([

                    'shipping_option_id' => $shipping_options->id,
                    'no_kg' => $no_kg,
                    'cost_no_kg' => $cost_no_kg,
                    'cost_increase' => $cost_increase,
                    'kg_increase' => $kg_increase,
                ]);

                $city = "city_id";
                //$city .= $i + 1;

                $city_request = $request->input($city)[$i];
                //[$request['country_id'][$i]];
                //dd($request->input($city),$city_request);

                //dd($city_request,$country);
                foreach ($city_request as $key => $row) {
                    if ($row == "all") {
                        $row = null;
                    }

                    $cities_shipping_options = Cities_shipping_option::create([

                        'shipping_option_id' => $shipping_options->id,
                        'city_id' => $row,
                    ]);
                    //                            $region_request =$request->input('region_id') ;

                }

                $region_request = ["all"];
                if ($request->input('region_id')) {
                    $region_request = $request->input('region_id')[$i];
                }

                //else

                //                        dd($region_request);
//                if (in_array("all", $region_request)) {
//                    $shipping_regions = ShippingRegion::create([
//
//                        'shipping_option_id' => $shipping_options->id,
//                        'region_id' => null,
//                    ]);
//                } else {
//                    foreach ($region_request as $item) {
//                        $shipping_regions = ShippingRegion::create([
//
//                            'shipping_option_id' => $shipping_options->id,
//                            'region_id' => $item,
//                        ]);
//                    }
//                }
            }
        }
    }

    public function freee_company_create()
    {
        $lang_id = Lang::getSelectedLangId();
        $languages = Language::get();

        $countries = Country::join('countries_data', 'countries_data.country_id', 'countries.id')
            ->select('countries_data.title', 'countries.id')->where('countries_data.lang_id', $lang_id)->get();
        $cities = City::join('city_datas', 'city_datas.city_id', 'cities.id')
            ->select('city_datas.title', 'cities.id')->where('city_datas.lang_id', $lang_id)->get();

        $shipping_company = shippingCompanies::join('shipping_companies_data', 'shipping_companies_data.shipping_company_id', 'shipping_companies.id')
            ->select(
                'shipping_companies.id',
                'shipping_companies.is_active',
                'shipping_companies.logo',
                'shipping_companies.shipping_type',
                'shipping_companies_data.title',
                'shipping_companies_data.lang_id',
                'shipping_companies_data.description'
            )
        //->where('shipping_companies_data.title','like', "Free Shipping")
            ->where('shipping_companies.shipping_type', "Free")
            ->first();

        if ($shipping_company != null) {
            $shipping_options = Shipping_option::where('company_id', $shipping_company->id)->get();
        } else {
            $shipping_options = null;
        }

        return view('admin.shipping.companies.free.create', compact(
            'countries',
            'cities',
            'shipping_options',
            'shipping_company',
            'languages'
        ));
    }

    public function update_shipping_company($id, Request $request)
    {
        //        return $request->region_id;
        //        dd($id);
        try {

            // $this->validate($request, [
            //     'cost.*' => 'numeric'
            // ]);

            $shipping_type = "paid";
            if ($request->free_shipping == "1") {
                $shipping_type = "free";
            }

            $shipping_company = shippingCompanies::where('id', $id)->first();
            $shipping_company->update([
                'is_active' => $request->is_active ?? 0,
                'shipping_type' => $shipping_type,
                "order" => $request->order,
            ]);

            $shipping_company_data = ShippingCompaniesData::where('shipping_company_id', $shipping_company->id)->first();
            $shipping_company_data->update([
                'title' => $request->company_name,
                'description' => $request->description,
            ]);

            if ($request->hasFile('logo')) {
                $request->validate([
                    'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                ]);

                $image_path = $shipping_company->logo;
                if (File::exists(public_path($image_path))) {
                    File::delete(public_path($image_path));
                }

                $image = $request->file('logo');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $request->logo->move(public_path('uploads/shipping_company/' . $shipping_company->id), $filename);

                $shipping_company->logo = '/uploads/shipping_company/' . $shipping_company->id . '/' . $filename;
                $shipping_company->save();
            }
            $langId = Lang::getSelectedLangId();
            $this->saveOptions($request, $shipping_company, $langId);

            return redirect()->back()->with('success', _i('Saved Successfully !'));
        } catch (\Exception $e) {
            error_log($e->getMessage());
            //dd($e);
            return redirect()->back()->with('error_message', _i('Element is linked to data!'));
        }
    }

    public function delete_shipping_option(Request $request)
    {

        // dd($request->optionId);

        $shipping_option = Shipping_option::where('id', $request->optionId)->first();
        if ($shipping_option == null) {
            return response()->json(false);
        }
        $shipping_option = Shipping_option::where('id', $request->optionId)->first();
        $shipping_option_order = Orders::where('shipping_option_id', $shipping_option->id)->get();
        if ($shipping_option_order->count() == 0) {
            DB::table('shipping_option_cities')->where('shipping_option_id', $shipping_option->id)->delete();
            DB::table('shipping_regions')->where('shipping_option_id', $shipping_option->id)->delete();
            $shipping_option->delete();
            return response()->json(true);
        }
    }

    public function delete_company($companyId)
    {

        try {

            $company = shippingCompanies::where('id', $companyId)->first();
            if ($company == null) {
                return redirect()->back()->with('error', _i('Not Found !'));
            }

            $shipping_options = Shipping_option::where('company_id', $company->id)->first();

            if ($shipping_options != null) {
                $shipping_option_order = Orders::where('shipping_option_id', $shipping_options->id)->get();

                if ($shipping_option_order->count() == 0) {
                    DB::table('shipping_option_cities')->where('shipping_option_id', $shipping_options->id)->delete();
                    DB::table('shipping_regions')->where('shipping_option_id', $shipping_options->id)->delete();
                    $shipping_optionsaa = Shipping_option::where('company_id', $company->id)->delete();
                    $company_data = ShippingCompaniesData::where('shipping_company_id', $company->id)->delete();

                    $image_path = $company->logo; // Value is not URL but directory file path
                    if (File::exists(public_path($image_path))) {
                        File::delete(public_path($image_path));
                    }
                }
            }
            $company->delete();
        } catch (\Exception $e) {

            error_log($e->getMessage());
            return redirect()->back()->with('error', _i('Can`t Deleted! There is related orders'));
        }

        return redirect()->back()->with('success', _i('Deleted Successfully !'));
    }

    public function getvalue(Request $request)
    {
        $rowData = ShippingCompaniesData::where('shipping_company_id', $request->id)
            ->where('lang_id', $request->lang_id)
            ->first(['title', 'description']);
        if (!empty($rowData)) {
            return response()->json(['data' => $rowData]);
        } else {
            return response()->json(['data' => false]);
        }
    }

    public function storelang(Request $request)
    {
         $rowData = ShippingCompaniesData::where('shipping_company_id', $request->id)
            ->where('lang_id', $request->lang_id_data)
            ->first();

        if ($rowData) {
            if ($rowData->lang_id == $request->lang_id_data) {
                ShippingCompaniesData::where('shipping_company_id', $request->id)->where('lang_id', $request->lang_id_data)->update([
                    'title' => $request->title,
                    'description' => $request->description,
                ]);
            }
        } else {

            $row = ShippingCompaniesData::where('shipping_company_id', $request->id)->whereNull('source_id')
                ->first();
            ShippingCompaniesData::create([

                'title' => $request->title,
                'description' => $request->description,
                'shipping_company_id' => $request->id,
                'lang_id' => $request->lang_id_data,
                'source_id' => $row->id,
            ]);
        }
        return response()->json("SUCCESS");
    }
}
