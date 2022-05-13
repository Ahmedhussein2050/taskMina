<?php

namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class SMS extends Model
{
    protected $table = 'sms';
    protected $fillable = array('to', 'message', 'model_type', 'user_id');
}
