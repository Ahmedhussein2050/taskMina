<?php

namespace App\Modules\Admin\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{

    public function index()
    {
        $permissions = Permission::all();
        //		dd($permissions);
        return view('admin.role.index', compact('permissions'), ['title' => _i('Permissions')]);
    }

    public function create()
    {
        return view('admin.role.create', ['languages' => Language::all(), 'permissions' => $this->getPermissions()]);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => ['unique:roles', 'max:255']
        ];
        $validator = validator()->make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $role = Role::create(['name' => $request->name]);
            foreach ($request->groups as $key => $value) {
                $role->givePermissionTo($value);
            }
            return redirect()->back()->with('success', _i('Added Successfully !'));
        }
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions  = $this->getPermissions();
//        dd($permissions);
        $languages = Language::get();
        return view('admin.role.edit', compact('role', 'permissions', 'languages'));
    }


    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $rules = [
            'name' => ['required', 'max:255', Rule::unique('roles')->ignore($role->id)],
            'permissions' =>  ['required', 'array', 'min:1'],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $role->name = $request->input('name');
        $role->save();

        $permissions = $request->input('permissions');
        $role->syncPermissions($permissions);

        $users = $role->users()->get();
        foreach ($users as $user) {
            $user->syncPermissions($permissions);
        }
        return redirect()->back()->with('success', _i('Updated Successfully !'));
    }


    public function destroy($id)
    {
        $role = Role::with('users')->findOrFail($id);

        if ($role->users->isNotEmpty()) {
            // dd($role->users);
            session()->flash('error', _i('role is in use!'));
            return response()
                ->json(['error' => _i('role is in use!')]);
        }
        // dd($role->users);
        $role->delete();
        session()->flash('success', _i('Deleted Successfully !'));
        return response()
            ->json(['success' => _i('Deleted Successfully !')]);
    }

    public function dataTable()
    {
        $role = Role::query()
            // ->select(['id', 'name' ,'created_at', 'updated_at'])
            // ->where('guard_name', 'ad')
            ->get();


        return DataTables::of($role)
            ->addColumn('action', function ($role) {
                return '<a href="' . route('role.edit', $role->id) . '" class="btn waves-effect waves-light btn-primary edit text-center" title="' . _i("Edit") . '"><i class="ti-pencil-alt center"></i> </a>' .
                    '<a href="' . route('role.destroy', $role->id) . '" data-remote="' . route('role.destroy', $role->id) . '" class="btn btn-delete waves-effect waves-light btn btn-danger text-center" title="' . _i("Delete") . '"><i class="ti-trash center"></i> </a>';
            })
            ->make(true);
    }

    public function getPermissions($lang_id = null)
    {
        if ($lang_id == null) {
            $lang_id = Language::get()->first()->id;
        }
        //$package = get_store_package();
        //$permissions = $package->permissions->pluck('permission_id');
//        $permissions = Permission::query()->where('is_shown', 1)->get();
        // dd($permissions);
        // foreach ($permissions as $per)
        // {
        $permission_data = Permission::leftJoin('permission_data', 'permission_data.permission_id', 'permissions.id')
            ->select('permissions.name', 'permissions.id as id', 'permission_data.title as title', 'permission_data.lang_id as lang_id')
            ->where('permissions.is_shown', 1)
            ->where('permission_data.lang_id', $lang_id)
            ->get();
        // 	$perms[] = $permission_data;
        // }
        //	dd($permission_data);
        return $permission_data;
    }

    public function export(Request $request)
    {
        $spreadSheet = new Spreadsheet();
        $sheet = $spreadSheet->getActiveSheet();
        $roles = Role::get();

        $i = 1;

        $sheet->setCellValue('A' . $i, '#');
        $sheet->setCellValue('B' . $i, 'Name');
        $sheet->setCellValue('C' . $i, 'Guard Name');

        $i++;

        foreach ($roles as $role) {
            $sheet->setCellValue('A' . $i, $role->id);
            $sheet->setCellValue('B' . $i, $role->name);
            $sheet->setCellValue('C' . $i, $role->guard_name);

            $i++;
        }
        $writer = new Xlsx($spreadSheet);
        $writer->save('Roles.xlsx');
        return redirect()->to('Roles.xlsx');
    }
}
