<?php

namespace App\Modules\Orders\Models;

use Illuminate\Database\Eloquent\Model;

class transaction_types extends Model
{
    public $timestamps = false;
    protected $table = 'transaction_types';
    protected $guarded = [];

    public function orders(){
        return $this->belongsToMany('App\Models\product\orders','transactions','type_id','order_id')->withPivot(
            'status',
            'bank_id',
            'total',
            'currency',
            'discount_code',
            'holder_name',
            'holder_card_number',
            'holder_cvc',
            'holder_expire');

    }
}
