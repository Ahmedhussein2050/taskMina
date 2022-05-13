<?php

namespace  App\Modules\Admin\Controllers\Discounts;

use App\Bll\Email;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\User;
use App\Modules\Admin\Models\Discount\Discount;
use App\Modules\Admin\Models\Discount\DiscountNotifications;
use App\Modules\Admin\Models\Discount\DiscountUser;
// use App\Notification;
use Illuminate\Http\Request;

use App\Notifications\DiscountMail;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use PHPUnit\Util\Json;
use Yajra\DataTables\Facades\DataTables;
// use Illuminate\Notifications\Notifiable;


class ManagerController extends Controller
{

    public function index()
    {


        if (request()->ajax()) {
            $type = "general";
            // switch (request()->query("type")) {
            // 	case "general":
            // 		$type = request()->query("type");
            // 		break;
            // 	case "private":
            // 		$type = request()->query("type");
            // 		break;
            // }

            $discount_code = new Discount();

            $discount_code = Discount::join('users', 'users.id', 'discounts.created_by')->select('discounts.*', 'users.name', 'users.image')->where('type', $type);

            // $discount_code = $discount_code->orderByDesc('id');
            return DataTables::of($discount_code)

                ->addColumn('title', function ($query) {

                    return $query->title;
                })->addColumn('usedTime', function ($query) {

                    return  $query->using_times . '/' . $query->limit;
                })->addColumn('status', function ($query) {
                    $checked = $query->active == 1 ? "checked" : "";

                    return '<input data-edit="' . $query->allow_edit . '" type="checkbox" id="check_' . $query->id . '" class="js-switch2 checkedIN" ' . $checked . ' data-id="' . $query->id . '" />';
                })->addColumn('Bouns', function ($query) {
                    $bonus = $query->value;
                    return ($query->calc_type == 'perc') ?  $bonus . ' ' . '%' : $bonus . ' ' . 'SAR';
                })->addColumn('start_date', function ($query) {

                    return  $query->start_date;
                })->addColumn('end_date', function ($query) {

                    return  $query->end_date;
                })->addColumn('created_at', function ($query) {

                    $url = asset($query->image);
                    $url2 = asset("admin_dashboard/assets/images/user.png");
                    return ($query->image != null) ? '<img src= ' . $url . ' border="0" style=" width: 50px; height: 50px;" class="img-responsive img-rounded" align="center" />' . $query->name :
                        '<img src= ' . $url2 . ' border="0" style=" width: 50px; height: 50px;" class="img-responsive img-rounded" align="center" />' . '  ' . $query->name;
                })
                ->addColumn('action', function ($query) {
                    $html = "<a href='discounts/" . $query->id . "/users'   ><i class='fa fa-users'></i> </a>";

                    // $html = $html . '<div class="btn-group">
                    // 	<a class="dropdown-toggle" data-toggle="dropdown">
                    // 		<i class="fa fa-envelope"></i>
                    // 	</a>
                    // 	<ul class="dropdown-menu" style="right: auto; left: 0; width: 5em; " >
                    // 		<li><a href="#" data-email="' . $query->id . '">' . _i('Email') . '</a></li>
                    // 		<li><a href="#" data-sms="' . $query->id . '">' . _i('SMS') . '</a></li>
                    // 	</ul>
                    // </div>';

                    return
                        $html . " <a href='discounts/" . $query->id . "/edit'   ><i class='fa fa-edit'></i> </a><a href='#' class=' btn-delete datatable-delete' data-url='" . route('admin.discount.delete', $query->id)  . "' ><i class='fa fa-trash'></i> </a>";
                })
                ->rawColumns([
                    'action', 'title', 'usedTime', 'status', 'bouns', 'start_date', 'end_date', 'created_at'
                ])
                ->make(true);
        }

        return view('admin.discounts.index');
    }


    public function delete($id)
    {

        Discount::where('id', $id)->delete();
        return response()->json(true);
    }

    public function updateActive(Request $request)
    {
        $active = $request->get('active');

        $discount1 = Discount::where('active', 1)->first();
        $discount  = Discount::where('id', $request->id)->first();

        if ($discount1 != null && $active != 0 ) {
            return  response()->json(["status" => "error"], 400);
        }

        $discount = Discount::where('id', $request->id)->first();
        if ($active == 1) {
            $discount->allow_edit = false;
        }
        $discount->active = $active;
        $discount->save();

        // $details = DiscountNotifications::where('discount_id', $request->id)->where('notified_by', 'system')->pluck('message')->first();

        // if ($details) {
        // 	$this->notificationsystem($request, $active, $details);
        // }
        // $mail = DiscountNotifications::where('discount_id', $request->id)->where('notified_by', 'email')->pluck('message')->first();

        // if ($mail) {
        // 	$this->notificationmail($request, $active, $mail);
        // }

        // $sms = DiscountNotifications::where('discount_id', $request->id)->where('notified_by', 'sms')->pluck('message')->first();

        // if ($sms) {
        // 	$this->notificationsms($request, $active, $sms);
        // }


        return  response()->json(["status" => "ok"], 200);
    }

