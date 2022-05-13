<?php

namespace App\Bll;

use App\Notification;

class Notifications
{
	public static function getAdminNotifications()
	{
		// $admin = Auth()->user();
		// $adminNotifications = \App\Notifications::where('notifiable_id', 0)->orWhere('notifiable_id',$admin->id)->whereNull('read_at');

		// return $adminNotifications;
		return auth()->user()->unreadNotifications();
		//->where("type","!=","App\Notifications\FavouriteProduct");
	}

	public static function getMyNotifications()
	{
		// $admin = Auth()->user();
		// $adminNotifications = \App\Notifications::where('notifiable_id', 0)->orWhere('notifiable_id',$admin->id)->whereNull('read_at');

		// return $adminNotifications;
		$all = auth()->user()->unreadNotifications();
		dd($all);
		//->where("type","!=","App\Notifications\FavouriteProduct");
	}

}
