@extends('admin.layout.index',[
'title' => _i('All Permissions'),
'activePageName' => _i('All Permissions'),
'activePageUrl' => '',
'additionalPageUrl' => url('/admin/permission/create') ,
'additionalPageName' => _i('Add'),
] )

@section('content')
	<div class="row">
		<div class="col-sm-12 mbl">
			<span class="pull-left">
				  <a href="{{url('admin/permission/create')}}" data-toggle="modal" data-target="#modal-create" class="btn btn-primary create add-permission">
						<i class="ti-plus"></i>{{_i('create new permission')}}
					</a>
			</span>
		</div>
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<h5> {{ _i('Permission List') }} </h5>
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
								<th  > {{_i('ID')}}</th>
								<th  > {{_i('Permission Name')}}</th>
								<th  > {{_i('created_at')}}</th>
								<th  > {{_i('updated_at')}}</th>
								<th  > {{_i('Controll')}}</th>
							</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

@include('admin.permission.create')
@include('admin.permission.edit')
@include('admin.permission.translate')

@endsection
@push('js')
	<script  type="text/javascript">
		$(function() {
			var table;
			table = $('#dataTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: '{{url('admin/permission/dataTable')}}',
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

			$('body').on('click','.lang_ex',function (e) {
				e.preventDefault();
				var transRowId = $(this).data('id');
				var lang_id = $(this).data('lang');

				$.ajax({
					url: '{{ route('permission.getLangValue') }}',
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
					url: '{{ url('admin/language/getLang') }}',
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
						}
					},
				});
			})
		});

	</script>
@endpush