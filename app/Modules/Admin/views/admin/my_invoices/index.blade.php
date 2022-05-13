@extends('admin.layout.index',
[
	'title' => _i('My invoices'),
	'subtitle' => _i('My invoices'),
	'activePageName' => _i('My invoices'),
	'activePageUrl' => route('myinvoices.index'),
	'additionalPageName' =>  _i('Settings'),
	'additionalPageUrl' => route('settings.index')
])
@section('content')
<div class="box-body">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<h5>{{_i('My invoices')}}</h5>
					<div class="card-header-right">
						<i class="icofont icofont-rounded-down"></i>
						<i class="icofont icofont-refresh"></i>
						<i class="icofont icofont-close-circled"></i>
					</div>
				</div>
				<div class="card-block">
					<div class="dt-responsive table-responsive text-center">
						<table id="slider_table" class="table table-bordered table-striped dataTable text-center">
							<thead>
								<tr role="row">
									<th>#</th>
									<th>{{ _i('Payment ID') }}</th>
									<th>{{ _i('Payment method') }}</th>
									<th>{{ _i('Trasnaction type') }}</th>
									<th>{{ _i('Price') }}</th>
									<th>{{ _i('Purchase date') }}</th>
									<th>{{ _i('Print') }}</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@push('js')
<script>
	var table = $('.dataTable').DataTable({
		order: [],
		processing: true,
		serverSide: true,
		ajax: '{{route('myinvoices.index')}}',
		columns: [
			{data: 'id', name: 'id'},
			{data: 'payment_id', name: 'payment_id'},
			{data: 'payment_method', name: 'payment_method'},
			{data: 'transaction_type', name: 'transaction_type'},
			{data: 'price', name: 'price', searchable: false},
			{data: 'created_at', name: 'created_at'},
			{data: 'print', name: 'print', searchable: false},
		]
	});
</script>
@endpush
