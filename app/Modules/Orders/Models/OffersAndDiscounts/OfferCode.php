<?php

namespace App\Modules\Orders\Models\OffersAndDiscounts;

use Illuminate\Database\Eloquent\Model;

class OfferCode extends Model
{

    protected $table = 'offer_codes';
    public $timestamps = true;
    protected $guarded =[];

	protected $casts = [
		'title' => 'array',
		"description" => "array"
	];
	public function getTitleAttribute($value)
	{
		return json_decode($value);
	}
	public function getDescriptionAttribute($value)
	{
		return json_decode($value);
	}
}
