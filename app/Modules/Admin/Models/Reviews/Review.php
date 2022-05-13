<?php

namespace App\Modules\Admin\Models\Reviews;


use App\Models\User;
use App\Modules\Admin\Models\Products\Product;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';
    protected $guarded = [];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
