<?php

namespace App\Modules\Orders\Controllers\orders;

use App\Bll\Lang;
use App\Bll\MyFatoorah;
use App\Bll\Order;
use App\Bll\Utility;

use App\Mail\CustomerOrderStatusChanged;
use App\Models\Language;
use App\Models\User;
use App\Modules\Admin\Models\countries;
use App\Modules\Admin\Models\Orders;
use App\Modules\Admin\Models\Products\bank_transfer;
use App\Modules\Admin\Models\Products\feature_options;
use App\Modules\Admin\Models\Products\product_details;
use App\Modules\Admin\Models\Products\product_photos;
use App\Modules\Admin\Models\Products\Product_type;
use App\Modules\Admin\Models\Products\products;
use App\Modules\Admin\Models\Settings\Currency;
use App\Modules\Admin\Models\Settings\Setting;
use App\Modules\Orders\Models\order_feature_options;
use App\Modules\Orders\Models\order_products;
use App\Modules\Orders\Models\Order_track;
use App\Modules\Orders\Models\PaymentGate;
use App\Modules\Orders\Models\Shipping\Shipping;
use App\Modules\Orders\Models\Shipping\Shipping_option;
use App\Modules\Orders\Models\Shipping\ShippingCompaniesData;
use App\Modules\Orders\Models\Stock;
use App\Modules\Orders\Models\Transaction as transactions;
use App\Modules\Orders\Models\transaction_types;
use App\Notifications\AdminNotification;
use CodeItNow\BarcodeBundle\Utils\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Modules\Admin\Models\UserBalance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Notification;

class OrdersController extends Controller
{
	public function index()

