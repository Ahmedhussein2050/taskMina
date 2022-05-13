@extends('admin.layout.index',
[
	'title' => _i('Edit Invoice'),
	'subtitle' => _i('Edit Invoice'),
	'activePageName' => _i('Edit Invoice'),
	'activePageUrl' => '',
	'additionalPageName' => _i('Invoices'),
	'additionalPageUrl' => route('invoice.index') ,
])
@push('css')
<style>
	.modal-header {
		background-color: #5cd5c4;
		border-color: #5cd5c4;
		color: #fff;
	}
</style>
@endpush
@section('content')
<div class="page-body">
	<form class="save_shipping_company" method="POST" action="{{route('invoice.update', $invoice->id)}}" enctype="multipart/form-data" data-parsley-validate="">
		@csrf
		@method('PATCH')
		<div class="row">
			<div class="col-sm-4 ">
				<div class="card">
					<div class="card-block">
						<div class="card-body card-block">
							<div class="">
								<div class="">
									<div class="form-group row ">
										<div class="col-sm-12">
											<div class="input-group ">
												<input class="form-control " name="no" placeholder="{{_i('Invoice No')}}" required value="{{ $invoice->no }}">
												<span class="input-group-addon input-group-addon-small" id="basic-addon5">
												<i class="fa fa-industry"></i>
												</span>
											</div>
											<div class="form-group">
												<label>{{ _i('Invoice Date') }}</label>
												<div class="input-group">
													<input type="date" name="date" class="form-control expire_date" value="{{ $invoice->date }}" required>
												</div>
											</div>
											<div class="form-group">
												<label>{{ _i('Invoice Due Date') }}</label>
												<div class="input-group">
													<input type="date" name="due_date" class="form-control expire_date" value="{{ $invoice->due_date }}" required>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-block">
						<div class="card-body card-block">
							<div class="">
								<div class="">
									<div class="form-group row ">
										<div class="col-sm-12">
											<div class="form-group">
												<label>{{ _i('Invoice Total') }}</label>
												<div class="input-group">
													<input type="text" name="invoice_total" class="form-control" value="{{ $invoice->total }}" required>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-8 ">
				<div class="card">
					<div class="card-block">
						<div class="card-body card-block text-center">
							<div class="">
								<div>
									<div class="form-group row ">
										<div class="col-md-6">
											<select name='user_id' id="ajax-select" class="selectpicker with-ajax col-md-12" data-live-search="true" title='{{ _i('Select Client') }}'>
												@foreach($users AS $user)
												<option value='{{ $user->id }}' data-subtext='{{ $user->email }}' {{$user->id == $invoice->user_id ? 'selected' : ''}}>{{ $user->name }}</option>
												@endforeach
											</select>
										</div>
										<div class="col-md-6">
											<select name='payment_id' id="ajax-select" class="selectpicker with-ajax col-md-12" data-live-search="true" title='{{ _i('Select Payment Method') }}'>
												@foreach( get_payment_methods() AS $payment )
												<option value='{{ $payment->id }}' {{$payment->id == $invoice->payment_id ? 'selected' : ''}}>{{ $payment->name }}</option>
												@endforeach
											</select>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-block">
						<div class="card-body card-block text-center">
							<div class="form-group row ">
								<div class="col-md-12">
									<select id="ajax-select" class="selectpicker select-product col-md-12" data-live-search="true" title='{{ _i('Select Product To Add') }}'>
										@foreach($products AS $product)
										<option value='{{ $product->id }}' data-title='{{ $product->title }}' data-price='{{ $product->price }}' data-image='{{ asset( $product->mainPhoto()) }}'>{{ $product->title }}</option>
										@endforeach
									</select>
								</div>
								<div class='col-md-12'><hr></div>
								<div class="invoice-products col-md-12">
									@foreach($invoice->products AS $product)
										<div class='col-md-6 pull-left product-details'>
											<div class='card'>
												<img class='card-img-top' src='{{ asset($product->product->mainPhoto()) }}' alt='Card image cap'>
												<div class='card-body'>
													<h5 class='card-title'>{{ $product->translation->title ??  $product->title }}</h5>
												</div>
												<ul class='list-group list-group-flush'>
													<li class='list-group-item'>
														<input type='text' name='quantity[]' class='form-control col-md-5 pull-left quantity' placeholder='{!! _i('Quantity') !!}' value='{{$product->quantity}}'>
														<input type='text' class='form-control col-md-5 pull-right price' placeholder='{!! _i('Price') !!}' value='{{$product->price}}' readonly>
													</li>
													<li class='list-group-item'>
														<input type='text' class='form-control col-md-5 pull-left total' placeholder='{!! _i('Total') !!}' value='{{$product->total_price}}' readonly>
														<a href='#' class='card-link btn btn-danger col-md-5 pull-right p-8-19 delete-product'>{!! _i('Delete') !!}</a>
													</li>
												</ul>
												<input type='hidden' name='products[]' value='{{$product->product_id}}'>
											</div>
										</div>
									@endforeach
								</div>
							</div>
							<div class="modal-footer">
								<button type="submit" class="btn btn-primary save ">{{_i('Save')}}</button>
								<button type="button" class="btn btn-default" data-dismiss="modal">{{_i('Close')}}</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
@push('js')
<script type="text/javascript">
	$('.select-product').on("changed.bs.select", function() {
    	var id = $('option:selected', this).val();
    	var title = $('option:selected', this).attr("data-title");
    	var price = $('option:selected', this).attr("data-price");
    	var image = $('option:selected', this).attr("data-image");
		var html = "<div class='col-md-6 pull-left product-details'><div class='card'><img class='card-img-top' src='" + image + "' alt='Card image cap'><div class='card-body'><h5 class='card-title'>" + title + "</h5></div><ul class='list-group list-group-flush'><li class='list-group-item'><input type='text' name='quantity[]' class='form-control col-md-5 pull-left quantity' placeholder='{!! _i('Quantity') !!}' value=1><input type='text' class='form-control col-md-5 pull-right price' placeholder='{!! _i('Price') !!}' value='" + price + "' readonly></li><li class='list-group-item'><input type='text' class='form-control col-md-5 pull-left total' placeholder='{!! _i('Total') !!}' value='" + price + "' readonly><a href='#' class='card-link btn btn-danger col-md-5 pull-right p-8-19 delete-product'>{!! _i('Delete') !!}</a></li></ul><input type='hidden' name='products[]' value='" + id + "'></div></div>";
		$('.invoice-products').append(html);
		sum_invoice_total()
	})
	$(document).on('change paste keyup', '.quantity', function(){
		var quantity = parseFloat( $(this).val() );
		var price = parseFloat( $(this).next('.price').val() );
		var total = $(this).closest('ul').find('.total').val(quantity*price);
		console.log(quantity);
		sum_invoice_total();
	})
	$(document).on('click', '.delete-product', function(e){
		e.preventDefault();
		$(this).closest('.product-details').remove();
		sum_invoice_total();
	})
	function sum_invoice_total()
	{
		var sum = 0;
		$('.invoice-products .total').each(function(){
		    sum += parseFloat(this.value);
		});
		$('input[name=invoice_total]').val(sum);
	}
</script>
@endpush
@endsection
