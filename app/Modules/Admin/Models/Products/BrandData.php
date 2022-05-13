<?php

namespace App\Modules\Admin\Models\Products;

use Illuminate\Database\Eloquent\Model;

class BrandData extends Model
{

    protected $table = 'brands_data';
    public $timestamps = true;
    protected $guarded = [];

    public function brand(){
        return $this->belongsTo(Brand::class,'id','brand_id');
    }

}
