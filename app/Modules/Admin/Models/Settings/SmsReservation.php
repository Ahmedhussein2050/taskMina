<?php

namespace App\Modules\Admin\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class SmsReservation extends Model
{
    protected $table = 'sms_reservations';
    protected $guarded = [];


    public function store()
    {
        return $this->hasOne('App\Store', 'id', 'store_id');
    }
}
