<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageAccount extends Model
{
    use HasFactory;
    protected $table = 'image_accounts';
    protected $guarded = [];
}
