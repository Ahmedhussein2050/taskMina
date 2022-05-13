<?php

namespace App\Modules\Notification\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Exists;

class Notifications extends Model
{
	protected $table = 'notifications';
	protected $guarded = [];

	protected $casts = [
		'id' => 'string'
	];


	public function notificationType($row)
	{

		$type = $row->type;
		$data = [];
		$text = [];
		$json =  json_decode($row->data, true);

		switch ($type) {
			case "App\Notifications\ClientRegister":  // notification to only admins

				$data['title'] =  $json['name'][app()->getLocale()];
				$data['body']  =  $json['text'][app()->getLocale()] ;
				$data['info']  =  'url:' . $json['url'] ;
				return $data;
				break;

			case   "App\Notifications\AdminNotifications"  :

 				$data['title'] =  _i('Notifications From Admin');
				$message = json_decode($row->data)->message;
				$data['body']  = json_decode($message)->{app()->getLocale()} ?? $json['message'];

 				return $data;
				break;

			// case   "App\Notifications\VoucherNotification":

			// 	$data['title'] =  $json['message']['title'][app()->getLocale()];
			// 	$data['body']  =  $json['message']['description'][app()->getLocale()];
			// 	$text['code']       =  $json['message']['code'];
			// 	$text['offer_id']   =  $json['message']['offer_id'];
			// 	$text['max_amount'] =  $json['message']['max_amount'];
			// 	$text['min_amount'] =  $json['message']['min_amount'];
			// 	$text['bonus']      =  $json['message']['bonus'];
			// 	$text['type']       =  $json['message']['type'];
			// 	$text['limit']      =  $json['message']['limit'];
			// 	$data['info']       = json_encode($text);
			// 	return $data;
			// 	break;


			case "App\Notifications\AddProductNotification":

				$data['title'] = $json['title'][app()->getLocale()] ?? $json['title'];
				$data['body']  = $json['product_id'] . ' ,storename:' . $json['storename'][app()->getLocale()] ?? $json['storename'];

				return $data;
				break;

			case   "App\Notifications\FavouriteProduct"  :


				$data['title'] = $json['name'][app()->getLocale()] ;
				$data['body']  = $json['text'][app()->getLocale()] ;
				$data['info']  = 'url:' . $json['url'] . ',id:' . $json['id'];
				return $data;
				break;


			case $type ==  "App\Notifications\OrderNotification" || $type ==  "App\Notifications\OrderRefundNotification":

				$data['title'] = $json['name'][app()->getLocale()];
				$data['body']  = $json['orderText'][app()->getLocale()];
				$data['info']  = 'order_id:' . $json['order_id'] . ', order_url:' . $json['order_url'];

				return $data;
				break;

			case "App\Notifications\ReviweNotification":

				$data['title'] =   _i('Review Notification') ;
				$data['body']  = $json['comment'][app()->getLocale()] ;
				$data['info']  = 'comment_id:' . $json['comment_id'] . $json['username'] ?? $json['username'][app()->getLocale()];
				return $data;
				break;


			case "App\Notifications\UserOrderNotification":

				$data['title'] = _i('Order Notification');
				$data['body']  = $json['message'] ;
				$data['info']  = 'order_id:' . $json['order_id'] ;

				return $data;
				break;
		}
	}
}
