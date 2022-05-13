<?php

namespace App\Modules\Admin\Controllers\Permissions;

use App\Bll\Lang;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\PermissionData;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class PermissionsController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $permission = Permission::select('permissions.*', 'permission_data.title', 'permission_data.lang_id')
                ->leftJoin('permission_data', 'permission_data.permission_id', 'permissions.id')
                ->where('permission_data.lang_id', Lang::getLang(session('locale')))
                ->where('permissions.guard_name' , "site");

            return DataTables::of($permission)
                ->addColumn('action', function ($permission) {
                    $html = '<button class="btn mr-1 ml-1 waves-effect waves-light btn-primary edit text-center" data-id ="'.$permission->id.'" data-name ="'.$permission->name.'" data-title ="'.$permission->title.'" data-lang_id ="'.$permission->lang_id.'" data-toggle="modal" data-target="#modal-edit"  title="'._i("Edit").'"><i class="ti-pencil-alt"></i> </button>' .
                        '<a href="'.route('site.admin.permissions.delete', $permission->id).'" data-remote="'.route('site.admin.permissions.delete', $permission->id).'" class="btn mr-1 ml-1 btn-delete waves-effect waves-light btn-danger text-center" title="'._i("Delete").'"><i class="ti-trash center"></i></a>';
                    $langs = Language::get();
                    $options = '';
                    foreach ($langs as $lang) {
                        // if ($lang->id != $permission->lang_id) {
                        $options .= '<li><a href="#" data-toggle="modal" data-target="#langedit" class="lang_ex" data-id="' . $permission->id . '" data-lang="' . $lang->id . '"style="display: block; padding: 5px 10px 10px;">' . $lang->title . '</a></li>';
                        // }
                    }
                    $html = $html . '
					<div class="btn-group">
						<button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"  title=" ' . _i('Translation') . ' ">
							<span class="ti ti-settings"></span>
						</button>
						<ul class="dropdown-menu">
							' . $options . '
						</ul>
					</div> ';
                    return $html;
                })
                ->make(true);
        }
        $languages = Language::get();

        return view('admin.security.permissions.permissions', compact('languages'));
    }

    public function edit( $id )
    {
        return Role::find($id);
    }

    public function store( Request $request )
    {
        $request->validate([
            'name' =>  array('required', 'max:255',
                Rule::unique('permissions')->where(function ($query) {
                    return $query->where('guard_name', 'site');
                })
            ),
            'title' =>  array('required', 'max:150'),
        ]);

        $permission = Permission::create([
            'name' => $request->name,
            'guard_name' => 'site',

        ]);
        PermissionData::create([
            'title' => $request->title,
            'lang_id' => Lang::getSelectedLangId(),
            'permission_id' => $permission->id,

        ]);

        $role = Role::where('name', 'Site')->first();
        $role->givePermissionTo($permission->name);

        return response()->json("SUCCESS");
    }

    public function update( Request $request)
    {
        $lang_id = Lang::getSelectedLangId();

        $request->validate([
            'name' =>  array('required', 'max:255',
                Rule::unique('permissions')->ignore($request->permission_id)->where(function ($query) {
                    return $query->where('guard_name', 'site');
                })
            ),
            'title' =>  array('required', 'max:150'),
        ]);

        $permission = Permission::findOrFail($request->permission_id);
        $permission_data = PermissionData::where('permission_id', $permission->id)
            ->where('lang_id', $lang_id)
            ->first();
        $permission->update([
            'name' => $request->name,
        ]);
        if ($permission_data == null) {
            $permission_data = PermissionData::create([
                'title' => $request->title,
                'lang_id' => $lang_id,

            ]);
        } else {
            $permission_data->update([
                'title' => $request->title,
                'lang_id' => $lang_id
            ]);
        }
        return response()->json("SUCCESS");
    }

    public function delete($id)
    {
        $permission = Permission::findOrFail($id);
        PermissionData::where('permission_id', $permission->id)->delete();
        $permission->delete();
        return response()->json(['data'=>true]);
    }

    public function getLangValue(Request $request)
    {
        $rowData = PermissionData::where('permission_id', $request->transRowId)
            ->where('lang_id', $request->lang_id)
            ->first(['title']);
        if (!empty($rowData)) {
            return response()->json(['data' => $rowData]);
        } else {
            return response()->json(['data' => false]);
        }
    }

    public function storeTranslation(Request $request)
    {
        $rowData = PermissionData::where('permission_id', $request->id)->where('lang_id', $request->lang_id_data)->first();
        if ($rowData !== null) {
            $rowData->update([
                'title' => $request->title,
                'lang_id' => $request->lang_id_data,
            ]);
        } else {
            $parentRow = PermissionData::where('permission_id', $request->id)->first();
            PermissionData::create([
                'title' => $request->title,
                'lang_id' => $request->lang_id_data,
                'permission_id' => $request->id,

            ]);
        }
        return response()->json("SUCCESS");
    }
}
