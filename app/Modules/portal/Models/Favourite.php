<?php



namespace App\Modules\portal\Models;

use App\Modules\Admin\Models\Products\Product;
use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{

    protected $table = 'users_favourites';
    public $timestamps = true;
    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class,'id', 'product_id');
    }



}
