@extends('admin.layout.index',
[
	'title' => _i('Campaign details'),
	'subtitle' => _i('Campaign details'),
	'activePageName' => _i('Campaign details'),
	'activePageUrl' => '',
	'additionalPageName' =>  _i('Campaigns'),
	'additionalPageUrl' => route('campaign.index')
])
@section('content')
<div class="box-body">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<h5>{{_i('Campaign users')}}</h5>
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
									<th class="text-center"> {{_i('ID')}}</th>
									<th class="text-center"> {{_i('User')}}</th>
									<th class="text-center"> {{_i('Phone')}}</th>
									<th class="text-center"> {{_i('Create Time')}}</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<h5>{{_i('Campaign products')}}</h5>
					<div class="card-header-right">
						<i class="icofont icofont-rounded-down"></i>
						<i class="icofont icofont-refresh"></i>
						<i class="icofont icofont-close-circled"></i>
					</div>
				</div>
				<div class="card-block">
					<div class="dt-responsive table-responsive text-center">
						<table id="products-table" class="table table-bordered table-striped dataTable text-center">
							<thead>
								<tr role="row">
									<th class="text-center"> {{_i('ID')}}</th>
									<th class="text-center"> {{_i('User')}}</th>
									<th class="text-center"> {{_i('Product')}}</th>
									<th class="text-center"> {{_i('Create Time')}}</th>
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
<script  type="text/javascript">
	var table;
	$(function () {
	    table = $('#slider_table').DataTable({
			order: [],
	        processing: true,
	        serverSide: true,
	        ajax: '{{route('campaign.details', $id)}}',
	        columns: [
	            {data: 'id'},
	            {data: 'user'},
	            {data: 'phone'},
	            {data: 'created_at'},
	        ]
	    });
	    table = $('#products-table').DataTable({
			order: [],
	        processing: true,
	        serverSide: true,
	        ajax: '{{route('campaign.details.products', $id)}}',
	        columns: [
	            {data: 'id'},
	            {data: 'name', name: 'users.name'},
	            {data: 'title', name: 'product_details.title'},
	            {data: 'created_at'},
	        ]
	    });
	});
</script>
@endpush
