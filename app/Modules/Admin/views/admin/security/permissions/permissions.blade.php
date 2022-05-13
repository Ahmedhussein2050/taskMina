@extends('admin.layout.index',[
	'title' => _i('Permissions'),
	'level1' => _i('Security'),
	'level1_url' => route('site.admin.permissions'),
	'level2' => _i('Permissions'),
	'level2_url' => route('site.admin.permissions'),
])
@section('content')
	<!-- Page-body start -->
	<div class="page-body">
		<div class="row">
			<div class="col-sm-12">
				<a href="#" class='btn btn-primary mb-2 create add-permission' data-toggle='modal' data-target="#modal-create" >
					{{ _i('Create new permission') }}
				</a>
				<div class="card">
					<div class="card-header">
						<h5>{{ _i('Permissions') }}</h5>
					</div>
					<div class="card-block">
						<div class="table-responsive dt-responsive">
							<table id="dataTable" class="table table-striped table-bordered nowrap">
								<thead>
									<tr>
										<th> {{_i('ID')}}</th>
										<th> {{_i('Permission')}}</th>
										<th> {{_i('Created at')}}</th>
										<th> {{_i('Updated at')}}</th>
										<th> {{_i('Options')}}</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Page-body end -->
	@include('admin.security.permissions.create')
	@include('admin.security.permissions.edit')
	@include('admin.security.permissions.translate')
@endsection
@push('js')
	<script  type="text/javascript">
		$(function () {
			var table =  $('#dataTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: '{{route('site.admin.permissions')}}',
				columns: [
					{data: 'id', name: 'id'},
					{data: 'title', name: 'title'},
					{data: 'created_at', name: 'created_at'},
					{data: 'updated_at', name: 'updated_at'},
					{data: 'action', name: 'action', orderable: true, searchable: true}
				]
			});

			$('#form_add').submit(function(e) {
				e.preventDefault();
				$.ajax({
					url: "{{route('site.admin.permissions.store')}}",
					type: "POST",
					data: new FormData(this),
					dataType: 'json',
					cache       : false,
					contentType : false,
					processData : false,
					success: function(response) {
						if (response.errors){
							if(response.errors.name)
							{
								$( '#name-error' ).html( response.errors.name[0] );
							}
							if(response.errors.title)
							{
								$( '#title-error' ).html( response.errors.title[0] );
							}
						}
						if (response == 'SUCCESS'){
							new Noty({
								type: 'success',
								layout: 'topRight',
								text: "{{ _i('Saved Successfully')}}",
								timeout: 2000,
								killer: true
							}).show();
							$('.modal.modal_create').modal('hide');
							$('#dataTable').DataTable().draw(false);
							$('#lang_add').val("");
							$('#title').val("");
							$('#name').val("");
							table.ajax.reload();
						}
					},
					error: function(data)
					{
						alert(data);
					}
				});
			});

			$('body').on('click', '.edit', function (e) {
				e.preventDefault();
				var permission_id = $(this).data('id');
				var lang_id = $(this).data('lang_id');
				var permission_name = $(this).data('name');
				var permission_title = $(this).data('title');

				$('#permission_id').val(permission_id);
				$('#lang_id').val(lang_id);
				$('#permission_name').val(permission_name);
				$('#permission_title').val(permission_title);
			});

			$('#form_edit').submit(function(e) {
				e.preventDefault();
				$.ajax({
					url: "{{route('site.admin.permissions.update')}}" ,
					type: "POST",
					data: new FormData(this),
					dataType: 'json',
					cache       : false,
					contentType : false,
					processData : false,
					success: function(response) {
						if (response.errors){
							if(response.errors.name)
							{
								$( '#form_edit #name-error' ).html( response.errors.name[0] );
							}
							if(response.errors.title)
							{
								$( '#form_edit #title-error' ).html( response.errors.title[0] );
							}
						}
						if (response == 'SUCCESS'){
							new Noty({
								type: 'success',
								layout: 'topRight',
								text: "{{ _i('Saved Successfully')}}",
								timeout: 2000,
								killer: true
							}).show();
							$('.modal.modal_edit').modal('hide');
							table.ajax.reload();
						}
					}
				});
			});

			$('#dataTable').on('click', '.btn-delete[data-remote]', function (e) {
				e.preventDefault();
				var url = $(this).data('remote');

				$.ajax({
					url: url,
					method: "delete",
					data: {
						_token: '{{ csrf_token() }}',
					},
					success: function (response) {
						// console.log(response);
						if (response.data === true){
							new Noty({
								type: 'error',
								layout: 'topRight',
								text: "{{ _i('Deleted Successfully')}}",
								timeout: 2000,
								killer: true
							}).show();
							table.ajax.reload();
						}
					}
				});
			});

			$('body').on('click','.lang_ex',function (e) {
				e.preventDefault();
				var transRowId = $(this).data('id');
				var lang_id = $(this).data('lang');
				$.ajax({
					url: '{{ route('site.admin.permissions.getLangValue') }}',
					method: "get",
					data: {
						lang_id: lang_id,
						transRowId: transRowId,
					},
					success: function (response) {
						if (response.data == 'false'){
							$('#titletrans').val('');
						}else{
							$('#titletrans').val(response.data.title);
						}
					}
				});

				$.ajax({
					url: '{{ route('all_langs') }}',
					method: "get",
					data: {
						lang_id: lang_id,
					},
					success: function (response) {
						$('.modal_create #header').empty();
						$('.modal_create #header').text('Translate to : '+response);
						$('#id_data').val(transRowId);
						$('#lang_id_data').val(lang_id);
					}
				});
			});

			$('body').on('submit','#lang_submit',function (e) {
				e.preventDefault();
				let url = $(this).attr('action');
				$.ajax({
					url: url,
					method: "post",
					data: new FormData(this),
					dataType: 'json',
					cache       : false,
					contentType : false,
					processData : false,
					success: function (response) {
						if (response.errors){
							$('#masages_model').empty();
							$.each(response.errors, function( index, value ) {
								$('#masages_model').show();
								$('#masages_model').append(value + "<br>");
							});
						}
						if (response == 'SUCCESS'){
							new Noty({
								type: 'success',
								layout: 'topRight',
								text: "{{ _i('Translated Successfully')}}",
								timeout: 2000,
								killer: true
							}).show();
							$('.modal.modal_create').modal('hide');
							table.ajax.reload();
						}
					},
				});
			})
		});
	</script>
@endpush
