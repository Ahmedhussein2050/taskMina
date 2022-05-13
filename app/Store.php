<?php

namespace App;

use App\Modules\Admin\Models\Orders;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
	protected $table = 'stores';
	protected $guarded = [];

	public function orders(){
		return new orders();
	}
}
