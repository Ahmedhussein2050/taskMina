<?php

namespace App\Modules\Orders\Models\Shipping;

use App\Bll\Lang;
use Illuminate\Database\Eloquent\Model;

class shippingCompanies extends Model {

    protected $table = 'shipping_companies'; // shipping_type
    protected $guarded = [];

    public function Data() {
        return $this->hasMany(ShippingCompaniesData::class, 'shipping_company_id', 'id');
    }

    // public function title() {
    //     $find = self::titlee()->first();
    //     //dd($find);
    //     if ($find == null) {
    //         $find = $this->Data()->first();
    //     }
    //     if ($find == null)
    //         return "";
    //     return $find ;
    // }
    public function titlee()
    {
        return $this->hasOne(ShippingCompaniesData::class, 'shipping_company_id', 'id')->where("lang_id", Lang::getSelectedLangId());
    }

	public function shipping_option()
	{
		return $this->hasMany(Shipping_option::class, 'company_id', 'id');
	}

	public function getLogoAttribute($value)
	{
		if(\request()->is('api/*')){
			return url( $value);
		}
		return $value;
	}
}
