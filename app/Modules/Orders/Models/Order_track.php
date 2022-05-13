<?php

namespace App\Modules\Orders\Models;

use Illuminate\Database\Eloquent\Model;

class Order_track extends Model
{
    protected $guarded =[];
     public function status()
    {
        return $this->belongsTo(Order_status::class, 'status_id',"id");
    }
     public function statusData()
    {
        return $this->belongsTo(Order_status_data::class, 'status_id',"status_id");
    }
}
