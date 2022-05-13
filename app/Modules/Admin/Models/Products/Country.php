<?php

namespace App\Modules\Admin\Models\Products;

use App\Bll\Lang;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';
    protected $guarded = [];
    public function data(){
        return $this->hasOne(countries_data::class, 'country_id')
            ->where('lang_id', Lang::getSelectedLangId());
    }
}
