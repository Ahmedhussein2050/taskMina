<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCustomFieldOption extends Model
{
    protected $table = 'custom_fields_options';
	protected $guarded = [];

	public function getNameAttribute($name)
	{
		return $name == NULL ? '' : $name;
	}

	public function getPriceAttribute($price)
	{
		return $price == NULL ? '' : $price;
	}
}
