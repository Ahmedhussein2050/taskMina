<?php

namespace App\Modules\Orders\Models;

use Illuminate\Database\Eloquent\Model;

class Order_status extends Model
{
    //
     public function data() {

        return $this->hasMany(Order_status_data::class, 'status_id', "id");
    }
}
