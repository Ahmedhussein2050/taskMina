<?php

namespace App\Modules\Admin\Controllers\Mails;

use App\Bll\Lang;
use App\Http\Controllers\Controller;

use App\Modules\Admin\Models\MailingList\MailingList;
use App\Modules\Admin\Models\MailingList\MailingListGroup;
use App\Modules\Admin\Models\MailingList\MailingListGroupData;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MailingListGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'name' => ['required'],
        ]);

        if ($validator->passes()) {
            $group = MailingListGroup::create([]);

            if ($request->hasFile('icon')) {
                $image_file = $request->file('icon');
                $filename = time() . '.' . $image_file->getClientOriginalExtension();
                $request->icon->move(public_path('uploads/mailing_list_groups/' . $group->id), $filename);
                $group->icon = '/uploads/mailing_list_groups/' . $group->id . '/' . $filename;
                $group->save();
            }

            MailingListGroupData::create([
                'name' => $request->name,
                'group_id' => $group->id,
                'lang_id' => Lang::getSelectedLangId(),
            ]);

            $group->emails()->attach($request->emails);

            return response()->json(true);
        }
        return response()->json(['errors' => $validator->errors()]);
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


    public function edit($id)
    {
        $emails = MailingList::get();
        $group = MailingListGroup::find($id);
       
        $group_emails = $group->emails->pluck('id')->toarray();
        return view('admin.mailing_list.ajax.edit_group', compact('emails', 'group', 'group_emails'));
    }


    public function update(Request $request, $id)
    {
        $group = MailingListGroup::findOrFail($id);

        $icon = $group->icon;

        if ($request->hasFile('icon')) {
            $image_file = $request->file('icon');
            $filename = time() . '.' . $image_file->getClientOriginalExtension();
            $request->icon->move(public_path('uploads/mailing_list_groups/' . $group->id), $filename);
            $icon = '/uploads/mailing_list_groups/' . $group->id . '/' . $filename;
        }

        $request->emails = $request->emails ?? [];

        $group->emails()->sync($request->emails);

        $group->update(['icon' => $icon]);

        return response()->json(true);
    }


    public function destroy($id)
    {
        $group = MailingListGroup::findOrFail($id);
        $group->emails()->detach();
        $group->delete();
        return response()->json(true);
    }
}
