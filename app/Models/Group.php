<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class, 'group_user');
    }
}
