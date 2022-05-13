<?php

namespace App\Modules\Admin\Models;
use App\Models\User;
use App\Modules\Admin\Models\Products\features;
use App\Modules\Admin\Models\Products\Product;
use App\Modules\Admin\Models\Products\products;
use App\Modules\Admin\Models\Settings\Tax;
use App\Modules\Orders\Models\order_feature_options;
use App\Modules\Orders\Models\order_products;
use App\Modules\Orders\Models\Order_status;
use App\Modules\Orders\Models\Order_track;
use App\Modules\Orders\Models\Shipping\Shipping;
use App\Modules\Orders\Models\Shipping\Shipping_option;
use App\Modules\Orders\Models\Transaction;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    public $timestamps = true;

    protected $table = 'orders';

    protected $primaryKey = "id";

    protected $softDelete = true;

    protected $guarded = [];

    public function gettransactions()
    {
        return $this->belongsTo(Transaction::class, 'id', 'order_id');
    }
    public function track()
    {
        return $this->belongsTo(Order_track::class, 'id', 'order_id');
    }

    public function state()
    {
        return $this->belongsToMany(Order_status::class , 'order_tracks' , 'order_id' , 'status_id')->withPivot(['comment' , 'created_at']);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function shipping_option()
    {
        return $this->hasOne(Shipping_option::class, 'id', 'shipping_option_id');
    }

    public function shipping()
    {
        return $this->belongsTo(Shipping::class, 'id', 'order_id');
    }
    //     modified by WFHKB

    public function addresses()
    {
        return $this->hasMany(Shipping::class, 'order_id');
    }

    public function store()
    {
        return $this->hasOne('App\Models\product\stores', 'id', 'store_id');
    }

    public function orderProducts()
    {
        return $this->hasMany(order_products::class, 'order_id', 'id');
    }

    public function products()
    {
        return $this->hasManyThrough(Product::class,order_products::class, 'order_id', 'id', 'id', 'product_id');
    }

    public function features()
    {
        return $this->belongsToMany(features::class, 'order_feature_options', 'order_id', 'feature_option_id');
    }
    public function options()
    {
        return $this->hasMany(order_feature_options::class, "order_id", "id");
    }

    public function transactions()
    {
        return $this->belongsToMany(Transaction::class, 'transactions', 'order_id', 'type_id')->withPivot(
            'status',
            'bank_id',
            'total',
            'currency',
            'discount_code',
            'holder_name',
            'holder_card_number',
            'holder_cvc',
            'holder_expire'
        );
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'order_id');
    }

    public function taxes()
    {
        return $this->belongsToMany(Tax::class, 'order_tax', 'order_id', 'tax_id');
    }
    public function shippingMethod()
    {
        return $this->belongsTo('ShippingMethod');
    }

    public function discount()
    {
        return $this->belongsTo('DiscountCodes');
    }
}
