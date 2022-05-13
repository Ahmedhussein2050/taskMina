<?php


namespace App\Modules\Orders\Models;


use App\Modules\Orders\Models\OffersAndDiscounts\DiscountTransaction;
use App\Modules\Orders\Models\OffersAndDiscounts\TransactionOffer;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    protected $table = 'transactions';
    protected $guarded = [];

    public $timestamps = true;
    public function order(){
        return $this->hasOne('App\Models\product\orders','id','order_id');
    }
    // public function type(){
    //     return $this->hasOne('App\Models\product\transaction_types','id','type_id');
    // }
    public function bank(){
        return $this->hasOne('App\Models\product\bank_transfer','id','bank_id');
    }



    public function transaction_type()
    {
        return $this->hasOne('App\Models\product\transaction_types', 'id', 'type_id');
    }


	public function gateway()
    {
        return $this->hasOne(PaymentGate::class, 'id', 'payment_gateway');
    }

	public function offers()
	{
		return $this->hasMany(TransactionOffer::class, 'transaction_id', 'id');
	}
	public function discounts()
	{
		return $this->hasMany(DiscountTransaction::class, 'transaction_id', 'id');
	}
}
