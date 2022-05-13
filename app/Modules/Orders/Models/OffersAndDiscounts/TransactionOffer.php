<?php

namespace App\Modules\Orders\Models\OffersAndDiscounts;

use App\Modules\Orders\Models\Transaction as transactions;
use Illuminate\Database\Eloquent\Model;

class TransactionOffer extends Model
{

	protected $table = 'transaction_offers';
	public $timestamps = true;
	protected $guarded = [];

	public function offer()
	{
		return $this->hasOne(Offer::class, "id", "offer_id");
	}
	public function transaction()
	{
		return $this->hasOne(transactions::class, "id", "transaction_id");
	}
}
