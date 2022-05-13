<?php

namespace App\Modules\Admin\Controllers\Users;

use App\Bll\Utility;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    public function help($query): string
    {
        $fullCreatedAt = preg_replace('/[[:space:]]/', ' - ', $query);
        $oldTimeStamp = substr($fullCreatedAt, strrpos($fullCreatedAt, '- ') + 1);
        $newTimeStamp  = date("g:i a", strtotime($oldTimeStamp));
        $oldDateStamp = substr($fullCreatedAt, 0, strpos($fullCreatedAt, ' -'));
        $newDateStamp = Carbon::parse($oldDateStamp)->format('d M Y');
        $day = Carbon::parse($oldDateStamp)->format('l');
        $fullCreatedAt = str_replace(
            [$oldTimeStamp, $oldDateStamp],
            [$newTimeStamp, $newDateStamp],
            $fullCreatedAt
        );
        return substr($day, 0, 3).' - '.preg_replace('/[[:space:]]+-/', ' || ', $fullCreatedAt);
    }
    public function index(){
        $users = User::all();
        if (request()->ajax()) {
            return DataTables::of($users)
                ->addColumn('active', function ($query) {
                    return "<a href data-id='".$query->id."' class='btn btn-warning change-active'>"._i('Change Activity')."</a>";
                })
                ->addColumn('created_at', function ($query) {
                    return Utility::dates($query->created_at);
                })
                ->addColumn('updated_at', function ($query) {
                    return Utility::dates($query->updated_at);
                })
                ->addColumn('edit', function ($query) {
                    return '<a href id="edit_user" data-id="'.$query->id.'" class="text-decoration-none btn btn-success" data-toggle="modal" data-target="#modal_edit_userPass">'._i('Edit Password').'</a>';
                })
                ->rawColumns(['created_at', 'updated_at', 'active', 'edit'])
                ->make(true);
        }
        return view('users.index');
    }
    public function update(){
        $user = User::query()->find(request()->id);
        $user->is_active = $user->is_active==1? 0 : 1;
        $user->save();
        if ($user->save()){
            return response()->json();
        }
    }
    public function change_pass(Request $request){
        $validator = Validator::make($request->all(), [
            'password'=>'required|confirmed'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        } else {
            $user = User::query()->find($request->id);
            $user->password = Hash::make($request->password);
            $user->save();
            return response()->json('success');
        }
    }
}
