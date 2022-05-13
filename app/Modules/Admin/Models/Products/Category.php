<?php

namespace App\Modules\Admin\Models\Products;

use App\Bll\Lang;
use App\Modules\Admin\Models\Product\ClassificationData;
use App\Modules\Brands\Models\BrandData;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{

    protected $table = 'categories';
    public $timestamps = true;
    protected $guarded = [];


    public function data()
    {
        return $this->hasMany(CategoryData::class, 'category_id', 'id');
    }
    public function dataa()
    {
        return $this->hasOne(CategoryData::class, 'category_id', 'id')->where('lang_id',Lang::getSelectedLangId());
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'categories_products', 'category_id', 'product_id');
    }
    public function getBrands($products)
    {

        $brand = $products->pluck('brand_id');
        $brands    = BrandData::whereIn('brand_id',$brand)->where('lang_id',Lang::getSelectedLangId())->get();
        return $brands;

    }
    public function getclassifications($products)
    {

        $class = $products->pluck('classification_id');
        $classfication    = ClassificationData::whereIn('classification_id',$class)->where('lang_id',Lang::getSelectedLangId())->get();
        return $classfication;

    }
}
