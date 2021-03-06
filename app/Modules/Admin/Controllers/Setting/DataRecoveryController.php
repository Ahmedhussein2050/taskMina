<?php

namespace App\Modules\Admin\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Modules\Admin\Models\Orders;
use App\Modules\Admin\Models\Products\products;
use Illuminate\Http\Request;

class DataRecoveryController extends Controller
{
    public function index()
    {
        return view('admin.settings.dataRecovery.index');
    }

    public function getProducts()
    {
        $products = products::leftJoin('product_details', 'product_details.product_id', 'products.id')
            ->where('products.store_id', session()->get("StoreId"))
            ->where('product_details.source_id', null)
            ->select('products.*', 'product_details.title')
            ->onlyTrashed()
            ->get();
        $product_type = '';
//        $product_type = Product_type::join('product_types_data', 'product_types_data.product_types_id', 'product_types.id')
//            ->whereNull('product_types_data.source_id')
//            ->where('product_types.store_id', session()->get("StoreId"))
//            //->get()
//            ->pluck("product_types_data.title", "product_types.id");
//        dd($products);
        return view('admin.settings.dataRecovery.products', compact('products', 'product_type'));
    }

    public function restoreProduct(Request $request)
    {
        $product = products::onlyTrashed()->where('store_id', session()->get("StoreId"))->find($request->id);



        if (!is_null($product)) {

            $product->restore();

            $product->product_details()->whereNotNull('deleted_at')->update(['deleted_at' => null]);
            $product->main_product_photo()->whereNotNull('deleted_at')->update(['deleted_at' => null]);
            $product->product_details()->whereNotNull('deleted_at')->update(['deleted_at' => null]);
            $product->product_photos()->whereNotNull('deleted_at')->update(['deleted_at' => null]);

            return response()->json(['status' => 'success']);

        } else {

            return response();
        }
    }

    public function getOrders()
    {
        $orders = orders::where('store_id', session()->get("StoreId"))->onlyTrashed()->get();
        return view('admin.settings.dataRecovery.orders', compact('orders'));
    }

    public function restoreorder(Request $request)
    {
        $order = orders::onlyTrashed()->where('store_id', session()->get("StoreId"))->find($request->id);

        if (!is_null($order)) {
            $order->restore();
            $order->orderProducts()->whereNotNull('deleted_at')->update(['deleted_at' => null]);;
            $order->gettransactions()->whereNotNull('deleted_at')->update(['deleted_at' => null]);;
            return response()->json(['status' => 'success']);
        } else {

            return response();
        }
    }
}
