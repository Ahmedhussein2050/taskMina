<?php

namespace App\Modules\Orders\Models\OffersAndDiscounts;

use Illuminate\Database\Eloquent\Model;

class OfferNotifications  extends Model
{

    protected $table = 'offer_notification';
    public $timestamps = true;

	protected $guarded = [];

    protected $message = [
        'message' => 'array',
    ];
}
