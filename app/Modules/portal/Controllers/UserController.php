<?php

namespace App\Modules\portal\Controllers;

use App\Bll\Utility;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Admin\Models\Orders;
use App\Modules\Admin\Models\Products\Country;
use App\Modules\Admin\Models\Products\Product;
use App\Modules\Admin\Models\UserBalance;
use App\Modules\Notification\Models\Notifications;
use App\Modules\portal\Models\Favourite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public function index()
    {
        $countries = Country::with('data')->get();
        return view('portal.user.account.user_info', compact('countries'));
    }


    public function updateUser(Request $request)
    {
        //dd($request->all());
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'gender' => ['required'],
            'phone' => ['numeric', 'nullable']
        ];

        $request->validate($rules);
        $user = User::find(auth()->user()->id);
        $user->update([
            'name' => $request->name,
            'last_name' => $request->lastname,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
        ]);
        return response('success');
    }

    public function favourite()
    {
        $products = Product::whereHas('favourite')->where("stock", '>',0)->get();
        return view('portal.user.account.favourite', compact('products'));
    }

    public function orders()
    {
        $orders = Orders::with('products')->where('user_id', auth()->user()->id)->get();
        return view('portal.user.account.orders', compact('orders'));
    }
    public function balance()
    {
        $balances = UserBalance::where('user_id', auth()->user()->id)->get();

        return view('portal.user.account.balance', compact(('balances')));
    }

    public function notificationTrash(Request $request)
    {

        Notifications::where('id', $request->id)->delete();

        return response()->json(['success']);
    }

    public function notificationRead(Request $request)
    {

        Notifications::where('id', $request->id)->update([
            'read_at' => Carbon::now()
        ]);

        return response()->json(['success']);
    }

    public function notificationshow(Request $request)
    {

       $notfications = Notifications::where('notifiable_id', auth()->user()->id)->orderBy('read_at', 'asc')->paginate(10);

        return view('portal.include.show_notifications',compact('notfications'));
    }
}
