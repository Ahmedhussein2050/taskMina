<?php

namespace App\Bll;

use App\DefaultImage;
use App\ImageAccount;
use App\Models\CurrencyStore;
use App\Models\Language;
use App\Models\User;
use App\Modules\Admin\Models\Products\Category;
use App\Modules\Admin\Models\Products\CategoryData;
use App\Modules\Admin\Models\Products\products;
use App\Modules\Admin\Models\Settings\City;
use App\Modules\Admin\Models\Settings\CityData;
use App\Modules\Admin\Models\Settings\Currency;
use App\Modules\Admin\Models\Settings\ItemsList;
use App\Modules\Notification\Models\Notifications;
use App\Setting;
use Carbon\Carbon;
use Salla\ZATCA\GenerateQrCode;
use Salla\ZATCA\Tags\InvoiceDate;
use Salla\ZATCA\Tags\InvoiceTaxAmount;
use Salla\ZATCA\Tags\InvoiceTotalAmount;
use Salla\ZATCA\Tags\Seller;
use Salla\ZATCA\Tags\TaxNumber;

class Utility
{

    public static $demoId = 3;

    public static function zatca($timeStamp, $totalValue, $vatValue)
    {
        $displayQRCodeAsBase64 = GenerateQrCode::fromArray([
            new Seller('Salla'), // seller name
            new TaxNumber('1234567891'), // seller tax number
            new InvoiceDate($timeStamp), // invoice date as Zulu ISO8601 @see https://en.wikipedia.org/wiki/ISO_8601
            new InvoiceTotalAmount($totalValue), // invoice total amount
            new InvoiceTaxAmount($vatValue) // invoice tax amount
        ])->render();
        return $displayQRCodeAsBase64;
    }
    public static function IsDemoStore()
    {
        if (self::$demoId == self::getStoreId())
            return true;
        return false;
    }

    public static function mainNav()
    {
        $categories = Category::whereHas('dataa')
            ->where('level', 1)
            ->get();
        return $categories;
    }
    public static function footerLink()
    {
        $list =  ItemsList::get();
        // dd( $list);
        return $list;
    }
    public static function generate_random_string($length = 32)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function getCategories($categories, &$result, $parent_id = 0, $depth = 0)
    {
        //filter only categories under current "parent"
        $cats = $categories->filter(function ($item) use ($parent_id) {
            return $item->parent_id == $parent_id;
        });

        //loop through them
        foreach ($cats as $cat) {
            //add category. Don't forget the dashes in front. Use ID as index
            $result[$cat->id] = str_repeat('-', $depth) . $cat->title;
            //go deeper - let's look for "children" of current category
            self::getCategories($categories, $result, $cat->id, $depth + 1);
        }
    }
    static function get_all_categories()
    {
        return Category::join('categories_data', 'categories.id', 'categories_data.category_id')
            ->select('categories.id', 'categories.image', 'categories_data.title', "parent_id")
            //->whereNull('parent_id')
            ->where('categories_data.lang_id', Lang::getSelectedLangId())
            ->with("children")
            ->get();
    }
    public static function getStoreId()
    {

        if (session()->get(Constants::StoreId) == null) {
        }
        return session()->get(Constants::StoreId);
    }
    public static function dates($timestamp): string
    {
        $fullCreatedAt = preg_replace('/[[:space:]]/', ' - ', $timestamp);
        $oldTimeStamp = substr($fullCreatedAt, strrpos($fullCreatedAt, '- ') + 1);
        $newTimeStamp  = date("g:i a", strtotime($oldTimeStamp));
        $oldDateStamp = substr($fullCreatedAt, 0, strpos($fullCreatedAt, ' -'));
        $newDateStamp = \Illuminate\Support\Carbon::parse($oldDateStamp)->format('d M Y');
        $day = Carbon::parse($oldDateStamp)->format('l');
        $fullCreatedAt = str_replace(
            [$oldTimeStamp, $oldDateStamp],
            [$newTimeStamp, $newDateStamp],
            $fullCreatedAt
        );
        $result = substr($day, 0, 3) . ' - ' . preg_replace('/[[:space:]]+-/', ' || ', $fullCreatedAt);
        return $result;
    }
    public static function getSelectedLang()
    {
        $language = Language::where('code', session('locale'))->first();
        if ($language == null)
            return Language::first();
        return $language;
    }
    public static function get_main_settings()
    {
        if (session("setting") != null)
            return session("setting");
        $setting = \App\Setting::join('settings_data', 'settings.id', 'settings_data.setting_id')
            ->select(
                'settings_data.id',
                'settings_data.title',
                'settings.id as setting_id',
                'settings_data.lang_id',
                'settings.logo',
                'settings.facebook_url',
                'settings.twitter_url',
                'settings.instagram_url',
                'settings.order_accept',
                'settings.product_rating',
                'settings.product_outStock',
                'settings.discount_codes',
                'settings.similar_products',
            )
            ->where('settings_data.lang_id', Lang::getSelectedLangId())
            ->first();
        session()->put("setting", $setting);
        return $setting;
    }
    public static function get_site_settings()
    {
        $settings = Setting::join('settings_data', 'settings.id', 'settings_data.setting_id')
            ->where('settings_data.lang_id', Lang::getSelectedLangId())
            ->first();
        return $settings;
    }
    public static function get_default_images()
    {
        $images = DefaultImage::first();

        $user_image = ImageAccount::value('image_account');
        $data = (object) [
            'favicon' => asset('/uploads/default_images/' . $images->favicon),
            'header' =>
            file_exists('uploads/default_images/'  . $images->header) ? asset('/uploads/default_images/'  . $images->header) : asset('/uploads/default.svg'),
            'footer' => asset('/uploads/default_images/' .  $images->footer),
            'not_found' => asset('/uploads/default_images/' .  $images->not_found),
            'user_image' => !empty($user_image) ? asset('/uploads/image_accounts/' .  $user_image) : '',
        ];
        return $data;
    }
    public static function getAdminprofile()
    {
        $id = auth()->guard('admin')->id;
        $admin = \App\Models\User::where('id', $id)->first();
        return $admin;
    }
    public static function get_settings()
    {
        if (session("settings") == null) {


            session()->put("settings", \App\Setting::first());
        }
        return  session("settings");
    }
    public static function get_default_currency($admin = false)
    {
        $currency_id = session()->get('currency_id');
        if ($currency_id == null) {
            $currency = Currency::where('is_default', 1)->first();
        } else {
            $currency = Currency::where('id', $currency_id)->first();
        }
        if ($currency == NULL) {
            $currency = Currency::first();
        }
        return $currency;
    }
    public static function product_price_after_discount_new(
        $price,
        $discount,
        $quantity = false,
        $currency_code = false,
        $abort_currency_change = false,
        $currency = false
    ) {
        if (!$currency) $currency = self::get_default_currency();
        if (!$price) return 0;
        $price = floatval($quantity ? $price * $quantity * (100 - $discount) / 100 : $price * (100 - $discount) / 100);
        if ($abort_currency_change == false) {
            $price = floatval($price * $currency->rate);
        }
        $price = number_format($price, 2, '.', '');
        return $price;
    }

