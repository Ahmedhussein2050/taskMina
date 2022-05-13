<?php

namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class OrderRefund extends Model
{
    public $timestamps = true;

    protected $table = 'order_refund';



    protected $guarded = [];
}
