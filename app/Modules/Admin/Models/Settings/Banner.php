<?php

namespace App\Modules\Admin\Models\Settings;

use App\Bll\Lang;
use App\Modules\Admin\Models\Products\Category;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{

    protected $table = 'banners';
    protected $guarded = [];

    public function category(){
        return $this->hasOne(Category::class,'id','category_id');
    }
    public function Data(){
        return $this->hasOne(BannerData::class,'banner_id','id')->where('lang_id',Lang::getSelectedLangId());
    }

	public function getImageAttribute($value)
	{
		if(\request()->is('api/*')){
			return url( $value);
		}
		return $value;
	}

}
