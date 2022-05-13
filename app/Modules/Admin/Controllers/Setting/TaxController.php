<?php

namespace App\Modules\Admin\Controllers\Setting;

use App\Bll\Lang;
use App\Http\Controllers\Controller;

use App\Models\Language;
use App\Modules\Admin\Models\countries;
use App\Modules\Admin\Models\Settings\Setting;
use App\Modules\Admin\Models\Settings\Tax;
use App\Modules\Admin\Models\Settings\TaxData;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TaxController extends Controller
{
	public function index()
	{
		$setting = Setting::first();
		$countries = countries::leftJoin('countries_data','countries_data.country_id','countries.id')
			->select('countries.id as id','countries_data.title')
			->where('countries_data.lang_id', Lang::getSelectedLangId())
			->get();

		$taxs = Tax::leftJoin('countries_data','countries_data.country_id','tax.country_id')
			->select('tax.*','countries_data.title')
			->where('countries_data.lang_id', Lang::getSelectedLangId())
			->get();

		$languages = Language::all();

		return view('admin.settings.tax.index', compact('countries','setting','taxs', 'languages'));
	}

	public function storeTax(Request $request)
	{
		if ($request->ajax()) {
			$rules = [
				'tax' => 'required|max:3',
				'country_id' => 'required',
				'name' => 'required',
				'lang_id' => 'required',
			];

			$validator = validator()->make($request->all(), $rules);
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			} else {
				$taxs= Tax::create([
					'tax' => $request->tax,
					'country_id' => $request->country_id,
				]);
				TaxData::create(['name' => $request->name, 'tax_id' => $taxs->id, 'lang_id' => $request->lang_id]);
			}
		return response()->json(['status' => 'success']);
		}
	}

	public function storeTaxNumb(Request $request,$id)
	{
		$setting = Setting::where("id", $id)->first();
		$countries = countries::leftJoin('countries_data','countries_data.country_id','countries.id')
			->select('countries.id as id','countries_data.title')
			->where('countries_data.lang_id', Lang::getSelectedLangId())
			->get();
		$rules = [
				'taxnumb' => 'required|max:191'
			];

			$validator = validator()->make($request->all(), $rules);
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			} else {
				$setting->taxnumb = $request->taxnumb;
				$setting->save();
			}
			return redirect('/admin/tax')->with('flash_message', _i('Updated Successfully !'));
	}

	public function storeTaxOption(Request $request)
	{
		if ($request->ajax()) {

			$rules = [
				'tax' => 'required|max:3',
				'country_id' => 'required',
			];

			$validator = validator()->make($request->all(), $rules);
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			} else {
				$taxs= Tax::create([
				'tax' => $request->tax,
				'country_id' => $request->country_id,
				'store_id' => session('StoreId'),
			]);
			}
		return response()->json(['status' => 'success']);
		}
	}

	public function storeOptions(Request $request, $id)
	{
		$setting = Setting::where("id", $id)->first();

		if ($request->has('tax_on_shipping')) {
			$setting->tax_on_shipping = $request->tax_on_shipping;
		} else {
			$setting->tax_on_shipping = 0;
		}

		if ($request->has('tax_on_product')) {
			$setting->tax_on_product = $request->tax_on_product;
		} else {
			$setting->tax_on_product = 0;
		}

		$setting->save();

		return response()->json(['status' => 'success']);
	}

	public function getDatatabletaxs()
	{
		$lang_id = Lang::getSelectedLangId();

		$taxs = Tax::select('tax.*','countries_data.title', 'taxs_data.name')
			->join('countries_data','countries_data.country_id','tax.country_id')
			->join('taxs_data','taxs_data.tax_id','tax.id')
			->where('countries_data.lang_id', $lang_id)
			->where('taxs_data.lang_id', $lang_id)
			->get();

		return DataTables::of($taxs)
			->addColumn('action', function ($taxs) {
				$languages = Language::get();
				$options = '';
				foreach ($languages as $lang) {
				$options .= '<li ><a href="#" data-toggle="modal" data-target="#langedit" class="lang_ex" data-id="'.$taxs->id.'" data-lang="'.$lang->id.'" style="display: block; padding: 5px 10px 10px;">'.$lang->title.'</a></li>';
				}
				$html = '
				<div class="btn-group">
					<button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"  title=" '._i('Translation').' ">
					<span class="ti ti-settings"></span>
					</button>
					<ul class="dropdown-menu" style="right: auto; left: 0; width: 5em; " >'.$options.'</ul>
				</div> ';

				$html .= '<a href ="#" data-id="'.$taxs->id.'" data-tax="'.$taxs->tax.'" data-country="'.$taxs->country_id.'" data-name="'.$taxs->name.'" data-toggle="modal" data-target="#edit"
				class="btn waves-effect waves-light btn-primary edit text-center" title="'._i("Edit").'"><i class="ti-pencil-alt"></i></a>  &nbsp;' . '
				<form class=" delete"  action="' . route("taxs.destroy", $taxs->id) . '"  method="POST" id="deleteRow"
				style="display: inline-block; right: 50px;" >
				<input name="_method" type="hidden" value="DELETE">
				<input type="hidden" name="_token" value="' . csrf_token() . '">
				<button type="submit" class="btn btn-danger" title=" ' . _i('Delete') . ' "> <span> <i class="ti-trash"></i></span></button>
				 </form>
				</div>';

				return $html;
			})
			->rawColumns([
				'action'
			])
			->make(true);
	}

	public function update_taxs(Request $request, $id)
	{
		$taxs = Tax::find($id);

		$rules = [
			'tax' => 'required|max:3',
			'country_id' => 'required',
		];

		$validator = validator()->make($request->all(), $rules);
		if ($validator->fails())
		{
			return redirect()->back()->withErrors($validator)->withInput();
		}

		$taxs->tax = $request->tax;
		$taxs->country_id = $request->country_id;

		$taxs->save();
		return response()->json(['status' => 'success']);
	}

	public function taxs_destroy($id)
	{
		$tax = Tax::findOrFail($id);
		$tax->delete();
		return redirect()->back()->with('flash_message', _i('Deleted Successfully !'));
	}

	public function updateTaxStatus(Request $request) {
		$setting = Setting::find(1);
		Setting::where('id', 1)->update(['tax_on_shipping' => $request->val]);
		return $setting->tax_on_shipping;
	}

	public function updateTaxStatusnumb(Request $request) {
		$setting = Setting::find(1);
		Setting::where('id', 1)->update(['tax_on_product' => $request->val]);
		return $setting->tax_on_product;
	}

	public function translation(Request $request)
	{
		$rowData = TaxData::where('tax_id', $request->transRow)
			->where('lang_id', $request->lang_id)
			->first(['name']);
		if (!empty($rowData)){
			return \response()->json(['data' => $rowData]);
		}else{
			return \response()->json(['data' => false]);
		}
	}

	public function storeTranslation(Request $request)
	{
		$rowData = TaxData::where('tax_id', $request->id)
			->where('lang_id' , $request->lang_id)
			->first();
		if ($rowData != null) {
			$rowData->update([
				'name' => $request->name,
			]);
		}else{
			TaxData::create([
				'name' => $request->name,
				'lang_id' => $request->lang_id,
				'tax_id' => $request->id
			]);
		}
		return \response()->json("SUCCESS");
	}
}
