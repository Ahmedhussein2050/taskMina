<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Bll;

use App\CartProductOption;
use App\Models\AbandonedCart;
use App\Models\ProductCustomFieldOption;
use App\Modules\Admin\Models\Orders;
use App\Modules\Admin\Models\Products\feature_data;
use App\Modules\Admin\Models\Products\feature_option_data;
use App\Modules\Admin\Models\Products\feature_options;
use App\Modules\Orders\Models\Order_status;
use App\Modules\Orders\Models\Stock;
use App\Modules\Orders\Models\Transaction as transactions;
use App\UserPoint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Description of Orders
 *
 * @author fz
 */
class Order
{

    function apply_discount_code_on_price(
        $price,
        $discount,
        $type
    )
    {
        if (empty($price)) return 0;
        if (empty($discount) || empty($type)) $discount = 0;

        $return = [];

        if ($type == 'perc') {
            $return['price'] = $price - ($discount / 100 * $price);
            $return['discount'] = $discount / 100 * $price;
        } elseif ($type == 'fixed') {
            $return['price'] = $price - $discount;
            $return['discount'] = $discount;
        } elseif ($type == 'item') {
            $return['price'] = 0;
            $return['discount'] = $price;
        }

        return $return;
    }

    //put your code here
    public static function getStatus()
    {
        $status = Order_status::leftJoin('order_status_datas', 'order_statuses.id', '=', 'order_status_datas.status_id')
            ->select(['order_statuses.*', 'order_status_datas.title'])
            ->where('order_status_datas.lang_id', Lang::getSelectedLangId())
            ->get();
        return $status;
    }

    public static function getCartProducts($order = 'ASC')
    {

        $return = [];
        if (Auth::check()) {

            $products = AbandonedCart::where('user_id', auth()->user()->id)
                ->with("product", "product.product_details")
                //->join("product_details","product_details.product_id","abandoned_carts.item_id")
                ->orderBy('abandoned_carts.id', $order)
                ->get();


            foreach ($products as $cproduct) {

                //	$product = products::where('products.id', $cproduct->item_id)->with('translation')->first();
                //				dd($product);
                $product = clone $cproduct->product;
                if (empty($product)) continue;
                $product->cart_id = $cproduct->id;
                $stocks = Stock::where('product_id', $product->id)
                    ->sum('quantity');

                if ($cproduct->qty < $stocks) {
                    $product->quantity = $cproduct->qty;
                } else {
                    $product->quantity = $stocks;
                }

                $product->affiliate_code = $cproduct->affiliate_code;

                if ($product->product_type == '54') // Donation
                {
                    if ($product->donation) {
                        $product->donation_amount = $cproduct['donation_amount'];
                    }
                }

                $options = CartProductOption::where('cart_id', $cproduct->id)->get();
                $options_price = 0;
                $options_data = [];

                foreach ($options as $option) {
                    if (empty($option)) continue;
                    $option = feature_options::find($option->option_id);


                    if (empty($option)) continue;
                    $option_data = feature_option_data::where('feature_option_id', $option->id)->where('lang_id', Lang::getSelectedLangId())->first();
                    $type = feature_data::where('feature_id', $option->feature_id)->where('lang_id', Lang::getSelectedLangId())->first();

                    if ($option_data != null) {
                        $option_data->type = $type ? $type->type : '';

//						array_push($options_data, $option_data);
                    }
//					if ($option_data != null) {
//						$option_data->type = $type ? $type->type : '';
//					}
                    $options_price += isset($option->price) ? $option->price : 0;
                    array_push($options_data, $option_data);
                }


                $product->options_price = $options_price;
                $product->options_data = $options_data;


                $custom_fields_price = 0;
                $product_custom_fields = isset($cproduct['custom_fields']) ? $cproduct['custom_fields'] : $cproduct->custom_fields;
                $custom_fields_array = json_decode($product_custom_fields, true);
                if (is_array($custom_fields_array)) {
                    foreach ($custom_fields_array as $custom_field) {
                        if (empty($custom_field)) continue;
                        if (!isset($custom_field['options'])) continue;
                        $price = ProductCustomFieldOption::whereIN('id', $custom_field['options'])->sum('price');
                        $custom_fields_price += $price;
                    }
                }

                $product->custom_fields = $product_custom_fields;
                $product->custom_fields_price = $custom_fields_price;
                $return[] = $product;
            }
        }


        // else {

        // 	$products = session()->get('cart') ?? [];
        // 	foreach ($products as $cproduct) {
        // 		$product = products::join('product_details', 'products.id', 'product_details.product_id')
        // 			->where('products.id', $cproduct['id'])

        // 			->where('lang_id', Lang::getSelectedLangId())
        // 			->select('products.*', 'product_details.title')
        // 			->first();

        // 		if (empty($product)) continue;

        // 		$product->quantity = $cproduct['quantity'];

        // 		if ($product->product_type == '54') // Donation
        // 		{
        // 			if ($product->donation) {
        // 				$product->donation_amount = $cproduct['donation_amount'];
        // 			}
        // 		}

        // 		$options_price = 0;
        // 		$options = $cproduct['options'];
        // 		foreach ($options as $option) {
        // 			$option = feature_options::find($option);
        // 			if (empty($option)) continue;
        // 			$options_price += $option->price;
        // 		}
        // 		$product->options_price = $options_price;

        // 		$custom_fields_price = 0;
        // 		$product_custom_fields = isset($cproduct['custom_fields']) ? $cproduct['custom_fields'] : $cproduct->custom_fields;
        // 		$custom_fields_array = json_decode($product_custom_fields, true);
        // 		if (!empty($custom_fields_array)) {
        // 			foreach ($custom_fields_array as $custom_field) {
        // 				if (empty($custom_field)) continue;
        // 				if (!isset($custom_field['options'])) continue;
        // 				$price = ProductCustomFieldOption::whereIN('id', $custom_field['options'])->sum('price');
        // 				$custom_fields_price += $price;
        // 			}
        // 		}

        // 		$product->custom_fields = $product_custom_fields;
        // 		$product->custom_fields_price = $custom_fields_price;

        // 		$return[] = $product;
        // 	}
        // }

        return $return;
    }

