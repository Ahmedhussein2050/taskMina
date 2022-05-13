<?php

namespace App\Modules\Admin\Models\Discount;

use App\Bll\Lang;
use App\Modules\Admin\Models\Products\product_details;
use Illuminate\Database\Eloquent\Model;

class DiscountProduct extends Model
{

    protected $table = 'discount_products';
    public $timestamps = true;
    protected $guarded = [];

    public function product()
    {
        return $this->hasOne(product_details::class,'product_id','product_id')->where('lang_id',Lang::getSelectedLangId());
    }
}
