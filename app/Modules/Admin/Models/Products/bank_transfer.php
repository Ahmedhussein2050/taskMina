<?php

namespace App\Modules\Admin\Models\Products;

use App\Offer;
use App\Offer_offline_payment;
use Illuminate\Database\Eloquent\Model;

class bank_transfer extends Model
{
    protected $table = 'bank_transfers';
    protected $guarded = [];

    public function store(){
        return $this->hasOne('App\Models\product\stores','id','store_id');
    }

	public function getLogoAttribute($value)
	{
		if(\request()->is('api/*')){
			return url( $value);
		}
		return $value;
	}
}
