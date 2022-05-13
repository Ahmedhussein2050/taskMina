<?php

namespace App\Modules\Orders\Models;

use App\Modules\Admin\Models\Orders;
use App\Modules\Admin\Models\Products\products;
use App\Modules\Orders\Models\OffersAndDiscounts\Offer;
use Illuminate\Database\Eloquent\Model;

class order_products extends Model
{
    protected $table = 'order_products';
    protected $guarded = [];

    public function product()
    {
        return $this->hasOne(products::class, 'id', 'product_id');
    }

    public function order()
    {
        return $this->hasOne(orders::class, 'id', 'order_id');
    }

    public function offer()
    {
        return $this->hasOne(Offer::class, 'id', 'offer_id');
    }

    public function getVatValAttribute()
    {
        return number_format((float)$this->price * (float)$this->vat / 100, 2);
    }

    public function getPriceAttribute($value)
    {
        return number_format($value, 2);
    }
}
