<?php

use App\ImageAccount;
use App\Modules\Admin\Controllers\AdminController;
use App\Modules\Admin\Controllers\AdminLoginController;
use App\Modules\Admin\Controllers\AttributeController;
use App\Modules\Admin\Controllers\Categories\CategoryController;
use App\Modules\Admin\Controllers\Contact\ContactsController;
use App\Modules\Admin\Controllers\DashboardController;
use App\Modules\Admin\Controllers\Discounts\DiscountsController;
use App\Modules\Admin\Controllers\Discounts\ManagerController;
use App\Modules\Admin\Controllers\ImageAccountController;
use App\Modules\Admin\Controllers\ImageSettingController;
use App\Modules\Admin\Controllers\LanguageController;
use App\Modules\Admin\Controllers\Mails\MailingListController;
use App\Modules\Admin\Controllers\Mails\MailingListGroupController;
use App\Modules\Admin\Controllers\Mails\MailingTemplatesController;
use App\Modules\Admin\Controllers\Permissions\PermissionsController;
use App\Modules\Admin\Controllers\Product\ExcelController;
use App\Modules\Admin\Controllers\Product\ProductController;
use App\Modules\Admin\Controllers\Reports\ReportController;
use App\Modules\Admin\Controllers\Reviews\ReviewsController;
use App\Modules\Admin\Controllers\Roles\RoleController;
use App\Modules\Admin\Controllers\Roles\RolesController;
use App\Modules\Admin\Controllers\SectionsController;
use App\Modules\Admin\Controllers\Settings\CitiesController;
use App\Modules\Admin\Controllers\Settings\ContactUsController;
use App\Modules\Admin\Controllers\Settings\ItemsListController;
use App\Modules\Admin\Controllers\Settings\ListItemsController;
use App\Modules\Admin\Controllers\Settings\PagesController;
use App\Modules\Admin\Controllers\Settings\SettingsController;
use App\Modules\Admin\Controllers\Shipping\ShippingController;
use App\Modules\Admin\Controllers\Users\UsersController;
use App\Modules\Brands\Controllers\BrandController;
use App\Modules\Notification\Controllers\NotificationAllController;
use App\Modules\Notification\Controllers\NotificationController;
use App\Modules\Orders\Controllers\orders\OrdersController;
use App\Modules\Orders\Controllers\transaction\TransactionsController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    Route::get('/lang/{locale?}', [DashboardController::class, 'changeLang']);
    Route::get('login', [AdminLoginController::class, 'login'])->name('admin.login');
    Route::post('login', [AdminLoginController::class, 'doLogin'])->name('admin.do.login');

    Route::group(['middleware' => ['auth:admin']], function () {
        Route::get('country/cities', 'CountriesController@get_all_country_cities')->name('countries.cities');
        Route::post('products/import', [ExcelController::class, 'importData'])->name('products.import');

        Route::get('mailing_templates', [MailingTemplatesController::class, 'index'])->name('mailing_templates.index');
        Route::post('mailing_templates', [MailingTemplatesController::class, 'store'])->name('mailing_templates.store');
        Route::get('mailing_templates/{id}/edit/{lang}', [MailingTemplatesController::class, 'edit'])->name('mailing_templates.edit');

        Route::get('mailing_list', [MailingListController::class, 'index'])->name('mailing_list.index');
        Route::post('mailing_list', [MailingListController::class, 'store'])->name('mailing_list.store');
        Route::post('mailing_list/import', [MailingListController::class, 'import'])->name('mailing_list.import');
        Route::patch('mailing_list/{id}', [MailingListController::class, 'update'])->name('mailing_list.update');
        Route::delete('mailing_list/{id}', [MailingListController::class, 'destroy'])->name('mailing_list.destroy');


        Route::post('store_user/send', [MailingTemplatesController::class, 'sendStore'])->name('UserSend');


        Route::post('mailing_list/json/cities', [MailingListController::class, 'cities']);

        Route::post('mailing_list_group', [MailingListGroupController::class, 'store'])->name('mailing_list_group.store');
        Route::get('mailing_list_group/{group}/edit', [MailingListGroupController::class, 'edit'])->name('mailing_list_group.edit');
        Route::post('mailing_list_group/{group}', [MailingListGroupController::class, 'update'])->name('mailing_list_group.update');
        Route::delete('mailing_list_group/{group}', [MailingListGroupController::class, 'destroy'])->name('mailing_list_group.destroy');

        Route::post('myfatoorah', [OrdersController::class, 'myfatoorah_admin'])->name('myfatoorah_admin')->middleware(['permission:Languages']);
        Route::post('execute_payment_admin', [OrdersController::class, 'execute_payment_admin'])->name('execute_payment_admin')->middleware(['permission:Languages']);
        Route::get('myfatoorah/finish', [OrdersController::class, 'myfatoorahFinish'])->name('myfatoorah_admin.finish')->middleware(['permission:Languages']);
        Route::get('orders/map', [OrdersController::class, 'ordersMap'])->name('orders.map')->middleware(['permission:Orders']);
        Route::post('orders/updateShippingAddress', [OrdersController::class, 'updateShippingAddress'])->name('orders.updateShippingAddress');


        Route::get('orders/offline/all', [TransactionsController::class, 'offline_orders'])->middleware(['permission:Orders']);
        Route::get('orders/offline/{id}/show', [TransactionsController::class, 'show_offline'])->middleware(['permission:Orders']);
        Route::get('orders/offline/{id}/accept', [TransactionsController::class, 'accept'])->middleware(['permission:Orders']);
        Route::get('orders/offline/{id}/refused', [TransactionsController::class, 'refused'])->middleware(['permission:Orders']);
        Route::get('orders/online/all', [TransactionsController::class, 'online_orders'])->middleware(['permission:Orders']);
        Route::get('orders/online/{id}/show', [TransactionsController::class, 'show_online'])->middleware(['permission:Orders']);
        Route::get('orders/financial_transactions', [TransactionsController::class, 'financial_transactions'])->middleware(['permission:Orders']);


        Route::get('products_purchased', [ReportController::class, 'productsPurchased'])
            ->name('reports.products.purchased');
        Route::post('products/store_translation', [ProductController::class, 'storeTranslation'])->name('products.store.translation');
        Route::get('products', [ProductController::class, 'index'])->name('products.index');
        Route::get('products/images/{id}', [ProductController::class, 'image_show'])->name('products.images');
        Route::post('products/images/{id}', [ProductController::class, 'image_save'])->name('products.dropzone.store');
        Route::get('products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
        Route::delete('products_info/{id}', [ProductController::class, 'destroy_info'])->name('products.info.destroy');
        Route::get('products_images/{id}', [ProductController::class, 'destroy_image'])->name('products.images.destroy');
        Route::post('products/store', [ProductController::class, 'store'])->name('products.store');
        Route::post('products/info/store', [ProductController::class, 'info_store'])->name('products.info.store');
        Route::post('products/{id}', [ProductController::class, 'update'])->name('products.update');
        Route::put('products/update/{id}', [ProductController::class, 'update']);
        Route::get('products/get_translations', [ProductController::class, 'getTranslations'])->name('products.get.translations');
        Route::get('products/get_info', [ProductController::class, 'getInfo'])->name('products.get.info');
        Route::get('products/update/{id}', [ProductController::class, 'update']);
        Route::get('products/edit/{id}', [ProductController::class, 'edit_product'])->name('products.edit');


        Route::post('categories/store_translation', [CategoryController::class, 'storeTranslation'])->name('categories.store.translation');
        Route::get('categories/get_translation', [CategoryController::class, 'getTranslation'])->name('categories.get.translation');
        Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::get('categories/{brand}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::post('categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
        Route::get('categories/{category}/delete', [CategoryController::class, 'deleteCategory']);





        Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
        Route::get('/brands/create', [BrandController::class, 'create'])->name('brands.create');
        Route::get('/brands/{brand}/edit', [BrandController::class, 'edit'])->name('brands.edit');
        Route::post('brands', [BrandController::class, 'store'])->name('brands.store');
        Route::get('brands/get_translation', [BrandController::class, 'getTranslation'])->name('brands.get.translation');
        Route::post('brands/store_translation', [BrandController::class, 'storeTranslation'])->name('brands.store.translation');
        Route::patch('brands/{brand}', [BrandController::class, 'update'])->name('brands.update');
        Route::post('brands/{brand}', [BrandController::class, 'destroy'])->name('brands.destroy');



        Route::get('notifications', [NotificationController::class, 'index'])->name('notification.index')->middleware(['permission:Notifications']);
        Route::post('notifications/send', [NotificationController::class, 'store'])->name('notification.store')->middleware(['permission:Notifications']);
        Route::delete('notifications/{id}/delete', [NotificationController::class, 'destroy'])->name('notification.destroy')->middleware(['permission:Notifications']);
        Route::get("ajax_city", [NotificationController::class, 'getCityByCountryId']);
        Route::get('notificationsAll', [NotificationAllController::class, 'index'])->name('notificationAll.index');
        Route::post('notificationsAll/read', [NotificationAllController::class, 'read'])->name('notificationAll.read');
        Route::get('notificationsAll/{id}/delete', [NotificationAllController::class, 'destroy'])->name('notificationAll.destroy');


        Route::get('profile/{id}', [AdminController::class, 'editProfile'])->name('admin.editProfile');
        Route::post('profilePassword', [AdminController::class, 'updatePassword'])->name('admin.updatePassword');
        Route::post('profile', [AdminController::class, 'updateprofile'])->name('admin.updateprofile');

        Route::get('all_users', [UsersController::class, 'index'])->name('users.any');
        Route::post('change_user_activity', [UsersController::class, 'update'])->name('users.activity');
        Route::post('change_user_password', [UsersController::class, 'change_pass'])->name('users.password');


        Route::get('logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

        Route::get('/', [DashboardController::class, 'index'])->name('admin.home')->middleware(['permission:Dashboard']);
        Route::get('/salesSearch', [DashboardController::class, 'salesSearch'])->name('admin.salesSearch')->middleware(['permission:Dashboard']);
        Route::get('/wordsSearch', [DashboardController::class, 'wordsSearch'])->name('admin.wordsSearch')->middleware(['permission:Dashboard']);
        Route::get('/lastOrders', [DashboardController::class, 'lastOrders'])->name('admin.lastOrders')->middleware(['permission:Dashboard']);
        Route::get('/soldProducts', [DashboardController::class, 'soldProducts'])->name('admin.soldProducts')->middleware(['permission:Dashboard']);
        Route::get('/bestSellingProducts', [DashboardController::class, 'bestSellingProducts'])->name('admin.bestSellingProducts')->middleware(['permission:Dashboard']);
        Route::get('/totalOrders', [DashboardController::class, 'totalOrders'])->name('admin.totalOrders')->middleware(['permission:Dashboard']);
        Route::get('/ordersFilterByStatus', [DashboardController::class, 'ordersFilterByStatus'])->name('admin.ordersFilterByStatus')->middleware(['permission:Dashboard']);
        Route::get('/get_cities', [DashboardController::class, 'get_cities'])->name('admin.get_cities')->middleware(['permission:Dashboard']);
        Route::get('/mostViewedProducts', [DashboardController::class, 'mostViewedProducts'])->name('admin.mostViewedProducts')->middleware(['permission:Dashboard']);

        Route::get('language/getLang', [LanguageController::class, 'getLang'])->name('admin.get.lang');

        Route::get('/reviews', [ReviewsController::class, 'index'])
            ->name('reviews.admin');
        Route::post('change_user_status', [ReviewsController::class, 'update'])
            ->name('reviews.status');
        Route::post('delete_user_review', [ReviewsController::class, 'destroy'])
            ->name('reviews.destroy');

        //        Route::get('categories', [CategoryController::class, 'index'])->name('categories.index')->middleware(['permission:Products']);
        //        Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create')->middleware(['permission:Products']);
        //        Route::get('categories/{brand}/edit', [CategoryController::class, 'edit'])->name('categories.edit')->middleware(['permission:Products']);
        //        Route::post('categories', [CategoryController::class, 'store'])->name('categories.store')->middleware(['permission:Products']);
        //        Route::patch('categories/{brand}', [CategoryController::class, 'update'])->name('categories.update')->middleware(['permission:Products']);
        //        Route::delete('categories/{brand}', [CategoryController::class, 'destroy'])->name('categories.destroy')->middleware(['permission:Products']);
        //        Route::post('categories/store_translation', [CategoryController::class, 'storeTranslation'])->name('categories.store.translation')->middleware(['permission:Products']);
        //        Route::get('categories/get_translation', [CategoryController::class, 'getTranslation'])->name('categories.get.translation')->middleware(['permission:Products']);
        //        Route::get('categories/{category}/delete', [CategoryController::class, 'deleteCategory'])->middleware(['permission:Products']);
        //        Route::post('categories/{category}/image', [CategoryController::class, 'uploadImage'])->name('categories.image.upload')->middleware(['permission:Products']);
        //        Route::get('category/{id}/features', [CategoryController::class, 'features'])->name('category.features');
        //        Route::post('category/update/feature', [CategoryController::class, 'featuresPost'])->name('category.update.feature');
        //        Route::post('create/category/v2', [CategoryController::class, 'createSingleV2'])->name('create.category.v2');
        //        Route::post('category/orders/update', [CategoryController::class, 'updateOrder'])->name('category.order.update');

        Route::get('settings/section/{section}', [SectionsController::class, 'index'])->name('section.index');
        Route::post('settings/sections/store/{section}', [SectionsController::class, 'store']);
        Route::post('settings/sections/update', [SectionsController::class, 'update']);
        Route::get('settings/sections/get/lang/value', [SectionsController::class, 'getLangValue']);
        Route::post('settings/sections/lang/store', [SectionsController::class, 'storelangTranslation']);
        Route::delete('settings/sections/{id}', [SectionsController::class, 'delete'])->name('section.destroy');
        Route::get('settings/section/create/{create}', [SectionsController::class, 'create'])->name('settings.sections.create');
        Route::get('settings/section/edit/{id}', [SectionsController::class, 'edit'])->name('settings.sections.edit');
        Route::get('settings/sections/autocomplete', [SectionsController::class, 'autocomplete']);
        Route::get('get/lang', [SectionsController::class, 'getlang'])->name('all_langs');



        Route::get('/contacts', [ContactsController::class, 'index'])->name('contacts.index');
        Route::get('/contacts/{id}', [ContactsController::class, 'show'])->name('contacts.show');
        Route::get('contacts/{id}/delete', [ContactsController::class, 'delete'])->name('contacts.delete');


        Route::get('settings', [SettingsController::class, 'index'])->name('settings.index')->middleware(['permission:Settings']);
        Route::get('settings/get', [SettingsController::class, 'get_settings'])->name('settings.edit')->middleware(['permission:Settings']);
        Route::patch('settings/get', [SettingsController::class, 'updateSettings'])->name('settings.update')->middleware(['permission:Settings']);
        Route::get('settings/translation', [SettingsController::class, 'getSettingsTranslation'])->name('settings.translation')->middleware(['permission:Settings']);
        Route::patch('settings/translation', [SettingsController::class, 'updateSettingsTranslation'])->name('settings.update_translation')->middleware(['permission:Settings']);
        Route::post('settings/save_domain', [SettingsController::class, 'saveDomain'])->name('settings.saveDomain')->middleware(['permission:Settings']);
        Route::get('settings/check', [SettingsController::class, 'check'])->middleware(['permission:Settings']);

        Route::get('default/images', [ImageSettingController::class, 'index'])->name('default.images.index');
        Route::post('default/images/edit/{name}/{id}', [ImageSettingController::class, 'edit'])->name('admin.default.images.edit');
        Route::post('settings/image_account/edit', [ImageAccountController::class, 'edit'])->name('admin.image.account.edit')->middleware('permission:Settings');

        Route::get('/cities', [CitiesController::class, 'index'])
            ->name('cities.index')->middleware(['permission:Cities']);
        Route::post('/cities_store', [CitiesController::class, 'store'])
            ->name('cities.store')->middleware(['permission:Cities']);
        Route::post('/cities_update', [CitiesController::class, 'update'])
            ->name('cities.update')->middleware(['permission:Cities']);
        Route::post('city_translate', [CitiesController::class, 'translate'])
            ->name('cities.translate')->middleware(['permission:Cities']);
        Route::post('/cities_delete', [CitiesController::class, 'destroy'])
            ->name('cities.destroy')->middleware(['permission:Cities']);


        Route::get('permissions', [PermissionsController::class, 'index'])->name('site.admin.permissions');
        Route::post('permissions', [PermissionsController::class, 'store'])->name('site.admin.permissions.store');
        Route::patch('permissions/update', [PermissionsController::class, 'update'])->name('site.admin.permissions.update');
        Route::post('permissions/store_translation', [PermissionsController::class, 'storeTranslation'])->name('site.admin.permissions.storeTranslation');
        Route::get('permissions/getLangValue', [PermissionsController::class, 'getLangValue'])->name('site.admin.permissions.getLangValue');
        Route::delete('permissions/{id}/delete', [PermissionsController::class, 'delete'])->name('site.admin.permissions.delete');

        Route::get('roles', [RolesController::class, 'index'])->name('site.admin.roles');
        Route::get('roles/create', [RolesController::class, 'create'])->name('site.admin.roles.create');
        Route::get('roles/{id}', [RolesController::class, 'edit'])->name('site.admin.roles.edit');
        Route::post('roles', [RolesController::class, 'store'])->name('site.admin.roles.store');
        Route::post('roles/{id}', [RolesController::class, 'update'])->name('site.admin.roles.update');
        Route::delete('roles/{id}/delete', [RolesController::class, 'destroy'])->name('site.admin.roles.destroy');
        Route::get('roles/get_permissions/{lang}', [RolesController::class, 'getPermissions']);


        Route::get('role/dataTable', [RoleController::class, 'dataTable']);
        Route::get('role/export', [RoleController::class, 'export'])->name('role.export');

        Route::get('admin', [\App\Modules\Admin\Controllers\Roles\AdminController::class, 'index'])->name('admin.index') //            ->middleware(['permission:Admins']);
        ;
        Route::get('admin/export', [\App\Modules\Admin\Controllers\Roles\AdminController::class, 'export'])->name('admin.export');
        Route::get('admin/create', [\App\Modules\Admin\Controllers\Roles\AdminController::class, 'create'])->name('admin.create');
        Route::get('admin/{user}/edit', [\App\Modules\Admin\Controllers\Roles\AdminController::class, 'edit'])->name('admin.edit');
        Route::post('admin', [\App\Modules\Admin\Controllers\Roles\AdminController::class, 'store'])->name('admin.store');
        Route::patch('admin/{user}', [\App\Modules\Admin\Controllers\Roles\AdminController::class, 'update'])->name('admin.update');
        Route::patch('admin/{user}/change_password', [\App\Modules\Admin\Controllers\Roles\AdminController::class, 'changePassword'])->name('admin.change_password');
        Route::get('admin/{id}', [\App\Modules\Admin\Controllers\Roles\AdminController::class, 'destroy'])->name('admin.destroy');

        Route::get('role/get_permissions/{lang}', [RoleController::class, 'getPermissions']);
        Route::resource('role', RoleController::class);
        //list
        Route::get('lists/get_translation', [ItemsListController::class, 'getTranslation'])->name('lists.get.translation');
        Route::post('lists/store_translation', [ItemsListController::class, 'storeTranslation'])->name('lists.store.translation');
        Route::get('list_items/get_translation', [ListItemsController::class, 'getTranslation'])->name('list_items.get.translation');
        Route::post('list_items/store_translation', [ListItemsController::class, 'storeTranslation'])->name('list_items.store.translation');

        Route::get('list_items', [ListItemsController::class, 'index'])->name('list_items.index');
        Route::post('list_items', [ListItemsController::class, 'store'])->name('list_items.store');
        Route::post('list_items/update', [ListItemsController::class, 'update'])->name('list_items.update');
        Route::delete('list_items/{id}', [ListItemsController::class, 'destroy'])->name('list_items.destroy');

        Route::post('lists', [ItemsListController::class, 'store'])->name('lists.store');
        Route::get('lists/{group}/edit', [ItemsListController::class, 'edit'])->name('lists.edit');
        Route::post('lists/{group}', [ItemsListController::class, 'update'])->name('lists.update');
        Route::delete('lists/{group}', [ItemsListController::class, 'destroy'])->name('lists.destroy');

        //attributes
        Route::get('attributes', [AttributeController::class, 'index'])
            ->name('category.attributes');

        Route::post('attribute/save', [AttributeController::class, 'store'])
            ->name('category.attributes.save');

        Route::post('attribute/{id}/delete', [AttributeController::class, 'delete'])
            ->name('category.attributes.delete');

        Route::post('attribute/edit', [AttributeController::class, 'edit'])
            ->name('category.attribute.edit');

        Route::post('attribute/update', [AttributeController::class, 'update'])
            ->name('category.attribute.update');

        Route::get('attribute/options', [AttributeController::class, 'getOptions'])
            ->name('attribute.get.options');

        Route::post('attribute/option/store', [AttributeController::class, 'storeOption'])
            ->name('attribute.option.store');

        Route::post('attribute/option/update', [AttributeController::class, 'updateOption'])
            ->name('attribute.option.update');

        Route::post('attribute/option/delete', [AttributeController::class, 'deleteOption'])
            ->name('attribute.option.delete');

        Route::post('attribute/icon/upload', [AttributeController::class, 'uploadIcon'])
            ->name('attribute.icon.upload');

        //shipping
        Route::get('shipping/get_cities', [ShippingController::class, 'get_cities']);
        //   modified by WF
        Route::get('shipping/get_regions', [ShippingController::class, 'get_regions']);


        Route::get('shipping', [ShippingController::class, 'index'])
            ->name('shipping.index');

        Route::get('shipping/api', [ShippingController::class, 'api'])
            ->name('shipping.api');

        Route::get('shipping/{id}/edit', [ShippingController::class, 'edit'])
            ->name('shipping.edit');

        Route::post('shipping/{id}', [ShippingController::class, 'freeStatus'])
            ->name('shipping');

        Route::get('shipping/company/create', [ShippingController::class, 'create'])
            ->name('shipping.create');

        Route::post('save_shipping_company', [ShippingController::class, 'save_shipping_company']);

        Route::post('update_shipping_company/{id}', [ShippingController::class, 'update_shipping_company']);

        Route::delete('shipping_option/delete', [ShippingController::class, 'delete_shipping_option']);

        Route::get('shipping/company/delete/{id}', [ShippingController::class, 'delete_company']);

        Route::get('shipping_company/get/lang/value', [ShippingController::class, 'getvalue']);

        Route::post('shipping_company/storeLang', [ShippingController::class, 'storelang']);

        Route::get('shipping/free_company/create', [ShippingController::class, 'freee_company_create']);

        Route::get('pages', [PagesController::class, 'index'])->name('pages.index');
        Route::get('pages/create', [PagesController::class, 'create'])->name('pages.create');
        Route::post('pages/store', [PagesController::class, 'store'])->name('pages.store');
        Route::get('pages/{id}/edit', [PagesController::class, 'edit'])->name('pages.edit');
        Route::post('pages/update', [PagesController::class, 'update'])->name('pages.update');
        Route::delete('pages/{id}', [PagesController::class, 'delete'])->name('pages.destroy');
        Route::get('pages/get/lang/value', [PagesController::class, 'pagergetLangvalue'])->name('page_lang_value');
        Route::post('pages/lang/store', [PagesController::class, 'pagestorelangTranslation'])->name('page_lang_store');

        Route::get('contact/all', [ContactUsController::class, 'index']);
        Route::get('contact/{id}/show', [ContactUsController::class, 'show']);
        Route::delete('contact/{id}/delete', [ContactUsController::class, 'delete'])->name('contact.destroy');

        Route::get('discounts/create', [DiscountsController::class, 'create'])->name('discounts.create');
        Route::Post('discounts/store', [DiscountsController::class, 'store'])->name('discounts.store');
        Route::get('discounts/{id}/edit', [DiscountsController::class, 'edit'])->name('discounts.edit');
        Route::Post('discounts/{id}/update', [DiscountsController::class, 'update'])->name('discounts.update');
        Route::get('discounts/{id}/member', [DiscountsController::class, 'member'])->name('discounts.member');
        Route::get("discounts/ajax_memberAppend", [DiscountsController::class, 'appendMember'])->name('discounts.ajaxmember');
        Route::get("discounts/ajax_groupAppend", [DiscountsController::class, 'appendGroup'])->name('discounts.ajaxgroup');
        Route::post("discounts/storeUserData", [DiscountsController::class, 'storeUserData'])->name('discounts.storeUserData');

        Route::get('discount/{id}/details', 'Admin\Discounts\DiscountsController@giftDetails')->name('admin.discount.trans');


        Route::get('discounts', [ManagerController::class, 'index'])->name('discounts.index');
        Route::get('discount_delete/{id}', [ManagerController::class, 'delete'])
            ->name('admin.discount.delete');
        Route::get('/discounts/{id}/user', [DiscountsController::class, 'users'])->name('admin.discountUsers.index');
        Route::get('discounts/updateActive', [ManagerController::class,'updateActive'])
		->name('admin.discount.updateActive');
    });
});
