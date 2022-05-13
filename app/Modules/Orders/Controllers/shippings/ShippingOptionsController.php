<?php

namespace App\Modules\Orders\Controllers\shippings;

use App\Bll\Lang;
use App\Bll\MyFatoorah;
use App\DataTables\shippingOptionDataTable;
use App\Http\Controllers\Controller;
use App\Modules\Admin\Models\cities;
use App\Modules\Admin\Models\countries;
use App\Modules\Orders\Models\Shipping\Cities_shipping_option;
use App\Modules\Orders\Models\Shipping\Shipping_option;
use App\Modules\Orders\Models\Shipping\Shipping_type;
use App\Modules\Orders\Models\Shipping\shippingCompanies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShippingOptionsController extends Controller
{
	public function getCountriesShipping(Request $request)
	{
		$exists = Shipping_option::where('country_id', $request->id)->exists();
		$options = null;
		if ($exists) {
			$options = Shipping_option::where('country_id', $request->id)->get();
		}
		return response()->json($exists);
	}

	public function getShippingOptions(Request $request)
	{
		$options = null;
		$option = Shipping_option::where('country_id', $request->country)->orWhere('country_id', NULL)->pluck('id')->toArray();
		$cities_shipping_options = DB::table('shipping_option_cities')
			->where(function($query) use($option, $request)
			{
				$query->whereIn('shipping_option_id', $option)->where('city_id', $request->city);
			})
			->orWhere(function($query) use($option)
			{
				$query->whereIn('shipping_option_id', $option)->where('city_id', NULL);
			})

			->pluck('shipping_option_id')->toArray();

		$Shipping_option = Shipping_option::select('shipping_options.*', 'shipping_companies_data.title', 'shipping_companies_data.description')
			->join("shipping_companies_data","company_id","shipping_company_id")
			->whereIn('shipping_options.id', $cities_shipping_options)
			->whereNull("shipping_companies_data.source_id")
			->get();
		return response()->json($Shipping_option);
	}

	public function index(shippingOptionDataTable $shipping_option)
	{
		return $shipping_option->render('admin.shipping.shipping_option.index');
	}

	public function create(shippingOptionDataTable $shipping_option)
	{
		$companies = shippingCompanies::pluck('title', 'id');
		$countries = countries::leftJoin('countries_data', 'countries_data.country_id', 'countries.id')->where("countries_data.lang_id", getLang())->select("countries_data.*")->get();
		return view('admin.shipping.shipping_option.create', compact('companies', 'countries'));
	}

	public function store(Request $request)
	{

		$data = $this->validate($request, [
			'delay' => 'required',
			'cost' => 'sometimes',
			'company_id' => 'required',
			'country' => 'required',
			'cash_delivery_commission' => 'numeric|sometimes',
		]);

		$sessionStore = MyFatoorah::get_store_id();
		if ($sessionStore == \App\Bll\Utility::$demoId) {
			return redirect()->back()->with('flash_message', _i('Added Successfully'));
		}

		if ($request['shipping_type'] == 'constant') {
			$cost = $request['cost'];
		} else {
			$cost = null;
		}
		$Shipping_option = Shipping_option::create(['delay' => $request['delay'], 'company_id' => $request['company_id'], 'cost' => $cost, 'cash_delivery_commission' => $request['cash_delivery_commission'], 'country_id' => $request['country'], 'lang_id' => 1]);
		$Shipping_option->cities()->attach($request['cities']);
		if ($request['shipping_type'] == 'weight') {
			Shipping_type::create(['shipping_option_id' => $Shipping_option->id, 'no_kg' => $request['no_kg'], 'cost_no_kg' => $request['cost_no_kg'], 'cost_increase' => $request['cost_increase'], 'kg_increase' => $request['kg_increase']]);
		}
		return redirect()->back()->with('flash_message', _i('success message'));
	}

	public function edit($id)
	{
		$shipping_option = Shipping_option::where('id' , $id)->first();
		$companies = shippingCompanies::pluck('title', 'id');
		$countries = countries::leftJoin('countries_data', 'countries_data.country_id', 'countries.id')->get();
		return view('admin.shipping.shipping_option.edit', compact('shipping_option', 'companies', 'countries'));
	}

	public function update(Request $request, $id)
	{

		$shipping_option = Shipping_option::where('id' , $id)->first();

		if ($request['shipping_type'] == 'constant') {
			$cost = $request['cost'];
		} else {
			$cost = null;
		}

		$shipping_option->company_id = $request->company_id;
		$shipping_option->country_id = $request->country;
		$shipping_option->cost = $cost;
		$shipping_option->delay = $request->delay;
		$shipping_option->cash_delivery_commission = $request->cash_delivery_commission;

		$shipping_option->update();


		if ($request['shipping_type'] == 'weight') {
			$shipping_type = Shipping_type::where('shipping_option_id', $shipping_option->id)->first();
			$shipping_type->no_kg = $request->no_kg;
			$shipping_type->cost_no_kg = $request->cost_no_kg;
			$shipping_type->cost_increase = $request->cost_increase;
			$shipping_type->kg_increase = $request->kg_increase;
		}

		$cities_shipping_options = Cities_shipping_option::where('shipping_option_id', $shipping_option->id)->delete();

		$shipping_option->cities()->attach($request['cities']);

		return redirect()->back()->with('flash_message', _i('success message'));

	}

	public function delete($id)
	{
		$shipping_option = Shipping_option::where('id' , $id)->first();
		$shipping_option->cities()->detach();
		$shipping_option->delete();
		return redirect()->back()->with('flash_message', _i('success delete'));
	}

	public function getcities(Request $request)
	{
		if ($request->ajax()) {
			$cities = cities::
			leftJoin('city_datas','cities.id','=','city_datas.city_id')
			->where('country_id', $request->country)
			->where('city_datas.lang_id', Lang::getSelectedLangId())
			->pluck('city_datas.title', 'cities.id');
			return response()->json($cities);
		}
	}

	public function getCitiesByCountry($country)
	{
		$country = json_decode($country);

		$cities = cities::
		leftJoin('city_datas','cities.id','=','city_datas.city_id')->
		where('country_id', $country)->where("city_datas.lang_id", Lang::getSelectedLangId())
			->get();
		return response()->json($cities);
	}

	public function getCityById($id)
	{
		$lang_id = Lang::getSelectedLangId();
		$cities = cities::select('cities.*', 'city_datas.title', 'countries_data.title AS country_title')
		->Join('city_datas','cities.id','=','city_datas.city_id')
		->Join('countries_data','cities.country_id','=','countries_data.country_id')
		->where('cities.id', $id)
		->where('city_datas.lang_id', $lang_id)
		->where('countries_data.lang_id', $lang_id)
		->first();
		return response()->json($cities);
	}
}
