<?php

namespace App\Modules\Orders\Models\OffersAndDiscounts;

use App\Modules\Admin\Models\Products\bank_transfer;
use App\Modules\Admin\Models\Products\products;
use App\Modules\Orders\Models\PaymentGate;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{

	protected $table = 'offers';
	// public $timestamps = true;
	protected $guarded = [];
	protected $casts = [
		'title' => 'array',
		"description" => "array"
	];
	public function durations()
	{
		return $this->hasMany(OfferDuration::class);
	}

	public function getTitleAttribute($value)
	{
		return json_decode($value);
	}
	public function getDescriptionAttribute($value)
	{

		return json_decode($value);
	}


	public function products()
	{
		return $this->belongsToMany(products::class, Offer_product::class, "offer_id", "product_id");
	}

	public function productsFree()
	{
		return $this->belongsToMany(products::class, Offer_free_product::class, "offer_id", "product_id");
	}

	public function codes()
	{
		return $this->hasMany(OfferCode::class, "offer_id", "id");
	}
    public function banks()
    {
        return $this->belongsToMany(bank_transfer::class,Offer_offline_payment::class,"offer_id","bank_id");

    }

    public function payments()
    {
        return $this->belongsToMany(PaymentGate::class,Offer_online_payment::class,"offer_id","method_id");

    }
	public function category()
	{
		return $this->belongsTo(Offer_category::class, "category_id");
	}
	public function pre_condition()
	{
		return $this->hasOne(Offer_pre_condition::class, "offer_id");
	}
	public function minimum_cart()
	{
		// if ($this->pre_condition()->first() == null)
		// 	return null;
		return $this->pre_condition()->first()->min_cart_amount??null;
	}
}
