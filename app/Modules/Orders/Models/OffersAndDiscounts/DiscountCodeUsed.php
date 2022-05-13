<?php

namespace App\Modules\Orders\Models\OffersAndDiscounts;

use Illuminate\Database\Eloquent\Model;

class DiscountCodeUsed extends Model
{
	protected $guarded = [];
	protected $table = 'discount_codes_used';
}