    public static function update_product_quantity($product_id, $quantity, $order_id)
    {
        foreach (self::getCartProducts() as $product) {
            Stock::create([
                'product_id' => $product_id,
                'quantity' => $quantity,
                'user_id' => auth()->user()->id,
                'order_id' => $order_id,

            ]);
        }
    }

    public static function getNext()
    {
        $orderNumber = orders::orderBy('id', 'desc')->first();
        if ($orderNumber != null) {
            $number = $orderNumber['ordernumber'] + 1;
        } else {
            $number = 1;
        }
        return $number;
    }

    private $order, $payment_type, $total, $user;

    public function __construct($order, $payment_type, $total, $user)
    {
        $this->order = $order;
        $this->payment_type = $payment_type;
        $this->user = $user;
        $this->total = $total;
    }

    public function buyByBalance()
    {
        $transaction = transactions::create([
            'order_id' => $this->order->id,
            'type' => $this->payment_type,
            'status' => 'complete',
            'payment_gateway' => $this->payment_type,
            'total' => $this->total,
            'user_id' => $this->user->id
        ]);
        if (!empty($user_points)) {
            $transaction = transactions::create([

                'order_id' => $this->order->id,
                'type_id' => null,
                'type' => 'points',
                'status' => 'complete',
                'payment_gateway' => 15,
                'total' => $user_points,
                'user_id' => $this->user->id,
                'points' => $this->user->product_points
            ]);

            UserPoint::create([

                'user_id' => $this->user->id,
                'points' => $this->user->product_points
            ]);

            $this->user->update(['product_points' => 0]);
        }

        $affiliate = new Affiliate($this->order->id);
        $affiliate->calculate();

        update_products_quantity($this->order->id);

        $this->newUserPoints();

        auth()->user()->update(['balance' => auth()->user()->balance - $this->total]);

        $this->clearUserCart();
    }

    function get_total($table)
    {
        return DB::table($table)->select('id')->count();
    }

    function get_total_updated($table)
    {
        return DB::table($table)->select('id')->where('updated', 1)->count();
    }

