@extends('admin.layout.index', 
[
	'title' => _i('Mailing Templates'),
	'subtitle' => _i('Mailing Templates'),
	'activePageName' => _i('Mailing Templates'),
	'activePageUrl' => route('mailing_templates.index'),
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
	<!-- Page-body start -->
	<div class="page-body">
		<div class="row">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-header">
						<ul class="nav nav-tabs" id="myTab" role="tablist">
							<li class="nav-item">
								<a class="nav-link active btn btn-primary" id="customers-tab" data-toggle="tab" href="#customers" role="tab" aria-controls="customers" aria-selected="true">{{ _i('Customers') }}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link btn btn-primary" id="orders-tab" data-toggle="tab" href="#orders" role="tab" aria-controls="orders" aria-selected="false">{{ _i('Orders') }}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link btn btn-primary" id="invoices-tab" data-toggle="tab" href="#invoices" role="tab" aria-controls="invoices" aria-selected="false">{{ _i('Invoices') }}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link btn btn-primary" id="tickets-tab" data-toggle="tab" href="#tickets" role="tab" aria-controls="tickets" aria-selected="false">{{ _i('Tickets') }}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link btn btn-primary" id="staff-tab" data-toggle="tab" href="#staff" role="tab" aria-controls="staff" aria-selected="false">{{ _i('Staff') }}</a>
							</li>
						</ul>
						<div class="card-header-right">
							<i class="icofont icofont-rounded-down"></i>
							<i class="icofont icofont-refresh"></i>
							<i class="icofont icofont-close-circled"></i>
						</div>
					</div>
					<div class="card-block">
						<div class="tab-content" id="myTabContent">
							<div class="tab-pane fade show active" id="customers" role="tabpanel" aria-labelledby="customers-tab">
								<div class="dt-responsive table-responsive text-center">
									<table id="" class="table table-bordered table-striped text-center">
										<thead>
											<tr>
												<th>{{_i('Title')}}</th>
												<th>{{_i('Subject')}}</th>
												<th>{{_i('Actions')}}</th>
											</tr>
										</thead>
										<tbody>
											@foreach($templates AS $template)
											@if($template->category == 'customers')
											<tr>
											<td>{{ $template->title }}</td>
											<td>{{ $template->subject }}</td>
											<td>
												<div class="btn-group">
													<button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"  title="{{ _i('Translation') }}">
														<span class="ti ti-settings"></span> {{ _i('Translation') }}
													</button>
													<ul class="dropdown-menu" style="right: auto; left: 0; width: 5em;">
														@foreach($languages AS $language)
														<li>
															<a href="{{route('mailing_templates.edit', [$template->id, $language->id])}}" style="display: block; padding: 5px 10px 10px;">{{ $language->title }}</a>
														</li>
														@endforeach
													</ul>
												</div> 
											</td>
											</tr>
											@endif
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
							<div class="tab-pane fade show" id="orders" role="tabpanel" aria-labelledby="orders-tab">
								<div class="dt-responsive table-responsive text-center">
									<table id="" class="table table-bordered table-striped text-center">
										<thead>
										<tr role="row">
											<th>{{_i('Title')}}</th>
											<th>{{_i('Subject')}}</th>
											<th>{{_i('Actions')}}</th>
										</tr>
										</thead>
										<tbody>
											@foreach($templates AS $template)
											@if($template->category == 'orders')
											<tr>
											<td>{{ $template->title }}</td>
											<td>{{ $template->subject }}</td>
											<td>
												<div class="btn-group">
													<button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"  title="{{ _i('Translation') }}">
														<span class="ti ti-settings"></span> {{ _i('Translation') }}
													</button>
													<ul class="dropdown-menu" style="right: auto; left: 0; width: 5em;">
														@foreach($languages AS $language)
														<li>
															<a href="{{route('mailing_templates.edit', [$template->id, $language->id])}}" style="display: block; padding: 5px 10px 10px;">{{ $language->title }}</a>
														</li>
														@endforeach
													</ul>
												</div> 
											</td>
											</tr>
											@endif
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
							<div class="tab-pane fade show" id="invoices" role="tabpanel" aria-labelledby="invoices-tab">
								<div class="dt-responsive table-responsive text-center">
									<table id="" class="table table-bordered table-striped text-center">
										<thead>
										<tr role="row">
											<th>{{_i('Title')}}</th>
											<th>{{_i('Subject')}}</th>
											<th>{{_i('Actions')}}</th>
										</tr>
										</thead>
										<tbody>
											@foreach($templates AS $template)
											@if($template->category == 'invoices')
											<tr>
											<td>{{ $template->title }}</td>
											<td>{{ $template->subject }}</td>
											<td>
												<div class="btn-group">
													<button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"  title="{{ _i('Translation') }}">
														<span class="ti ti-settings"></span> {{ _i('Translation') }}
													</button>
													<ul class="dropdown-menu" style="right: auto; left: 0; width: 5em;">
														@foreach($languages AS $language)
														<li>
															<a href="{{route('mailing_templates.edit', [$template->id, $language->id])}}" style="display: block; padding: 5px 10px 10px;">{{ $language->title }}</a>
														</li>
														@endforeach
													</ul>
												</div> 
											</td>
											</tr>
											@endif
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
							<div class="tab-pane fade show" id="tickets" role="tabpanel" aria-labelledby="tickets-tab">
								<div class="dt-responsive table-responsive text-center">
									<table id="" class="table table-bordered table-striped text-center">
										<thead>
										<tr role="row">
											<th>{{_i('Title')}}</th>
											<th>{{_i('Subject')}}</th>
											<th>{{_i('Actions')}}</th>
										</tr>
										</thead>
										<tbody>
											@foreach($templates AS $template)
											@if($template->category == 'tickets')
											<tr>
											<td>{{ $template->title }}</td>
											<td>{{ $template->subject }}</td>
											<td>
												<div class="btn-group">
													<button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"  title="{{ _i('Translation') }}">
														<span class="ti ti-settings"></span> {{ _i('Translation') }}
													</button>
													<ul class="dropdown-menu" style="right: auto; left: 0; width: 5em;">
														@foreach($languages AS $language)
														<li>
															<a href="{{route('mailing_templates.edit', [$template->id, $language->id])}}" style="display: block; padding: 5px 10px 10px;">{{ $language->title }}</a>
														</li>
														@endforeach
													</ul>
												</div> 
											</td>
											</tr>
											@endif
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
							<div class="tab-pane fade show" id="staff" role="tabpanel" aria-labelledby="staff-tab">
								<div class="dt-responsive table-responsive text-center">
									<table id="" class="table table-bordered table-striped text-center">
										<thead>
										<tr role="row">
											<th>{{_i('Title')}}</th>
											<th>{{_i('Subject')}}</th>
											<th>{{_i('Actions')}}</th>
										</tr>
										</thead>
										<tbody>
											@foreach($templates AS $template)
											@if($template->category == 'staff')
											<tr>
											<td>{{ $template->title }}</td>
											<td>{{ $template->subject }}</td>
											<td>
												<div class="btn-group">
													<button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"  title="{{ _i('Translation') }}">
														<span class="ti ti-settings"></span> {{ _i('Translation') }}
													</button>
													<ul class="dropdown-menu" style="right: auto; left: 0; width: 5em;">
														@foreach($languages AS $language)
														<li>
															<a href="{{route('mailing_templates.edit', [$template->id, $language->id])}}" style="display: block; padding: 5px 10px 10px;">{{ $language->title }}</a>
														</li>
														@endforeach
													</ul>
												</div> 
											</td>
											</tr>
											@endif
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
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