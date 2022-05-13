<?php

namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $table = 'email';
    protected $fillable = array('to', 'message', 'model_type', 'user_id');
}