	{
		$section =  orders::query()
			->join('transactions', 'orders.id', 'transactions.order_id')
			->select('orders.*')
			->get();
//		dd($section);
		if (request()->ajax()) {

			if (request()->type2) {
				$section = transactions::leftJoin('orders', 'orders.id', '=', 'transactions.order_id')
					->leftJoin('transaction_types', 'transaction_types.id', '=', 'transactions.type_id')
					->select('orders.id', 'orders.status', 'orders.ordernumber', 'orders.shipping_cost', 'orders.updated')
					->where('transactions.type_id', request()->type2)->get();
			}

			if (request()->type3) {
				$section = $section->where('shipping_option_id', request()->type3);
			}

			if (request()->type) {
				$section = orders::query()
					->join('order_statuses', 'orders.order_status', 'order_statuses.id')
					->join('transactions', 'orders.id', 'transactions.order_id')
					->select('orders.*', 'order_statuses.code')
					->where('order_statuses.code', request()->type)->get();
			}
			// *************
			//            $section = $section->orderByDesc('id');
			return DataTables::of($section)
				// ->order(function ($query) {
				// 	$query->orderBy('status', 'asc');
				// })
				->addColumn('user', function ($query) {

					$user = DB::table('users')->where('id', $query->user_id)->first();

					if ($user == NULL) return;
					return $user->name . " " . $user->last_name;
				})
				->addColumn('user_image', function ($query) {

					$user = DB::table('users')->where('id', $query->user_id)->first();
					if ($user == NULL) return;
					if ($user->image != null) {
						$url = asset('uploads/users/' . $user->id . '/' . $user->image);
						return '<img src="' . $url . '" border="0" style="max-width:80px; max-height:50px;" class="img-responsive img-rounded" align="center" />';
					} else {
						$url = asset('default_images/avatar_male.png');
						return '<img src="' . $url . '" border="0" style="max-width:80px; max-height:50px;" class="img-responsive img-rounded" align="center" />';
					}
				})
				//				->addColumn('type', function ($query) {
				//					if ($query->user_id == 0) {
				//						return "<i class='ti-bolt'></i>" ;
				// 					}
				//					return "<i class='ti-bolt'></i>" ;
				//				})
				->addColumn('status', function ($query) {
					//					$text = _i('Wait');
					//					$track = ($query->track()->latest()->first());
					////					dd($query->track() );
					//					if ($track != null) {
					//						if ($track->statusData()->first() != null)
					//						{
					//							$text = $track->statusData()->where('lang_id', Lang::getSelectedLangId())->first()->title;
					//						}
					//						$status_id = $track->status_id;
					//					}
					//					if( $query->updated == 1 )
					//					{
					//						$text .= "<label class='label label-danger'>"._i('Updated')."</label>";
					//					}
					//					return $text;
					$section = orders::join('order_statuses', 'orders.order_status', 'order_statuses.id')->select('order_statuses.code')
						->where('orders.id', $query->id)
						->first();
					return $section ? $section->code : '';
				})
				->addColumn('action', function ($section) {
					return
						'<div style="display: flex">' .
//						'<a href="' . $section->id . '/edit" target="_blank" class="btn waves-effect waves-light btn-primary edit text-center btn-sm" title="' . _i("Edit") . '"><i class="ti-pencil-alt"></i> </a>' . "&nbsp;&nbsp;&nbsp;" .
//
//						"&nbsp;&nbsp;&nbsp;" .
						'<a href="' . route('show_orders', $section->id) . '" target="_blank" class="btn waves-effect waves-light btn-success show text-center btn-sm" title="' . _i("Show") . '">
							<i class="ti-eye"></i></a>
							&nbsp;&nbsp;&nbsp;

						</div>';
				})
				->rawColumns([
					'action', 'user', 'user_image', 'type', 'status'
				])
				->make(true);
			//							<a href="' . route('print_order', $section->id) . '" target="_blank" class="btn waves-effect waves-light btn-success show text-center btn-sm" title="' . _i("Print") . '">
            //							<i class="ti-printer"></i></a>
		}

		$orderstatus = ['wait', 'refused', 'accepted', 'shipped', 'completed', 'review', 'processing', 'return', 'shipping'];

		$transtransaction_types = transaction_types::get();
//		dd($transtransaction_types);
		$shipping_option = Shipping_option::get();

		return view('admin.orders.index', ['transtransaction_types' => $transtransaction_types, 'shipping_option' => $shipping_option, 'orderstatus' => $orderstatus]);
	}
	public function showAll(){
		$section =  orders::query()->latest();
		if (request()->ajax()) {
			if (request()->type2) {
				$section = transactions::leftJoin('orders', 'orders.id', '=', 'transactions.order_id')
					->leftJoin('transaction_types', 'transaction_types.id', '=', 'transactions.type_id')
					->select('orders.id', 'orders.status', 'orders.ordernumber', 'orders.shipping_cost', 'orders.updated')
					->where('transactions.type_id', request()->type2)->get();
			}

			if (request()->type3) {
				$section = $section->where('shipping_option_id', request()->type3);
			}

			if (request()->type) {
				$section = orders::query()
					->join('order_statuses', 'orders.order_status', 'order_statuses.id')
					->select('orders.*', 'order_statuses.code')
					->where('order_statuses.code', request()->type)->get();
			}
			// *************
			//            $section = $section->orderByDesc('id');
			return DataTables::of($section)
				// ->order(function ($query) {
				// 	$query->orderBy('status', 'asc');
				// })
				->addColumn('user', function ($query) {

					$user = DB::table('users')->where('id', $query->user_id)->first();

					if ($user == NULL) return;
					return $user->name . " " . $user->last_name;
				})
				->addColumn('user_image', function ($query) {

					$user = DB::table('users')->where('id', $query->user_id)->first();
					if ($user == NULL) return;
					if ($user->image != null) {
						$url = asset('uploads/users/' . $user->id . '/' . $user->image);
						return '<img src="' . $url . '" border="0" style="max-width:80px; max-height:50px;" class="img-responsive img-rounded" align="center" />';
					} else {
						$url = asset('default_images/avatar_male.png');
						return '<img src="' . $url . '" border="0" style="max-width:80px; max-height:50px;" class="img-responsive img-rounded" align="center" />';
					}
				})
				//				->addColumn('type', function ($query) {
				//					if ($query->user_id == 0) {
				//						return "<i class='ti-bolt'></i>" ;
				// 					}
				//					return "<i class='ti-bolt'></i>" ;
				//				})
				->addColumn('status', function ($query) {
					//					$text = _i('Wait');
					//					$track = ($query->track()->latest()->first());
					////					dd($query->track() );
					//					if ($track != null) {
					//						if ($track->statusData()->first() != null)
					//						{
					//							$text = $track->statusData()->where('lang_id', Lang::getSelectedLangId())->first()->title;
					//						}
					//						$status_id = $track->status_id;
					//					}
					//					if( $query->updated == 1 )
					//					{
					//						$text .= "<label class='label label-danger'>"._i('Updated')."</label>";
					//					}
					//					return $text;
					$section = orders::join('order_statuses', 'orders.order_status', 'order_statuses.id')->select('order_statuses.code')
						->where('orders.id', $query->id)
						->first();
					return $section ? $section->code : '';
				})
				->addColumn('action', function ($section) {
					return
						'<div style="display: flex">' .
//						'<a href="' . $section->id . '/edit" target="_blank" class="btn waves-effect waves-light btn-primary edit text-center btn-sm" title="' . _i("Edit") . '"><i class="ti-pencil-alt"></i> </a>' . "&nbsp;&nbsp;&nbsp;" .
//
//						"&nbsp;&nbsp;&nbsp;" .
						'<a href="' . route('show_orders', $section->id) . '" target="_blank" class="btn waves-effect waves-light btn-success show text-center btn-sm" title="' . _i("Show") . '">
							<i class="ti-eye"></i></a>
							&nbsp;&nbsp;&nbsp;

						</div>';
				})
				->rawColumns([
					'action', 'user', 'user_image', 'type', 'status'
				])
				->make(true);
//            <a href="' . route('print_order', $section->id) . '" target="_blank" class="btn waves-effect waves-light btn-success show text-center btn-sm" title="' . _i("Print") . '">
//							<i class="ti-printer"></i></a>
		}

		$orderstatus = ['wait', 'refused', 'accepted', 'shipped', 'completed', 'review', 'processing', 'return', 'shipping'];

		$transtransaction_types = transaction_types::get();
//		dd($transtransaction_types);
		$shipping_option = Shipping_option::get();

		return view('admin.orders.show_all', ['transtransaction_types' => $transtransaction_types, 'shipping_option' => $shipping_option, 'orderstatus' => $orderstatus]);
	}
	public function show()
	{

		// + Add Order Button
		$number = rand(1111111, 9999999);
		$users = User::all();
		$countries = countries::with('cities')->get();
		$product_type = Product_type::get();

		$products = products::leftJoin('product_details', 'products.id', '=', 'product_details.product_id')
			->select(['products.*', 'product_details.title', 'product_details.description', 'product_details.product_id as product_id', 'product_details.lang_id'])
			->get();

		$banks = bank_transfer::pluck('title', 'id');

		foreach ($products as $product) {
			$product['product_photos'] = product_photos::where('product_id', $product->id)->get();
		}

		$transtransaction_types = PaymentGate::where('status', 1)->get();

		return view(
			'admin.orders.create',
			compact(
				'banks',
				'product_type',
				'number',
				'users',
				'countries',
				'products',
				'transtransaction_types'
			)
		);
	}


