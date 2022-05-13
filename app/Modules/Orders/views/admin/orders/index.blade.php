@extends('admin.layout.index',[
	'title' => _i('Orders'),
	'subtitle' => _i('Orders'),
	'activePageName' => _i('Orders'),
	'activePageUrl' => route('admin.orders.index'),
	'additionalPageName' => _i('Settings'),
	'additionalPageUrl' => route('settings.index')
] )
@section('content')
<div class="flash-message">
	@foreach (['danger', 'warning', 'success', 'info'] as $msg)
	@if(session()->has($msg))
	<p class="alert alert-{{ $msg }}">{{ session()->get($msg) }}</p>
	@endif
	@endforeach
</div>
<div class="page-body">
	<div class="card blog-page" >
		<div class="card-block ">
				@include('admin.layout.message')
			<div class="dt-responsive table-responsive text-center">
				<table class=" table table-bordered table-striped table-responsive text-center" id="order_data"
					width="100%">
					<thead>
						<tr role="row">
							<th>{{_i('ID')}}</th>
							<th>{{_i('Image')}}</th>
							<th>{{_i('type')}}</th>
							<th>{{_i('User')}}</th>
							<th>{{_i('status')}}</th>
							<th>{{_i('Order Number')}}</th>
							<th>{{_i('Total')}}</th>
							<th>{{_i('shipping cost')}}</th>
							<th>{{_i('Order Time')}}</th>
							<th>{{_i('action')}}</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>
@push('js')
<script type="text/javascript">

	var table;
	function init(url = "{{route('admin.orders.index')}}")
	{
		table = $('#order_data').DataTable(
		{
			// "order": [],
			dom: "Blfrtip",
			buttons:
			[
				{{--{--}}
				{{--	"text":"<i class=\"ti-plus\"><\/i> {{_i('Add Order')}}", "className":"btn btn-primary create",--}}
				{{--	"action": function(e, dt, button, config)--}}
				{{--	{--}}
				{{--		window.location = "../orders";--}}
				{{--	}--}}
				{{--},--}}
				{"extend": "print", "className": "btn btn-primary", "text": "<i class=\"ti-printer\"><\/i>"},
				{
					"text":"{{_i('Reset')}}", "className":"btn btn-inverse",
					action: function (e, dt, button, config)
					{
						reset()
					}
				},
				{"extend": "collection", "className": "btn btn-inverse", "text": "{{_i('Status')}}",
					buttons: [
						@foreach ($orderstatus as $order)
						{
							text: "{{$order}}",
							"className": "btn btn-inverse",
							action: function (e, dt, button, config)
							{
								filterByStatus(button.text())
							}
						},
						@endforeach
					]
				},
				{"extend": "collection", "className": "btn btn-inverse", "text": "{{_i('Shipping Options')}}",
					buttons: [
						@foreach ($shipping_option as $type)
						{
							<?php
							$company =  App\Modules\Orders\Models\Shipping\ShippingCompaniesData::where('shipping_company_id',$type->company_id)
							->where('lang_id' ,\App\Bll\Lang::getSelectedLangId())->first();
							?>
							text: "@if($company != null){{ $company->title }} @endif {{_i('delay') ." ". $type->delay }}",
							"className": "btn btn-inverse",
							action: function (e, dt, button, config)
							{
							   filterByShipping('{{$type->id}}');
							}
						},
						@endforeach
					]
				},
				{
					"text":"{{_i('Show All')}}", "className":"btn btn-inverse",
					action: function (e, dt, button, config)
					{
						window.location = "../all_orders";
					}
				},

			],
			"order":[[0,'asc']],
			"responsive": true,
			"processing": true,
			"serverSide": true,
			ajax: {
				url: url,
			},
			columns: [
				{data: 'id'},
				{data: 'user_image'},
				{data: 'type'},
				{data: 'user'},
				{data: 'status'},
				{data: 'ordernumber'},
				{data: 'total'},

				{data: 'shipping_cost'},
				{data: 'created_at'},
				{
					data: 'action',
					orderable: false,
					searchable: false
				}
			],
			'drawCallback': function () {
			}
		});
	}
	$(function () {
		init();
	});

	function reset()
	{
		table.destroy();
		init('{{route('admin.orders.index')}}');
	}
	function showAll()
	{
		table.destroy();
		init('{{route('admin.orders.index')}}?allOrders=yes');
	}

	function filterByStatus(type)
	{
		table.destroy();
		init('{{route('admin.orders.index')}}?type=' + type);
	}

	function filterByTransaction(type2) {
		table.destroy();
		init('{{route('admin.orders.index')}}?type2=' + type2);
	}

	function filterByShipping(type3) {
		table.destroy();
		init( '{{route('admin.orders.index')}}?type3=' + type3);
	}

</script>
@endpush
<style>
	.table {
	display: table !important;
	}
	.row {
	width: 100% !important;
	}
</style>
@endsection
