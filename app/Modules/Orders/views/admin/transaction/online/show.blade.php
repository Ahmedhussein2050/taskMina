@extends('admin.layout.index',[
	'title' => _i('Show Online Order'),
	'subtitle' => _i('Show Online Order'),
	'activePageName' => _i('Show Online Order'),
	'activePageUrl' => '',
	'additionalPageUrl' => '' ,
	'additionalPageName' => '',
] )

@section('content')

	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-6">
				<div class="card card-border-primary">
					<div class="card-header">
						<h5>{{_i('Transaction Info')}} </h5>
					</div>
					<div class="card-block">
						<div class="row">
							<div class="col-lg-12">
								<div class="form-group">
									<label class=" col-lg-4">{{_i('Transaction Name')}}</label>
									<label class=" col-lg-7">{{$transaction_type ? $transaction_type["name"] : 'Empty'}}<img src="{{ asset($transaction_type->image) }}" alt="Paypal" class="img-fluid col-md-5"></label>
								</div>
								<div class="form-group">
									<label class=" col-lg-4">{{_i('Transaction No')}}</label>
									<label class=" col-lg-7">{{$transaction["payment_id"]}}</label>
								</div>
								<div class="form-group">
									<label class=" col-lg-4">{{_i('Total')}}</label>
									<label class=" col-lg-7">{{$transaction["total"]}} {{$transaction["currency"]}}

									</label>
								</div>
								@if($transaction->payment_gateway == 'bank')
								<div class="form-group">
									<label class=" col-lg-4">{{_i('Sender name')}}</label>
									<label class=" col-lg-7">{{$transaction->bank_sender_name}}</label>
								</div>
								<div class="form-group">
									<label class=" col-lg-4">{{_i('Bank Transactions num')}}</label>
									<label class=" col-lg-7">{{$transaction->bank_transactions_num}}</label>
								</div>
								<div class="form-group">
									<label class=" col-lg-4">{{_i('Image')}}</label>
									<label class=" col-lg-7">
										<a href='{{ asset($transaction->image) }}'>
											<img src='{{ asset($transaction->image) }}' class='img-thumbnail'>
										</a>
									</label>
								</div>
								@elseif($transaction->payment_gateway == 'paypal')
								<div class="form-group">
									<label class=" col-lg-4">{{_i('Payment ID')}}</label>
									<label class=" col-lg-7">{{$transaction->payment_id}}</label>
								</div>
								<div class="form-group">
									<label class=" col-lg-4">{{_i('Payment email')}}</label>
									<label class=" col-lg-7">{{$transaction->payment_email}}</label>
								</div>




								@endif
								<div class="form-group">
									<label class=" col-lg-4">{{_i('Transaction Time')}}</label>
									<label class=" col-lg-7">{{$transaction["created_at"]}}</label>
								</div>
							</div>
						</div>
					</div>
					<div class="card-footer">
						<div class="task-list-table">
							<p class="task-due"><strong> {{_i('Status :')}} </strong>
								@if($transaction["status"] == "pending")
									<strong class="label label-warning">{{_i('Pending')}}</strong>
								@elseif($transaction["status"] == "paid")
									<strong class="label label-success">{{_i('Paid')}}</strong>
								@else
									<strong class="label label-danger">{{_i('Rejected')}}</strong>
								@endif
							</p>
						</div>
						@if($transaction->status == 'pending')
						<div class="task-board m-2">
							<a href="{{url('admin/orders/offline/'.$transaction->id.'/accept')}}" class="btn btn-success btn-sm "><i class="icofont icofont-checked m-2"></i>{{_i('Accept')}}</a>
							<a href="{{url('admin/orders/offline/'.$transaction->id.'/refused')}}" class="btn btn-danger btn-sm "><i class="icofont icofont-close-squared-alt m-2"></i>{{_i('Reject')}}</a>
						</div>
						@endif
						<!-- end of pull-right class -->
					</div>
					<!-- end of card-footer -->
				</div>
			</div>
			<!----------------------------------------------------------------------->
			<div class="col-lg-6">
				<!-- Invoice list card start -->
				@if($user != NULL)
				<div class="card card-border-primary">
					<div class="card-header">
						<h5>{{_i('User Info')}}</h5>

					</div>

					<div class="card-block">
						<div class="row">
							<div class="col-lg-12">
								<div class="form-group">
									<label class=" col-lg-4">{{_i('First Name')}}</label>
									<label class=" col-lg-7">{{$user["name"]}}</label>
								</div>
								<div class="form-group">
									<label class=" col-lg-4">{{_i('Last Name')}}</label>
									<label class=" col-lg-7">{{$user["lastname"]}}</label>
								</div>
								<div class="form-group">
									<label class=" col-lg-4">{{_i('Email')}}</label>
									<label class=" col-lg-7">{{$user["email"]}}</label>
								</div>
								<div class="form-group">
									<label class=" col-lg-4">{{_i('Phone')}}</label>
									<label class=" col-lg-7">{{$user["phone"]}}</label>
								</div>
								<div class="form-group">
									<label class=" col-lg-4">{{_i('Balance')}}</label>
									<label class=" col-lg-7">{{$user["balance"]}} {{ \App\Bll\Utility::get_default_currency('admin')->code }}</label>
								</div>

								<div class="form-group">
									<label class=" col-lg-4"><strong> {{_i('Order NO')}} </strong></label>
									<label class=" col-lg-7"><a href="{{url('admin/orders/'.$transaction["order_id"].'/edit')}}">{{$transaction["order_id"]}}</a></label>
								</div>
							</div>

						</div>
					</div>
					<div class="card-footer">
						<div class="task-list-table">
							<p class="task-due"><strong> {{_i('Status')}} :  </strong> <strong class="label label-warning">{{($user["is_active"]==1)? _i('Active'): _i('Not Active')}}</strong></p>
						</div>
{{--						<div class="task-board m-0">--}}
{{--							<a href="{{url('admin/user/'.$user['id'].'/edit')}}" class="btn btn-info btn-mini b-none"><i class="icofont icofont-eye-alt m-1"></i></a>--}}
{{--						</div>--}}
						<!-- end of pull-right class -->
					</div>

					<!-- end of card-footer -->
				</div>
				@elseif($order->user_id ==0 )
					<div class="card card-border-primary">
						<div class="card-header">
							<h5>{{_i('User Info')}}</h5>

						</div>

						<div class="card-block">
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label class=" col-lg-4">{{_i('First Name')}}</label>
										<label class=" col-lg-7">{{$order->name}}</label>
									</div>

									<div class="form-group">
										<label class=" col-lg-4">{{_i('Email')}}</label>
										<label class=" col-lg-7">{{$order->email}}</label>
									</div>
									<div class="form-group">
										<label class=" col-lg-4">{{_i('Phone')}}</label>
										<label class=" col-lg-7">{{$order->phone}}</label>
									</div>
									<div class="form-group">
										<label class=" col-lg-4"><strong> {{_i('Order NO')}} </strong></label>
										<label class=" col-lg-7"><a href="{{url('admin/orders/'.$transaction["order_id"].'/edit')}}">{{$transaction["order_id"]}}</a></label>
									</div>
								</div>

							</div>
						</div>
						<div class="card-footer">
							<div class="task-list-table">
								<p class="task-due"><strong> {{_i('Status')}} :  </strong> <strong class="label label-warning">{{($user["is_active"]==1)? _i('Active'): _i('Not Active')}}</strong></p>
							</div>
							<div class="task-board m-0">
								<a href="{{url('admin/user/'.$user['id'].'/edit')}}" class="btn btn-info btn-mini b-none"><i class="icofont icofont-eye-alt m-1"></i></a>
							</div>
							<!-- end of pull-right class -->
						</div>

						<!-- end of card-footer -->
					</div>

				@else
				<div class="alert alert-danger">
					User Not Found
				</div>

				@endif
				<!-- Invoice list card end -->
			</div>
			<!----------------------------------------------------------------------->



		</div>
	</div>

@endsection
