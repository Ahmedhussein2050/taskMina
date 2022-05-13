<?php

namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index()
    {
    }

    public function showUsers(AdminsDataTable $admins)
    {
        return $admins->render('security.users.allUsers', ['type' => _('Admins')]);
    }

    public function createUser()
    {
        return view('security.users.add');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255', 'min:3'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else
        {
            $user = User::create([

                'name'     => $request->name,
                'lastname' => $request->lastname,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);
            return redirect()->back()->with('success', _i('Added Successfully !'));
        }
    }

    public function editUser($id)
    {
        $user = User::where('id' , $id)->first();
        return view('security.users.edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::where('id' , $id)->first();

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['sometimes', 'confirmed'],
        ];
        if (!is_null($request->password)) {
            $rules['password'] = ['confirmed', 'min:6'];
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else
        {
            $user->name = $request->input('name');
            $user->lastname = $request->lastname;
            $user->email = $request->input('email');

            if ($request->has('password') && $request->input('password') != null) {
                $user->password = bcrypt($request->password);
            }
            $user->save();

            return redirect( route('customers.edit', $user->id) )->with('success', _i('Updated Successfully !'));
        }
    }

    public function editProfile($id)
    {

        $user =	DB::table('users')->where('id',$id)->first();

        return view('security.users.editProfile', compact('user'));
    }

    public function deleteUser($id)
    {
        $user = User::where('id' , $id)->first();

        if ($id != User::first()->id) {
            if ($user->hasAnyRole(Role::all()) || $user->hasAnyPermission(Permission::all())) {
                $roles = $user->getRoleNames();
                $permissions = $user->getPermissionsViaRoles($roles);
                foreach ($permissions as $permission) {
                    $user->revokePermissionTo($permission);
                }
                foreach ($roles as $role) {
                    $user->removeRole($role);
                }
            }
            $user->delete();
            session()->flash('success', _i('Deleted Successfully !'));
            return Response::json(true);
        }
    }


    public function updatePassword(Request $request)
    {

        $id = auth()->guard("admin")->user()->id;
        $user = Admin::where('id' , $id)->first();
        $rules = [
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return redirect()->back()->withErrors($validator);

        $user->password = bcrypt($request->input('password'));
        $user->save();

        return redirect()->back()->withFlashMessage(_i('Password Changed Successfully !'));
    }
    public function updateprofile(Request $request)
    {
        $id = auth()->guard("admin")->user()->id;

        $user = Admin::where('id' , $id)->first();
        $rules = [
            'name' => ['required'],

        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return redirect()->back()->withErrors($validator);
// 		dd($user);
        $user->name = $request->name;
        $user->lastname = $request->lastname ;
        $user->phone = $request->phone ;
        $user->save();

        return redirect()->back()->withFlashMessage(_i('Updated Successfully !'));
    }

    public function editCustomerGroup(Request $request, $id)
    {
        $user = User::where('id' , $id)->first();
        $groups = Group::get();
        $user_groups = $user->groups->pluck('id')->toarray();
        return view('admin.userOrders.ajax.edit_customer_group', compact('user', 'groups', 'user_groups'));
    }

    public function updateCustomerGroup(Request $request, $id)
    {
        $user = User::where('id' , $id)->first();
        $user->groups()->sync($request->groups);
        return response()->json(true);
    }
}
