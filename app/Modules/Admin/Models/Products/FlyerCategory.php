<?php

namespace App\Modules\Admin\Models\Products;

use Illuminate\Database\Eloquent\Model;

class FlyerCategory extends Model
{
    public $timestamps = true;
    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function parent()
    {
        return $this->hasOne(Category::class,'id','parent_id');
    }
    public function children()
    {
        return $this->hasMany(Category::class,'parent_id','id');
    }

}
