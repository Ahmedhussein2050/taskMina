<?php

namespace App\Modules\Admin\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeOptionData extends Model
{
    use HasFactory;

    protected $table = 'attributes_options_data';
    protected $fillable = ['option_id', 'title', 'lang_id'];
}