	public function edit($id)
	{
		$order = orders::where('id', $id)
			->with('user')
			->with('shipping_option')
			->with(
				[
					'orderProducts' => function ($query) {
						$query->with('product');
					}
				]
			)
			->with('features')
			->first();
		//return  $order->
		// ;

		if ($order == null) {
			abort("404");
		}

		$order->update(['updated' => NULL]);

		$transactions = transactions::where('order_id', $id)->first();
		if ($transactions == null) {
			$transactions = 0;
		}
		$number = $order->ordernumber;
		$address = Shipping::where('order_id', $id)->with('city')->with('country')->get();
		$address = $address->map(function ($query) {
			$query->countries = $query->country;
			return $query;
		});
		$address = $address->first();
		$users = User::get();
		$countries = countries::leftJoin('countries_data', 'countries_data.country_id', 'countries.id')
			->where('countries_data.lang_id', Lang::getSelectedLangId())
			->select('countries.id as id', 'countries_data.title')
			->pluck('title', 'id');
		$product_type = Product_type::get();
		$products = product_details::with(['product' => function ($query) {
			$query->with(['product_photos' => function ($q) {
				$q->where('main', 1);
			}]);
		}])->get();
		//$transtransaction_types = transaction_types::get();
		$transtransaction_types = PaymentGate::where('status', 1)->get();
		$banks = bank_transfer::pluck('title', 'id');
		$status = \App\Bll\Order::getStatus(); // ??

		$text = "Wait ...";
		$status_id = "";
		$track = ($order->track()->latest()->first());
		// dd($track);
		if ($track != null) {
			if ($track->statusData()->first() != null) {
				$text = $track->statusData()->where('lang_id', Lang::getSelectedLangId())->first()->title;
			}
			$status_id = $track->status_id;
		}

		if ($order->shipping_option != null) {
			$company = ShippingCompaniesData::where('shipping_company_id', $order->shipping_option->company_id)

				// ->where('lang_id' ,Lang::getSelectedLangId())
				->first();
		} else {
			$company = null;
		}
		return view('admin.orders.edit', compact('address', 'product_type', 'number', 'users', 'countries', 'products', 'transtransaction_types', 'order', 'transactions', 'banks', "status", 'text', 'status_id', 'company'));
	}

