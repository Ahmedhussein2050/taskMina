<?php

namespace App\Modules\Admin\Models\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryData extends Model
{
    protected $table = 'categories_data';
    public $timestamps = true;
    protected $guarded = [];
}
