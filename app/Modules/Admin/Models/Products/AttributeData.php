<?php

namespace App\Modules\Admin\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeData extends Model
{
    use HasFactory;

    protected $table = 'attributes_data';
    protected $fillable = ['attribute_id', 'title', 'placeholder', 'lang_id'];
}
