<?php

namespace App\Modules\Admin\Models\Discount;


use Illuminate\Database\Eloquent\Model;

class DiscountNotifications extends Model
{

    protected $table = 'discount_notifications';
    public $timestamps = true;

	protected $guarded = [];

	public function getMessageAttribute($value)
    {
        return json_decode($value);
    }

}
