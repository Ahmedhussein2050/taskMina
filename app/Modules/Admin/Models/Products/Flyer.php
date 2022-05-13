<?php

namespace App\Modules\Admin\Models\Products;

use Illuminate\Database\Eloquent\Model;

class Flyer extends Model
{
    protected $fillable = [
        'link',
        'category_id',
        'store_id',
        'period',
        'start_date',
        'end_date',
    ];
    public function Images(){
        return $this->hasMany('App\FlyerImages','flyer_id');
    }
    public function Cities(){
        return $this->belongsToMany('App\Models\cities', 'city_flyers','flyer_id','city_id');
    }

}
