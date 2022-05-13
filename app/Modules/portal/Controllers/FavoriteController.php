<?php

namespace App\Modules\portal\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Modules\Admin\Models\Products\Product;
use App\Modules\portal\Models\Favourite;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Auth;
use App\Modules\Notification\Models\Notifications;
use Illuminate\Support\Facades\Notification;

class FavoriteController extends Controller


{
    public function create($product)
    {
        //dd($product);
        if (!Auth::user()) {
            return response()->json(['status' => 'failed', 'message' => _i('You have to login to favorite product')]);
        }

        $product = Product::where('id',$product)->where("stock", '>',0);
        if ($product == NULL) {
            return response()->json(['status' => 'error', 'message' => _i('Something Wrong Happened')]);
        }
        //dd($product);
        if ($product->fav != null) {
            Favourite::where('product_id', $product->id)->where('user_id', auth()->user()->id)->delete();
            return response()->json(['status' => 'success', 'message' => _i('Product Removed from your favorites successfully')]);
        } else {
            Favourite::create([
                'user_id' => auth()->user()->id,
                'product_id' => $product->id,
            ]);
            $names = [];
            $text = [];
            foreach (Language::get() as $lang) {
                if ($lang->code == 'ar') {
                    $names['ar'] = ('تم اضافه المنتج الى المفضلة');
                    $text['ar'] = ('تم اضافه المنتج الى المفضلة');
                }
                if ($lang->code = 'en') {
                    $names['en'] = ('product added to favourite successfully');
                    $text['en'] = ('product added to favourite successfully');
                }
            }
            $favData = [
                'name' => $names,
                'text' =>  $text,
                'url' => url('/product/' . $product->id),
                'id' => $product->id,

            ];

            Notification::send(auth()->user(), new \App\Notifications\FavouriteProduct($favData));
            return response()->json(['status' => 'success', 'message' => _i('Product added to your favorite successfully')]);
        }
    }
}
