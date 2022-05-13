<?php

namespace App\Modules\Admin\Controllers\Reports;


use App\Bll\Lang;
use App\Models\User;
use App\Modules\Admin\Models\Orders;
use App\Modules\Admin\Models\Products\CategoryData;
use App\Modules\Admin\Models\Products\countries_data;
use App\Modules\Admin\Models\Products\Product;
use App\Modules\Admin\Models\Products\products;
use App\Modules\Admin\Models\rating\userRating;
use Carbon\Carbon;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
	public function index()
	{
		$todayMinusOneWeekAgo =  Carbon::parse()->format('d F Y');
		$years = range(Carbon::now()->year, 2014);
		$now = Carbon::now();

		$orders = DB::table('orders')->get();

		$clints = DB::table('users')->get();

		$countries = countries_data::all();

		$visitors = DB::table('visitors')->get();
		$shippingcompanies = DB::table('shipping_companies')->join("shipping_companies_data", "shipping_companies_data.shipping_company_id", "shipping_companies.id")->where('lang_id', getLang())->get();

		$transaction_types = DB::table('transaction_types')->get();

		// best product sell
		$pros = Product::all();
		$pros = $pros->map(function ($product) {
			if (count([$product->order_products]) > 1) {
				$product->order_count = count([$product->order_products]);
			}
			return $product;
		});
		$best = $pros->sortByDesc('order_count')->take(10);

		foreach ($best as $single) {
			$data = Product::where('products.id', $single->id)
				->join('product_details', 'product_details.product_id', '=', 'products.id')
				->join('product_photos', 'product_photos.product_id', '=', 'products.id')
				->where('store_id', session()->get('StoreId'))
				->where('product_photos.main', 1)
				->where('product_details.lang_id', Lang::getLang(session('adminlang')))
				->select(
					'products.*',
					'products.price',
					'product_details.title',
					'product_details.description',
					'product_details.lang_id',
					'product_details.source_id',
					'product_photos.photo',
					'product_photos.tag'
				)
				->get();
			$best_products[] = $data;
		}
		//  dd(getLang(session('lang')));

		//Best clints orderd
		$clint = User::get();
		$clint = $clint->map(function ($clints) {
			if (count([$clints->orders]) > 1) {
				$clints->order_count = count([$clints->orders]);
			}
			return $clints;
		});
		$best = $clint->sortByDesc('order_count')->take(10);

		foreach ($best as $single) {
			$data = DB::table('users')
				->where('users.id', $single->id)
				->get();
			$best_clints[] = $data;
		}
		//  dd($best_clints);


		$best_paymant = array();
		$best_pay = orders::select(DB::raw('`user_id` as clint_id , sum(`total`) as total_count'))
			->groupBy('user_id')
			->orderBy('total_count', 'desc')
			->get();

		foreach ($best_pay as $single) {
			//  dd($single);
			$data = DB::table('users')
				->where('id', $single->clint_id)->get();
			$best_paymant[] = $data;
		}


		$matches = userRating::select(DB::raw('COUNT(user_id) as rateuser'))
			->groupBy('rating')->get()->toArray();


		return view(
			'admin.reports.index',
			[
				'orders' => $orders,
				'clints' => $clints,
				'countries' => $countries,
				'visitors' => $visitors,
				'best_products' => $best_products,
				'best_clints' => $best_clints,
				'shippingcompanies' => $shippingcompanies,
				'transaction_types' => $transaction_types,
				'best_paymant' => $best_paymant,
			]
		);
	}

	public function productsPurchased(Request $request)
	{

		$lang_id = Lang::getSelectedLangId();
		$filter = $request->filter;
		$category = $request->category;
		if (request()->ajax()) {
			$query = products::join('product_details', 'product_details.product_id', 'products.id')
				->join('order_products', 'order_products.product_id', 'products.id')
				->join('orders', 'orders.id', 'order_products.order_id')
				->join('order_statuses', 'orders.order_status', 'order_statuses.id')
				->select('products.id', 'products.price', 'order_statuses.code', 'product_details.title', DB::raw("COUNT(products.id) purchased_count"))
				->where('order_statuses.code', 'completed')
				->where('product_details.lang_id', $lang_id)


				->groupBy('products.id');
			if ($category) {
				$query = $query->where('category_id', $category);
			}
			if ($filter	 == 'best_selling') {

				$query = $query->orderByDesc('purchased_count') ;

			} elseif ($filter == 'less_selling') {
				$query = $query->orderBy('purchased_count', 'ASC') ;
			}
			return DataTables::eloquent($query)
				->addColumn('id', function ($query) {
					return _i('Product');
				})
				->addColumn('type', function ($query) {
					return _i('Product');
				})
				->addColumn('sales_total', function ($query) {

					return ($query->price * $query->purchased_count);
				})
				->addColumn('details', function ($query) {
					return 'Details';
				})
				->rawColumns([
					'id',
					'type',
					'purchased_count',
					'sales_total',
					'details',
				])
				->make(true);
		}

		$categories = CategoryData::where('lang_id', $lang_id)->get();
		return view('admin.reports.products_purchased', compact('categories'));
	}
}
