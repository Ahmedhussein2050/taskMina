<?php

namespace App\Modules\portal\Controllers;

use App\Bll\EndOrder;
use App\Bll\Utility;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Admin\Models\OrderRefund;
use App\Modules\Admin\Models\Orders;
use App\Modules\Admin\Models\Products\Country;
use App\Modules\Admin\Models\Products\Product;
use App\Modules\Orders\Models\order_products;
use App\Modules\portal\Models\Favourite;
use Essam\TapPayment\Payment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class OrdersController extends Controller
{


    protected function orderDetails($id)
    {
        $order = Orders::with(['orderProducts.product', 'shipping_option.company'])->where('user_id', auth()->user()->id)->find($id);
        if ($order == null) {
            abort(404);
        }
        return view('portal.user.account.order_details', compact('order'));
    }

    public function confirmOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shipping_option' => 'required',
            'country' => 'required',
            'city' => 'required',
            'region' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('cart')
                ->withErrors($validator)
                ->withInput();
        }
        $details = [
            "country" => $request->country,
            "city"    => $request->city,
            "region"  => $request->region,
            "street"  => $request->street,
            "shipping_option"  => $request->shipping_option,
        ];

        $order  = new EndOrder($details);
        return  $order->products();
    }

    protected function orderRedirect(Request $request)
    {
        $order  = new EndOrder();
        return  $order->orderRedirect($request);
    }

    protected function orderReturn(Request $request)
    {
        OrderRefund::create([
            'order_id' => $request->order_id,
            'comment' => $request->description,
        ]);

        $order = Orders::find($request->order_id);
        $order->update(['status' => 'refund']);

        return response('success');
    }


    protected function thankScreen(Request $request)
    {
        return view('portal.include.thank_screen');
    }
}
