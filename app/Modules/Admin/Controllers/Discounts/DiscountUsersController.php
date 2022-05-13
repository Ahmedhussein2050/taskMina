<?php

namespace  App\Modules\Admin\Controllers\Discounts;

use App\User;
use App\Discount;
use App\discount_promotors;
use App\DiscountTransaction;
use App\DiscountUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DiscountUsersController extends Controller
{
	public function index(Request $request)
	{
		$id = $request->id;

		$discount = Discount::findOrFail($id);

		if (request()->ajax()) {

			$discount_user = DiscountUser::join('discounts', 'discount_users.discount_id', 'discounts.id')
				->select('discount_users.*', 'discounts.user_times')
				->where('discount_id', $request->id)
				->get();

			//	dd($discount_user);
			$discount_promot = discount_promotors::join('discounts', 'discount_promotors.discount_id', 'discounts.id')
				->join("promotors", "promotors.id", "discount_promotors.promotor_id")
				->select('discount_promotors.*', 'discounts.user_times', "promotors.user_id")
				->where('discount_id', $request->id)
				->get();


			$discount_user = $discount_user->merge($discount_promot);
			//dd($discount_user);
			return DataTables::of($discount_user)

				->addColumn('user_code', function ($query) {
					$user = User::where('id', $query->user_id)->pluck('membership_id')->first();
					return $user;
				})
				->addColumn('members', function ($query) {

					$image = User::where('id', $query->user_id)->first();
					$url = asset($image->image);

					$url2 = asset("admin_dashboard/assets/images/user.png");
					return ($image->image != null) ? '<img src= ' . $url . ' border="0" style=" width: 80px; height: 80px;" class="img-responsive img-rounded" align="center" />' :
						'<img src= '  . $url2 . ' border="0" style=" width: 50px; height: 50px;" class="img-responsive img-rounded"   />' . '  ' . $image->name;
				})

				->addColumn('code', function ($query) {


					return '<a href=' . route('discount.transactions', $query->code) . ' id="transaction"  data-code="' . $query->code . '">' . $query->code . '</a>';
				})
				->addColumn('using_time', function ($query) {
					return   $query->counter . "/" . $query->user_times;
				})

				->rawColumns([
					'members', 'user_code', 'code', 'using_time'
				])
				->make(true);
		}
		return view('admin.discounts.discount_users', compact('discount'));
	}

	public function discountTransactions(Request $request)
	{
		$code = $request->code;


		$discount_trans = DiscountTransaction::where('code', $code)
			->get();


		if (request()->ajax()) {

			return DataTables::of($discount_trans)
				->addColumn('ID', function ($query) {

					return "<a href='/admin/discount/" . $query->id . "/details'>" . $query->id . "</a>";
				})
				->addColumn('transactions', function ($query) {

					return $query->transaction_id;
				})
				->addColumn('members', function ($query) {

					$image = User::where('id', $query->user_id)->first();
					$url = asset($image->image);

					$url2 = asset("admin_dashboard/assets/images/user.png");
					return ($image->image != null) ? '<img src= ' . $url . ' border="0" style=" width: 80px; height: 80px;" class="img-responsive img-rounded" align="center" />' :
						'<img src= '  . $url2 . ' border="0" style=" width: 50px; height: 50px;" class="img-responsive img-rounded"   />' . '  ' . $image->name;
				})
				->addColumn('membership', function ($query) {
					$user = User::where('id', $query->user_id)->first();
					return  	$user->membership_id;
				})

				->rawColumns([
					'transactions', 'members', 'membership', "ID"
				])
				->make(true);
		}

		$discount    = Discount::join("transaction_discount", "discounts.id", "transaction_discount.discount_id")->where("code", $request->code)->first();

		if ($discount == null)
			return back()->withErrors(['error',  _i('Not Found transaction !')]);;



		return view('admin.discounts.discount_transactions', compact('discount', 'code'));
	}
}
