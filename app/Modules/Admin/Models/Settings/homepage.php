<?php

namespace App\Modules\Admin\Models\Settings;

use App\Modules\Admin\Models\Products\Category;
use Illuminate\Database\Eloquent\Model;

class homepage extends Model
{
    protected $table = 'store_homepages';
    protected $fillable = [
        'category_id',
        'store_id',
        'sort',
        'template',
    ];
    public function store(){
        return $this->hasOne('App\Store','id','store_id');
    }
    public function category(){
        return $this->hasOne(Category::class,'id','category_id');
    }
}
