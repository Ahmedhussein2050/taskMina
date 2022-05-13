<?php

namespace App\Modules\Admin\Models;

use App\Bll\Lang;
use App\Modules\Admin\Models\Products\products;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Admin\Models\SectionData;
use App\Modules\Admin\Models\Settings\Banner;
use App\Modules\Admin\Models\Services\Services;
use App\Modules\Admin\Models\Settings\SuccessPartner;
 use App\Modules\Admin\Models\Products\Category;
use PhpOffice\PhpSpreadsheet\Calculation\Web\Service;

class Section extends Model
{
	protected $table = 'sections';
	protected $guarded = [];

	public function Data()
	{
		return $this->hasMany(SectionData::class, 'section_id', 'id');
	}

	public function categories()
	{
		return $this->belongsToMany(Category::class, 'section_category', 'section_id', 'category_id');
	}

	public function banners()
	{
		return $this->belongsToMany(Banner::class, 'banner_section', 'section_id', 'banner_id');
	}

	public function services()
	{
		return $this->belongsToMany(Services::class, 'service_section', 'section_id', 'service_id');
	}

	public function partners()
	{
		return $this->belongsToMany(SuccessPartner::class, 'success_partner_section', 'section_id', 'success_partner_id');
	}

	public function translation()
	{
		return $this->hasOne(SectionData::class,'section_id','id')->where('lang_id', Lang::getSelectedLangId());
	}

	public function getImageAttribute($value)
	{
		if(\request()->is('api/*')){
			return url( $value);
		}
		return $value;
	}
    public function productsRelations($total = true)
    {
        if ($this->type == 'latest_products') {
            $categories = $this->categories->pluck('id');
            $products_1 = products::join("product_details", "product_details.product_id", "products.id")->where("lang_id", Lang::getSelectedLangId())
                ->where([
                    'hidden' => 0,
                ])->select("products.*", "product_details.title", "product_details.description" )
                ->orderBy('products.id', 'DESC');
            if (count($categories) > 0) {
                $products_1 = $products_1->join("categories_products", "categories_products.product_id", "products.id")->whereIn('categories_products.category_id', $categories);
            }

            return $products_1;

        } elseif ($this->type == 'best_selling_products') {
            $categories = $this->categories->pluck('id');
            $products_1 = products::join("product_details", "product_details.product_id", "products.id")
                ->where("lang_id", Lang::getSelectedLangId())->where('hidden', 0)
                ->select("products.*", "product_details.title", "product_details.description" );
            $products_1 =	$products_1->joinSub("select product_id,count(*) as c from order_products GROUP by product_id order by c desc", "orders", "orders.product_id", "products.id")
                ->orderBy('orders.c', 'DESC');
            if (count($categories) > 0) {
                $products_1 = $products_1->join("categories_products", "categories_products.product_id", "products.id")->whereIn('categories_products.category_id', $categories);
            }

            return $products_1;
        } elseif ($this->type == 'random_products') {

            $products_1 = products::join("product_details", "product_details.product_id", "products.id")
                ->join("section_products", "section_products.product_id", "products.id")->where("section_products.section_id", $this->id)
                ->where("lang_id", Lang::getSelectedLangId())
                ->select("products.*", "product_details.title", "product_details.description" )
                ->where('hidden', 0)->inRandomOrder();
             return $products_1;
        }

    }
    public function products($total = true)
	{
		if ($total)
			return $this->productsRelations()->get()->take($this->total)->shuffle();
		return $this->productsRelations()->get();
	}



    public function sectionProducts()
    {
        return $this->belongsToMany(products::class, 'section_products', 'section_id', 'product_id');
    }
}
