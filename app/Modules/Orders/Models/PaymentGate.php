<?php

namespace App\Modules\Orders\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentGate extends Model
{
    protected $table = 'site_payment_gates';
    protected $guarded = [];

	public function getImageAttribute($value)
	{
		if(\request()->is('api/*')){
			return url( $value);
		}
		return $value;
	}

}
