<?php

namespace App\Modules\Admin\Models\Discount;


use Illuminate\Database\Eloquent\Model;

class discount_promotors extends Model
{

    protected $table = 'discount_promotors';
    public $timestamps = true;
	protected $guarded = [];

    public function discount()
    {
        return $this->hasOne('App\Discounts','discount_id','id');
    }
	public function promotor()
    {
        return $this->hasOne('App\promotor','promotor_id','id');
    }

}
