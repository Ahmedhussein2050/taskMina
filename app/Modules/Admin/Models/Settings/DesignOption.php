<?php


namespace App\Modules\Admin\Models\Settings;


use Illuminate\Database\Eloquent\Model;

class DesignOption extends  Model
{

    protected $table = 'design_options';
    protected $guarded = [];
    // 'main_menu' , ['classification_list' , 'custom_list']
    // 'home_page_display' , ['latest_product' , 'custom_design']
    public $timestamps = true;

}
