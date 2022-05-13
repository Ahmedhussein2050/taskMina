<?php



namespace App\Modules\Brands\Models;

use App\Bll\Lang;
use App\Modules\Admin\Models\Product\Classification;
use App\Modules\Admin\Models\Product\ClassificationData;
use App\Modules\Admin\Models\Products\Product;
use App\Modules\Admin\Models\Products\products;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{

    protected $table = 'brands';
    public $timestamps = true;
    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(products::class, 'brand_id')->where("stock", '>',0);
    }

    public function translation()
    {
    	return $this->hasOne(BrandData::class)->where('lang_id', Lang::getSelectedLangId());
    }

	public function getImageAttribute($value)
	{
		if(\request()->is('api/*')){
			return url($value );
		}
		return $value;
	}
    public function getclassifications($brand_id)
    {
        // dd($brand_id);
        $produsts = Product::where('brand_id',$brand_id)->get();
        $class = $produsts->pluck('classification_id');
        $classfication    = Classification::whereIn('id',$class)->get();
        return $classfication;

    }

}
