<?php

namespace App\Modules\Admin\Models;

use App\Bll\Lang;
use App\Models\cities;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
     protected $table = 'regions' ;
     protected $guarded = [] ;

	public function city()
	{
		return $this->belongsTo(cities::class , 'city_id' ) ;

     }

	 public function title($lang_id = null)
	{
		$data = array_column($this->hasMany(RegionData::class, 'region_id')->get()->toArray(), null, "lang_id");

		if ($lang_id != null) {
			$find = $data[$lang_id];
		}
		else
		$find = array_first($data);

		if($find!=null)
			return $find["title"];
		return "";
	}
	public function data()
	{
		return $this->hasMany(RegionData::class )->where('lang_id' , Lang::getSelectedLangId()) ;
     }
	public function regionData(){
		return $this->join('region_data','region_data.region_id','regions.id')
			->select('region_data.title','regions.id')
			;
	}


}
