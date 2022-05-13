<?php

namespace App\Modules\Admin\Models\Products;

use App\Bll\Lang;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{

    protected $table = 'brands';
    public $timestamps = true;
    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(products::class, 'brand_id');
    }

    public function translation()
    {
    	return $this->hasOne(BrandData::class)->where('lang_id', Lang::getSelectedLangId());
    }

	public function getImageAttribute($value)
	{
		if(\request()->is('api/*')){
			return url($value );
		}
		return $value;
	}

}
