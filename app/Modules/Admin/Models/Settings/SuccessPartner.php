<?php

namespace App\Modules\Admin\Models\Settings;

use App\Modules\Admin\Models\Products\Category;
use App\Modules\Admin\Models\Settings\BannerData;
use Illuminate\Database\Eloquent\Model;

class SuccessPartner extends Model
{
    protected $table = 'success_partners';
    protected $guarded = [];

    public function category(){
        return $this->hasOne(Category::class,'id','category_id');
	}

	public function Data(){
		return $this->hasOne(BannerData::class,'banner_id','id')->first();
	}

	public function SuccessData(){
        return $this->hasOne(SuccessPartnerData::class,'success_partner_id','id')->first();
    }
	public function getImageAttribute($value)
	{
		if(\request()->is('api/*')){
			return url( $value);
		}
		return $value;
	}
}
