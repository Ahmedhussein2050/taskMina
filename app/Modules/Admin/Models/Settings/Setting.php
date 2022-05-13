<?php


namespace App\Modules\Admin\Models\Settings;


use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    protected $table = 'settings';
    public $timestamps = true;
    protected $guarded = [];
}
