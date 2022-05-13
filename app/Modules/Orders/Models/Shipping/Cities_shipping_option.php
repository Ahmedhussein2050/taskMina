<?php
namespace App\Modules\Orders\Models\Shipping;

use Illuminate\Database\Eloquent\Model;

class Cities_shipping_option extends Model
{
    protected $table = 'shipping_option_cities';
    public $timestamps = true;
    protected $guarded = [];
}
