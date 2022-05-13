<?php

namespace App\Modules\Orders\Models\Shipping;

use App\Modules\Admin\Models\cities;
use App\Modules\Admin\Models\countries;
use App\Modules\Admin\Models\Products\countries_data;
use App\Modules\Admin\Models\Region;
use App\Modules\Admin\Models\Settings\Currency;
use Illuminate\Database\Eloquent\Model;

class Shipping_option extends Model
{
    protected $table = 'shipping_options';
    public $timestamps = true;
	protected $guarded = [];

    // public function company(){
    //     return $this->hasOne(ShippingCompaniesData::class,'shipping_company_id','company_id');
	// }
    public function company(){
        return $this->hasOne(shippingCompanies::class,'id','company_id');
	}

    public function country(){
        return $this->hasOne(countries::class,'id','country_id');
    }

    public function shipping_require(){
        return $this->hasOne('App\ShippingRequire','id','shipping_require_id');
	}

	public function shipping_cities(){
        return $this->hasMany(Cities_shipping_option::class,'shipping_option_id','id');
	}



    public function cities(){
        return $this->belongsToMany(cities::class,'shipping_option_cities','shipping_option_id','city_id');
    }
    // public function regions(){
	// 	return $this->belongsToMany(Region::class,'shipping_regions','shipping_option_id','region_id');
    //     return $this->hasMany(ShippingRegion::class);
    // }

	public function currency(){
		return $this->hasOne(Currency::class, 'id', 'currency_id');
	}
}
