<?php

namespace App\Modules\Orders\Models;

use App\Modules\Admin\Models\Products\feature_option_data;
use Illuminate\Database\Eloquent\Model;

class order_feature_options extends Model
{
	protected $table = 'order_feature_options';
	protected $guarded = [];
	public function Data()
	{
		$f = $this->hasOne(feature_option_data::class, "feature_option_id", "feature_option_id")->where("lang_id", getLang());
		if ($f == null) {
			$f = $this->hasOne(feature_option_data::class, "feature_option_id", "feature_option_id");
		}
		return $f;
	}

	public function translation ()
	{
		return $this->hasOne(feature_option_data::class, "feature_option_id", "feature_option_id")->where("lang_id", getLang());
	}
	// public function Feature()
	// {
	// 	return $this->hasOneThrough(features::class, feature_options::class, "feature_id","id","feature_id","feature_id");
	// }
}
