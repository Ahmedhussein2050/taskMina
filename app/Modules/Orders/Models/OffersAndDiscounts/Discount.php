<?php

namespace App\Modules\Orders\Models\OffersAndDiscounts;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{

    protected $table = 'discounts';
    public $timestamps = true;
    protected $guarded = [];

	public function users()
	{
		return $this->belongsToMany(User::class, 'discount_users', 'discount_id', 'user_id');
	}
	public function creator()
	{
		return $this->belongsTo(User::class,  'user_id','id');
	}

	public function notifications()
	{
		return $this->hasMany(DiscountNotifications::class,"discount_id");
	}
	public function promotors()
	{
		return $this->belongsToMany(Promotors::class,discount_promotors::class,"discount_id","promotor_id");

	}
	public function systemNotifications()
	{
		return $this->notifications()->where("notified_by","system");
	}
	public function smsNotifications()
	{
		return $this->notifications()->where("notified_by","sms");
	}
	public function emailNotifications()
	{
		return $this->notifications()->where("notified_by","email");
	}

}
