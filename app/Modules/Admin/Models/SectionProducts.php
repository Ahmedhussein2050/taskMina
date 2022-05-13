<?php

namespace App\Modules\Admin\Models;

use App\Modules\Admin\Models\Products\CategoryData;
use Illuminate\Database\Eloquent\Model;

class SectionProducts extends Model
{
    protected $table = 'section_products';
    public $timestamps = false;
    protected $guarded = [];

    public function category(){
    	return $this->belongsTo(CategoryData::class ,'category_id','category_id')->where('lang_id', getLang());
	}


}
