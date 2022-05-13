<?php

namespace App\Modules\Admin\Models;

 
use App\Bll\Lang;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Admin\Models\Products\CategoryData;

class CategoryMaster extends Model
{
    protected $table = 'section_category_master';
    public $timestamps = false;
    protected $guarded = [];

    public function category(){
    	return $this->belongsTo(CategoryData::class ,'category_id','category_id')->where('lang_id',Lang::getSelectedLangId());
	}


}
