<?php

namespace App\Modules\Admin\Models\Products;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{

    protected $table = 'order_statuses';
    public $timestamps = true;

    public function status()
    {
        return $this->hasMany('OrderTrackStatusDatas');
    }

}
