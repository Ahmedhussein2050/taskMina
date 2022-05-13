<?php

namespace App\Modules\Orders\Controllers\transaction;

use App\Bll\Utility;
use App\DataTables\FinancialTransactionsDataTable;
use App\DataTables\OfflineDataTable;
use App\DataTables\OnlineDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Admin\Models\Orders;
use App\Modules\Admin\Models\Products\bank_transfer;
use App\Modules\Orders\Models\PaymentGate;
use App\Modules\Orders\Models\Transaction;
use App\Modules\Orders\Models\transaction_types;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TransactionsController extends Controller
{
	public function offline_orders(OfflineDataTable $transaction)
	{
		return $transaction->render('admin.transaction.offline.all_offline');
	}

	public function financial_transactions()
	{
		// $query = Transaction::select('transactions.*')
		// 		->orderByDesc('transactions.id')->get();

		// 		dd($query);

		if (request()->ajax()) {
			$query = Transaction::select('transactions.*');
				///->orderByDesc('transactions.id');

			if (request()->type ) {
				if(request()->type == "online"){
					$query->where('transactions.type' , request()->type);
				}else{
					$query->where('transactions.bank_id' ,"!=", null);
				}
			}
			return DataTables::eloquent($query)
				->addColumn('user' , function($query){
					if( !empty( $query->order_id ) )
					{
						$order = orders::where('id', $query->order_id)->first();
						if( !empty( $order ) )
						{
							$user = User::where('id' , $order->user_id)->first();
						}
					}
					else if( !empty( $query->user_id ) )
					{
						$user = User::where('id' , $query->user_id)->first();
					}
					if( !empty( $user ) )
					{
						return $user->name." ".$user->lastname;
					}
					return "<label class='label label-danger'>" . _i('User not found') . "</label>";
				})

				->addColumn('trans_type' , function($query){
                         if($query->transaction_type=='pay'){
                            return "purchased";
						 }elseif($query->transaction_type=='charge')
                            return "chargebalance";
				})

				->addColumn('transaction_type' , function($query){
					if($query->bank_id != null){

						$bank = bank_transfer::where('id' , $query->bank_id)->first();
						return $bank["title"];
					}else{
						$payment_gate = PaymentGate::where('id' , $query->payment_gateway)->first();

						// $transaction_type = transaction_types::where('id' , $query->type_id)->first();
						return $payment_gate ? $payment_gate["name"] : 'empty';
					}

				})




				->editColumn('total' , function($query){
					return $query["total"] ." ". Utility::get_default_currency(true)->code;
				})
				->editColumn('status' , function($query){
					$text = '';

					if( $query->status == 'pending' )
					{
						$text = '<label class="label label-default">'. _i('Pending') .'</label>';
					}
					else if( $query->status == 'paid' )
					{
						$text = '<label class="label label-success">'. _i('Paid') .'</label>';
					}
					else if( $query->status == 'refused' )
					{
						$text = '<label class="label label-warning">'. _i('Rejected') .'</label>';
					}

					if( !$text )
					{
						$text = $query->status;
					}

					if( $query->updated == 1 )
					{
						$text .= '<label class="label label-danger">'. _i('Updated') .'</label>';
					}

					return $text;
				})
				->addColumn('action', function ($query){
					if($query->bank_id != null){
						$html = '<a href="'.url('admin/orders/offline/'.$query->id.'/show').'" target="_blank" class=" btn  btn-primary" title="'._i('Show').'">
					<i class="ti ti-eye"></i> '._i('Show').'</a>';
					}else{
						$html = '<a href="'.url('admin/orders/online/'.$query->id.'/show').'" target="_blank" class=" btn  btn-primary" title="'._i('Show').'">
					<i class="ti ti-eye"></i> '._i('Show').'</a>';
					}

					return $html;
				})

				->rawColumns([
					'user',
					'bank',
					'action',
					'status'
				])
				->make(true);

		}
 	 return view('admin.transaction.all_financial_transactions');

	}

	public  function show_offline($id)
	{
		$transaction = Transaction::where('id' , $id)->first();

		$order = Orders::where('id' , $transaction->order_id)->first();
		$user = User::where('id' , $order->user_id)->first();
		$bank = Bank_transfer::where('id' , $transaction->bank_id)->first();

		return view('admin.transaction.offline.show' , compact('transaction','order','user','bank' ));
	}

	public function online_orders(OnlineDataTable $transaction)
	{
		return $transaction->render('admin.transaction.online.all_online');
	}

	public  function show_online($id)
	{
//		return Transaction::all() ;
		$transaction = Transaction::where('id' , $id)->first();

		Transaction::where('id', $id)->update(['updated' => NULL]);
		$order = Orders::where('id' , $transaction->order_id)->first();
		$user_id = empty( $order ) ? $transaction->user_id : $order->user_id;
		$user = User::where('id' , $user_id)->first();
		$transaction_type = transaction_types::where('id' , $transaction->type_id)->first();
		$transaction_type = PaymentGate::where('id' , $transaction->payment_gateway)->first();

		return view('admin.transaction.online.show' , compact('transaction','order','user','transaction_type'));
	}

	public function accept($id)
	{
		$transaction = Transaction::where('id' , $id)->first();
		$transaction->status = "paid";
		$transaction->save();

		$user = User::where('id' , $transaction->user_id)->first();
		$user->update(['balance' => $user->balance + $transaction->total]);
		return redirect()->back()->with('flash_message' ,_i('Accepted Successfully !'));
	}

	public function refused($id)
	{
		$transaction = Transaction::where('id' , $id)->first();
		$transaction->status = "refused";
		$transaction->save();

		$user = User::where('id' , $transaction->user_id)->first();
		$user->update(['balance' => $user->balance - $transaction->total]);

		return redirect()->back()->with('flash_message' ,_i('Rejected Successfully !'));

	}}
