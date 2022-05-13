<?php

namespace App\Models;


use App\CartProductOption;
use App\Modules\Admin\Models\Products\feature_options;
use App\Modules\Admin\Models\Products\Product;
use App\Modules\Admin\Models\Products\products;
use Illuminate\Database\Eloquent\Model;

class AbandonedCart extends Model
{
    protected $table = "abandoned_carts";
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class, "item_id");
    }
    public function options()
    {
        return $this->hasManyThrough(feature_options::class, CartProductOption::class, "option_id", "option_id", "id", "id");
    }

    public function getPriceAttribute($value)
    {
        return $value->total_price *  $value->qty;
    }
}
