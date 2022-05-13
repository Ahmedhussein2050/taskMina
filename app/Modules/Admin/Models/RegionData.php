<?php

namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class RegionData extends Model
{
    protected  $table = 'region_data' ;
    protected $guarded = [] ;

	public function region()
	{
		return $this->belongsTo(Region::class  , 'region_id' )  ;
    }


}