    public function BankTransfer()
    {
        $transaction = transactions::create([

            'order_id' => $this->order->id,
            'type_id' => null,
            'type' => $this->payment_type,
            'status' => 'pending',
            'bank_id' => $this->payment_type,
            'payment_gateway' => $this->payment_type,
            'total' => $this->total,
            'user_id' => $this->user->id
        ]);
        if (!empty($user_points)) {
            $transaction = transactions::create([

                'order_id' => $this->order->id,
                'type_id' => null,
                'type' => 'points',
                'status' => 'pending',
                'payment_gateway' => 15,
                'total' => $user_points,
                'user_id' => $this->user->id,
                'points' => $this->user->product_points
            ]);
        }
        update_products_quantity($this->order->id);
        $this->clearUserCart();
    }

    public function CashOnDelivery()
    {
        transactions::create([

            'order_id' => $this->order->id,
            'type_id' => null,
            'type' => $this->payment_type,
            'status' => 'pending',
            'payment_gateway' => 16,
            'total' => $this->total,
            'user_id' => $this->user->id
        ]);
        if (!empty($user_points)) {
            $transaction = transactions::create([

                'order_id' => $this->order->id,
                'type_id' => null,
                'type' => 'points',
                'status' => 'pending',
                'payment_gateway' => 15,
                'total' => $user_points,
                'user_id' => $this->user->id,
                'points' => $this->user->product_points
            ]);
        }
        update_products_quantity($this->order->id);
        $this->clearUserCart();
    }

    public function hyper($request)
    {
        $paymentName = PaymentGate::where('id', $request->payment_method)->first();

        $test = '';
        $paytype = '';
        if ($this->payment_type == 9) {
            $test = "&testMode=EXTERNAL";
        } else {
            $test = "";
        }

        if ($this->payment_type == 12 || $this->payment_type == 9 || $this->payment_type == 13) {
            $paytype = "PA";
        } else {
            $paytype = "DB";
        }

        $url = "https://test.oppwa.com/v1/payments";
        $data = "entityId=8ac7a4c974c45b1b0174cf086f6815ed" .
            "&amount=$this->total_price" .
            "&currency=SAR" .
            $test .
            "&paymentBrand=$paymentName->method" .
            "&paymentType=$paytype" .
            "&card.number=$request->card_number" .
            "&card.holder=$request->card_holder" .
            "&card.expiryMonth=$request->expire_month" .
            "&card.expiryYear=$request->expire_year" .
            "&card.cvv=$request->cvv" .
            "&shopperResultUrl=https://soinksa.com/ar";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGFjN2E0Yzk3NGM0NWIxYjAxNzRjZjA3NTZkMTE1ZTV8UjhjallNQzZRaw=='
        ));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);

        $data = json_decode($responseData, true);

        $idpay = '';
        if (substr($data['result']['code'], 0, 3) == '000') {
            $idpay = $data["id"];
            $transaction = transactions::create([

                'order_id' => $this->order->id,
                'type_id' => null,
                'type' => $this->payment_type,
                'status' => 'complete',
                'payment_gateway' => $this->payment_type,
                'total' => $this->total,
                'payment_id' => $idpay,
                'user_id' => $this->user->id
            ]);
        } else {
            return response()->json(['status' => 'error', 'payment' => $this->payment_type, 'message' => $data["result"]["description"]]);
        }
        $affiliate = new Affiliate($this->order->id);
        $affiliate->calculate();

        update_products_quantity($this->order->id);

        $this->newUserPoints();

        $this->clearUserCart();
    }

    private function clearUserCart()
    {
        $user_id = auth()->user()->id;
        $carts = AbandonedCart::where('user_id', $user_id)->get();

        foreach ($carts as $cart) {
            CartProductOption::where('cart_id', $cart->id)->delete();
            $cart->delete();
        }
    }

    private function newUserPoints()
    {

        $user_id = auth()->user()->id;
        $total = 0;
        foreach (self::getCartProducts() as $product) {
            if (empty($product->points)) continue;
            UserPoint::create([

                'user_id' => $user_id,
                'product_id' => $product->id,
                'product_quantity' => $product->quantity,
                'points' => $product->points
            ]);
            $total += $product->points * $product->quantity;
        }
        auth()->user()->update([
            'product_points' => auth()->user()->product_points + $total
        ]);
    }
}
