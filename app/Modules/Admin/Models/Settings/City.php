<?php

namespace App\Modules\Admin\Models\Settings;

use App\Bll\Lang;
use App\Modules\Admin\Models\Products\countries_data;
use App\Modules\Admin\Models\Products\Country;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';
    protected $guarded = [];
    public function country(){
        return $this->belongsTo(Country::class);
    }
    public function countryData(){
        return $this->hasOne(countries_data::class,'country_id','country_id');
    }

    public function shipping_option(){
        return $this->belongsToMany('App\Models\Shipping\Shipping_option','shipping_option_cities','city_id','shipping_option_id');
    }

    public function data(){
        return $this->hasOne(CityData::class, 'city_id')->where('lang_id', Lang::getSelectedLangId());
    }
    public function dataa(){
        return $this->hasMany(CityData::class, 'city_id', 'id');
    }

    public function Flyers(){
        return $this->belongsToMany('App\Flyer', 'city_flyers','city_id','flyer_id');
    }
}
