<?php


namespace App\Modules\Admin\Models\Settings;


use Illuminate\Database\Eloquent\Model;

class CustomDesign extends Model
{

    protected $table = 'custom_design_options';
    protected $guarded = [];
    // 'option_type' , ['custom_list' ,'custom_design']
    public $timestamps = true;



}
