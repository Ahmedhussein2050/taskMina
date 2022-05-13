<?php

namespace App\Modules\Admin\Controllers\Roles;

use App\Bll\Lang;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class RolesController extends Controller
{
    public function index()
    {
        $lang_id = Lang::getSelectedLangId();
        $permissions = Permission::
        join('permission_data', 'permissions.id', 'permission_data.permission_id')
            ->where('guard_name', 'site')
            ->where('permission_data.lang_id', $lang_id)
            ->get();

        if (request()->ajax()) {
            $roles = Role::where('guard_name', 'site')->get();
            return DataTables::of($roles)
                ->editColumn('options', function($query) {
                    $html = "<a href='#' class='btn btn-info edit-row' data-toggle='modal' data-target='#default-Modal' data-url='".route('site.admin.roles.edit', $query->id)."'>Edit</a>";
                    $html .= "<a href='#' class='btn btn-danger ml-2 btn-delete' data-url='".route('site.admin.roles.destroy', $query->id)."'>Delete</a>";
                    return $html;
                })
                ->rawColumns([
                    'options',
                ])
                ->make(true);
        }
        return view('admin.roles', compact('permissions'));
    }

    public function edit( $id )
    {
        $role = Role::find($id);
        $permissions = $role->permissions->pluck('name');
        return ['role' => $role, 'permissions' => $permissions];
    }

    public function store( Request $request )
    {
        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'site'
        ]);
        $role->givePermissionTo($request->permissions);
        return response()->json('success');
    }

    public function update( Request $request, $id )
    {
        $role = Role::find($request->id);
        $role->update([
            'name' => $request->name
        ]);
        $role->syncPermissions($request->permissions);
        return response()->json('success');
    }

    public function destroy($id)
    {
        Role::query()->find($id)->delete();
    }
}
