<?php

namespace App\Bll;

use App\Models\AbandonedCart;
use App\Models\Language;
use App\Modules\Admin\Models\Orders;
use App\Modules\Admin\Models\Products\Product;
use App\Modules\Admin\Models\Settings\Setting;
use App\Modules\Orders\Models\order_products;
use App\Modules\Orders\Models\PaymentGate;
use App\Modules\Orders\Models\Shipping\Shipping;
use App\Modules\Orders\Models\Shipping\Shipping_option;
use App\Modules\Orders\Models\Transaction;
use Carbon\Carbon;
use Essam\TapPayment\Payment;
use Exception;
use GuzzleHttp\Psr7\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redirect;

class EndOrder
{
    private $product;
    private $total;

    private $details;
    private $user;

    public function __construct($details = null)
    {
        $this->details = $details;
        $this->user    = Auth::user()->id;
    }

    private function totalAfterTax()
    {
        $settings = Setting::first();
        if ($settings) {
            $tax = $settings->tax_on_product;
            return $this->product->price + ($this->product->price * ($tax / 100));
        }
    }
    public function products()
    {
        //dd($this->details);
        $carts = AbandonedCart::where('user_id', $this->user)->get();
        $shipping = Shipping_option::find($this->details['shipping_option']);
        $order = Orders::create([
            'user_id'     =>  Auth::user()->id,
            'status'      =>  'wait',
            'ordernumber' =>  rand(1111111, 9999999),
            'currency'    =>  'SAR',
            'shipping_option_id'  =>  $this->details['shipping_option'],
            'shipping_cost'  => $shipping->cost,
            'created_by'     => Auth::user()->id,
        ]);
        foreach ($carts as $cart) {
            order_products::create([
                'product_id' => $cart->item_id,
                'order_id'   => $order->id,
                'count'      => $cart->qty,
                'price'      => $cart->total_price,
            ]);
            $product = Product::where('id', $cart->item_id)->first();
            if ($product->stock != null && $product->stock > 0) {
                $product->update([
                    'stock' => $product->stock - 1
                ]);
            }
            $order->update(['total' => $order->total + $cart->qty * $cart->total_price]);
        }

        $this->saveShipping($order->id, $this->details);
        return $this->paymentTab($order);
    }


    private function paymentTab($order)
    {
        $key = Config::get('app.key_tab');

        $TapPay = new Payment(['secret_api_Key' => $key]);

        $redirect = false; // return response as json , you can use it form mobile web view application

        $payment = $TapPay->charge([
            'amount' => $order->total + $order->shipping_cost,
            'currency' => 'SAR',
            'threeDSecure' => 'true',
            'description' => 'mashora payment',
            'statement_descriptor' => 'mashora',
            'customer' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
            'source' => [
                'id' => 'src_card'
            ],
            'post' => [
                'url' => null
            ],
            'redirect' => [
                'url' => url("orders/redirect?order_id=$order->id")
            ]
        ], $redirect);
        return Redirect::to($payment->transaction->url);
    }
    public function orderRedirect($request)
    {
        $key = Config::get('app.key_tab');
        $secret_api_Key = $key;
        $TapPay = new Payment(['secret_api_Key' => $secret_api_Key]);
        $charge_id = $request->get('tap_id'); // from tap getaway response url
        $Charge =  $TapPay->getCharge($charge_id);
        if ($Charge != null && isset($Charge->object) && $Charge->object == "charge" && isset($Charge->status) && $Charge->status == "CAPTURED") {
            if (isset($request->order_id)) {

                $this->notification($request->order_id);
                $this->saveTransaction($request->order_id);
                return Redirect::to('thankScreen');
            }
        }
        dd('Error happend');
    }

    private function notification($order_id)
    {
        $names = [];
        $text = [];
        foreach (Language::get() as $lang) {
            if ($lang->code == 'ar') {
                $names['ar'] = _i('تم انشاء الطلب بنجاح');
                $text['ar'] = _i('client create order');
            }
            if ($lang->code = 'en') {
                $names['en'] = _i('order added successfuly2');
                $text['en'] = _i('client create order');
            }
        }
        $orderData = [
            'name' => $names,
            'orderText' =>  $text,
            'order_url' => url('order/' . $order_id),
            'order_id' => $order_id,

        ];

        Notification::send(auth()->user(), new \App\Notifications\OrderNotification($orderData));
    }

    private function saveTransaction($order_id)
    {
        $order = Orders::find($order_id);
        $gate = PaymentGate::where('name', 'Tabs')->first();
        Transaction::create([
            'order_id'        => $order->id,
            'total'           => $order->total,
            'currency'        => 'SAR',
            'payment_gateway' => $gate->id,
            'status'          => 'paid',
            'user_id'         => $this->user
        ]);
        AbandonedCart::where('user_id', $this->user)->delete();
    }

    private function saveShipping($order_id, $details)
    {
        if ($details['shipping_option'] != NULL) {
            Shipping::create([
                'country_id' => $details['country'],
                'city_id' => $details['city'],
                'order_id' => $order_id,
                'region' => $details['region'],
                'street' => $details['street'],
            ]);
        }
    }
}
