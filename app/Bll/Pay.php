<?php

namespace App\Bll;

use App\Admin;
use App\Bll\Offers\AfterPayment;
use App\Discount;
use App\discount_promotors;
use App\DiscountTransaction;
use App\DiscountUser;
use App\Language;
use App\Mail\CustomerOrderConfirm;
use App\Transaction;
use App\UserPoint;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Notification;

use function GuzzleHttp\Promise\exception_for;

class Pay
{
	private $order_id, $amount, $payment_id, $payment_method, $user, $email, $currency;
	public function __construct($user, $order_id, $amount, $payment_id, $method_id, $email, $currency = "USD")
	{
		$this->user = $user;
		$this->order_id = $order_id;
		$this->amount = $amount;
		$this->payment_id = $payment_id;

		$this->payment_method = $method_id;
		$this->email = $email;
		$this->currency = $currency;
	}

	public function Process()
	{
		//dd(session()->all());
		$params = [
			'order_id' => $this->order_id,
			//'type_id' => null,
			'type' => 'online',
			'status' => 'paid',
			'currency' => $this->currency,
			'payment_gateway' => $this->payment_method,
			'payment_email' => $this->email,
			'payment_id' => $this->payment_id,
			'total' => $this->amount,
			'user_id' => $this->user->id,
			'transaction_type' => 'pay'
		];
		$transaction = Transaction::create($params);

		foreach (getCartProducts() as $product) {
			if (!empty($product->points)) {
				UserPoint::create([
					'user_id' => $this->user->id,
					'product_id' => $product->id,
					'product_quantity' => $product->quantity,
					'points' => $product->points,
					'sum_points' => $product->quantity * $product->points,
				]);
			}
		}
		$after = new AfterPayment($transaction);
		$after->check();

		DB::transaction(function () use ($transaction) {
			$new_discount = Session::get('new_discount');
			if ($new_discount) {
				$calc_discount = NewDiscount::check($new_discount['code'], $new_discount['total']);
			}

			if (!empty($calc_discount)) {

				$code = Session::get('discount_data');


				DiscountTransaction::create([
					'transaction_id' => $transaction->id,
					'discount_id' => $code['new_discount_id'],
					'type' => $code['calc_type'],
					'value' => $code['value'],
					'user_id' => auth()->user()->id,
					'code' => $code['code']
				]);

				if ($code['dis_type'] == 'free' || ($code['dis_type'] == 'general' && $code['promotor_code'] == null)) {

					$user_discount = DiscountUser::where('user_id', auth()->user()->id)->where('discount_id', $code['new_discount_id'])->first();
					$user_discount->update([
						'counter' => $user_discount->counter + 1
					]);
				}

				if ($code['dis_type'] == 'general' && $code['user_code'] == null) {

					$promotor_discount = discount_promotors::where('promotor_id', $code['promotor_id'])->where('discount_id', $code['new_discount_id'])->first();
					$promotor_discount->update([
						'counter' => $promotor_discount->counter + 1
					]);
				}

				$discount = Discount::find($code['new_discount_id']);
				$discount->update([
					'using_times' => $discount->using_times + 1
				]);
			}
		});

		$this->user->update(['product_points' => 0]);
		$affiliate = new Affiliate($this->order_id);
		$affiliate->calculate();

		update_products_quantity($this->order_id);
		clear_user_cart();
		$this->sendNotification();
	}
	private function sendNotification()
	{

		$names = [];
		$text = [];
		foreach (Language::get() as $lang) {
			if ($lang->code == 'ar') {
				$names['ar'] = _i('order added successfuly');
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
			'order_url' => url('admin/orders/' . $this->order_id . '/show'),
			'order_id' => $this->order_id,

		];
		$settings = get_settings();

		Notification::send(Admin::all(), new \App\Notifications\OrderNotification($orderData));
		try {
			Mail::send($this->user->email, new CustomerOrderConfirm($this->user, null, $this->order_id, null, null, null, null));
			Mail::send($settings->email, new CustomerOrderConfirm($this->user, null, $this->order_id, null, null, null, null));
		} catch (Exception $e) {
			//error_log($e->getMessage());
			Log::error($e->getMessage());

		}
	}
}
