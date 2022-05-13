<?php

namespace App\Modules\Admin\Models\Products;

use Illuminate\Database\Eloquent\Model;

class Product_type extends Model
{

    protected $table = 'product_types';
    public $timestamps = true;
    protected $guarded = [];

    public function product(){
        $this->hasMany(products::class,'product_type','id');
    }
    public function Code()
    {
        return $this->hasMany(ProductTypeCode::class, 'id', 'type_code');
    }
}
