<?php

namespace App\Modules\Admin\Models\Products;

// use ChristianKuri\LaravelFavorite\Traits\Favoriteable;

use App\Bll\Lang;
use App\Bll\Utility;
use App\Comment;
use App\Models\User;
use App\Modules\Admin\Models\Discount\Discount;
use App\Modules\Admin\Models\Discount\DiscountProduct;
use App\Modules\Admin\Models\Reviews\Review;
use App\Modules\Orders\Models\Stock;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;

class products extends Model {

    // use Favoriteable;


    protected $table = 'products';
    public $timestamps = true;
    protected $guarded = [];
    protected $with = ['comments', 'comments.user', 'comments.reply'];

    public function mainPhoto() {
        $find = $this->product_photos()->where("main", "1")->first();
        if ($find != null)
            return $find->photo;
        return "/images/placeholder.png";
    }
    public function Images(){
        return $this->hasMany(ProductImages::class,'product_id');
    }
    public function Type() {
        $find = $this->product_type()->first();
        if ($find != null)
            return $find->id;
        return -1;
    }

    public function Category() {
        return $this->categories()->get();
    }

    public function Donation() {
        return $this->donations()->get();
    }

    public function donations() {
        return $this->hasMany(Donations::class, 'product_id', 'id');
    }

    public function singleProductDetails() {
        $find = $this->product_details()->where("source_id", null)->first();
        return $find;
    }

    public function product_type() {
        return $this->hasOne(Product_type::class, 'id', 'product_type');
    }

    public function categories() {
        return $this->belongsToMany(Category::class, 'categories_products', 'product_id', 'category_id');
    }
    public function checkStock()
    {
        return $this->hasMany(Stock::class, 'product_id');
    }

    public function hasStock()
    {
        return $this->checkStock()->sum('quantity');
    }
//    public function features() {
//        return $this->hasMany(features::class, 'product_id', 'id');
//    }

    public function product_details() {
        return $this->hasMany(product_details::class, 'product_id', 'id');
    }

    public function detailes() {
        return $this->hasOne(product_details::class,'product_id', 'id')->where('lang_id', Lang::getSelectedLangId());
    }

    public function product_photos() {
        return $this->hasMany(product_photos::class, 'product_id', 'id');
    }

    public function main_product_photo() {
        return $this->hasOne(product_photos::class, 'product_id', 'id')->whereMain(1);
    }

    public function comments() {
        return $this->hasMany(Comment::class)->whereNull('comment_id');
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function reviews(){
        return $this->hasMany(Review::class, 'product_id');
    }
    public function getPriceWithTax($value)
	{
		return $value + ($value * Utility::taxOnProduct())/100;

	}
    public function imagee($product){

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
