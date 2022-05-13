<?php

namespace App\Modules\Admin\Models\Products;

use App\Models\Language;
use Illuminate\Database\Eloquent\Model;

class product_details extends Model
{
    protected $table = 'product_details';
    protected $guarded = [];

    public function product()
    {
        return $this->hasOne(products::class,'id','product_id');
    }
    public function products()
    {
        return $this->belongsTo(products::class,'product_id','id');
    }
    public function language()
    {
        return $this->hasOne(language::class,'id','lang_id');
    }
    public function parent()
    {
        return $this->hasOne(product_details::class,'id','source_id');
    }
    public function children()
    {
        return $this->hasMany(product_details::class,'source_id','id');
    }
}
