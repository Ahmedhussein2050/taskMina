<?php

namespace  App\Modules\Admin\Controllers\Discounts;

use App\Language;
use App\User;
use App\DiscountCodesData;
use App\Discount;
use App\discount_promotors;
use App\Http\Controllers\Controller;
use App\Promotors;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class DiscountPromotorController extends Controller {

	public function index(Request $request)
	{

	      $id= $request->id;

		if (request()->ajax())
		{

			$discount_promotor = discount_promotors::join('discounts', 'discount_promotors.discount_id', 'discounts.id')
			->join("promotors", "promotors.id", "discount_promotors.promotor_id")
			->select('discount_promotors.*', 'discounts.user_times', "promotors.user_id")
			->where('discount_id', $request->id)
			->get();


			return DataTables::of($discount_promotor)

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

				return  $query->code;
			})

			->addColumn('using_time', function ($query) {
				return   $query->counter . "/" . $query->user_times;
			})
			->addColumn('action', function ($query) {
				return
					"<a href='#' class='btn mr-1 ml-1 btn-danger btn-delete datatable-delete' data-url='" . route('admin.discount.delete', $query->id)  . "' >" . _i('Delete') . "</a>";
			})
			->rawColumns([
				'action', 'members', 'user_code', 'code', 'using_time'
			])
			->make(true);
		}
		return view('admin.discounts.discount_promotor' ,compact('id'));
	}

	public function delete($id)
    {
		// dd($id);
        discount_promotors::where('id', $id)->delete();

        return response()->json(true);
    }



}
