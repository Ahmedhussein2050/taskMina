<?php

namespace App\Modules\Orders\Models\OffersAndDiscounts;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Promotors extends Model
{

    protected $table = 'promotors';
    public $timestamps = true;

	protected $guarded = [];

	public function account()
    {
        return $this->hasOne(User::class,"id", 'user_id');
    }
	public function user()
    {
        return  $this->belongsTo(User::class,"user_id","id");
    }

}
