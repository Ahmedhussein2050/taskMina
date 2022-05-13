<?php

namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class UserBalance extends Model
{
    public $timestamps = true;

    protected $table = 'user_balance';

    protected $guarded = [];
}
