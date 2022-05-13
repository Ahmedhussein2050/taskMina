<?php

namespace App\Modules\Admin\Models\Products;

use Illuminate\Database\Eloquent\Model;

class ProductData extends Model
{

    protected $table = 'product_details';
    protected $fillable = [
        'title',
        'label',
        'description',
        'info',
        'product_id',
        'lang_id',
    ];

    public $timestamps = true;

}
