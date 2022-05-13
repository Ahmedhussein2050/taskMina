@extends('admin.layout.index',[
	'title' => _i('Transactions'),
	'subtitle' => _i('Transactions'),
	'activePageName' => _i('Transactions'),
	'activePageUrl' => '',
	'additionalPageUrl' => '' ,
	'additionalPageName' => '',
] )

@section('content')
	<!-- Page-body start -->
	<div class="page-body">
		<div class="card blog-page" >
			<div class="card-block ">
				<table class=" table table-bordered table-striped table-responsive text-center" id="order_data"
					   width="100%">
					<thead>
					<tr role="row">
						<th>{{_i('ID')}}</th>
						<th>{{_i('User')}}</th>
						<th>{{_i('Transaction type')}}</th>
						<th>{{_i('Transaction type')}}</th>
						<th>{{_i('Total')}}</th>
						<th>{{_i('Status')}}</th>
						<th>{{_i('action')}}</th>
					</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
	<style>
		.table {
			display: table !important;
		}
		.row {
			width: 100% !important;
		}
	</style>
@endsection

@push('js')
	<script type="text/javascript">
		var table;
		function init(url = "{{url('admin/orders/financial_transactions')}}")
		{
			table = $('#order_data').DataTable(
				{
					"dom": "Blfrtip",
					"buttons":
						[
							{"extend": "print", "className": "btn btn-primary", "text": "<i class=\"ti-printer\"><\/i>"},

							{"extend": "collection", "className": "btn btn-inverse", "text": "<?= _i('Payment Types') ?>",
								buttons: [
									{ text: "{{_i('online')}}",
										"className": "btn btn-inverse" ,
										action: function (e, dt, button, config) {
											filterByTransaction(button.text())
										} },
									{ text: "{{_i('offline')}}",
										"className": "btn btn-inverse" ,
										action: function (e, dt, button, config) {
											filterByTransaction(button.text())
										} },
								]},
						],
                     order:[[0,'desc']],
					"responsive": true,
					"processing": true,
					"serverSide": true,
					ajax: {
						url: url,
					},
					columns: [
						{data: 'id'},
						{
							data: 'user',
							name : 'user_id',

						},
						{data: 'transaction_type'},
					    {data:'trans_type'},
						{data: 'total'},
						{data: 'status'},

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
		function filterByTransaction(type) {
			table.destroy();
			init('{{url('admin/orders/financial_transactions')}}?type=' + type);
		}
	</script>
@endpush







