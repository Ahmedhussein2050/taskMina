<?php

namespace App\Modules\Admin\Models;

use App\Bll\Lang;
use Illuminate\Database\Eloquent\Model;

class cities extends Model
{
    protected $table = 'cities';
    protected $fillable = [
        'country_id',
    ];
    public function country(){
        return $this->belongsTo('App\Models\countries');
    }
    public function countryData(){
        return $this->hasOne('App\Models\countries_data','country_id','country_id');
    }

    public function shipping_option(){
        return $this->belongsToMany('App\Models\Shipping\Shipping_option','shipping_option_cities','city_id','shipping_option_id');
    }

    public function data(){
        return $this->hasOne(CityData::class, 'city_id')->where('lang_id', Lang::getSelectedLangId());
    }

    public function Flyers(){
        return $this->belongsToMany('App\Flyer', 'city_flyers','city_id','flyer_id');
    }
}
