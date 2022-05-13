<?php

namespace  App\Modules\Admin\Controllers\Discounts;



use App\Http\Controllers\Controller;

use App\Models\Language;
use App\Modules\Admin\Models\Discount\Discount;
use App\Modules\Admin\Models\Discount\DiscountNotifications;
use App\Modules\Admin\Models\Discount\DiscountProduct;
use App\Modules\Admin\Models\Discount\DiscountTransaction;
use App\Modules\Orders\Models\OffersAndDiscounts\Promotors;
use App\Modules\Orders\Models\order_products;
use Illuminate\Http\Request;


class DiscountsController extends Controller
{

    public function giftDetails(Request $request)
    {

        $id = $request->id;
        $find = DiscountTransaction::findOrFail($id);

        $discount = $find->discount;

        $transactions = $find->transaction;
        if ($transactions == null)
            abort(404);
        $orders = order_products::where('order_id', $transactions->order_id)->get();
        $bank = $transactions->bank;
        $payment = $transactions->gateway;
        return view('admin.discounts.gift_details', compact('transactions', 'orders', 'id', 'payment', 'bank', 'discount'));
    }

    public function create()
    {

        $langs = Language::get();
        $promotors = Promotors::where("status", "active")->get();
        return view('admin.discounts.create', compact('langs', 'promotors'));
    }

    public function store(Request $request)
    {
         // dd($request->all());

        $data = $this->validate($request, [
            'title' => 'required',
            'promotor_id' => 'sometimes',
            'commissionValue' => 'sometimes',
            "date_from" => "required|date",
            "date_to" => "required|date|after:date_from",
            'bonus' => 'required',
            'products' => 'required',
        ]);


        $request['exclude'] = $request['exclude'] ?? 0;
        $request['bonus'] = $request['bonus'] ?? '';
        //$request['type'] = $request['type'] ?? '';

        $discounts = Discount::create([
            'type'       => $request['type'],
            'title'      => $request->title,
            'limit'      => $request->using_times,
            'user_times' => $request->user_times,
            'calc_type'  => $request['bonus'],
            'value'      => $request['bonusValue'],
            'start_date' => $request['date_from'],
            'end_date'   => $request['date_to'],
            'created_by' => auth()->user()->id,
            'code'       =>  'DC'. rand(1111111, 9999999),

        ]);
        $discounts->save();
        if ($request->products != 0) {
            foreach ($request->products as $key => $product) {
                DiscountProduct::create([
                    'product_id' => $product,
                    'discount_id' => $discounts->id,
                ]);
            }
        }else{
            DiscountProduct::create([
                'product_id' => null,
                'discount_id' => $discounts->id,
            ]);
        }

        return redirect(route('discounts.index', ["type" => $request->type]))->with('success', _i('Saved Successfully !'));
    }

    private function updateNotification($discount, $type, $val)
    {
        switch ($type) {
            case "system":
                $notification = $discount->systemNotifications->first();
                break;
            case "sms":
                $notification = $discount->smsNotifications->first();
                break;
            case "email":
                $notification = $discount->emailNotifications->first();
                break;
        }
        if ($notification == null) {
            return $this->addNotification($discount->id, $type, $val);
        }
        $notification->message = $val;
        $notification->save();
    }

    private function addNotification($discount_id, $type, $val)
    {
        $Notify = DiscountNotifications::create([
            'discount_id' => $discount_id,
            'notified_by' => $type,
            'message' => json_encode($val),

        ]);
        $Notify->save();
    }

    public function edit($id)
    {
        $langs = Language::get();
        $promotors =  Promotors::join("users", "users.id", "promotors.user_id")->where("promotors.status", "active")->select("name", "promotors.id")->get();

        $Discount = Discount::select(
            'discounts.*',
            'discount_promotors.promotor_id',
            'discount_promotors.code',
            'discount_promotors.discount_id',
            'discount_promotors.commission',
            'discount_promotors.commission_type',
            'discount_notifications.discount_id as dis_id',
            'discount_notifications.notified_by',
            'discount_notifications.message'
        )
            ->leftjoin('discount_notifications', 'discount_notifications.discount_id', 'discounts.id')
            ->leftjoin('discount_promotors', 'discount_promotors.discount_id', 'discounts.id')
            ->where('discounts.id', '=', $id)->first();
        if ($Discount == null)
            abort(404);

        return view('admin.discounts.edit', compact('Discount', 'langs', "promotors"));
    }

    public function update(Request $request, $id)
    {
        $data = $this->validate($request, [
            'title' => 'required',
            'promotor_id' => 'sometimes',
            'commissionValue' => 'sometimes',
            "date_from" => "required|date",
            "date_to" => "required|date|after:date_from",
            'bonus' => 'required',
            //'products' => 'required',
        ]);

        $Discount = Discount::where('id', $id)->first();


        $Discount->limit = $request->using_times;
        $Discount->user_times = $request->user_times;
        $Discount->created_by = auth()->user()->id;
        $Discount->title = $request->title;

        $Discount->calc_type = $request['bonus'] ?? "";
        $Discount->value = $request->bonusValue;
        $Discount->start_date = $request['date_from'];
        $Discount->end_date = $request['date_to'];


        $Discount->save();
        if($request->productss == 0){
            DiscountProduct::where('discount_id', $Discount->id)->delete();

            DiscountProduct::create([
                'product_id' => null,
                'discount_id' => $Discount->id,
            ]);
        }else{
            DiscountProduct::where('discount_id', $Discount->id)->delete();

            foreach ($request->products as $key => $product) {
                DiscountProduct::create([
                    'product_id' => $product,
                    'discount_id' => $Discount->id,
                ]);
            }
        }

        return back()->with('success', _i('Updated Successfully !'));
    }

    public function member($id)
    {
        $Discount_id = $id;
        return view('admin.discounts.member', compact('Discount_id'));
    }

    public function appendMember(Request $request)
    {
        if ($request->id != null) {
            $userData = User::whereIn('id', $request->id)->get()->toArray();
        } else {
            $userData = [];
        }
        if ($request->group_id != null) {
            $groupUserData = User::join('group_user', 'group_user.user_id', 'users.id')
                ->whereIn('group_user.group_id', $request->group_id);
            if ($request->query("promo") != null) {
                $groupUserData = $groupUserData->whereNotIn("id", function ($q) {
                    return $q->select("user_id")->from("promotors");
                });
            }
            $groupUserData = $groupUserData->get()->toArray();
        } else {
            $groupUserData = [];
        }

        if ($request->aband_id != null) {
            $abandData = User::whereIn('id', $request->aband_id)->get()->toArray();
        } else {
            $abandData = [];
        }
        $promotors = [];
        if ($request->promo_id != null) {
            $promotors = Promotors::join("users", "users.id", "promotors.user_id")->where("promotors.id", request()->promo_id)->get()->toArray();
        }

        $result = array_merge($groupUserData, $userData, $abandData, $promotors);

        $html = view('admin.discounts.append', compact('result'))->render();

        return json_encode($html);
    }

    public function storeUserData(Request $request)
    {

        try {
            $discount = Discount::find($request->discount_id);
            if ($discount != null) {
                $discount->users()->sync($request->user_id);
                $discount->promotors()->sync($request->promo_id);
            }
        } catch (\Exception $exception) {

            return back()->withError($exception->getMessage())->withInput();
        }

        return back()->with('success', _i('Saved Successfully !'));
    }

    protected function users($id)
    {
        $users = order_products::where('discount_id', $id)->get();
        dd($users);
    }
}
