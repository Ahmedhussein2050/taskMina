<?php

namespace App\Modules\Admin\Controllers\Mails;

use App\Bll\Lang;
use App\Http\Controllers\Controller;

use App\Modules\Admin\Models\cities;
use App\Modules\Admin\Models\countries;
use App\Modules\Admin\Models\Imports\MailingListImport;
use App\Modules\Admin\Models\MailingList\MailingList;
use App\Modules\Admin\Models\MailingList\MailingListGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class MailingListController extends Controller
{

    public function index(Request $request)
    {
        if (request()->ajax()) {
            if($request->has('group'))
            {
                if($request->group == 0)
                {
                    $emails = MailingList::get();
                }
                else
                {
                    $group = MailingListGroup::find($request->group);
                    $emails = $group->emails()->get();
                    // dd($emails);
                }
            }
            elseif($request->has('country'))
            {
                if($request->country == 0)
                {
                    $emails = MailingList::get();
                }
                else
                {
                    $emails = MailingList::where('country_id', $request->country)->get();
                }
            }
            elseif($request->has('city'))
            {
                if($request->city == 0)
                {
                    $emails = MailingList::get();
                }
                else
                {
                    $emails = MailingList::where('city_id', $request->city)->get();
                }
            }
            else
            {
                $emails = MailingList::get();
            }
            return DataTables::of($emails)
                ->addColumn('actions', function ($email) {
                    $groups = $email->groups->pluck('id')->toJson();
                    return '<a href="'.route('mailing_list.update', $email->id).'" class="color-white btn waves-effect waves-light btn-primary edit text-center" title="'._i("Edit").'" data-email="'.$email->email.'" data-groups="'.$groups.'" data-country_id="'.$email->country_id.'" data-city_id="'.$email->city_id.'" data-toggle="modal" data-target="#edit-email-modal"><i class="ti-pencil-alt center"></i> '._i("Edit").'</a> <a href="'.route('mailing_list.destroy', $email->id).'" data-remote="'.route('mailing_list.destroy', $email->id).'" class="color-white btn btn-delete waves-effect waves-light btn btn-danger text-center" title="'._i("Delete").'"><i class="ti-trash center"></i> '._i("Delete").'</a>';
                })
                ->rawColumns([
                    'actions'
                ])
                ->make(true);
        }

        $countries = countries::select('countries.id', 'countries_data.title')
            ->join('countries_data', 'countries.id', 'countries_data.country_id')
            ->where('lang_id', Lang::getSelectedLangId())
            ->get();

        $cities = cities::select('cities.id', 'city_datas.title')
            ->join('city_datas', 'cities.id', 'city_datas.city_id')
            ->where('lang_id', Lang::getSelectedLangId())
            ->get();

        $emails = MailingList::get();
        $groups = MailingListGroup::join('mailing_list_groups_data', 'mailing_list_groups_data.group_id', 'mailing_list_groups.id')
            ->select('mailing_list_groups_data.name', 'mailing_list_groups.id', 'mailing_list_groups.icon')
            ->where('mailing_list_groups_data.lang_id', Lang::getSelectedLangId())
            ->get();
        return view('admin.mailing_list.index', compact('emails', 'groups', 'countries', 'cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', Rule::unique('mailing_list')],
        ]);

        if ($validator->passes()) {
            $email = MailingList::create([
                'email' => $request->email,
                'country_id' => $request->country,
                'city_id' => $request->city,
            ]);

            $email->groups()->attach($request->groups);

            return response()->json(true);
        }
        return response()->json(['errors' => $validator->errors()]);
    }

    public function import(Request $request)
    {
        Excel::import(new MailingListImport($request), request()->file('file'));
        return response()->json(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $email = MailingList::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'email' => ['required', Rule::unique('mailing_list')->ignore($id)],
        ]);

        if ($validator->passes()) {
            $email->update([
                'email' => $request->email,
                'country_id' => $request->country,
                'city_id' => $request->city,
            ]);

            $email->groups()->sync($request->groups);

            return response()->json(true);
        }
        return response()->json(['errors' => $validator->errors()]);
    }


    public function destroy($id)
    {
        $email = MailingList::findOrFail($id);
        $email->groups()->detach();
        $email->delete();
        return response()->json(true);
    }

    public function cities(Request $request)
    {
        $cities = cities::select('cities.id', 'city_datas.title')
            ->join('city_datas', 'cities.id', 'city_datas.city_id')
            ->where('lang_id', Lang::getSelectedLangId())
            ->where('country_id', $request->country_id)
            ->get();
        return $cities;
    }
}
