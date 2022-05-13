<?php

namespace App\Modules\Admin\Models\Products;

use Illuminate\Database\Eloquent\Model;

class feature_options extends Model
{
    protected $table = 'feature_options';
    public $timestamps = true;
    protected $guarded = [];

    public function data()
    {
        return $this->hasOne(feature_option_data::class, 'feature_option_id', 'id')->where('lang_id', getLang());
    }

    public function feature()
    {
        return $this->belongsTo(features::class, 'feature_id', 'id');
    }
}
