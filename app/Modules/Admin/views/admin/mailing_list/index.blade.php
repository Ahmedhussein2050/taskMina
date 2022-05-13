@extends('admin.layout.index',
[
	'title' => _i('Mailing List'),
	'subtitle' => _i('Mailing List'),
	'activePageName' => _i('Mailing List'),
	'activePageUrl' => route('mailing_list.index'),
	'additionalPageName' => '',
	'additionalPageUrl' => '' ,
])

@push('css')
	<style>
		.card-block a {
			color: #757575;
		}
		.card-block a:hover {
			color: #1abc9c;
		}
	</style>
@endpush

@section('content')

	@include('admin.mailing_list.includes.group_modal')
	@include('admin.mailing_list.includes.edit_group_modal')
	@include('admin.mailing_list.includes.customer_group_modal')
	@include('admin.mailing_list.includes.send_modal')

	@include('admin.mailing_list.includes.add_email_modal')
	@include('admin.mailing_list.includes.edit_email_modal')

	@include('admin.mailing_list.includes.import_emails_modal')
	<!-- Page-body start -->
	<div class="page-body">
		<div class="row">
			<div class="col-md-6 col-xl-3">
				<div class="card client-blocks">
					<div class="card-block">
						<h5>
							<a href="javascript:void(0)" class="groups reload-datatable" data-type="group" data-id='0'>
								{{ _i('All Emails') }}
							</a>
						</h5>
						<ul>
							<li>
								<i class="icofont icofont-ui-user-group text-primary"></i>
							</li>
							<li class="text-right text-primary">
								{{ count($emails) }}
							</li>
						</ul>
					</div>
				</div>
			</div>
			@if(count($groups) > 0)
				@foreach($groups as $group)
					<div class="col-md-6 col-xl-3">
						<div class="card client-blocks">
							<div class="card-block">
								<h5>
									<a href="javascript:void(0)" class="groups reload-datatable" data-type="group" data-id="{{ $group->id }}">{{ $group->name }}</a>
								</h5>
								<span class='pull-right'>
									<a href='{{ route('mailing_list_group.edit', $group->id) }}' data-href='{{ route('mailing_list_group.edit', $group->id) }}' class='edit-group' data-toggle="modal" data-target="#edit-group"><i class="ti ti-pencil"></i></a>
									<a href='#' class='btn-delete' data-remote='{{ route('mailing_list_group.destroy', $group->id) }}'>
										<i class="ti ti-trash"></i>
									</a>
								</span>
								<ul>
									<li>
										<img src="{{ asset($group->icon) }}" alt="" width="200px">
									</li>
									<li class="text-right text-primary">
										{{ count($group->emails) }}
									</li>
								</ul>
							</div>
						</div>
					</div>
				@endforeach
			@endif
			<div class="col-md-6 col-xl-3">
				<div class="card client-blocks">
					<div class="card-block">
						<h5>{{ _i('Create New Group') }}</h5>
						<ul>
							<li>
								<a href="#" data-toggle="modal" data-target="#addGroup" style="font-size: 25px;font-weight: bold">
									<i class="ti-plus text-primary"></i>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="d-flex justify-content-between my-3">
			<div class="main-btn">
				<a href="{{ route('mailing_list.index') }}" class="btn btn-primary" data-toggle="modal" data-target="#add-email-modal">
					<i class="ti-plus"></i>
					{{ _i('Add New Email') }}
				</a>
				<a href="{{ route('mailing_list.index') }}" class="btn btn-primary" data-toggle="modal" data-target="#import-emails-modal">
					<i class="ti-plus"></i>
					{{ _i('Import Emails') }}
				</a>
			</div>

			<div class="sub-btn">
				@include('admin.mailing_list.ajax.filter')
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-header">
						<h5>{{_i('Emails')}}</h5>
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
									<th>{{_i('ID')}}</th>
									<th>{{_i('Email')}}</th>
									<th>{{_i('Created At')}}</th>
									<th>{{_i('Actions')}}</th>
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
		$(function() {
			var table = $('#dataTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: '{{ route('mailing_list.index') }}',
				columns: [
					{data: 'id', name: 'id'},
					{data: 'email', name: 'email'},
					{data: 'created_at', name: 'created_at'},
					{data: 'actions', name: 'actions', orderable: false, searchable: false},
				]
			});
			$('.reload-datatable').click(function(){
				var type = $(this).data('type');
				var id = $(this).data('id');
				table.ajax.url( '{{ route('mailing_list.index') }}?' + type + '=' + id ).load();
			})
		});

		$(document).on('change', '.selectpicker.country', function(){
			var country = $(this).val();
			var select = $(".selectpicker.city");
			$.ajax({
				url: "{{url('admin/mailing_list/json/cities')}}",
				type: 'post',
				data: {"_token":"{{ csrf_token() }}", country_id: country},
				success: function(data)
				{
					select.empty();
					select.selectpicker({title: "{{_i('Please Select City')}}"});
					for (var i = 0; i < data.length; i++) {
						select.append('<option value="' + data[i]['id'] + '">' + data[i]['title'] + '</option>');
					}
					select.selectpicker('refresh');
				}
			});
		})

		$('#add-email-form').submit(function (e) {
			e.preventDefault();
			var url = "{{ route('mailing_list.store') }}";

			var form = $("#add-email-form").serialize();
			$.ajax({
				url: url,
				type: "post",
				//data:form,
				data: new FormData(this),
				dataType: 'json',
				cache: false,
				contentType: false,
				processData: false,

				success: function (res) {
					if (res.errors) {
						if (res.errors.email) {
							$('#email-error').html(res.errors.email[0]);
						}
					}
					if (res == true) {
						$('.modal').modal('hide');
						$("#add-email-form").parsley().reset();
						new Noty({
							type: 'success',
							layout: 'topRight',
							text: "{{ _i('Added Successfully')}}",
							timeout: 2000,
							killer: true
						}).show();
						setTimeout(function () {
							location.reload();
						}, 2000);
					}
				}
			})
		});

		$('#import-emails-form').submit(function (e) {
			e.preventDefault();
			var url = "{{ route('mailing_list.import') }}";

			var form = $("#import-emails-form").serialize();
			$.ajax({
				url: url,
				type: "post",
				//data:form,
				data: new FormData(this),
				dataType: 'json',
				cache: false,
				contentType: false,
				processData: false,

				success: function (res) {
					if (res.errors) {
						if (res.errors.email) {
							$('#email-error').html(res.errors.email[0]);
						}
					}
					if (res == true) {
						$('.modal').modal('hide');
						$("#add-email-form").parsley().reset();
						new Noty({
							type: 'success',
							layout: 'topRight',
							text: "{{ _i('Added Successfully')}}",
							timeout: 2000,
							killer: true
						}).show();
						setTimeout(function () {
							location.reload();
						}, 2000);
					}
				}
			})
		});

		var url = '';
		$(document).on('click', '.edit', function(){
			var email = $(this).data('email');
			var groups = $(this).data('groups');
			var country_id = $(this).data('country_id');
			var city_id = $(this).data('city_id');
			$('#edit-email-form #email').val(email);
			$('#edit-email-form #groups').val(groups);
			$('#edit-email-form .country').val(country_id);

			var select = $("#edit-email-form .selectpicker.city");
			select.empty();
			$('.selectpicker').selectpicker('refresh');

			if( country_id != '')
			{
				$.ajax({
					url: "{{url('admin/mailing_list/json/cities')}}",
					type: 'post',
					data: {"_token":"{{ csrf_token() }}", country_id: country_id},
					success: function(data)
					{
						select.empty();
						select.selectpicker({title: "{{_i('Please Select City')}}"});
						for (var i = 0; i < data.length; i++) {
							select.append('<option value="' + data[i]['id'] + '">' + data[i]['title'] + '</option>');
							select.val(city_id);
							$('.selectpicker').selectpicker('refresh');
						}
					}
				});
			}
			else
			{
				$('#edit-email-form .country').val(0);
				$('.selectpicker').selectpicker('refresh');
			}

			url = $(this).attr('href');
		})

		$('#edit-email-form').submit(function (e) {
			e.preventDefault();
			var form = $("#edit-email-form").serialize();
			$.ajax({
				url: url,
				type: "post",
				//data:form,
				data: new FormData(this),
				dataType: 'json',
				cache: false,
				contentType: false,
				processData: false,

				success: function (res) {
					if (res.errors) {
						if (res.errors.email) {
							$('#email-error').html(res.errors.email[0]);
						}
					}
					if (res == true) {
						$('.modal').modal('hide');
						$("#add-email-form").parsley().reset();
						new Noty({
							type: 'success',
							layout: 'topRight',
							text: "{{ _i('Updated Successfully')}}",
							timeout: 2000,
							killer: true
						}).show();
						setTimeout(function () {
							location.reload();
						}, 2000);
					}
				}
			})
		});

		$(function () {
			$('#add_group_form').submit(function (e) {
				e.preventDefault();
				var url = "{{ route('mailing_list_group.store') }}";

				var form = $("#add_group_form").serialize();
				$.ajax({
					url: url,
					type: "post",
					//data:form,
					data: new FormData(this),
					dataType: 'json',
					cache: false,
					contentType: false,
					processData: false,

					success: function (res) {
						if (res.errors) {
							if (res.errors.name) {
								$('#name-error').html(res.errors.name[0]);
							}
						}
						if (res == true) {
							$('.modal').modal('hide');
							$("#add_group_form").parsley().reset();
							new Noty({
								type: 'success',
								layout: 'topRight',
								text: "{{ _i('Added Successfully')}}",
								timeout: 2000,
								killer: true
							}).show();
							setTimeout(function () {
								location.reload();
							}, 2000);
						}
					}
				})
			});

			$('body').on('submit', '#update_form', function (e) {
				e.preventDefault();
				var url = $(this).data('action');

				var form = $("#update_form").serialize();
				$.ajax({
					url: url,
					type: "post",
					data: new FormData(this),
					dataType: 'json',
					cache: false,
					contentType: false,
					processData: false,

					success: function (res) {
						if (res.errors) {
							if (res.errors.title) {
								$('#title-error').html(res.errors.title[0]);
							}
						}
						if (res == true) {
							$('.modal').modal('hide');
							$("#add_group_form").parsley().reset();
							new Noty({
								type: 'success',
								layout: 'topRight',
								text: "{{ _i('Updated Successfully')}}",
								timeout: 2000,
								killer: true
							}).show();
							setTimeout(function () {
								location.reload();
							}, 1000);
						}
					}
				})
			});

			$('#send_form').submit(function (e) {
				e.preventDefault();
				var url = "{{ route('UserSend') }}";

				var form = $("#send_form").serialize();
				$.ajax({
					url: url,
					type: "post",
					//data:form,
					data: new FormData(this),
					dataType: 'json',
					cache: false,
					contentType: false,
					processData: false,

					success: function (res) {
						console.log(res);
						if (res[0] == false) {
							$('.modal').modal('hide');
							$('#error').css('display', 'block');
							$('#error_text').text(res.message);
						} else {
							$('.modal').modal('hide');
							$('#error').css('display', 'none');
							$("#send_form").parsley().reset();
							$('#message').val("");

							new Noty({
								type: 'success',
								layout: 'topRight',
								text: "{{ _i('Message on its Way')}}",
								timeout: 2000,
								killer: true
							}).show();
						}

					}
				})
			});
		});

		$(document).ready(function () {
			$(document).on('click', '.btn-delete[data-remote]', function (e) {
				var $this = $(this);
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
					success: function (res) {
						if (res.errors) {
							if (res.errors.title) {
								$('#title-error').html(res.errors.title[0]);
							}
						}
						if (res == true) {
							$this.closest('.col-md-6.col-xl-3').hide();
							$('.modal').modal('hide');
							new Noty({
								type: 'success',
								layout: 'topRight',
								text: "{{ _i('Deleted Successfully')}}",
								timeout: 2000,
								killer: true
							}).show();
							setTimeout(function () {
								// location.reload();
							}, 2000);
						}
					}
				}).always(function (data) {
					$('#dataTable').DataTable().draw(false);
				});
			});
		});

		$('#edit-group').on('show.bs.modal', function (e) {
			var loadurl = $(e.relatedTarget).data('href');
			$(this).find('.modal-body').load(loadurl, function(){
				$('.selectpicker').selectpicker('refresh');
			});
		});

		$('#add_user_to_group').on('show.bs.modal', function (e) {
			var loadurl = $(e.relatedTarget).data('href');
			$(this).find('.modal-body').load(loadurl, function(){
				$('.selectpicker').selectpicker('refresh');
			});
		});
	</script>
@endpush
