<?php

namespace App\Bll\Offers;

use App\Bll\Order;

use App\Modules\Admin\Models\Products\products;
use App\Modules\Orders\Models\OffersAndDiscounts\Offer;
use App\Modules\Orders\Models\OffersAndDiscounts\Offer_online_payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class Extra
{
	public function check()
	{
		$ids = collect(Order::getCartProducts())->pluck("id");

		$offer = Offer::join('offer_category', 'offer_category.id', 'offers.category_id')
			->join('offer_online_payment', 'offer_online_payment.offer_id', 'offers.id')
			->select('offers.*', 'offer_category.code', 'offer_online_payment.method_id')
			->where('offers.active_bool', 1)
			->where('offers.start_date', '<', Carbon::now())
			->where('offers.end_date', '>', Carbon::now())
			->where('offers.offer_limit', '>', 'offers.using_counter')
			->where('offer_category.code', '=', 'extra')
			->first();
		if ($offer != null) {
			$offer_prdoducts = $offer->products;
			if ($offer_prdoducts->count() > 0) {
				$find = $offer_prdoducts->whereIn("id", $ids)->first();
				if ($find)
					$extra_payment = Offer_online_payment::join('offers', 'offers.id', 'offer_online_payment.offer_id')
						->where('offer_id', $offer->id)->get();
				else
					return null;
			} else
				$extra_payment = Offer_online_payment::join('offers', 'offers.id', 'offer_online_payment.offer_id')
					->where('offer_id', $offer->id)->get();
		} else {
			$extra_payment = null;
		}
		//	dd($extra_name);
		return $extra_payment;
	}
	public  function apply($pay_method, $ids)
	{
		Session::forget('extra');
		// dd($ids);
		$offer = Offer::join('offer_category', 'offer_category.id', 'offers.category_id')
			->join('offer_online_payment', 'offer_online_payment.offer_id', 'offers.id')
			->select('offers.*', 'offer_category.code', 'offer_online_payment.method_id as payment_method')
			->where('offers.active_bool', 1)
			->where('offers.start_date', '<', Carbon::now())
			->where('offers.end_date', '>', Carbon::now())
			->where('offers.offer_limit', '>', 'offers.using_counter')
			->where('offer_category.code', '=', 'extra')
			->where('offer_online_payment.method_id', $pay_method)
			->first();

		if ($offer == null)
			return;

		$amount = 0;

		if ($ids != null || $ids != []) {
			$offer_products = $offer->products;
			//dd($offer_products);


			if ($offer_products->count() == 0) {
				$offer_products = products::whereIn('id', $ids)->get();
			} else
				$offer_products = $offer_products->whereIn("id", $ids);

			foreach ($offer_products as $offer_product) {

				$amount = $amount + $offer_product->afterDiscount(false);
			}

			if (($offer->calc_type == 'net') && ($amount > $offer->bonus)) {
				$amount =  $offer->bonus;
			} elseif ($offer->calc_type == 'perc')
				$amount = $amount  *  ($offer->bonus / 100);
		}



		$extra = [
			'offer_id' => $offer->id,
			'offer_total' => $amount,
			'payment_method' => $pay_method,
			'product_ids' => $ids
		];

		Session::put('extra', $extra);

		return response()->json(['status' => 'success', 'data' => $amount, 'id' => $offer->id]);
	}
}