	public function saveallorders(Request $request)
	{


		$shippingOption = null;
		if ($request->shipping_option == null && $request->totalprice == null) {
			return response()->json(['status' => 'failed']);
		} else {
//			dd($request->all());
			$shippingOption_id = $request->shipping_option;
			$ordernumber = $request->ordernumber;
			$products = $request->product;
			$user_id = $request->user_id;
			if ($request->shipping_option != null) {
				$country_id = $request->countries;
				$city_id = (int) $request->cities;
				$neighborhood = $request->neighborhood;
				$street = $request->street;
				$address = $request->address;
			}
			$code = $request->code;
			$payment_id = $request->payment_id;
			$totalPrice = (float) str_replace(',', '', $request->totalprice);
			$payment = $request->payment_title;
			$bank = $request->bank;
			$bank_transactions_num = $request->bank_transactions_num;
			$shipping_cost = $request->shipping_cost;
			$cod_cost = $request->cod? : 0;
			$image = $request->image;

			$paymentMethodId = session()->get('PaymentMethodId');
			$invoiceId = session()->get('InvoiceId');
			$currency = \App\Bll\Constants::defaultCurrency;
			if ($ordernumber != null && $user_id != null) {
				// DB::beginTransaction();
				// try {
				if ($shippingOption_id != null) {
					$shippingOption = Shipping_option::where('id', $shippingOption_id)->first();
					$order = orders::create(['user_id' => $user_id, 'ordernumber' => $ordernumber, 'shipping_option_id' => $shippingOption->id, 'shipping_cost' => $shipping_cost, 'cod_cost' => $cod_cost, 'total' => $totalPrice, "currency" => $currency]);
				} else {
					$order = orders::create(['user_id' => $user_id, 'ordernumber' => $ordernumber, 'shipping_option_id' => null, 'shipping_cost' => null, 'total' => $totalPrice, "currency" => $currency]);
				}

				$order_product = [];
				foreach ($products as $key => $product) {
					$pro = product_details::where('product_id', $key)->first();
					$productUpdate = products::where('id', $key)->first();
                    \App\Bll\Order::update_product_quantity($key, $product['quantity'] * -1, $order->id);
					// $productUpdate->update(['max_count' => DB::raw('max_count -' . $product['quantity'])]);
					$order_product[] = order_products::create(['product_id' => $key, 'order_id' => $order->id, 'count' => $product['quantity'], 'price' => $productUpdate->price, 'discount' => $productUpdate->discount]);
					$details = [
						'id' => $order->id,
						'product_id' => $key,
						'title' => $pro->title,
						'number' => $order->ordernumber,
						'total' => $order->total,
						'action' => 'Add',
					];

					Notification::send(auth()->user(), new AdminNotification($details));
				}

				$imageName = '';
				if ($image) {
					$request->validate([
						'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
					]);

					$numberrand = rand(11111, 99999);
					$randname = time() . $numberrand;
					$imageName = $randname . '.' . $image->getClientOriginalExtension();
					$image->move(public_path('uploads/payment'), $imageName);
				}
				if ($shippingOption != null) {
					$shipping = Shipping::create(['country_id' => $country_id, 'city_id' => $city_id, 'order_id' => $order['id'], 'Neighborhood' => $neighborhood, 'street' => $street, 'address' => $address, 'code' => $code]);
				}

				if ($payment != null) {
					$transaction = transactions::create([
						'order_id' => $order->id,
						'payment_gateway' => PaymentGate::query()->where('name', $payment)->first()->id,
						'status' => 'pending',
						'total' => $shipping_cost + $totalPrice + $cod_cost,
						'user_id' => $user_id,
						'transaction_type' => 'pay',
					]);
				}
				// 	DB::commit();
				// } catch (\Exception $e) {
				// 	return $e;
				// 	DB::rollBack();
				// }
				// $order;
				// $order_product;
				// $shipping;
				// $transaction;
			}
		}

		return response()->json(['status' => 'success', 'order' => $order]);
	}

	protected function removeProduct(Request $request)
	{


		$find = order_products::where("order_id", $request->order_id)->where("product_id", $request->product_id);
		$count = $find->first()->count;
		$product = products::where('id', $request->product_id)->first();
		$product->update(['max_count' => DB::raw('max_count +' . $count)]);

		$price = $find->first()->price * $count;
		$order = orders::where('id', $request->order_id)->first();
		$order->update(['total' => $order->first()->total - $price]);

		$find->delete();

		return response()->json(["status" => "ok"]);
	}

