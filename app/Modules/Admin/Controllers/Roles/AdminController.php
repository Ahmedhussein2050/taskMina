<?php

namespace App\Modules\Admin\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{

    public function index()
    {

        if (request()->ajax()) {			$admin =Admin::where('guard' , 'admin');
            // dd($admin);
            return DataTables::of($admin)
                ->addColumn('image', function ($admin) {
                    $url = asset('/uploads/users/' . $admin->id . '/' . $admin->image);
                    return '<img src=' . $url . ' style="width: 80px; height: 80px;" class="img-responsive img-rounded" align="center" />';
                })
                ->addColumn('edit', function ($admin) {
                    return '<a href="'.route('admin.edit', $admin->id).'" class="btn waves-effect waves-light btn-primary edit text-center" title="'._i("Edit").'"><i class="ti-pencil-alt center"></i> '._i("Edit").'</a>';
                })
                ->addColumn('delete', function ($admin) {
                    return '<a href="'.route('admin.destroy', $admin->id).'" data-remote="'.route('admin.destroy', $admin->id).'" class="btn btn-delete waves-effect waves-light btn btn-danger text-center" title="'._i("Delete").'"><i class="ti-trash center"></i> '._i("Delete").'</a>';
                })
                ->rawColumns([
                    'edit',
                    'delete',
                    'image',
                ])
                ->make(true);
        }
        return view('admin.admin.index');
    }


    public function create()
    {
        $roles =  Role::where('guard_name', 'admin')->get();
        return view('admin.admin.create', compact('roles'));
    }
    public function AuthRouteAPI(Request $request){
        return $request->user();
    }

    public function store(Request $request)
    {
        //return $request->all() ;
        $rules =  [
            'name' => ['required', 'string', 'max:255', 'min:3'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'role' => ['required'],
        ];
        //		dd( Role::where('id' , $request->role)->first());
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $user = Admin::create([
                'name' => $request->name,
                'last_name' => $request->lastname,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'is_active' => 1 ,
                'guard' => 'admin',
            ]);

            $role = Role::where('id' , $request->role)->first();
            $permissions = $role->load('permissions');
            $user->assignRole($role['id']);

            foreach ($permissions->permissions as $perm)
            {
                $user->givePermissionTo($perm['name']);
                $user->save();
            }

            ///	dd(  $user->hasAnyPermission(['Products']));
            if( $request->hasFile('image') )
            {
                $request->validate([
                    'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                ]);

                $image_tmp = $request->file('image');
                $destinationPath = public_path('/uploads/users/'. $user->id);
                $extenstion = $image_tmp->getClientOriginalExtension();
                $fileName = rand(111, 99999).'.'.$extenstion;
                $image_tmp->move($destinationPath, $fileName);
                $request->image = $fileName;
                $user->image = $request->image;
                $user->save();
                //return $user ;
            }


            return redirect()->back()->with('success' ,_i('Added Successfully !'));
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $user = Admin::where('id',$id)->first();
////        $user = User::findorfail($id);
//        dd($user);
        $roles =  Role::where('guard_name', 'admin')->get();
        return view('admin.admin.edit', compact('user', 'roles'));
    }


    public function update(Request $request, $id)
    {
        $user = Admin::where('id' , $id)->first();
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'roles' => ['sometimes', 'min:1']
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $user->name = $request->input('name');
            $user->last_name = $request->input('lastname');
            $user->email = $request->input('email');
            $user->phone = $request->input('phone');

            if($request->has('roles'))
            {
                $user->syncRoles($request->roles);
                $permissions[] = $user->getPermissionsViaRoles($request->roles);
                $user->syncPermissions($permissions);
            }

            $user->save();

            return redirect(route('admin.edit', $user->id))->with( 'success',_i('Updated Successfully !')); // return if is update admin

        }
    }


    public function destroy($id)
    {
        $user = Admin::where('id' , $id)->first();
        if($user->hasAnyRole(Role::all()) || $user->hasAnyPermission(Permission::all()))
        {
            $roles = $user->getRoleNames();
            $permissions = $user->getPermissionsViaRoles($roles);
            foreach($permissions as $permission)
            {
                $user->revokePermissionTo($permission);
            }
            foreach($roles as $role)
            {
                $user->removeRole($role);
            }
        }
        $user->delete();
        return redirect()->back()->with('success', _i('Deleted Successfully !'));
    }

    public function changePassword(Request $request, $id)
    {
        $user = Admin::where('id' , $id)->first();
        $rules = [
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator);
        }

        $user->password = Hash::make($request->input('password'));
        $user->save();

        return redirect()->back()->with('success', _i('Password Changed Successfully !'));
    }

    public function export(Request $request){
        $spreadSheet = new Spreadsheet();
        $sheet = $spreadSheet->getActiveSheet();
        $roles = Admin::all();

        $i = 1;

        $sheet->setCellValue('A'.$i,'#');
        $sheet->setCellValue('B'.$i,'Name');
        $sheet->setCellValue('C'.$i,'Email');

        $i++;

        foreach ($roles as $role){
            $sheet->setCellValue('A'.$i,$role->id);
            $sheet->setCellValue('B'.$i,$role->name);
            $sheet->setCellValue('C'.$i,$role->email);
            $i++;
        }
        $writer = new Xlsx($spreadSheet);
        $writer->save('Admins.xlsx');
        return redirect()->to('Admins.xlsx');
    }
}
