@extends('site.admin.layout.app',[
	'title' => _i('Roles'),
	'level1' => _i('Security'),
	'level1_url' => url('admin/roles'),
	'level2' => _i('Roles'),
	'level2_url' => url('admin/roles'),
])
@section('content')
	<div class="row">
		<div class="col-sm-12 mbl">
			<span class="pull-left">
				<a href="{{ route('site.admin.roles.create') }}" class="btn btn-primary create add-permission">
					<i class="ti-plus"></i>{{_i('Create new role')}}
				</a>
			</span>
		</div>
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<h5> {{ _i('Roles list') }} </h5>
					<div class="card-header-right">
						<i class="icofont icofont-rounded-down"></i>
						<i class="icofont icofont-refresh"></i>
						<i class="icofont icofont-close-circled"></i>
					</div>
				</div>
				<div class="card-block">
					<div class="dt-responsive table-responsive text-center">
						<table id="dataTable"  class="table table-striped table-bordered nowrap text-center">
							<thead>
								<tr role="row">
									<th> {{_i('ID')}}</th>
									<th> {{_i('Role name')}}</th>
									<th> {{_i('created_at')}}</th>
									<th> {{_i('updated_at')}}</th>
									<th> {{_i('Options')}}</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@push('js')
	<script  type="text/javascript">
		$(function() {
			var table = $('#dataTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: '{{ route('site.admin.roles') }}',
				columns: [
					{data: 'id', name: 'id'},
					{data: 'name', name: 'name'},
					{data: 'created_at', name: 'created_at'},
					{data: 'updated_at', name: 'updated_at'},
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
					data: {method: '_DELETE', submit: true}
				}).always(function (data) {
					$('#dataTable').DataTable().draw(false);
				});
			});
		});
	</script>
@endpush
