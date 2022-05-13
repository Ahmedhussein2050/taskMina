<?php

namespace App\Modules\Orders\Models\OffersAndDiscounts;

use Illuminate\Database\Eloquent\Model;

class OfferDuration extends Model
{

    protected $table = 'offer_durations';
    public $timestamps = false;
    protected $guarded =[];

	public function offer()
	{
		return $this->belongsTo(Offer::class, 'offer_id', 'id');
	}

}
