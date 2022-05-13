<?php

namespace App\Bll\Offers;


use App\Modules\Admin\Models\Orders;
use App\Modules\Orders\Models\OffersAndDiscounts\Offer;
use App\Modules\Orders\Models\OffersAndDiscounts\OfferCode;
use App\Modules\Orders\Models\OffersAndDiscounts\OfferDuration;
use App\Modules\Orders\Models\OffersAndDiscounts\TransactionOffer;
use App\Notifications\VoucherNotification;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;

class AfterPayment
{

	private $transaction;
	public function __construct($transaction)
	{

		$this->transaction = $transaction;
	}

	public function check()
	{
		// dd(session()->all());
		$this->sendUserVoucherCode();

		$extra_offer = Session::get('extra');
		// dd($extra_offer);
		$free_offer = session("free_offer");
		//voucher code
		$new_offer = Session::get('new_offer');

		if ($extra_offer) {
			$this->applyExtra($extra_offer);
		}
		//voucher code
		if ($new_offer) {
			$this->applyVoucherCode($new_offer);
		}
		//buy n get n
		if ($free_offer != null && $free_offer['offer_total'] > 0) {
			$this->applyFree($free_offer);
			Session::forget("free_offer");
		}
		//check for duration offer and update using count
		// $order = orders::find(session("order_id"));
		// $duration_offers = $order->orderProducts->whereNotNull("offer_id"); //->get();
		// if ($duration_offers->count() > 0) {
		// 	foreach ($duration_offers as $item)
		// 		$this->UpdateUsedCount($item['offer_id']);
		// }
		$this->applyDuration();
	}

	private function applyDuration()
	{
		$order = orders::find(session("order_id"));

		$duration_offers = $order->orderProducts->whereNotNull("offer_id"); //->get();
		//dd($duration_offers, $order->orderProducts);
		$commissions = DB::table('vw_product_commession')->select("commession", "id")->whereIn("id", $duration_offers->pluck("product_id"))->get();
		//$arr_comm =($commissions->pluck("commession","id"));
		if ($duration_offers->count() > 0) {
			foreach ($duration_offers as $item) {

				$comm = $commissions->where("id", $item->product_id)->first();
				$val = 0;
				if ($comm != null) {
					$val = $comm->commession;
					$find = OfferDuration::where("offer_id", $item['offer_id'])->where("min_commition", "<=", $val)->where("max_commition", ">=", $val)->first();
					if ($find != null) {
						$val = $find->bonus;
					} else
						$val = 0;
				}
				TransactionOffer::create([
					'transaction_id' => $this->transaction->id,
					'offer_id' => $item['offer_id'],
					'user_id' => auth()->user()->id,
					"type" => "perc",
					'value' => $val
				]);
				$this->UpdateUsedCount($item['offer_id']);
			}
		}
	}
	private function applyFree($free_offer)
	{

		TransactionOffer::create([
			'transaction_id' => $this->transaction->id,
			'offer_id' => $free_offer['offer_id'],
			'user_id' => auth()->user()->id,
			'value' => $free_offer['offer_total']
		]);
		$this->UpdateUsedCount($free_offer['offer_id']);
	}

	private function sendUserVoucherCode()
	{

		$offer = Offer::join('offer_category', 'offer_category.id', 'offers.category_id')
			->select('offers.*')
			->where('active_bool', 1)
			->where('start_date', '<=', Carbon::now())
			->where('end_date', '>=', Carbon::now())
			->where('offer_limit', '>', 'using_counter')
			->whereIn('offer_category.code', ['voucher'])
			->first();
		if ($offer != null) {
			$this->transaction->order->total;
			$code = $offer->codes->whereNull("user_id")->first();
			$new = $code->replicate();
			$new->user_id = auth()->id();
			$new->limit = 1;
			$new->count = 0;
			$new->save();

			//$this->UpdateUsedCount($code->offer_id);

			Notification::send(auth()->user(), new VoucherNotification($new));
		}
	}

	private function applyVoucherCode($code)
	{
		TransactionOffer::create([
			'transaction_id' => $this->transaction->id,
			'offer_id' => $code['offer_id'],
			'type' => $code['calc_type'],
			'value' => $code['bonus'],
			'user_id' => auth()->user()->id,
			'code' => $code['code']
		]);

		$updateCode = OfferCode::where('code', $code['code'])->whereNull("user_id")->first();
		$updateCode->update([
			'count' => $updateCode->count + 1
		]);
		$this->UpdateUsedCount($code['offer_id']);
	}

	private function UpdateUsedCount($offer_id)
	{
		$offer = Offer::find($offer_id);
		$offer->update([
			'using_counter' => $offer->using_counter + 1
		]);
	}

	private function applyExtra($extra_offer)
	{
		$payment_method = $this->transaction->payment_gateway;
		$extra = new Extra();

		$calc_extra_offer = $extra->apply($payment_method, $extra_offer['product_ids']);
		if (!empty($calc_extra_offer)) {
			$data = $calc_extra_offer->getData();
			TransactionOffer::create([
				'transaction_id' => $this->transaction->id,
				'offer_id' => $data->id,
				'user_id' => auth()->user()->id,
				'value' => $data->data,
			]);
			$offer = Offer::find($extra_offer['offer_id']);
			$offer->update([
				'using_counter' => $offer->using_counter + 1
			]);
		}
	}

	// private function applyFree($free_offer)
	// {
	// 	return;

	// 	$calc_free_offer = \App\Bll\Offer::freeDurationOffer($free_offer['offer_id'], $free_offer['count'], $free_offer['total'], $free_offer['product_ids']);
	// 	if (!empty($calc_free_offer)) {
	// 		TransactionOffer::create([
	// 			'transaction_id' => $this->transaction->id,
	// 			'offer_id' => $free_offer['offer_id'],
	// 			'user_id' => auth()->user()->id,
	// 		]);

	// 		$offer = Offer::find($free_offer['offer_id']);
	// 		$offer->update([
	// 			'using_counter' => $offer->using_counter + 1
	// 		]);
	// 	}
	// }
}
