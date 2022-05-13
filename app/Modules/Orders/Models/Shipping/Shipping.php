<?php

namespace App\Modules\Orders\Models\Shipping;

use App\Modules\Admin\Models\cities;
use App\Modules\Admin\Models\countries;
use App\Modules\Admin\Models\Orders;
use App\Site\Region;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    protected $table = 'shippings_address';
    protected $guarded = [];

    public function country(){
        return $this->hasOne(countries::class,'id','country_id');
    }
    public function city(){
        return $this->hasOne(cities::class,'id','city_id');
    }
	public function region(){
        return $this->hasOne( Region::class,'id','region_id');
    }
    public function order(){
        return $this->hasOne(Orders::class,'id','order_id');
    }
//     modified by WFHKB

	public function order_v2()
	{
		return $this->belongsTo(orders::class , 'order_id') ;
	}
}
