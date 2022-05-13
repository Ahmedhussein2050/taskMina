<?php

namespace App\Modules\Admin\Models\Products;

use App\Bll\Lang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attribute extends Model
{
    use HasFactory;

    protected $table = 'attributes';
    protected $fillable = ['type', 'required', 'front', 'icon'];

    public function Data()
    {
        return $this->hasMany(AttributeData::class, 'attribute_id', 'id');
    }

    public function Options()
    {
        return $this->hasMany(AttributeOption::class, 'attribute_id', 'id');
    }

    // public function Category()
    // {
    //     return $this->belongsToMany(Category::class, CategoryAttribute::class, 'attribute_id', 'category_id');
    // }

    public function frontData()
    {
        return $this->hasOne(AttributeData::class, 'attribute_id', 'id')->where('lang_id', Lang::getSelectedLangId());
    }
}
