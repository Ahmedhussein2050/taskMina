<?php

namespace App\Bll\Offers;

use App\CartProductOption;
use App\Modules\Admin\Models\Products\products;

class OneFree
{
    private $pre_condition, $products_with_additions, $offer, $ids, $total, $count;

    public function __construct($offer, $total, $ids, $count)
    {
        //dd($offer, $total, $ids, $count);
        $options_prices =  CartProductOption::join("products", "products.id", "product_id")->whereIn("products.id", $ids)->join("feature_options", "feature_options.id", "option_id")->select("product_id", "feature_options.price");
        $this->products_with_additions = products::whereIn("products.id", $ids)->leftJoinSub($options_prices, 'options', function ($join) {
            $join->on('products.id', '=', 'options.product_id');
        })->selectRaw("((IFNULL(options.price,0) + products.price)*1.15) as total,products.id");

        //$min_cart = Offer_pre_condition::where('offer_id', $offer->id)->first();
        $this->pre_condition = $offer->pre_condition;
        $this->offer = $offer;
        $this->total = $total;
        $this->ids = $ids;
        $this->count = $count;
        if ($this->pre_condition->free_products_max_price == null) {
            $this->pre_condition->free_products_max_price = 0;
        }
    }

    private function oneFreeWithMiniCartAmount()
    {
        if ($this->pre_condition->min_cart_amount < $this->total) {
            //find product with price greater than mimimum cart amount
            $buy_products = with(clone $this->products_with_additions)->get()->where("total", ">=", $this->pre_condition->min_cart_amount)->sortByDesc("total")->take(1);
            if ($buy_products == null)
                $buy_products = with(clone $this->products_with_additions)->groupBy("id")->havingRaw("sum(total)>=" . $this->pre_condition->min_cart_amount)->get(); //SELECT id FROM products group by id having sum(price)>300;
            // extract the mimimum cart amount from the cart
            return $this->calculate($buy_products);
        }
        return response()->json('error');
    }

    private function getCart($free_products)
    {
        $buy_ids = array_diff($this->ids, $free_products->pluck("id")->toArray());

        if ($this->products_with_additions->get()->whereIn("id", $buy_ids)->sum("total") >= $this->pre_condition->min_cart_amount) {
            return response()->json(['status' => 'success', 'data' => $free_products->sum("total"), 'id' => $this->offer->id]);
        }
    }


    private function calculate($buy_products)
    {
        $free_ids = array_diff($this->ids, $buy_products->pluck("id")->toArray());
        $free = with(clone $this->products_with_additions)->whereIn("id", array_values($free_ids));
        if ($this->offer->productsFree->count() > 0) {
            $free = $free->whereIn("id", $this->offer->productsFree->pluck("id"));
        }

        $total_free = $free->orderBy("total")->take($this->pre_condition->free_products_num)->get()->sum("total");
        if ($total_free > $this->pre_condition->free_products_max_price &&  $this->pre_condition->free_products_max_price != 0) {
            $price = $this->pre_condition->free_products_max_price;
        } else {
            $price = $total_free;
        }

        $free_ids = $this->ids;
        if ($this->pre_condition->min_cart_amount != null) {
            if ($this->offer->productsFree->count() > 0) {
                $free_ids = $this->offer->productsFree->whereIn("id", $this->ids)->pluck("id");
                if (count($free_ids) == 0)
                    return;
            }
            $free_products = $this->products_with_additions->get()->whereIn("id", $free_ids)->take($this->pre_condition->free_products_num);
            if ($this->offer->productsFree->count() > 0) {
                if ($free_products->sum("total") >=  $this->pre_condition->free_products_max_price) {
                    //
                    return $this->getCart($free_products);
                }
            } else {
                $free_products = $this->products_with_additions->get()->whereIn("id", $free_ids)->where("total", "<=", $this->pre_condition->free_products_max_price)->take($this->pre_condition->free_products_num);
                return $this->getCart($free_products);
            }
            return;

            if (($this->total - $total_free) >= $this->pre_condition->min_cart_amount) {
                return response()->json(['status' => 'success', 'data' => $price, 'id' => $this->offer->id]);
            } else
                return response()->json('error');
        }

        if ($free == null)
            return response()->json('error');

        if ($price == 0)
            return response()->json('error');

        return response()->json(['status' => 'success', 'data' => $price, 'id' => $this->offer->id]);
    }

    public  function Get()
    {
        //minimum cart
        if ($this->pre_condition->min_cart_amount != null) {
            if (count($this->ids) >= ($this->pre_condition->buy_products_num + $this->pre_condition->free_products_num))
                return $this->oneFreeWithMiniCartAmount();
            return;
        }

        $buy_products = with(clone $this->products_with_additions)->get();
        if ($this->offer->products->count() > 0) {
            $buy_products = with(clone $this->products_with_additions)->join("offer_products", "products.id", "offer_products.product_id")->where("offer_products.offer_id", $this->offer->id)->get();
        }
        if ($buy_products->count() >= $this->pre_condition->buy_products_num + $this->pre_condition->free_products_num) {
            $buy_products = $buy_products->take($this->pre_condition->buy_products_num);
            return ($this->calculate($buy_products));
        }
        return response()->json('error');
    }
}
