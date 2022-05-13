<?php

namespace App\Modules\Admin\Models\Products;

use Illuminate\Database\Eloquent\Model;

class LabelData extends Model
{
    protected $table = "lables_data";
    protected $guarded = [];

	public function products() {
		return $this->belongsToMany(products::class, 'product_lables','product_id','lable_data_id');
	}

}
