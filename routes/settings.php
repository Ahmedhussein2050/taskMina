<?php

 use App\Modules\Admin\Controllers\Reports\ReportController;
use App\Modules\Admin\Controllers\Setting\AccountControlController;
use App\Modules\Admin\Controllers\Setting\BannersController;
use App\Modules\Admin\Controllers\Setting\DataRecoveryController;
use App\Modules\Admin\Controllers\Setting\SeoController;
use App\Modules\Admin\Controllers\Setting\SettingsController;
use App\Modules\Admin\Controllers\Setting\SliderController;
use App\Modules\Admin\Controllers\Setting\SmsController;
use App\Modules\Admin\Controllers\Setting\TaxController;
use App\Modules\Admin\Controllers\Setting\UsageController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Settings Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin settings routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::prefix('admin')->group(function () {

    Route::group(['middleware' => ['auth:admin']], function () {

    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::get('settings/get', [SettingsController::class, 'get_settings'])->name('settings.edit');
    Route::patch('settings/get', [SettingsController::class, 'updateSettings'])->name('settings.update');
    Route::get('settings/translation', [SettingsController::class, 'getSettingsTranslation'])->name('settings.translation');
    Route::patch('settings/translation', [SettingsController::class, 'updateSettingsTranslation'])->name('settings.update_translation');


    Route::resource('transferBank', 'Admin\Product\BankTransferController');

    Route::get('settings/sliders', [SliderController::class, 'index'])->name('slider.index');
    Route::post('settings/sliders/store', [SliderController::class, 'store']);
    Route::post('settings/sliders/update', [SliderController::class, 'update']);
    Route::get('settings/sliders/get/lang/value', [SliderController::class, 'getLangValue']);
    Route::post('settings/sliders/lang/store', [SliderController::class, 'storelangTranslation']);
    Route::delete('settings/sliders/{id}', [SliderController::class, 'delete'])->name('admin_slider.destroy');

    Route::get('settings/usages', [UsageController::class, 'index'])->name('usages.index');
    Route::post('settings/usages/store', [UsageController::class, 'store']);
    Route::post('settings/usages/update', [UsageController::class, 'update']);
    Route::get('settings/usages/get/lang/value', [UsageController::class, 'getLangValue']);
    Route::post('settings/usages/lang/store', [UsageController::class, 'storelangTranslation']);
    Route::delete('settings/usages/{id}', [UsageController::class, 'delete'])->name('usages.destroy');


    Route::get('settings/features', 'Admin\FeatureController@index')->name('settings.features.index');
    Route::get('settings/features/get', 'Admin\FeatureController@get_features')->name('settings.features.edit');
    Route::patch('settings/features/get', 'Admin\FeatureController@updateSettings')->name('settings.features.update');
    Route::get('settings/features/translation', 'Admin\FeatureController@getSettingsTranslation')->name('settings.features.translation');
    Route::patch('settings/features/translation', 'Admin\FeatureController@updateSettingsTranslation')->name('settings.features.update_translation');



    Route::get('settings/banners', [BannersController::class, 'index'])->name('banner.index');
    Route::post('settings/banners/store', [BannersController::class, 'store']);
    Route::post('settings/banners/update', [BannersController::class, 'update']);
    Route::get('settings/banners/get/lang/value', [BannersController::class, 'getLangValue']);
    Route::post('settings/banners/lang/store', [BannersController::class, 'storelangTranslation']);
    Route::delete('settings/banners/{id}', [BannersController::class, 'delete'])->name('banner.destroy');

    Route::get('storeOptions', 'Admin\Setting\StoreOptionController@index')->name('storeOptions.index');
    Route::post('storeOptions/maintenance/{id}', 'Admin\Setting\StoreOptionController@storeMaintenance')->name('storeOptions.storeMaintenance');
    Route::post('storeOptions/options/{id}', 'Admin\Setting\StoreOptionController@storeOptions')->name('storeOptions.storeOptions');

    // setting sms name reservation
    Route::get('sms', [SmsController::class,'index'])->name('sms.index');
    Route::get('sms/generateDocs', [SmsController::class,'generateDocs'])->name('sms.generateDocs');
    Route::post('sms/store', [SmsController::class,'store'])->name('sms.store');

    Route::get('connectServices', [SettingsController::class, 'connectServices'])->name('connectServices');

    Route::get('seo', [SeoController::class,'StoreSeo'])->name('seo.index');
    Route::post('seo/setting', [SeoController::class,'settingStore'])->name('seo.storeSetting');
    Route::post('seo/product', [SeoController::class,'productStore'])->name('seo.storeProduct');

    Route::get('tax', [TaxController::class,'index'])->name('taxPrep');
    Route::post('tax/store', [TaxController::class,'storeTax'])->name('TaxStore');
    Route::post('updateTaxStatus', [TaxController::class,'updateTaxStatus'])->name('updateTaxStatus');
    Route::post('updateTaxStatusnumb', [TaxController::class,'updateTaxStatusnumb'])->name('updateTaxStatusnumb');
    Route::post('taxnumb/store/{id}', [TaxController::class,'storeTaxNumb'])->name('TaxNumbStore');
    Route::post('taxnoptions/store/{id}', [TaxController::class,'storeOptions'])->name('Taxoptions');
    Route::get('taxs/all', [TaxController::class,'getDatatabletaxs'])->name('alltaxs');
    Route::patch('taxs/{tax}', [TaxController::class,'update_taxs'])->name('updatetaxs');
    Route::delete('taxs/delete/{id}', [TaxController::class,'taxs_destroy'])->name('taxs.destroy');
    Route::get('taxs/translation', [TaxController::class,'translation'])->name('taxs.get_translation');
    Route::post('taxs/translation', [TaxController::class,'storeTranslation'])->name('taxs.store_translation');

    Route::get('accountControl', [AccountControlController::class, 'index'])->name('accountControl.index');
    Route::post('accountControl/change', [AccountControlController::class, 'change_setting']);

    Route::get('dataRecovery', [DataRecoveryController::class,'index'])->name('dataRecovery.index');
    Route::get('dataRecovery/products', [DataRecoveryController::class,'getProducts'])->name('dataRecovery.products');
    Route::post('dataRecovery/products', [DataRecoveryController::class,'restoreProduct'])->name('dataRecovery.restoreProduct');
    Route::get('dataRecovery/orders', [DataRecoveryController::class,'getOrders'])->name('dataRecovery.orders');
    Route::post('dataRecovery/orders', [DataRecoveryController::class,'restoreOrder'])->name('dataRecovery.restoreOrder');

    Route::get('settings/currency/get_datatable', [SettingsController::class, 'getDatatablecurrency'])->name('allcurrency');
    Route::post('settings/currency/store', [SettingsController::class, 'store_currency']);;
    Route::get('settings/currency/{id}/edit', [SettingsController::class, 'edit_currency']);
    Route::post('settings/currency/{id}/update', [SettingsController::class, 'update_currency']);;
    Route::delete('settings/currency/{id}/delete', [SettingsController::class, 'currency_destroy'])->name('currency.destroy'); //;
    Route::get('settings/currency', [SettingsController::class, 'get_currency'])->name('currency-setting');
    Route::get('currency/get/lang/value', [SettingsController::class, 'currencygetLangvalue'])->name('currency_lang_value');
    Route::post('currency/lang/store', [SettingsController::class, 'currencystorelangTranslation'])->name('currency_lang_store');

    

    Route::get('newsletters', 'Admin\NewsLetterController@index');
    Route::get('newsletters/export', 'Admin\NewsLetterController@expotNewsLettersExcel');

    //Report
    Route::resource('reports', 'Admin\ReportController');



    Route::resource('celebrates', 'Admin\CelebrateController');

    Route::get('content_management/{id}/edit/{lang}', 'Admin\ContentController@edit');
    Route::resource('content_management', 'Admin\ContentController');
    Route::get('content/sort', 'Admin\ContentController@sort');



    Route::group(['namespace' => 'Admin\Articles'], function () {
        Route::get('blog', 'ArticlesController@index')->name('blog.index');
        Route::get('blog/create', 'ArticlesController@create')->name('blog.create');
        Route::post('blog/store', 'ArticlesController@store')->name('blog.store');
        Route::get('blog/{id}/edit', 'ArticlesController@edit')->name('blog.edit');
        Route::post('blog/{id}/update', 'ArticlesController@update')->name('blog.update');
        Route::get('blog/get/lang/value', 'ArticlesController@getLangvalue');
        Route::post('blog/lang/store', 'ArticlesController@storelangTranslation');
        Route::delete('blog/{id}', 'ArticlesController@delete')->name('articles.destroy');


        Route::get('blog/categories', 'ArticleCategoryController@index')->name('blog_categories.index');
        Route::get('blog/categories/create', 'ArticleCategoryController@create');
        Route::post('blog/categories/store', 'ArticleCategoryController@store')->name('blog_categories.store');
        Route::get('blog/categories/{id}/edit', 'ArticleCategoryController@edit');
        Route::post('blog/categories/{id}/update', 'ArticleCategoryController@update');
        Route::delete('blog/categories/{id}', 'ArticleCategoryController@delete')->name('artcl_categories.destroy');
        Route::get('get_categories', 'ArticleCategoryController@get_categories');
        Route::get('blog/categories/get/lang/value', 'ArticleCategoryController@getLangvalue');
        Route::post('blog/categories/lang/store', 'ArticleCategoryController@storelangTranslation');
    });

    Route::get('settings/products', 'Admin\SettingsController@products')->name('product_settings.index');
    Route::patch('settings/products/{id}', 'Admin\SettingsController@updateProducts')->name('product_settings.update');

    Route::get('settings/chat', 'Admin\SettingsController@chat')->name('chat_settings.index');
    Route::patch('settings/chat/{id}', 'Admin\SettingsController@updateChat')->name('chat_settings.update');
});

});
