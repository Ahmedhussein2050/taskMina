<?php

namespace App\Modules\Orders\Models\OffersAndDiscounts;

use Illuminate\Database\Eloquent\Model;

class Offer_product extends Model
{

    protected $table = 'offer_products';
    public $timestamps = false;

	public function offer()
	{
		$ExtraCategory = Offer_category::where('code', 'extra')->first();
		$oneFreeCategory = Offer_category::where('code', 'oneFree')->first();
		$today = date('Y-m-d H:i:s');
		return $this->belongsTo(Offer::class, 'offer_id', 'id')->where('offers.active_bool', '1')
			->where('offers.using_counter', '<', 'offers.offer_limit')
			->whereDate('offers.start_date', '<=', $today)
			->whereDate('offers.end_date', '>=', $today)
			->whereIn('offers.category_id', [$ExtraCategory->id, $oneFreeCategory->id]);
	}
}
