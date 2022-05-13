<?php

namespace App\Modules\Admin\Controllers\Settings;

use App\Bll\Lang;
use App\Bll\Utility;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Modules\Admin\Models\Products\countries_data;
use App\Modules\Admin\Models\Products\Country;
use App\Modules\Admin\Models\Settings\City;
use App\Modules\Admin\Models\Settings\CityData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class CitiesController extends Controller
{
    public function index()
    {

        $country = Country::query()->where('code', 'SA')->first();
        $cities = city::with('dataa')->where('country_id', $country->id)->get();
        $langs = Language::all();
        if (request()->ajax()) {
            return DataTables::of($cities)
                ->addColumn('action', function ($query) {
                    $html = '<a href data-lat="' . $query->lat . '" data-lng="' . $query->lng . '" data-id="' . $query->id . '"  class="btn btn-success edit-btn ml-1" data-toggle="modal" data-target="#modal_create1">' . _i('Edit') . '</a>' .
                        '<a href data-id="' . $query->id . '" class="btn btn-danger delete-btn mx-1">' . _i('Delete') . '</a>';
                    $langs = Language::get();
                    $options = '';
                    foreach ($langs as $lang) {
                        if ($query->dataa) {
                            if ($query->dataa->where('lang_id', $lang->id)->first()) {
                                $name = $query->dataa->where('lang_id', $lang->id)->first();
                                $name = $name->title;
                            } else {
                                $name = '';
                            }
                        } else {
                            $name = '';
                        }
                        $options .= '<li ><a href="#" class="trans-btn ml-1 lang_ex" data-toggle="modal" data-target="#modal_trans1" data-name="' . $name . '" data-id="' . $query->id . '" data-lang="' . $lang->id . '"
						style="display: block; padding: 5px 10px 10px;">' . $lang->title . '</a></li>';
                    }
                    $html = $html . '
					 <div class="btn-group">
					   <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"  title=" ' . _i('Translation') . ' ">
						 <span class="ti ti-settings"></span>
					   </button>
					   <ul class="dropdown-menu" style="right: auto; left: 0; width: 5em; " >
						 ' . $options . '
					   </ul>
					 </div> ';
                    return $html;
                })
                ->addColumn('created_at', function ($query) {
                    return Utility::dates($query->created_at);
                })
                ->addColumn('name', function ($query) {
                    $coun = '';
                    if ($query->dataa) {
                        $coun =  $query->dataa->where('lang_id', Lang::getSelectedLangId())->first();
                        if ($coun  != null) {
                            $coun = $query->dataa->first()['title'];
                        } else {
                            $coun = '';
                        }
                    }
                    return $coun;
                })
                ->addColumn('updated_at', function ($query) {
                    return Utility::dates($query->updated_at);
                })
                ->rawColumns(['created_at', 'updated_at', 'action'])
                ->make(true);
        }
        return view('cities.index', compact('cities', 'langs'));
    }

    public function store(Request $request)
    {
        //        dd($request->all());
        $validator = Validator::make($request->all(), [
            'city_title' => 'required|String|Max:20',
            'lang_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json('fail');
        } else {
            $city = new city();
            //            dd($city);
            $country = Country::query()->where('code', 'SA')->first();
            $city->country_id = $country->id;
            $city->lat = $request->lat;
            $city->lng = $request->lng;
            $city->save();
            if ($city->save()) {
                $cityData = new CityData();
                $cityData->title = $request->city_title;
                $cityData->lang_id = $request->lang_id;
                $cityData->city_id = $city->id;
                $cityData->save();
                if ($cityData->save()) {
                    return response()->json('success');
                } else {
                    return response()->json('fail');
                }
            } else {
                return response()->json('fail');
            }
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lat' => 'required|Max:10',
            'lng' => 'required|Max:10',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        } else {
            //            dd($request->all());
            //            dd($cityData);
            $city = city::query()->find($request->city_id);
            $city->lat = $request->lat;
            $city->lng = $request->lng;
            $city->save();
            return response()->json('success');
        }
    }

    public function translate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'city_title' => 'required|Max:191',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        } else {
            $cityData = CityData::query()->where('lang_id', $request->lang)->where('city_id', $request->city_id)->first();
            if (!$cityData) {
                $cityData = new CityData();
                $cityData->lang_id = $request->lang;
                $cityData->city_id = $request->city_id;
            }
            $cityData->title = $request->city_title;
            $cityData->save();
        }
        return response()->json('success');
    }


    public function destroy(Request $request)
    {
        if ($request->id) {
            CityData::query()->where('city_id', $request->id)->delete();
            city::query()->find($request->id)->delete();
            return response()->json('SUCCESS');
        } else {
            return response()->json('fail');
        }
    }
}