    public static function getChildren($cat, $data, &$result, $depth = 0)
    {

        //add category. Don't forget the dashes in front. Use ID as index

        $result[$cat->id] = (($depth > 0) ? "|" : "") . str_repeat('--', $depth) . $data[$cat->id]->title;
        //go deeper - let's look for "children" of current category
        if ($cat->children->count() > 0) {
            foreach ($cat->children as $child)
                self::getChildren($child, $data, $result, $depth + 1);
        }
    }

    public static function showNotifications()
    {
        if (auth()->check() == false) return [];
        $notifications = Notifications::where('notifiable_id', auth()->user()->id)->orderBy('read_at', 'asc');
        return $notifications;
    }
    public static function convert_email_variables($text, $user_id, $variables)
    {
        $settings = self::get_site_settings();
        $store_url = env("APP_URL");

        $logo = asset("portal/images/logo.png");
        $user = User::find($user_id);
        $text = str_replace(
            [
                '{store_name}',
                '{store_url}',
                '{store_logo}',
                '{user_name}',
                '{user_id}',
                '{forgot_url}',
                '{order_no}',
                '{ticket_id}',
            ],
            [
                $settings->title,
                $store_url,
                $logo,
                $user->name ?? '',
                $user->id ?? '',
                $variables->forgot_url ?? '',
                $variables->order_no ?? '',
                $variables->ticket_id ?? '',
            ],
            $text
        );
        //dd($text);
        return $text;
    }
    public static function get_main_categories()
    {
        return Category::join('categories_data', 'categories.id', 'categories_data.category_id')
            ->select('categories.id', 'categories.image', 'categories_data.title')
            ->whereNull('parent_id')
            ->where('categories_data.lang_id', Lang::getSelectedLangId())
            ->get();
    }
    public static function currencies()
    {
        $currencies = Currency::join('currencies_data', 'currencies.id', 'currencies_data.currency_id')
            ->where('currencies_data.lang_id', Lang::getSelectedLangId())
            ->select('currencies.*')
            ->get();
        return $currencies;
    }

    public static  function number_formatted($price, $number_format_data = ['.', ','])
    {
        $price = number_format($price, 2, $number_format_data[0], $number_format_data[1]);
        $price = str_replace('.00', '', $price);
        return $price;
    }

    public static function getMaxPrice()
    {

        return (products::max("price"));
    }
    public static function getRatingPercent($var1, $var2)
    {
        if ($var1 == 0 || $var2 == 0) return 0;
        return $var1 / $var2 * 100;
    }
    public static function taxOnProduct()
    {
        $settings = Setting::first();
        return  $settings->tax_on_product;
    }
    static function cities($id)
    {
        $cities = City::with('Data')->where('country_id', $id)->get();
        foreach ($cities as $city) {
            $data = CityData::where('city_id', $city->id)->where('lang_id', Lang::getSelectedLangId())->first();

            $city->title = $data ? $data->title : 'City Name';
        }

        return $cities;
    }
}
