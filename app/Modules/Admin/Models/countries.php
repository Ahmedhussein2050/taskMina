<?php

namespace App\Modules\Admin\Models;

use App\Bll\Lang;
use Illuminate\Database\Eloquent\Model;

class countries extends Model
{
    protected $table = 'countries';
    protected $fillable = [
        'code',
        'logo',
    ];
    protected $with = ['data'];
    public function cities(){
        return $this->hasMany(cities::class,'country_id','id');
    }
    public function cityData(){
        return $this->cities()->join('city_datas','city_datas.city_id','cities.id')
            ->select('city_datas.title','cities.id')->where('city_datas.source_id' , null)->get();
    }

    public function data(){
        return $this->hasMany(countries_data::class,'country_id');
    }
    public function get_translation()
    {
        return $this->belongsTo(countries_data::class, 'country_id')->where('lang_id', Lang::getSelectedLangId());
    }
}
