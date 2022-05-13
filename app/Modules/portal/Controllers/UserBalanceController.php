<?php

namespace App\Modules\portal\Controllers;

use App\Bll\Utility;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\User;
use App\Modules\Admin\Models\Orders;
use App\Modules\Admin\Models\Products\Country;
use App\Modules\Admin\Models\Products\Product;
use App\Modules\Admin\Models\UserBalance;
use App\Modules\Notification\Models\Notifications;
use App\Modules\Orders\Models\PaymentGate;
use App\Modules\Orders\Models\Transaction;
use App\Modules\portal\Models\Favourite;
use Essam\TapPayment\Payment;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Notification;

class UserBalanceController extends Controller
{


    public function balancePayment(Request $request)
    {
        if ($request->amount != null) {
            $key = Config::get('app.key_tab');
            $TapPay = new Payment(['secret_api_Key' => $key]);
            $redirect = false;
            $payment = $TapPay->charge([
                'amount' => $request->amount,
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
                    'url' => url("userbalance/redirect")
                ]
            ], $redirect);
            $this->balance($request);

            return Redirect::to($payment->transaction->url);
        }
    }
    private function balance($request)
    {
        if ($request->amount) {
            $gate = PaymentGate::where('name', 'Tabs')->first();
            $transaction = Transaction::create([
                'total'           => $request->amount,
                'currency'        => 'SAR',
                'payment_gateway' => $gate->id,
                'status'          => 'paid',
                'user_id'         => auth()->user()->id
            ]);
            UserBalance::create([
                'user_id' => auth()->user()->id,
                'balance' => $request->amount,
                'transaction_id' => $transaction->id,
                'description' => $request->details,
            ]);
        }
    }

    public function userRedirect(Request $request)
    {
        $key = Config::get('app.key_tab');
        $secret_api_Key = $key;
        $TapPay = new Payment(['secret_api_Key' => $secret_api_Key]);
        $charge_id = $request->get('tap_id');
        $Charge =  $TapPay->getCharge($charge_id);
        if ($Charge != null && isset($Charge->object) && $Charge->object == "charge" && isset($Charge->status) && $Charge->status == "CAPTURED") {
            $this->notification();
            return Redirect::to('thankScreen');
        }
        dd('Error happend');
    }
    private function notification()
    {
        $names = [];
        $text = [];
        foreach (Language::get() as $lang) {
            if ($lang->code == 'ar') {
                $names['ar'] = _i('تمت الاضافة الي محفظتك');
                $text['ar'] = _i('تمت الاضافة الي المحفظه');
            }
            if ($lang->code = 'en') {
                $names['en'] = _i('Added to wallet');
                $text['en'] = _i('Added to wallet');
            }
        }
        $orderData = [
            'name' => $names,
            'orderText' =>  $text,
            'order_url' => '',
            'order_id' => '',

        ];

        Notification::send(auth()->user(), new \App\Notifications\OrderNotification($orderData));
    }
}
