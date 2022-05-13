@extends('admin.layout.index',[
	'title' => _i('Invoices'),
	'activePageName' => _i('Invoices'),
	'activePageUrl' => '',
	'additionalPageUrl' => '' ,
	'additionalPageName' => '',
] )

@section('content')
<div style="clear:both;"></div>
<div class="box-body">
	<div class="row">
		<div class="col-sm-12 mb-3">
			<span class="pull-left">
			<a href="{{route('invoice.create')}}" class="btn btn-primary create add-permissiont" type="button"><span><i class="ti-plus"></i> {{_i('Create Invoice')}} </span></a>
			</span>
		</div>
		<div class="col-sm-12">
			<!-- Zero config.table start -->
			<div class="card">
				<div class="card-header">
					<h5>{{_i('Invoices')}}</h5>
					<div class="card-header-right">
						<i class="icofont icofont-rounded-down"></i>
					</div>
				</div>
				<div class="card-block">
					<div class="dt-responsive table-responsive text-center">
						<table id="dataTable" class="table table-bordered table-striped dataTable text-center">
							<thead>
								<tr role="row">
							
									<th class="sorting"> {{_i('No')}}</th>
									<th class="sorting"> {{_i('Date')}}</th>
									<th class="sorting"> {{_i('Due Date')}}</th>
									<th class="sorting"> {{_i('Total')}}</th>
									<th class="sorting"> {{_i('Created At')}}</th>
									<th class="sorting"> {{_i('Control')}}</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@push('css')
<style>
	.modal_create  {
	margin: 2px auto;
	z-index: 1100 !important;
	}
</style>
@endpush
@endsection
@push('js')
<script>
	$(function () {
	    $('#dataTable').DataTable({
			order:[[0,'desc']],
	        processing: true,
	        serverSide: true,
	        ajax: '{{route('invoice.index')}}',
	        columns: [
			
	            {data: 'no', name: 'no'},
	            {data: 'date', name: 'date'},
	            {data: 'due_date', name: 'due_date'},
	            {data: 'total', name: 'total'},
	            {data: 'created_at', name: 'created_at'},
	            {data: 'action', name: 'action', orderable: true, searchable: true}
	        ]
	    });
	});

	$(document).ready(function () {
		$('#dataTable').on('click', '.btn-delete[data-remote]', function (e) {
			e.preventDefault();
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			var url = $(this).data('remote');
			$.ajax({
				url: url,
				type: 'DELETE',
				dataType: 'json',
				data: {method: '_DELETE', submit: true},
				success: function (response) {
					if (response.status == 'error'){
						new Noty({
							type: 'error',
							layout: 'topRight',
							text: "{{ _i('Something Wrong Happened')}}",
							timeout: 2000,
							killer: true
						}).show();
					}
					if (response.status == 'success'){
						new Noty({
							type: 'success',
							layout: 'topRight',
							text: "{{ _i('Deleted Successfully !')}}",
							timeout: 2000,
							killer: true
						}).show();
					}
				}
			}).always(function (data) {
				$('#dataTable').DataTable().draw(false);
			});
		});
	});
</script>
@endpush