	public function updateallorders(Request $request)
	{


		$shippingOption = $request->shipping_option;
		$ordernumber = $request->ordernumber;
		$order = orders::where('id', $request->order_id)->first();
		$products = $request->product;

		$user_id = $request->user_id ?? $order->user_id;
		$address = $request->address;
		$country_id = $request->countries;
		$city_id = $request->cities;
		$neighborhood = $request->neighborhood;
		$street = $request->street;
		$code = $request->code;
		$payment = $request->payment;
		if ($ordernumber != null && $user_id != null) {
			DB::beginTransaction();
			try {
				if ($shippingOption != 0) {
					$shipping_option_details = Shipping_option::where('id', $shippingOption)->first();
					if ($request['cash_delivery_commission'] != null) {
						$orderupdate = $order->update(['user_id' => $user_id, 'ordernumber' => $ordernumber, 'shipping_option_id' => $shippingOption, 'shipping_cost' => $shipping_option_details['cost'] + $shipping_option_details['cash_delivery_commission']]);
					} else {
						$orderupdate = $order->update(['user_id' => $user_id, 'ordernumber' => $ordernumber, 'shipping_option_id' => $shippingOption, 'shipping_cost' => $shipping_option_details['cost']]);
					}
				} else {
					$orderupdate = $order->update(['user_id' => $user_id, 'ordernumber' => $ordernumber, 'shipping_option_id' => null, 'shipping_cost' => null]);
					Shipping::where("order_id", $order->id)->delete();
				}
				$order_product = [];
				$ids = [];

				// dd($products);
				// dd($request->all());
				$addPrice = 0;
				foreach ($products as $key => $product) {
					if ($key == 0) {
						$order->features()->detach();
					}
					$product['id'] = $key;

					$orderProduct = order_products::where('order_id', $order['id'])->where("product_id", $product["id"])->first();
					// dd($orderProduct);
					if ($orderProduct != null) {
						$productUpdate = products::where('id', $key)->first();
						// dd($productUpdate);
						if ($orderProduct->count > $product['quantity']) {
							$minus = $orderProduct->count - $product['quantity'];
							$productUpdate->update(['max_count' => DB::raw('max_count +' . $minus)]);
						} elseif ($orderProduct->count < $product['quantity']) {
							$minus = $product['quantity'] - $orderProduct->count;
							products::where('id', $key)->update(['max_count' => DB::raw('max_count -' . $minus)]);
						}
						// dd(($orderProduct->count * $orderProduct->price));
						$addPrice += ($product['quantity'] * $orderProduct->price) - ($orderProduct->count * $orderProduct->price);
						$orderProduct->update(['count' => $product['quantity']]);
						// dd($order->total);
						// dd($addPrice);
					} else {
						$ids[] = $product['id'];
					}
				}

				$productNotIn = array_map(function ($product_id) use ($order, $products, &$addPrice) {
					$product = ($products[$product_id]);
					$productUpdate = products::where('id', $product_id)->first();
					$addPrice += $productUpdate->price;
					$productUpdate->update(['max_count' => DB::raw('max_count -' . $product['quantity'])]);
					order_products::create([
						"product_id" => $productUpdate->id,
						"order_id" => $order->id, "count" => $product['quantity'], 'price' => $productUpdate->price
					]);
				}, $ids);
				$order->total += $addPrice;
				$order->save();
				$ship = Shipping::where('order_id', $order['id'])->first();
				if ($address) {
					if ($ship == null) {
						$shipping = Shipping::create([
							'country_id' => $country_id, 'city_id' => $city_id,
							'order_id' => $order->id,
							'Neighborhood' => $neighborhood, 'street' => $street, 'address' => $address, 'code' => $code
						]);
					} else {
						$shipping = $ship->update([
							'country_id' => $country_id, 'city_id' => $city_id,
							'Neighborhood' => $neighborhood, 'street' => $street, 'address' => $address, 'code' => $code
						]);
					}
				}
				DB::commit();
			} catch (\Exception $e) {
				return $e;
				DB::rollBack();
			}
			$orderupdate;
			$order_product;
			$shipping;
			$productNotIn;
		}
		return response()->json([$order, 'status' => 'success']);
	}

	protected function update(Request $request)
	{
		//dd($request->all());

		$find = orders::where("id", $request->input("order_id"))->first();
		if ($find == null) {
			return back()->with('error', _i('Order Not found'));
		}
		$transaction = transactions::where("order_id", $find->id)->first();
		//dd($transaction);
		if ($transaction == null) {
			return back()->with('error', _i('Transaction Not found'));
		}
		if ($request->has("update_payment")) {
			$transaction->payment_gateway = $request->payment_gateway;
			// $transaction->transaction_type = $request->payment_gateway;
			$transaction->save();
			return redirect()->back()->with('success', _i('Payment method updates successfully !'));
		}
		if ($request->has("bank_id")) {
			$file = $request->file("image");
			if ($file == null) {
				return back()->with('error', _i('Transaction photo is required'));
			}

			$request->validate([
				'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
			]);

			$numberrand = rand(11111, 99999);
			$randname = time() . $numberrand;
			$imageName = $randname . '.' . $file->getClientOriginalExtension();

			$path = ('uploads/store/order/' . $find->id);
			$file->move(public_path($path), $imageName);
			$path .= "/" . $imageName;
			$transaction->image = $path;
			$transaction->type = "offline";
			$transaction->bank_id = $request->input("bank_id");
			$transaction->holder_name = $request->input("holder_name");
			$transaction->bank_transactions_num = $request->input("bank_transactions_num");
			$transaction->save();
			return redirect()->back()->with('success', _i('Payment method updates successfully !'));
		}
	}

	public function saveproduct(Request $request)
	{


		$this->validate($request, [
			'title' => 'required',
			'type' => 'required',
			'max_count' => 'required',
			'price' => 'required',
			'image' => 'required',
		]);

		DB::beginTransaction();
		try {
			$product = products::create(['max_count' => $request['max_count'], 'price' => $request['price'], 'product_type' => $request['type']]);
			$product_details = product_details::create(['title' => $request->title, 'product_id' => $product->id, 'lang_id' => session('langId')]);
			DB::commit();
		} catch (\Exception $e) {
			return $e;
			DB::rollBack();
		}
		//$product;
		$product_details = product_details::with(['product', 'product.features', 'product.features.options'])->whereProductId($product->id)->first();
		return response()->json($product_details);
	}

	public function refreshproducts()
	{
		$products = product_details::with(['product' => function ($query) {
			$query;
			$query->with(['product_photos' => function ($q) {
				$q->where('main', 1);
			}]);
			$query->with(['features' => function ($q) {
				$q->with('options');
			}]);
		}])->get();
		return response()->json($products);
	}

