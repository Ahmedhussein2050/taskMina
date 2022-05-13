@extends('admin.layout.index',[
	'title' => _i('Roles'),
	'level1' => _i('Security'),
	'level1_url' => route('site.admin.roles'),
	'level2' => _i('Roles'),
	'level2_url' => route('site.admin.roles'),
])
@section('content')
	<!-- Page-body start -->
	<div class="page-body">
		<div class="row">
			<div class="col-sm-12">
				<a href="#" class='btn btn-primary mb-2' data-toggle='modal' data-target='#add-Modal'>
					{{ _i('Create new role') }}
				</a>
				<div class="card">
					<div class="card-header">
						<h5>{{ _i('Roles') }}</h5>
					</div>
					<div class="card-block">
						<div class="table-responsive dt-responsive">
							<table id="datatable" class="table table-striped table-bordered nowrap">
								<thead>
									<tr>
										<th>#</th>
										<th>{{ _i('Name') }}</th>
										<th>{{ _i('Created at') }}</th>
										<th>{{ _i('Options') }}</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="add-Modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">{{ _i('Create new role') }}</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						<form action="{{ route('site.admin.roles.store') }}" method='post' id='add-form'>
							@csrf
							<div class="form-group">
								<label for="exampleInputEmail1">{{ _i('Name') }}</label>
								<input type="text" class="form-control modal-name" name='name'>
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">{{ _i('Permissions') }}</label>
								<select name="permissions[]" class='js-example-tags' multiple>
									@foreach( $permissions AS $permission )
									<option value="{{ $permission->name }}">{{ $permission->title }}</option>
									@endforeach
								</select>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">{{ _i('Close') }}</button>
						<button type="submit" class="btn btn-primary waves-effect waves-light" form='add-form'>{{ _i('Save') }}</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="default-Modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">{{ _i('Edit role') }}</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						<form action="{{ route('site.admin.roles.update', 1) }}" method='post' id='edit-form'>
							@csrf
							<input type="hidden" name='id' id='modal-id'>
							<div class="form-group">
								<label for="exampleInputEmail1">{{ _i('Name') }}</label>
								<input type="text" class="form-control modal-name" name='name'>
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">{{ _i('Permissions') }}</label>
								<select name="permissions[]" class='js-example-tags permissions' multiple>
									@foreach( $permissions AS $permission )
									<option value="{{ $permission->name }}">{{ $permission->title }}</option>
									@endforeach
								</select>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
							{{ _i('Close') }}
						</button>
						<button type="submit" class="btn btn-primary waves-effect waves-light" form='edit-form'>
							{{ _i('Save') }}
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Page-body end -->
@endsection
@push('js')
<script>
	$('#datatable').DataTable({
		processing: true,
		serverSide: true,
		ajax: '{{route('site.admin.roles')}}',
		columns: [
			{data: 'id', name: 'id'},
			{data: 'name', name: 'name'},
			{data: 'created_at', name: 'created_at'},
			{data: 'options', name: 'options', orderable: true, searchable: true}
		]
	});
	$(document).on('click', '.edit-row', function(){
		var url = $(this).data('url');
		$.ajax({
			url: url,
			method: "get",
			success: function (response) {
				console.log(response);
				$('#edit-form .modal-name').val(response.role.name);
				$('#edit-form .permissions').val(response.permissions).trigger('change');
				$('#modal-id').val(response.role.id);
			}
		});
	});
	$('body').on('submit', '#add-form', function (e) {
		e.preventDefault();
		var url = $(this).attr('action');
		$.ajax({
			url: url,
			method: "post",
			data: new FormData(this),
			dataType: 'json',
			cache       : false,
			contentType : false,
			processData : false,
			success: function (response) {
				$('.modal').modal('hide');
				$('#datatable').DataTable().draw(false);
			},
		});
	});
	$('body').on('submit', '#edit-form', function (e) {
		e.preventDefault();
		var url = $(this).attr('action');
		$.ajax({
			url: url,
			method: "POST",
			data: new FormData(this),
			dataType: 'json',
			cache       : false,
			contentType : false,
			processData : false,
			success: function (response) {
				$('.modal').modal('hide');
				$('#datatable').DataTable().draw(false);
			},
		});
	});
	$('#datatable').on('click', '.btn-delete[data-url]', function (e) {
		e.preventDefault();
		var url = $(this).data('url');
		$.ajax({
			url: url,
			type: 'DELETE',
			dataType: 'json',
			data: {method: '_DELETE', submit: true}
		}).always(function (data) {
			$('#datatable').DataTable().draw(false);
		});
	});
</script>
@endpush
