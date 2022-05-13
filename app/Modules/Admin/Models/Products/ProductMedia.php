<?php

namespace App\Modules\Admin\Models\Products;

use Illuminate\Database\Eloquent\Model;

class ProductMedia extends Model
{

    protected $table = 'product_media';
    public $timestamps = true;

    public function product()
    {
        return $this->belongsTo('Product');
    }

}
