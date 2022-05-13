<?php

namespace App\Modules\Admin\Models\Products;

use App\Bll\Lang;
use App\Bll\Utility;
use App\Modules\Admin\Models\Discount\Discount;
use App\Modules\Admin\Models\Discount\DiscountProduct;
use App\Modules\Admin\Models\Product\Classification;
use App\Modules\Admin\Models\Reviews\Review;
use App\Modules\Orders\Models\Stock;
use App\Modules\portal\Models\Favourite;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Product extends Model
{

    protected $table = 'products';
    public $timestamps = true;
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function product_details()
    {
        return $this->hasMany(product_details::class, 'product_id', 'id');
    }
    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function media()
    {
        return $this->hasMany(ProductMedia::class);
    }
    public function Images()
    {
        return $this->hasMany(ProductImages::class, 'product_id');
    }

    public function Attributes()
    {
        return $this->hasMany(AttributeValue::class, 'product_id');
    }

    public function classification()
    {
        return $this->belongsTo(Classification::class, 'classification_id', 'id');
    }
    public function hasStock()
    {
        return $this->checkStock()->sum('quantity');
    }

    public function checkStock()
    {
        return $this->hasMany(Stock::class, 'product_id');
    }
    public function translation()
    {
        $obj = $this->hasOne(product_details::class, 'product_id', 'id')->where('lang_id', Lang::getSelectedLangId());
        if ($obj->first() == null)
            $obj = $this->hasOne(product_details::class, 'product_id', 'id');
        return $obj;
    }
    public function comments()
    {
        return $this->hasMany(Review::class, 'product_id');
    }
    public function fav()
    {
        return $this->hasOne(Favourite::class, 'product_id')->where('user_id', auth()->user()->id);
    }

    public function favourite()
    {
        return $this->hasMany(Favourite::class, 'product_id')->where('user_id', auth()->user()->id);
    }

    public function getPriceWithTax($value)
    {
        return $value + ($value * Utility::taxOnProduct()) / 100;
    }
    public function imagee($product)
    {

        $image_path = 'uploads/products/' . $product->sku;
        $images = File::glob($image_path . '/*');
        return $images;
    }

    public function discounts($product)
    {
        $value = null;
        $pro  = DiscountProduct::where('product_id', null)->first();
        $all  = Discount::where('id', $pro->discount_id)->first();
        $dtt  = new DateTime($all->start_date);
        $edd  = new DateTime($all->end_date);
        if ($all->active == 1 &&   $dtt->format('Y-m-d') <= Carbon::now() && $edd->format('Y-m-d') > Carbon::now()) {
            $value = $all;
        }

        $p = $this->hasMany(DiscountProduct::class, 'product_id', 'id')->where('product_id', $product->id);
        foreach ($p->get() as $discount) {

            $dis = Discount::where('id', $discount->discount_id)->first();
            $dt = new DateTime($dis->start_date);
            $ed = new DateTime($dis->end_date);

            if ($dis->active == 1 && $dt->format('Y-m-d') <= Carbon::now() && $ed->format('Y-m-d') > Carbon::now()) {
                $value = $dis;
            }
        }
        return $value;
    }
}