	public function savenewuser(Request $request)
	{

    if ($request['id'] != null){
        $user = User::findorfail($request['id']);
        $this->validate($request, [
            'email' => 'required',
            'name' => 'required',
        ]);

        $user->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone']
        ]);
        return response()->json($user);
    }else{
        $this->validate($request, [
            'email' => 'required|unique:users',
            'name' => 'required',
        ]);

        $user = User::create([
            'name' => $request['name'],
            'password' => Hash::make($request['123123']),
            'email' => $request['email'],
            'guard' => 'web',
            'email_verified_at' => Carbon::now(),

            'phone' => $request['phone']
        ]);

        return response()->json($user);
    }

	}

	public function updateShippingAddress(Request $request)
	{

        $order = orders::where('id',$request['id'])->first();

        $shipping_address = Shipping::where('order_id',$order->id)->first();

        $shipping_address->update([
            'country_id'=>$request['countries'],
            'city_id'=>$request['cities'],
            'Neighborhood'=>$request['neighborhood'],
            'street'=>$request['street'],
            'address'=>$request['address'],
            'code'=>$request['code'],

        ]);

        $order->update([
            'shipping_option_id'=>$request['shipping_option'],
        ]);

        return response()->json('success');

	}

	public function delete($id)
	{

		$order = orders::where('id', $id)->first();
		$order_products = order_products::where('order_id', $order->id)->get();
		foreach ($order_products as $product) {
			Stock::create([

				'product_id' =>  $product->product_id,
				'quantity' => $product->count,
				'user_id' => Auth::id(),
				'details' => _i('Order Was Deleted'),
			]);
		}


		transactions::where('order_id', $order->id)->delete();
		$order->delete();
		return redirect()->back()->with('flash_message', _i('Deleted Successfully !'));
	}

	public function getproduct(Request $request)
	{
		$products = products::with(['product_details' => function ($m) use ($request) {
			$m->where('title', 'LIKE', '%' . $request->val . '%');
		}])
			->with(['product_photos'])
        ->get();
		return response()->json(['data' => $products]);
	}

	public function getproductsingle(Request $request)
	{
		$product = products::leftJoin('product_details', 'products.id', '=', 'product_details.product_id')->where('products.id', $request->pro_id)->select([
				'products.*', 'product_details.title',
				'product_details.description',
				'product_details.product_id as product_id',
				'product_details.lang_id',
			])->first();
		if ($product != null)
			$product->photo = url("") . $product->mainPhoto();

		$product->price = Order::apply_discount_code_on_price($product->price, $product->discount, 'perc')['price'];
		$product->max_count = $product->hasStock();
		return response()->json(['data' => $product]);
	}

	public function getPayways(Request $request)
	{
		if ($request->ajax()) {
			$bank = bank_transfer::where('id', $request->bank_id)->first();
			return view('admin.orders.includes._bank', compact('bank'));
		}
	}

	public function myfatoorah_admin(Request $request)
	{
		//   dd($request->all());
		if ($request->has("order")) {
			$order = orders::where('id', $request->input("order"))->first();
			$transaction = new \App\Bll\OrderTransaction();
			$transaction->orderId = $order->id;
			$transaction->typeId = request()->input("vpayment_type");
			$transaction->Save();

			$price = $order->total;
			$currency = \App\Bll\Constants::defaultCurrency;
			$user = \GuzzleHttp\json_encode(User::where('id', $order->user_id)->first());
			//   dd($price);
			$resultInitPayment = MyFatoorah::initializePayment($price, $currency);
			$resultInitPaymentdecode = json_decode($resultInitPayment);
			return view('admin.orders.pay', [
				"resultInitPaymentdecode" => $resultInitPaymentdecode,
				"user" => $user, "order" => $order->id,
				'currency' => $currency, 'price' => $price
			]);
		}
		return back()->with('error', _i('Invalid data'));
	}

	public function execute_payment_admin(Request $request)
	{
		$user = json_decode($request->user);
		$params = [];
		$params['PaymentMethodId'] = $request->paymentmethod_id;
		$params['CustomerName'] = $user->name;
		$params['DisplayCurrencyIso'] = $request->currency;
		$params['CustomerMobile'] = $user->phone;
		$params['CustomerEmail'] = $user->email;
		$params['InvoiceValue'] = $request->price;
		$params['CallBackUrl'] = route('myfatoorah_admin.finish');
		$params['ErrorUrl'] = MyFatoorah::$errorUrl;
		$params['language'] = MyFatoorah::get_store_id();
		$params['CustomerReference'] = "order_" . $request->input("order");
		$params['InvoiceItems'][0]['itemName'] = $user->name;
		$params['InvoiceItems'][0]['Quantity'] = 1;
		$params['InvoiceItems'][0]['UnitPrice'] = $request->price;
		//dd($params);
		$resultExecPayment = MyFatoorah::ExecutePayment($params);
		// dd($resultExecPayment);
		$resultExecPaymentdecode = json_decode($resultExecPayment);
		if ($resultExecPaymentdecode->IsSuccess) {
			session()->put('PaymentMethodId', $request->paymentmethod_id); //to check if user paid or not
			session()->put('InvoiceId', $resultExecPaymentdecode->Data->InvoiceId); //to check if user paid or not
			$data = $resultExecPaymentdecode->Data;
			$PaymentURL = $data->PaymentURL;
			return redirect($PaymentURL);
			$return = MyFatoorah::directPayment([
				"paymentType" => "card",
				"card" => [
					"Number" => "5123450000000008",
					"expiryMonth" => "05",
					"expiryYear" => "21",
					"securityCode" => "100"
				]
			], $PaymentURL);
			echo ($return);
		}
	}

	public function myfatoorahFinish()
	{
		$transaction_session = new \App\Bll\OrderTransaction();
		$transaction_session = $transaction_session->get();
		if ($transaction_session == null) {
			abort(404);
		}
		//$this->CreateStore($transaction->Request, $transaction->Membership);

		$order = orders::where('id', $transaction_session->orderId)->first();
		$transaction = $order->gettransactions()->first();
		//  dd($transaction);
		$transaction->type_id = $transaction_session->typeId;
		$transaction->status = "paid";
		$transaction->type = "online";
		$transaction->bank_transactions_num = request()->input("paymentId");
		$transaction->save();

		$transaction_session->destroy();

		return view('admin.orders.myfatoorah_finish');
	}

	public function showOrder(Request $request, $id)
	{

		$lang_id = Lang::getSelectedLangId();
		//        DB::enableQueryLog();
		$order = orders::where('id', $id)
			->with('user')
			->with(['shipping_option' => function ($m) use ($lang_id) {
				// $m->where('lang_id', $lang_id);
			}])
			->with('gettransactions')
			->with('shipping')
            ->with('track')
			->with(['orderProducts' => function ($query) use ($lang_id) {
				$query->with(['product' => function ($q) use ($lang_id) {
					$q->with(['product_details' => function ($qu) use ($lang_id) {
						$qu->where('lang_id', $lang_id);
					}]);
				}]);
			}])
//			->with('features')
//			->with('options.Data')
			->first();
		//        dd(DB::getQueryLog());
		// dd($order);
		//return  $order;
		if ($order == null) {
			abort('404');
		}

		$order->update(['updated' => NULL]);

		$transactions = transactions::where('order_id', $id)->where('status', 'paid')->first();
		if ($transactions == null) {
			$transactions = 0;
		}
		$number = $order->ordernumber;

		$status = \App\Bll\Order::getStatus();

		//$transtransaction_types = transaction_types::get();
		$transtransaction_types = PaymentGate::where('status', 1)->get();
		$banks = bank_transfer::pluck('title', 'id');
		$currency = \App\Bll\Constants::defaultCurrency;

		$text = "Wait ...";
		$status_id = "";
		$track = ($order->track()->latest()->first());
		if ($track != null) {
			if ($track->statusData()->first() != null) {
				$text = $track->statusData()->where('lang_id', $lang_id)->first()->title;
			}
			$status_id = $track->status_id;
		}
		return view('admin.orders.show', compact('order', 'number', 'status', 'transtransaction_types', 'banks', 'currency', 'status_id', 'text'));
	}

	public function reviewOrder(Request $request)
	{
         // dd($request->all());
		$find = orders::where("id", $request->input("order_id"))->first();
		// $order_status = Order_track::where('order_id', $request->order_id)->whereIn('status_id', ['2', '3'])->get();
		// if ($order_status->count() == 0) {
			if ($find == null) {
				return response()->json(["status" => "fail", "msg" => "fail"]);
			}
            if($request->status_id == 'complete_refund' && $request->balance != null){
               UserBalance::create([
                  'user_id' =>$find->user_id,
                  'balance' =>$request->balance,
               ]);
            }
            $find->update(['status' => $request->status_id]);
            return response()->json(["status" => "ok", "msg" => "success", "data" => $request->status_id]);
			// if (in_array($request->status_id, ['2', '3'])) {
			// 	$order_products = order_products::where('order_id', $request->input("order_id"))->get();
			// 	foreach ($order_products as $product) {
			// 		Stock::create([

			// 			'product_id' =>  $product->product_id,
			// 			'quantity' => $product->count,
			// 			'user_id' => Auth::id(),
			// 			'details' => _i('Order Was aborted'),
			// 		]);
			// 	}

			// 	$features = order_feature_options::where('order_id', $find->id)->get();
			// 	if ($features->count() > 0) {
			// 		foreach ($features as $feature) {
			// 			$option = feature_options::where('id', $feature->feature_option_id)->first();
			// 			$option->update(['sold' => $option->sold - $feature->quantity]);
			// 		}
			// 	}
			// }

			// Order_track::create([

			// 	'order_id' => $request->order_id,
			// 	'status_id' => $request->status_id,
			// 	'comment' => $request->comments,
			// ]);

			// if ($request->status_id == 8) {
			// 	$find->update(['status' => 'complete']);
			// }



			$user = User::find($find->user_id);

			// if ($request->status_id == 7) {
			// 	$owner = Auth::user();
			// 	$names = [];
			// 	$text = [];
			// 	foreach (Language::get() as $lang) {
			// 		if ($lang->code == 'ar') {
			// 			$names['ar'] = _i('The Order has been returned successfully');
			// 			$text['ar'] = _i('The Order has been returned successfully');
			// 		}
			// 		if ($lang->code = 'en') {
			// 			$names['en'] = _i('The Order has been returned successfully');
			// 			$text['en'] = _i('The Order has been returned successfully');
			// 		}
			// 	}
			// 	$OrderRefundData = [
			// 		'name' => $names,
			// 		'orderText' =>  $text,
			// 		'order_url' => url(Lang::get_language_by_code() . '/orders/' . $request->order_id . '/show'),
			// 		'order_id' => $request->order_id,

			// 	];
			// 	// dd( $owner);
			// 	Notification::send($owner, new  \App\Notifications\OrderRefundNotification($OrderRefundData));
			// }

			// \App\Bll\Mail::send('thxphp@gmail.com',new CustomerOrderStatusChanged($user, $find->ordernumber));
			// \App\Bll\Mail::send($user->email, new CustomerOrderStatusChanged($user, $find->ordernumber));

		// 	return response()->json(["status" => "ok", "msg" => "success", "data" => $request->status_id]);
		// }
        // else {
		// 	return response()->json(["status" => "false", "msg" => "false", "data" => $request->status_id]);
		// }
	}

	public function userOrderNotification(Request $request)
	{


		$user_id = $request->user_id;
		$user = User::where('id', $user_id)->first();
		$details = [
			'order_id' => $request->order_id,
			'message' => $request->message,
			'user_id' => $user_id

		];

		// \App\Notifications::create([
		// 	'notifiable_id'=>$user_id,
		// 	'data'=>$request->message,
		// 	//'notification_id'=>rand(111111,999999),
		//   'type' => 'App\Notification\UserOrderNotification'
		// ]);
		Notification::send($user, new \App\Notifications\UserOrderNotification($details, $user_id));






		//		\Illuminate\Support\Facades\Notification::send($user, new UserOrderNotification($details,$user_id));
		return response()->json([true]);
	}

	public function printOrder($id)
	{

        $order = orders::with('taxes')->where('id', $id)->first();
//         dd($order);
        if ($order == null)
            abort(404);
        $user = auth()->user();
        $setting = Setting::join('settings_data', 'settings.id', 'settings_data.setting_id')
            ->where('lang_id', Lang::getSelectedLangId())

            ->first();
        $currency = Currency::where('is_default', 1)->first();

        $qrCode = new QrCode();
        $qrCode
            ->setText("No: $order->ordernumber \nDate: $order->created_at\nTotal: $order->total")
            ->setSize(100)
            ->setPadding(10)
            ->setErrorCorrection('high')
            ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
            ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
            // ->setLabel('Scan Qr Code')
            ->setLabelFontSize(16)
            ->setImageType(QrCode::IMAGE_TYPE_PNG);

        $qr_code_type = $qrCode->getContentType();

        $qr_code = $qrCode->generate();

        return view('admin.orders.print', compact('order', 'user', 'setting', 'currency', 'qr_code_type', 'qr_code'));


//        return view('web.' . get_default_template() . '.' . 'account.print', compact('order', 'user', 'setting', 'currency', 'qr_code_type', 'qr_code'));



	}

	public function ordersMap(Request  $request)
	{

		//		$temp = CityData::join('temp2','temp2.name','city_datas.title')->select('temp2.lat','temp2.lon','city_datas.city_id')->get();
		//  		 foreach ($temp as $tem) {
		//			 $city = cities::where('id', $tem->city_id)->first();
		// 			 $city->update([
		//				 'lat' => $tem->lat,
		//				 'lng' => $tem->lon,
		//			 ]);
		//		 }

		$orders = orders::get();
		$orders_for_map = [];

		//		foreach ($orders as $order) {
		//			$city  = 1 ;
		//			$lat  = 1 ;
		//			$lng  = 1 ;

		//
		//			if ($order->shipping){
		//
		//				if ($order->shipping->city) {
		//
		//
		//					if ($order->shipping->city->lat != 0) {
		////						dd($order->shipping->city);
		//						$city = $order->shipping->city->id;
		//						$lat = $order->shipping->city->lat;
		//						$lng = $order->shipping->city->lng;
		//					}
		//				}
		//			}
		//
		// 			if ($order->shipping && $order->shipping->country) {
		//				$orders_for_map [] = [
		////					$order->id ,
		// 		//				$city,
		//				    $order->shipping->city->id,
		//					$order->shipping->city->lat  ,
		//					$order->shipping->city->lng  ,
		//
		//					];
		//				}
		// 			}
		//	dd($orders_for_map);

		$orders_for_map = Shipping::select('city_id')->get();
		foreach ($orders_for_map as $order) {
			$order->count = Shipping::where('city_id', $order->city->id)->count();
			$order->city->lat;
			$order->city->lng;
		}
		//dd($orders_for_map);
		return view(
			'admin.orders.orders_map',
			compact('orders', 'orders_for_map')
		);
	}
}
