<?php

use App\Modules\Admin\Controllers\Categories\CategoryController;

use App\Modules\Orders\Controllers\orders\OrdersController;
use App\Modules\Orders\Controllers\shippings\companiesShippingController;
use App\Modules\Orders\Controllers\shippings\ShippingOptionsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::prefix('admin')->group(function () {
    Route::group(['middleware' => ['auth:admin']], function () {
//        Route::get('products', [ProductsController::class, 'index'])->name('products.index')->middleware(['permission:Products']);
        Route::get('googlesync', [GoogleMerchantController::class, 'index']);
        Route::post('googlesync/{id}', [GoogleMerchantController::class, 'insert']);
        Route::post('googlesyncAll', [GoogleMerchantController::class, 'insertSyncAll']);

        Route::post('meta/store', [MetaProductController::class, 'store'])->name('meta.store');
        Route::get('data', [MetaProductController::class, 'getData'])->name('get-meta-data');


//        Route::post('features/store/{id}', [ProductsController::class, 'newSaveFeature'])->name('features.store');
//        Route::post('features/update/{id}', [ProductsController::class, 'updateFeature'])->name('features.update');
//        Route::get('features/check/{id}', [ProductsController::class, 'checkFeature'])->name('features.check');

//        Route::get('get_ajax_addition', [ProductsController::class, 'get_ajax_addition'])->middleware(['permission:Products']);

//        Route::get('product/all', [ProductsController::class, 'all_products'])->middleware(['permission:Products']);
//        Route::get('product/{id}/edit', [ProductsController::class, 'edit'])->middleware(['permission:Products']);
//        Route::get('product/{id}/show', [ProductsController::class, 'show_product'])->middleware(['permission:Products']);
//        Route::get('product/{id}/img', [ProductsController::class, 'get_images'])->middleware(['permission:Products']);
//        Route::get('product/{id}/video', [ProductsController::class, 'getVideos'])->middleware(['permission:Products']);
//        Route::delete('product/delete/{id}', [ProductsController::class, 'delete'])->name('productdelete')->middleware(['permission:Products']);
//        Route::post('dublicate/{id}', [ProductsController::class, 'dublicated'])->name('product_dublicate')->middleware(['permission:Products']);
//        Route::get('get_status', [ProductsController::class, 'Get_status'])->name('get_status')->middleware(['permission:Products']);
//        Route::get('hidden', [ProductsController::class, 'hidden'])->name('get_hidden')->middleware(['permission:Products']);
//        Route::get('product/customers/{id}', [ProductsController::class, 'Get_users_product'])->name('product.customers');
//        Route::post('saveproduct', [ProductsController::class, 'saveproduct'])->middleware(['permission:Products']);
//        Route::post('updateproduct', [ProductsController::class, 'updateproduct'])->middleware(['permission:Products']);
//        Route::post('saveProductDetails', [ProductsController::class, 'saveProductDetails'])->name('product.savedetails')->middleware(['permission:Products']);
//        Route::post('saveAllCat', [ProductsController::class, 'saveAllCat'])->middleware(['permission:Products']);
//        Route::post('savefeatures', [ProductsController::class, 'savefeatures'])->name('product.savefeatures')->middleware(['permission:Products']);
//        Route::get('product/{feature_id}/featuredel', [ProductsController::class, 'featuredel'])->middleware(['permission:Products']);
//        Route::get('getproduct/{id}', [ProductsController::class, 'getproduct'])->middleware(['permission:Products']);
//        Route::post('product/imagespost', [ProductsController::class, 'imagespost'])->name('product.imagespost')->middleware(['permission:Products']);
//        Route::post('imageSubmit', [ProductsController::class, 'imageSubmit'])->middleware(['permission:Products']);
//        Route::post('upload_video', [ProductsController::class, 'uploadVideo'])->middleware(['permission:Products']);
//        Route::post('imagesdel', [ProductsController::class, 'imagesdel'])->name('product.imagesdel')->middleware(['permission:Products']);
//        Route::post('product/productdel', [ProductsController::class, 'productdel'])->middleware(['permission:Products']);
//        Route::get('product/{cat_id}/catdel', [ProductsController::class, 'catdel'])->middleware(['permission:Products']);
//        Route::get('product/get/lang/value', [ProductsController::class, 'ProductrgetLangvalue'])->name('Product_lang_value')->middleware(['permission:Products']);
//        Route::post('product/lang/store', [ProductsController::class, 'ProductstorelangTranslation'])->name('Product_lang_store')->middleware(['permission:Products']);
//        Route::get('product/data', [ProductsController::class, 'getData'])->name('get-product-data')->middleware(['permission:Products']);
//        Route::get('product/getFeatures', [ProductsController::class, 'getFeatures'])->name('getFeatures')->middleware(['permission:Products']);
//        Route::post('product/deleteFeatureOption', [ProductsController::class, 'deleteFeatureOption'])->name('deleteFeatureOption')->middleware(['permission:Products']);
//        Route::get('product/get/similarProducts', [ProductsController::class, 'getSimilarProducts'])->name('getSimilarProducts')->middleware(['permission:Products']);
//        Route::post('product/similarProducts/store', [ProductsController::class, 'saveSimilarProducts'])->name('save.getSimilarProducts')->middleware(['permission:Products']);
//        Route::get('product/similarProducts', [ProductsController::class, 'similarProducts'])->name('similarProducts')->middleware(['permission:Products']);

        Route::get('product_type/all', [ProductTypeController::class, 'all'])->middleware(['permission:Products']);
        Route::get('product_type/get_datatable', [ProductTypeController::class, 'datatableProductType'])->middleware(['permission:Products']);
        Route::post('product_type/store', [ProductTypeController::class, 'store'])->middleware(['permission:Products']);
        Route::post('product_type/update', [ProductTypeController::class, 'update'])->middleware(['permission:Products']);
        Route::get('product_type/delete', [ProductTypeController::class, 'delete'])->middleware(['permission:Products']);

        Route::get('get/product/card', [ProductTypeController::class, 'getCard'])->name('get_card')->middleware(['permission:Products']);
        Route::post('product/card', [ProductTypeController::class, 'postCard'])->name('post_card')->middleware(['permission:Products']);
        Route::delete('product/card/delete', [ProductTypeController::class, 'delete_card'])->name('delete_card')->middleware(['permission:Products']);

        Route::get('get/product/digital', [ProductTypeController::class, 'getdigital'])->name('get_digital')->middleware(['permission:Products']);
        Route::post('product/digital', [ProductTypeController::class, 'postdigital'])->name('post_digital')->middleware(['permission:Products']);
        Route::delete('product/del_digital', [ProductTypeController::class, 'delDigital'])->name('del_digital')->middleware(['permission:Products']);

        Route::get('get/product/donate', [ProductTypeController::class, 'getdonate'])->name('get_donate')->middleware(['permission:Products']);
        Route::post('product/donate', [ProductTypeController::class, 'postdonate'])->name('post_donate')->middleware(['permission:Products']);

        Route::get('orders/all', [OrdersController::class, 'index'])->name('admin.orders.index')->middleware(['permission:Products']);
        Route::get('all_orders', [OrdersController::class, 'showAll'])->name('admin.orders.all')->middleware(['permission:Products']);
        Route::get('orders/{id}/edit', [OrdersController::class, 'edit'])->middleware(['permission:Products']);
        Route::delete('orders/{id}/delete', [OrdersController::class, 'delete'])->name('orders.destroy')->middleware(['permission:Products']);
        Route::get('orders', [OrdersController::class, 'show'])->middleware(['permission:Products']);
        Route::post('orders', [OrdersController::class, 'store'])->middleware(['permission:Products']);
        Route::post('saveallorders', [OrdersController::class, 'saveallorders'])->name('save-new-Product')->middleware(['permission:Products']);
        Route::post('order/remove', [OrdersController::class, 'removeProduct'])->middleware(['permission:Products']);

        Route::post('updateallorders', [OrdersController::class, 'updateallorders'])->name('update-Product')->middleware(['permission:Products']);
        Route::post('orders/update', [OrdersController::class, 'update'])->middleware(['permission:Products']);

        Route::get('orders/{id}/show', [OrdersController::class, 'showOrder'])->name('show_orders')->middleware(['permission:Products']);
        Route::get('orders/{id}/print', [OrdersController::class, 'printOrder'])->name('print_order')->middleware(['permission:Products']);
        Route::post('userOrderNotification', [OrdersController::class, 'userOrderNotification'])->name('userOrderNotification')->middleware(['permission:Products']);

        Route::get('get/pays', [OrdersController::class, 'getPayways'])->name('get-pay-banks')->middleware(['permission:Products']);

        Route::post('orders/saveproduct', [OrdersController::class, 'saveproduct'])->middleware(['permission:Products']);
        Route::post('orders/savenewuser', [OrdersController::class, 'savenewuser'])->name('orders.savenewuser')->middleware(['permission:Products']);
        Route::get('orders/refreshproducts', [OrdersController::class, 'refreshproducts'])->middleware(['permission:Products']);

        Route::post('review/order', [OrdersController::class, 'reviewOrder'])->name('review-order')->middleware(['permission:Products']);

        Route::get('get/product', [OrdersController::class, 'getproduct'])->name('get-product')->middleware(['permission:Products']);
        Route::get('get/product/single', [OrdersController::class, 'getproductsingle'])->name('get-product-single')->middleware(['permission:Products']);
        Route::post('getShippingOptions', [ShippingOptionsController::class, 'getShippingOptions'])->name('getShippingOptions')->middleware(['permission:Shipping']);
        Route::post('getCountriesShipping', [ShippingOptionsController::class, 'getCountriesShipping'])->middleware(['permission:Shipping']);
        Route::get('shipping_option/all', [ShippingOptionsController::class, 'index'])->middleware(['permission:Shipping']);
//        Route::resource('companies', [companiesShippingController::class])->middleware(['permission:Shipping']);
        Route::get('getcitiesbycountry/{country}', [ShippingOptionsController::class, 'getCitiesByCountry'])->middleware(['permission:Shipping']);
        Route::get('getCities', [ShippingOptionsController::class, 'getCities'])->name('getCitiesByCountry')->middleware(['permission:Shipping']);
        Route::get('getcitybyid/{city}', [ShippingOptionsController::class, 'getCityById'])->middleware(['permission:Shipping']);
        Route::get('shipping_option/create', [ShippingOptionsController::class, 'create'])->middleware(['permission:Shipping']);
        Route::post('shipping_option/store', [ShippingOptionsController::class, 'store'])->middleware(['permission:Shipping']);
        Route::get('shipping_option/{id}/edit', [ShippingOptionsController::class, 'edit'])->middleware(['permission:Shipping']);
        Route::put('shipping_option/{id}/update', [ShippingOptionsController::class, 'update'])->middleware(['permission:Shipping']);
        Route::delete('shipping_option/{id}/delete', [ShippingOptionsController::class, 'delete'])->name('shipping_option.destroy')->middleware(['permission:Shipping']);

        Route::get('category/create', [CategoryController::class, 'create']);
        Route::get('product_status', [ProductFilterController::class, 'product_status'])->name('product.getstatus')->middleware(['permission:Products']);
        Route::get('product_search', [ProductFilterController::class, 'product_search'])->name('product.product_search')->middleware(['permission:Products']);
        Route::get('product_brand', [ProductFilterController::class, 'product_brand'])->name('product.getbrand')->middleware(['permission:Products']);
        Route::get('product_type', [ProductFilterController::class, 'product_type'])->name('product.gettype')->middleware(['permission:Products']);
        Route::get('product_category', [ProductFilterController::class, 'product_category'])->name('product.getcategory')->middleware(['permission:Products']);
        Route::get('product/instagram/sync', [InstagramController::class, 'redirectTo'])->name('instagram.sync')->middleware(['permission:Products']);
        Route::get('product/instagram/callback', [InstagramController::class, 'Callback'])->name('instagram.callback')->middleware(['permission:Products']);

        Route::get('comments', [CommentsController::class, 'index'])->middleware(['permission:Comments']);
        Route::patch('comments/{comment}', [CommentsController::class, 'update'])->name('comments.update')->middleware(['permission:Comments']);
        Route::delete('comments/{comment}', [CommentsController::class, 'delete'])->name('comments.destroy')->middleware(['permission:Comments']);
        Route::post('comments/{comment}/reply', [CommentsController::class, 'reply'])->name('comments.reply')->middleware(['permission:Comments']);
        Route::patch('comments/{comment}/approve', [CommentsController::class, 'approve'])->name('comments.approve')->middleware(['permission:Comments']);

//        Route::get('products/request', [ProductsController::class, 'productRequest'])->name('products.requested')->middleware(['permission:Products']);
//        Route::get('products/notify', [ProductsController::class, 'productOutNotify'])->name('products.notify')->middleware(['permission:Products']);

//        Route::get('products/custom/fields/show', [ProductsController::class, 'showCustomFields'])->name('products.custom.fields.show');
//        Route::post('products/custom/fields/store', [ProductsController::class, 'storeCustomFields'])->name('products.custom.fields.store');
//        Route::delete('products/custom/fields/option/destroy', [ProductsController::class, 'destroyCustomFieldOption'])->name('products.custom.fields.options.destroy');
//        Route::delete('products/custom/fields/destroy', [ProductsController::class, 'destroyCustomField'])->name('products.custom.fields.destroy');
//        Route::get('products/qr', [ProductsController::class, 'allProducts'])->name('products.qr')->middleware(['permission:Products']);

        Route::post('lable/autocmplete', [LabelsController::class, 'fetch'])->name('lable.autocmplete');
        Route::post('lable/autocmplete/detail', [LabelsController::class, 'fetchDetail'])->name('lable.autocmplete.detail');
        Route::post('label-store', [LabelsController::class, 'store'])->name('new.label');

        Route::post('save_detail', [LabelsController::class, 'save_detail'])->name('save_detail')->middleware(['permission:Products']);
        Route::post('get_detail/{id}', [LabelsController::class, 'get_detail'])->name('get_detail')->middleware(['permission:Products']);
        Route::post('delete_detail', [LabelsController::class, 'delete_detail'])->name('delete_detail');

        // sync label translation
        Route::post('label/sync-translation', [LabelsController::class, 'syncTranslation'])->name('sync.translation');


//        Route::post('get_translate_feature/{id}', [ProductsController::class, 'get_translate_feature'])->name('get_translate_feature')->middleware(['permission:Products']);
//        Route::post('products/saveTranslateFeature', [ProductsController::class, 'saveTranslateFeature'])->name('saveTranslateFeature')->middleware(['permission:Products']);
//        Route::post('products/saveTranslateFeatureType', [ProductsController::class, 'saveTranslateFeatureType'])->name('saveTranslateFeatureType')->middleware(['permission:Products']);

//        Route::post('get_translate_fields/{id}', [ProductsController::class, 'get_translate_fields'])->name('get_translate_fields')->middleware(['permission:Products']);
//        Route::post('products/saveTranslateFields', [ProductsController::class, 'saveTranslateFields'])->name('saveTranslateFields')->middleware(['permission:Products']);
//        Route::get('reviews', [ReviewsController::class, 'index'])->name('reviews.index')->middleware(['permission:Comments']);
//        Route::post('reviews', [ReviewsController::class, 'store'])->middleware(['permission:Comments']);
//        Route::post('reviews/update', [ReviewsController::class, 'update'])->name('reviews.update')->middleware(['permission:Comments']);
//        Route::get('reviews/destroy/{id}', [ReviewsController::class, 'destroy'])->name('reviews.destroy')->middleware(['permission:Comments']);
    });
});
