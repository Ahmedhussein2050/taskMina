<?php

namespace App\Modules\Orders\Models\Shipping;

use App\Site\Region;
use Illuminate\Database\Eloquent\Model;

class ShippingRegion extends Model
{
	protected  $table = 'shipping_regions' ;
    protected $guarded = [] ;

	public function shipping_option(){
		return $this->belongsTo('App\Models\Shipping\Shipping_option','shipping_option_id');
	}

	public function region()
	{
		return $this->belongsTo(Region::class , 'region_id') ;
	}

}
