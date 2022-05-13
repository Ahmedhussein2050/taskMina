<?php

namespace App\Modules\Admin\Models\Products;

use App\Bll\Lang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AttributeOption extends Model
{
    use HasFactory;

    protected $table = 'attributes_options';
    protected $fillable = ['attribute_id'];

    public function Data()
    {
        return $this->hasMany(AttributeOptionData::class, 'option_id', 'id');
    }
    public function translation()
    {
        return $this->hasOne(AttributeOptionData::class, 'option_id', 'id')->where('lang_id', Lang::getSelectedLangId());
    }

    public function frontData()
    {
        return $this->hasOne(AttributeOptionData::class, 'option_id', 'id')->where('lang_id', Lang::getSelectedLangId());
    }
    
    public function value()
    {
        return $this->hasOne(AttributeValue::class, 'option_id', 'id');
    }
}
