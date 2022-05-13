<?php

namespace App\Modules\Admin\Models\Products;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{

    protected $table = 'types';
    public $timestamps = true;
    protected $guarded = [];

    public function products()
    {
        return $this->hasMany('Product', 'type_id');
    }

}
