<?php

namespace App\Modules\Admin\Models\Product;

use App\Bll\Lang;
use App\Modules\Admin\Models\Products\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classification extends Model
{
    use HasFactory;
    protected $table = 'classifications';
    protected $guarded = [];

    public function data()
    {
        return $this->hasOne(ClassificationData::class, 'classification_id', 'id')->where('lang_id',Lang::getSelectedLangId());
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'classification_id', 'id')->where("stock", '>',0);
    }
}
