<?php

namespace App\Bll;

use App\Modules\Admin\Models\Settings\Setting;
use App\Store;

class MyFatoorah
{

    public static $is_site = 0;
    protected static $domain, $token;
    public $success_url;
    public $error_url;
    public static $currency = 'SAR';

    public static function get_store_id(){
        return Store::first()->id;
    }
    public static function init()
    {
        if(self::get_store_id() == null || self::$is_site == 1)
        {
            $settings = Setting::first();
        }
        elseif( self::$is_site == 0 )
        {
            $settings = Setting::first();
        }
        self::$token = $settings->myfatoorah_token;
        self::$domain = $settings->myfatoorah_type == 'live' ? 'api.myfatoorah.com' : 'apitest.myfatoorah.com';
    }

    protected static function doRequest($params, $query)
    {
        self::init();
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $header[0] = "Authorization: bearer " . self::$token;
        $header[1] = 'Content-Type:application/json';
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_URL, $query);
        $result = curl_exec($curl);
        if ($result == false) {
            error_log("Domain::CreateSubSomain Exception curl_exec threw error \"" . curl_error($curl) . "\" for $query");
        }
        curl_close($curl);
        return $result;
    }

    public static function initializePayment($price, $currency)
    {
        self::init();
        $directory = "/v2/InitiatePayment";
        $query = "https://" . self::$domain . "/{$directory}";
        $params = json_encode(["InvoiceAmount" => $price, "CurrencyIso" => $currency]);
        $result = self::doRequest($params, $query);
        return $result;
    }

    public static function executePayment($params)
    {

        self::init();
        $directory = "/v2/ExecutePayment";
        $query = "https://" . self::$domain . "/{$directory}";
        $params = json_encode($params);
        $result = self::doRequest($params, $query);
        return $result;
    }

    public static function status($key)
    {
        self::init();
        $params = ['Key' => $key, 'KeyType' => 'InvoiceId'];
        $directory = "/v2/GetPaymentStatus";
        $query = "https://" . self::$domain . "/{$directory}";
        $params = json_encode($params);
        $result = self::doRequest($params, $query);
        return json_decode($result);
    }

    public static function directPayment($params, $url)
    {
        self::init();
        $params = json_encode($params);
        $result = self::doRequest($params, $url);
        return $result;
    }
}
