<?php

namespace App\Modules\portal\Controllers;

use App\Bll\Lang;
use App\Bll\Utility;
use App\Http\Controllers\Controller;
use App\Modules\Admin\Models\MailingList\MailingList;
use App\Modules\Admin\Models\Product\Classification;
use App\Modules\Admin\Models\Products\Category;
use App\Modules\Admin\Models\Products\Product;
use App\Modules\Admin\Models\Products\product_details;
use App\Modules\Admin\Models\Reviews\Review;
use App\Modules\Admin\Models\Settings\Currency;
use App\Modules\Orders\Models\Stock;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class ProductsController extends Controller
{
    public function show($id)
    {
        $lang_id = Lang::getSelectedLangId();
        $user_currency =  Currency::where('is_default', 1)->first();

        $product = Product::where('id', $id)->with(['translation', 'Attributes' ])->where("stock", '>',0)
        ->where("stock", '!=',null)
         ->has('translation')
        ->where("hidden", 0)->first();
 // dd($product);
        if ($product == null) {
            abort(404);
        }
        $image_path = 'uploads/products/' . $product->sku;
        $images = File::glob($image_path . '/*');
        //   dd($images);

        if (empty($product)) abort(404);
        if ($product->hidden == 1) return redirect('/');

        $product->stock = Stock::where('product_id', $product->id)
            ->sum('quantity');

        return view('portal.singlePages.product', compact('product', 'images'));
    }

    public function sendReview(Request $request, $id)
    {

        $product = Product::where('id', $id)->first();
        if ($product == NULL) return;

        if (auth()->check()) {
            //   dd($request->all());
            $validator = $request->validate([
                'stars' => 'required|integer|between:1,5',
                'comment' => 'required|max:1000'
            ]);

            try {
                Review::create([
                    'stars' => $request->stars,
                    'body' => $request->comment,
                    'published' => 0,
                    'product_id' => $product->id,
                    'user_id' => auth()->id(),
                ]);
            } catch (Exception $ex) {
                $errors = new \Illuminate\Support\MessageBag;
                $errors->add('errors', 'Sent before' . $ex->getMessage());

                return response($errors, 404);
            }

            return response()->json('success');
        }
    }
}
