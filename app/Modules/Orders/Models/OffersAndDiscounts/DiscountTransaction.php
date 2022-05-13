<?php

namespace App\Modules\Orders\Models\OffersAndDiscounts;


use App\Modules\Orders\Models\Transaction;
use Illuminate\Database\Eloquent\Model;

class DiscountTransaction extends Model
{

    protected $table = 'transaction_discount';
    public $timestamps = true;
    protected $guarded = [];

	public function transaction()
	{
		return $this->hasOne(Transaction::class,"id","transaction_id");
	}
	public function discount()
	{
		return $this->hasOne(Discount::class,"id","discount_id");
	}

}
