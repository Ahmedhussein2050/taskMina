<?php

namespace App\Modules\Orders\Models\Shipping;

use Illuminate\Database\Eloquent\Model;

class Shipping_type extends Model
{
    protected $table = 'shipping_types';
    public $timestamps = true;
	protected $guarded = [];

	public function shippingOptions()
	{
        return $this->hasOne(Shipping_option::class,'id','shipping_option_id');
    }
}
