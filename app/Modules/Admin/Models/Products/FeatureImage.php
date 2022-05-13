<?php

namespace App\Modules\Admin\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeatureImage extends Model
{
    protected $table = "feature_images" ;
    protected  $guarded= [] ;

    public function feature_option()
    {
        return	 $this->belongsTo(feature_options::class , 'feature_option_id') ;
    }

    public function option_images(){
        return $this->hasMany( FeatureImage::class,'feature_id','id');
    }

}
