<?php


namespace App\Modules\Admin\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{

    protected $table = 'sliders';
    public $timestamps = true;
    protected $fillable = array('url','published','image', 'store_id');

}
