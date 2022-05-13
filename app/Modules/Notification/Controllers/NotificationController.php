<?php

namespace App\Modules\Notification\Controllers;

use App\Bll\Lang;
use App\Events\CustomNotification;
use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\User;
use App\Modules\Admin\Models\cities;
use App\Modules\Admin\Models\CityData;
use App\Modules\Admin\Models\countries_data;
use App\Modules\Notification\Models\Notifications;
use App\Modules\Orders\Models\OffersAndDiscounts\Promotors;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Notification as FacadesNotification;

class NotificationController extends Controller
{
    protected function getCityByCountryId(Request $request)
    {
        if ($request->input("ids") == null)
            $cities = [];
        else
            $cities = cities::join('city_datas', 'cities.id', 'city_datas.city_id')->whereIn('cities.country_id', $request->input("ids"))->where('lang_id', getLang())->select('cities.id', 'city_datas.title')->pluck('title', 'id');
        return response()->json(['data' => $cities], 200);
    }


    public function index()
    {
        $lang_id = Lang::getSelectedLangId();
        if (request()->ajax()) {

            $notifications = Notifications::latest()->get();

            return DataTables::of($notifications)
                ->addColumn('user', function ($notifications) {
                    if ($notifications->notifiable_id) {
                        $user = DB::table('users')->where('id', $notifications->notifiable_id)->first();
                    } else {
                        $user = DB::table('users')->where('id', $notifications->user_id)->first();
                    }
                    $html = "<a href>";
                    if ($user->image != null) {
                        $html .= "<img class='media-object img-circle comment-img' src='" . asset('uploads/users/' . $user->id . '/' . $user->image) . "' alt='" . $user->name . "'>";
                    } else {
                        $html .= "<img class='media-object img-circle comment-img' src='" . asset('images/articles/personal_NoImage.jpg') . "' alt='" . $user->name . "'>";
                    }
                    $html .= "</a>";
                    $html .= "<p><a href><span>" . $user->name . $user->last_name . "</span></a></p>";
                    return $html;
                })
                ->addColumn('textt', function ($notifications) {
                    $data = json_encode($notifications->notificationType($notifications));
                    return json_decode($data)->title;
                    // if ($notifications->data) {
                    //     if (isset(json_decode($notifications->data)->name)) {

                    //         $data = $notifications->data;
                    //         $json = json_decode($data, true);
                    //         $notifications->data = $json['name'][app()->getLocale()];
                    //     } else if (isset(json_decode($notifications->data)->message)) {
                    //         $data = $notifications->data;
                    //         $json = json_decode($data, true);
                    //         $notifications->data = $json['message'];
                    //     } else if (json_decode($notifications->data)) {
                    //         $data = $notifications->data;
                    //         $json = json_decode($data, true);
                    //         $notifications->data = $json[app()->getLocale()];
                    //     } else {
                    //         $notifications->data;
                    //     }
                    //     return $notifications->data;
                    // } else {

                    // }
                })
                ->addColumn('options', function ($notifications) {
                    return '<a href="' . route('notification.destroy', $notifications->id) . '" data-remote="' . route('notification.destroy', $notifications->id) . '" class="color-white btn btn-delete waves-effect waves-light btn btn-danger text-center" title="' . _i("Delete") . '"><i class="ti-trash center"></i> ' . _i("Delete") . '</a>';
                })
                ->rawColumns([
                    'user',
                    'options',
                    'textt',
                ])
                // ->order(function ($query){
                // 	if(request()->ajax() && request()->has('id')){
                // 		$query->orderBy('id','desc');
                // 	}
                // })

                ->make(true);
        }

        $countries = countries_data::where('lang_id', $lang_id)->get();
        $cities = CityData::where('lang_id', $lang_id)->get();
        $groups = Group::get();
        $users = User::get();
        $promotors = Promotors::with('user')->get();
        //dd($promotors);

        return view('admin.notifications.index', compact('countries', 'cities', 'groups', 'users', 'promotors'));
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

    public function store(Request $request)
    {
        if (empty($request->country) && empty($request->city) && empty($request->group) && empty($request->users)) {
            return response()->json('error');
        }

        if (empty($request->text)) {
            return response()->json('error');
        }

        $text = empty($request->text) ? NULL : $request->text;
        $notification_id = rand(100000, 999999);


        $country = empty($request->country) ? NULL : $request->country;
        if (!empty($country)) {
            $users = User::where('country_id', $country)->get();
            foreach ($users as $user) {

                // $notif=	Notifications::create([

                // 		'notifiable_id' => $user->id,
                // 		'data' => $text,
                // 		//'notification_id' => $notification_id,
                //      'type' => 'App\Notification\AdminNotification'
                //  ]);
                // event(new CustomNotification($user->id, $text, $notif->created_at));
            }
            FacadesNotification::send($users, new \App\Notifications\AdminNotifications($text));
        }

        $city = empty($request->city) ? NULL : $request->city;
        if (!empty($city)) {
            $users = User::where('city_id', $city)->get();
            foreach ($users as $user) {
                // 	$notif =	Notifications::create([
                // 		'notifiable_id' => $user->id,
                // 		'data' => $text,
                // 		//'notification_id' => $notification_id,
                //      'type' => 'App\Notification\AdminNotification'

                //  ]);
                event(new \App\Events\CustomNotification($user->id, $text, $notif->created_at, $notif->id));
            }
            FacadesNotification::send($users, new \App\Notifications\AdminNotifications($text));
        }

        $group = empty($request->group) ? NULL : $request->group;
        if (!empty($group)) {
            $group = Group::where('id', $group)->first();
            $users = $group->users ?? [];
            foreach ($users as $user) {
                //event(new \App\Events\CustomNotification($user->id, $text));
                // 	$notif =	Notifications::create([

                // 		'notifiable_id' => $user->id,
                // 		'data' => $text,
                // 		//'notification_id' => $notification_id,
                //      'type' => 'App\Notification\AdminNotification'

                //  ]);
                event(new \App\Events\CustomNotification($user->id, $text, $notif->created_at, $notif->id));
            }
            FacadesNotification::send($users, new \App\Notifications\AdminNotifications($text));
        }

        if (!empty($request->users)) {
            $user = $request->users;
            $users = User::whereIN('id', $user)->get();
            //dd($users);
            foreach ($users as $user) {

                // 	$notif =	Notifications::create([

                // 		'notifiable_id' => $user->id,
                // 		'data' => $text,
                // 		//'notification_id' => $notification_id,
                //           'type' => 'App\Notification\AdminNotification'

                //  ]);


                //event(new \App\Events\CustomNotification($user->id, $text ,$notif->created_at,$notif->id));
            }
            FacadesNotification::send($users, new \App\Notifications\AdminNotifications($text));
        }

        return response()->json('success');
    }


    public function show(Notification $notification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Notification $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Notification $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Notification $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $not = Notifications::where('id', $id)->first();
        if ($not) {
            Notifications::where('id', $id)->delete();
        } else {
            Notifications::where('id', $id)->delete();
        }

        return response()->json('success');
    }

    public function read(Request $request)
    {
        //dd($request->id);
        $not = Notifications::where('id', $request->id)->first();
        if ($not) {
            Notifications::where('id', $request->id)->update(['read_at' => Carbon::now()]);
        } else {
            Notifications::where('id', $request->id)->update(['status' => 'seen']);
        }
        return response()->json('success');
    }

    public function trash(Request $request)
    {

        $not = Notifications::where('id', $request->id)->first();
        if ($not) {
            Notifications::where('id', $request->id)->delete();
        } else {
            Notifications::where('id', $request->id)->delete();
        }
        return response()->json(['success']);
    }
}
