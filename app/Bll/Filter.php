<?php

namespace App\Bll;

use App\Modules\Admin\Models\Product\Classification;
use App\Modules\Admin\Models\Products\CategoryData;
use App\Modules\Admin\Models\Products\product_details;
use Illuminate\Database\Eloquent\Collection;
use App\Modules\Admin\Models\Products\ProductCategory;
use App\Modules\Admin\Models\Products\products;
use App\Modules\Admin\Models\Settings\Currency;
use App\Modules\Brands\Models\Brand;
use App\Modules\Portal\Models\Review;
use Illuminate\Pagination\LengthAwarePaginator;
use Maatwebsite\Excel\Concerns\ToArray;

class Filter
{
    private $lang_id, $settings, $products;
    public $search, $brand, $category, $section, $filter, $labels, $colors, $color_groups, $other_colors, $min_price, $max_price, $classification, $rate;
    public function __construct($settings, $lang_id)
    {
        $this->lang_id = $lang_id;
        $this->settings = $settings;

        Collection::macro('paginate', function ($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });
    }
    public function setProducts($products)
    {
        //dd($products);
        $this->products = $products;
    }


    public  function Get()
    {
        $products = $this->handle();

        if ($this->products == null) {
            $arr_products = $products->select("products.*")->get();
        } else {

            $arr_products =  $this->products;
        }
        //dd($products);
        $arr_categorirs  = ProductCategory::whereIn("product_id", $arr_products->pluck("id"))->get();

        $categories = CategoryData::where('lang_id', $this->lang_id)->whereIn("category_id", $arr_categorirs->pluck("category_id"))->get();
        //  dd( $arr_categorirs);
        $brands = Brand::with("translation")->whereIn("brands.id", $arr_products->pluck("brand_id"))->get();
        // classifications
        $classification = Classification::whereIn('id', $arr_products->pluck("classification_id"))->get();
        // $reviews = Review::get();
        //labels
        // $labels = LabelData::whereIn("lable_id", function ($q) use ($arr_products) {
        //     $q->from("product_lables")->whereIn("product_id", $arr_products->pluck("id"))->where("active", 1)->select("lable_id");
        // })->where("lang_id", getLang())->get();
        // //

        // $values = ProductLabelData::join("product_lables", "product_lables.id", "product_lables_data.item_id")->whereIn("product_lables.product_id", $arr_products->pluck("id"))
        //     ->where("product_lables.active", "1")
        //     ->where("lang_id", getLang())->get();

        //colors
        // $colors = $this->getType($arr_products->pluck("id"), "color");
        // $size = $this->getType($arr_products->pluck("id"), "size");

        // $products= $products->select("*");

        $products = $products->paginate($this->settings->products_per_page_website);
            // dd($products);
        ;
        return  compact('products', 'categories', 'brands','classification');
    }
    private function handle()
    {
        $filters = [];
        $details = product_details::where('product_details.title', 'LIKE', "%{$this->search}%");
        if ($this->products != null) {
            $products = $details->whereIn("product_id", $this->products->pluck("id"));
        }
        $details = $details->get();

        $ids = $details->pluck("product_id")->unique();
        //dd($ids);
        $products = products::whereIn("products.id", $ids)->where("hidden", 0)->where("stock", '>',0)->where("stock", '!=',null);

        if ($this->brand) {
            $products = $products->whereIn('brand_id', $this->brand);
        }
        if ($this->classification) {
            $products = $products->whereIn('classification_id', $this->classification);
        }
        if ($this->rate) {
            $products = $products->join("reviews", "products.id", "reviews.product_id")->whereIn("reviews.stars", $this->rate);
        }

        // if ($this->labels) {
        //     $find = ProductLabelData::whereIn("value",  $this->labels)->select("item_id")->get();

        //     $products = $products->whereIn('products.id', function ($q) use ($find) {
        //         $q->from("product_lables")->whereIn("id", $find)->select("product_id");
        //     });
        // }
        if ($this->category) {
            $category = $this->category;
            if (!is_array($category)) {
                $category = [$category];
            }
            $products = $products->join("categories_products", "products.id", "categories_products.product_id")->whereIn("categories_products.category_id", $category);
            // $products = $products->whereHas('categories', function ($query) use ($category) {
            // 	$query->whereIN('category_id', $category);
            // });
        }
        //sections
        // if ($this->section) {
        //     $coll = $this->section->productsRelations(false);
        //     if ($coll != null)
        //         $products =  $products->whereIn('products.id', $coll->select("products.id")); //($products);
        // }

        $products = $products->select("products.*");



        return $products;
    }

    public  function GetProducts()
    {
        $request = request();

        if (request()->ajax()) {

            if ($request->brand) {
                if (!is_array($request->brand))
                    $this->brand = [$request->brand];
                else
                    $this->brand = $request->brand;
            }
            if ($request->label) {
                $this->labels = $request->label;
            }
            if ($request->category) {
                $this->category = $request->category;
            }
            if ($request->filter != null) {
                $this->filter = $request->filter;
            }
            if ($request->color != null) {
                $this->colors = $request->color;
            }
            // if ($this->rate != null) {
            // dd($request->all());
            $this->rate = $request->rate;

            // }
            // if ($request->input("color-group") != null) {
            // 	$this->color_groups = $request->input("color-group");
            // }

            if ($request->min_price != null) {
                $this->min_price = $request->min_price;
            }
            if ($request->max_price != null) {
                $this->max_price = $request->max_price;
            }
            if ($request->classification != null) {
                $this->classification = $request->classification;
            }
        }




        $products = $this->handle()->distinct("products.id");


        if ($this->min_price != null || $this->max_price != null) {
            $products = $products->get();

            $user_currency = Currency::where('is_default', 1)->first();


            $products = $products->filter(function ($product, $key) use ($user_currency) {
                if (empty($product->discount))
                    $price =  Utility::number_formatted(Utility::product_price_after_discount_new($product->price, 0, false, $product->currency_code, false, $user_currency));
                else
                    $price = Utility::number_formatted(Utility::product_price_after_discount_new($product->price, $product->discount, false, $product->currency_code, false, $user_currency));

                $price = floatval($price);

                $bool = true;
                if (strlen($this->min_price) > 0)
                    $bool = ($price >= floatval($this->min_price));
                if (strlen($this->max_price))
                    $bool = $bool & ($price <= floatval($this->max_price));

                // echo $price ." {".$product->price. "}[" . $this->min_price . "," . $this->max_price . "]";

                return $bool;
            });
        }
        //	dd($products->get());



        $counter = $products->count();
        //$products = $products->paginate($this->settings->products_per_page_website);
        $products = $products->paginate($this->settings->products_per_page_website);


        return compact('products');
    }
}
