<?php

namespace App\Modules\Admin\Models\Products;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    protected $table = "lables";
    protected $guarded = [];
    public function Data() {
        return $this->hasMany(LabelData::class,'lable_id','id');
    }
    // public function Another() {
    // 	return $this->hasOne(LabelData::class,'lable_id','id')->where('lang_id','!=',Lang::getSelectedLangId());
    // }
    public function productLabel() {
        return $this->hasOne(ProductLabel::class,'lable_id','id');
    }

}
