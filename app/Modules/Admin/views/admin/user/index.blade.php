@extends('admin.layout.index',[
	'title' => _i('All Users'),
	'subtitle' => _i('All Users'),
	'activePageName' => _i('All Users'),
	'activePageUrl' => '',
	'additionalPageUrl' => route('user.create') ,
	'additionalPageName' => _i('Add'),
] )

@section('content')
	<div class="row">
		<div class="col-sm-12 ">
		   <span class="pull-left">
			    <a href="{{route('user.export')}}" class="btn btn-primary create add-permission">
						<i class="ti-plus"></i>{{_i('Export Users')}}
					</a>
			   <a href="{{ route('user.create') }}"  class="btn btn-primary create add-permission">
				   <i class="ti-plus"></i>{{_i('create new user')}}
			   </a>
		   </span>
		</div>
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<h5>{{_i('All Admins')}}</h5>
					<div class="card-header-right">
						<i class="icofont icofont-rounded-down"></i>
						<i class="icofont icofont-refresh"></i>
						<i class="icofont icofont-close-circled"></i>
					</div>
				</div>
				<div class="card-block">
					<div class="dt-responsive table-responsive text-center">
						<table id="dataTable" class="table table-bordered table-striped dataTable text-center">
							<thead>
							<tr role="row">
								<th  > {{_i('ID')}}</th>
								<th  > {{_i('Name')}}</th>
								<th  > {{_i('Image')}}</th>
								<th  > {{_i('Email')}}</th>
								<th  > {{_i('Created At')}}</th>
								<th  > {{_i('Edit')}}</th>
								<th  > {{_i('Delete')}}</th>
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
			$('#dataTable').DataTable({
				order:[[0,'desc']],
				processing: true,
				serverSide: true,
				ajax: '{{ route('user.index') }}',
				columns: [
					{data: 'id', name: 'id'},
					{data: 'name', name: 'name'},
					{data: 'image', name: 'image'},
					{data: 'email', name: 'email'},
					{data: 'created_at', name: 'created_at'},
					{data: 'edit', name: 'edit', orderable: false, searchable: false},
					{data: 'delete', name: 'delete', orderable: false, searchable: false}
				]
			});
		});
	</script>
@endpush
