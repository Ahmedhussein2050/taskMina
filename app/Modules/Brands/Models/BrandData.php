<?php


namespace App\Modules\Brands\Models;

use Illuminate\Database\Eloquent\Model;

class BrandData extends Model
{

    protected $table = 'brands_data';
    public $timestamps = true;
    protected $guarded = [];
    public function brand(){
        return $this->belongsTo(Brand::class);
    }

}
