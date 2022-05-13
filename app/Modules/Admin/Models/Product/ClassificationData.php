<?php

namespace App\Modules\Admin\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassificationData extends Model
{
    use HasFactory;
    protected $table = 'classifications_data';
    protected $guarded = [];
}
