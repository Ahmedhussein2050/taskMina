<?php

namespace App\Modules\Notification\Controllers;

use App\Http\Controllers\Controller;
use App\Notifications;

use App\Models\Group;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class NotificationAllController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{

	    $notAll = \App\Bll\Notifications::getAdminNotifications()->paginate(10);
	   // dd($notAll);

	    $notAllwithoutorder = \App\Bll\Notifications::getAdminNotifications()->where('type','!=','App\Notifications\OrderNotification')->paginate(10);
        $notNew = \App\Bll\Notifications::getAdminNotifications()->where('type','=','App\Notifications\OrderNotification')->paginate(10);
        $notFav = \App\Bll\Notifications::getAdminNotifications()->where('type','=','App\Notifications\FavouriteProduct')->paginate(10);
        $notStock = \App\Bll\Notifications::getAdminNotifications()->where('type','=','App\Notifications\StockProduct')->paginate(10);
        $notRefund = \App\Bll\Notifications::getAdminNotifications()->where('type','=','App\Notifications\OrderRefundNotification')->paginate(10);


		return view('admin.notificationsAll.index',compact('notAll','notNew','notFav','notStock','notRefund','notAllwithoutorder'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Notification  $notification
	 * @return \Illuminate\Http\Response
	 */
	public function show(Notification $notification)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Notification  $notification
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Notification $notification)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Notification  $notification
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Notification $notification)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Notification  $notification
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		Notifications::where('id', $id)->delete();
        return back()->with('success', _i('Delete Successfully !'));

//		return response()->json('success');
	}

	public function read(Request $request)
	{

//		$user = auth()->user()->where('id' ,'=', $request->id);
//		dd($user);
		Notifications::where('id', $request->id)->update(['read_at' => NOW()]);
		return response()->json('success');
	}
}