    private function notificationsystem($request, $active, $details)
    {

        $users = User::join('discount_users', 'users.id', 'discount_users.user_id')
            ->where('discount_users.discount_id', $request->id)
            ->select('users.id', 'discount_users.code')->get();

        if ($details && $users != null) {
            $text = [];
            $arrDea = json_decode(json_encode($details), true);
            foreach ($users as $user) {
                $code = $user->code;

                foreach (Language::get() as $lang) {
                    $text[$lang->code] = $arrDea[$lang->code] . ' ' . $code;
                }
                // dd($text);
                //      \App\Notifications::create([
                // 	'Illuminate\Support\Facades'=>$user->id,
                // 	'data'=>json_encode($text),
                // 	//'notification_id'=>rand(111111,999999),
                //   'type' => 'App\Notification\DiscountNotification'
                //  ]);

            }
            Notification::send($users, new \App\Notifications\AdminNotifications(json_encode($text)));
        }
        $details = DiscountNotifications::where('discount_id', $request->id)->where('notified_by', 'system')->first();
        $details->send = $active;
        $details->save();
    }

    private function notificationmail($request, $active, $mail)
    {

        $users = User::join('discount_users', 'users.id', 'discount_users.user_id')
            ->where('discount_users.discount_id', $request->id)
            ->select('users.email', 'discount_users.code')->get();
        // dd($users);
        $arrDea = json_decode(json_encode($mail), true);

        foreach ($users as $user) {
            $code = $user->code;
            $message = [];
            foreach (Language::get() as $lang) {
                $message[$lang->code] = $arrDea[$lang->code] . ' ' . $code;
            }

            if (app()->getLocale() == "ar")
                $data = $message[app()->getLocale()];
            else
                $data = $message[app()->getLocale()];

            try {
                Notification::send($user, new DiscountMail($data, $code));
            } catch (Exception $e) {
                Log::error($e->getMessage());
            }
        }
        $details = DiscountNotifications::where('discount_id', $request->id)->where('notified_by', 'email')->first();
        $details->send = $active;
        $details->save();
    }

    // private function notificationsms($request, $active, $sms)
    // {

    // 	$users = User::join('discount_users', 'users.id', 'discount_users.user_id')
    // 		->where('discount_users.discount_id', $request->id)
    // 		->select('users.phone', 'users.id', 'discount_users.code')->get();

    // 	$arrDea = json_decode(json_encode($sms), true);

    // 	$smss = new SMS();

    // 	foreach ($users as $user) {
    // 		$code = $user->code;
    // 		$message = [];
    // 		foreach (Language::get() as $lang) {
    // 			$message[$lang->code] = $arrDea[$lang->code] . ' ' . $code;
    // 		}

    // 		$smss->smsSave(json_encode($message), $user->phone, $user->id, 'customers');
    // 	}
    // 	return response()->json(true);
    // 	$details = DiscountNotifications::where('discount_id', $request->id)->where('notified_by', 'sms')->first();
    // 	$details->send = $active;
    // 	$details->save();
    // }

    protected function sendEmailNotify(Request $request)
    {
        $discount = Discount::find($request->id);
        $users = DiscountUser::where('discount_id', $request->id)->get();
        if ($users->isEmpty()) {
            $response = [
                'error' => true,
                'message' => _i('This Discount does not have users in it')
            ];
            return response($response, 200);
        } else {
            $users_ids = $users->pluck('user_id')->toArray();
            $arr = implode(',', $users_ids);
            $email = new Email;
            $discount_notify = DiscountNotifications::where('discount_id', $discount->id)
                ->where('notified_by', 'email')
                ->first();
            $data = json_decode(json_encode($discount_notify->message), true);
            $message = $data['ar'];
            $email->emailSave('Soinksa Discount', $message, null, null, 'discount', null, $arr, null, $discount->id);
            $response = [
                'error' => false,
                'message' => _i('Discount emails scheduled successfully')
            ];
            return response($response, 200);
        }
    }

    protected function sendSMSNotify(Request $request)
    {
        $discount = Discount::find($request->id);
        $users = DiscountUser::where('discount_id', $request->id)->get();
        if ($users->isEmpty()) {
            $response = [
                'error' => true,
                'message' => _i('This Discount does not have users in it')
            ];
            return response($response, 200);
        } else {
            // $users_ids = $users->pluck('user_id')->toArray();
            // $arr = implode(',', $users_ids);
            // $sms = new SMS;
            // $discount_notify = DiscountNotifications::where('discount_id', $discount->id)
            // 	->where('notified_by', 'email')
            // 	->first();
            // $data = json_decode(json_encode($discount_notify->message), true);
            // $message = $data['ar'];
            // $sms->smsSave($message, null, null, 'discount', null, $arr, null, $discount->id);
            // $response = [
            // 	'error' => false,
            // 	'message' => _i('Discount SMS scheduled successfully')
            // ];
            // return response($response, 200);
        }
    }
}
