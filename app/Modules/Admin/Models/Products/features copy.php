<?php

namespace App\Modules\Admin\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class features extends Model
{

    protected $table = 'features';
    public $timestamps = true;
    protected $guarded = [];

    public function product(){
        return $this->hasOne(products::class,'product_id','id');
    }
    public function data() {
        return $this->hasOne(feature_data::class,'feature_id','id');
    }
    public function options(){
        return $this->hasMany(feature_options::class,'feature_id','id');
    }

    public function products(){
        return $this->belongsToMany(products::class,'product_features','feature_id','product_id');
    }
    public function orders(){
        return $this->belongsToMany(orders::class,'order_feature_options','feature_option_id','order_id');
    }
}
