<?php

namespace App\Bll;

use App\Models\AbandonedCart;
use App\Modules\Admin\Models\Settings\Setting;
use Carbon\Carbon;

class Cart
{
    public function __construct($product = null)
    {
        $this->product = $product;
        $this->user_id = auth()->user()->id;
    }

    public function addToCart()
    {
        $cart = AbandonedCart::where('user_id', $this->user_id)->where('item_id', $this->product->id)->first();
        if ($cart != null) {
            $cart->update([
                'qty' => $cart->qty + 1
            ]);
        } else {
            AbandonedCart::create([
                'user_id' => $this->user_id,
                'item_id' =>  $this->product->id,
                'qty'     =>  1,
                'total_price'   => $this->product->getPriceWithTax($this->product->price)
            ]);
        }
        return $this->cartitems();
    }

    public function increase()
    {
        $cart = AbandonedCart::where('user_id', $this->user_id)->where('item_id', $this->product->id)->first();
        if ($cart != null) {
            $cart->update([
                'qty' => $cart->qty + 1
            ]);
        }
        $discount = $cart->product->discounts($cart->product);
        if ($discount != null) {
            if ($discount->calc_type == 'perc') {
                $total  = $cart->getPriceAttribute($cart) - ($cart->getPriceAttribute($cart) * $discount->value) / 100;

            } else {
                $total  = $cart->getPriceAttribute($cart) - $discount->value;

            }
        } else {
            $total =  $cart->qty * $cart->total_price;
        }
       //  dd( $total);
        return  $total;
    }

    public function decrease()
    {
        $cart = AbandonedCart::where('user_id', $this->user_id)->where('item_id', $this->product->id)->first();
        if ($cart != null && $cart->qty > 1) {
            $cart->update([
                'qty' => $cart->qty - 1
            ]);
        }
        $discount = $cart->product->discounts($cart->product);
        if ($discount != null) {
            if ($discount->calc_type == 'perc') {
                $total  = $cart->getPriceAttribute($cart) - ($cart->getPriceAttribute($cart) * $discount->value) / 100;
             } else {
                $total  = $cart->getPriceAttribute($cart) - $discount->value;
             }
        } else {
            $total =  $cart->qty * $cart->total_price;
        }
        return  $total;
    }

    public function destroy()
    {
        $cart = AbandonedCart::where('user_id', $this->user_id)->where('item_id', $this->product->id)->first();
        if ($cart != null) {
            $cart->delete();
        }
    }

    // private function totalAfterTax()
    // {
    //     $settings = Setting::first();
    //     if ($settings) {
    //         $tax = $settings->tax_on_product;
    //         return   $this->product->price + ($this->product->price * ($tax / 100));
    //     }
    // }

    public function cartitems()
    {
        $cart = AbandonedCart::where('user_id', $this->user_id)->count();
        return $cart;
    }
}
