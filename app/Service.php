<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';
    protected $guarded = [];

	public function Data ()
	{
		return $this->hasMany(ServiceData::class, 'service_id', 'id');
	}
}
