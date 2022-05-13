<?php

namespace App\Modules\Admin\Models\Products;

use App\Bll\Lang;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;
    protected $table = 'attributes_values';
    protected $fillable = [
        'product_id',
        'attribute_id',
        'option_id',
        'value',
    ];


    public function attribute(){
        return $this->hasOne(Attribute::class,'id','attribute_id') ;
    }

    public function attributeData(){
        return $this->hasOne(AttributeData::class,'attribute_id','attribute_id')->where('lang_id',Lang::getSelectedLangId());
    }

    public function attrOptionData(){
        return $this->hasOne(AttributeOptionData::class,'option_id','option_id')->where('lang_id',Lang::getSelectedLangId());
    }

}
