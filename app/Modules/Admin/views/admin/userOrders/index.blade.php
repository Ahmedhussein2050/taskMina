@extends('admin.layout.index',
[
    'title' => _i('Customers'),
    'subtitle' => _i('Customers'),
    'activePageName' => _i('Customers'),
    'activePageUrl' => route('customers.index'),
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

    @include('admin.userOrders.includes.group_modal')
    @include('admin.userOrders.includes.edit_group_modal')
    @include('admin.userOrders.includes.customer_group_modal')
    @include('admin.userOrders.includes.send_modal')
    <!-- Page-body start -->
    <div class="page-body">
        @if(count($users) > 0)
            <div class="row">
                <div class="col-md-6 col-xl-3">
                    <div class="card client-blocks">
                        <div class="card-block">
                            <h5><a href="javascript:void(0)" class="groups reload-datatable" data-type="all" data-id='all'>{{ _i('All Customers') }}</a>
                            </h5>
                            <ul>
                                <li>
                                    <i class="icofont icofont-ui-user-group text-primary"></i>
                                </li>
                                <li class="text-right text-primary">
                                    {{ count($users) }}
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
                                        <a href="javascript:void(0)" class="groups reload-datatable" data-type="group" data-id="{{ $group->id }}">{{ $group->title }}</a>
                                    </h5>
                                    <span class='pull-left'>
                                        <a href='{{ route('groups.edit', $group->id) }}' data-href='{{ route('groups.edit', $group->id) }}' class='edit-group' data-toggle="modal" data-target="#edit-group"><i class="ti ti-pencil"></i></a>
                                        <a href='#' class='btn-delete' data-remote='{{ route('groups.destroy', $group->id) }}'><i class="ti ti-trash"></i></a>
                                    </span>
                                    <ul>
                                        <li>
                                            <img src="{{ $group->icon != NULL ? asset($group->icon) : '' }}" alt="" width="200px">
                                        </li>
                                        <li class="text-right text-primary">
                                            {{ count($group->users) }}
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
                                    <a href="#" data-toggle="modal" data-target="#addGroup"
                                       style="font-size: 25px;font-weight: bold"><i
                                            class="ti-plus text-primary"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between my-3">
                <div class="main-btn">
                    <a href="{{ route('customer.create') }}" class="btn btn-primary"><i
                            class="ti-plus"></i>
                        {{ _i('Add New User') }}
                    </a>
                </div>

                <div class="sub-btn">
                    @include('admin.userOrders.ajax.filter')
                </div>
            </div>

            <div id="error" class="alert alert-danger text-center" style="display: none">
                <p id="error_text"></p>
            </div>

            <div class="content">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-name">
                            <h3>{{ _i('Customers') }}</h3>
                        </div>
                    </div>
                    <div class="card-block">
						<div class="dt-responsive table-responsive text-center">
							<table id="dataTable" class="table table-bordered table-striped dataTable text-center">
								<thead>
									<tr role="row">
										<th>{{_i('ID')}}</th>
										<th>{{_i('User')}}</th>
										<th>{{_i('Status')}}</th>
										<th>{{_i('Phone Verified')}}</th>
										<th>{{_i('Block User')}}</th>
										<th>{{_i('Actions')}}</th>
									</tr>
								</thead>
							</table>
						</div>
                    </div>
                </div>
                @else
                    <div class="alert alert-danger text-center">
                        <p class="lead">{{ _i('No Users') }}</p>
                    </div>
                @endif
            </div>
    </div>
@endsection

@push('js')

    <script>
		$(function() {
			var table = $('#dataTable').DataTable({
				order: [[0,'desc']],
				processing: true,
				serverSide: true,
				ajax: '{{ route('customers.index') }}',
				columns: [
					{data: 'id', name: 'id'},
					{data: 'user', name: 'user'},
					{data: 'status', name: 'status'},
					{data: 'phone_verified_at', name: 'phone_verified_at'},
					{data: 'block', name: 'block'},

					{data: 'actions', name: 'actions', orderable: false, searchable: false},
				]
			});
			$('.reload-datatable').click(function(){
				var type = $(this).data('type');
				var id = $(this).data('id');
				table.ajax.url( '{{ route('customers.index') }}?' + type + '=' + id ).load();
			})

            $('#add_form').submit(function (e) {
                e.preventDefault();
                var url = "{{ route('createGroup') }}";

                var form = $("#add_form").serialize();
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
                            if (res.errors.title) {
                                $('#title-error').html(res.errors.title[0]);
                            }
                        }
                        if (res == true) {
                            $('.modal').modal('hide');
                            $("#add_form").parsley().reset();
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
                            $("#add_form").parsley().reset();
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

            $('#send_email_form').submit(function (e) {
                e.preventDefault();
                var url = "{{ route('UserSend') }}";

				var form = $("#send_email_form").serialize();
                $.ajax({
                    url: url,
                    type: "post",
                    data: new FormData(this),
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,

                    success: function (res) {
                        console.log(res);
                        if (res == 'error') {
                            new Noty({
                                type: 'error',
                                text: '{{ _i('All fields are required') }}',
                                timeout: 2000,
                                killer: true
                            }).show();
                        } else {
                            $('.modal').modal('hide');
                            $("#send_email_form").parsley().reset();
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

			$('#send_sms_form').submit(function (e) {
                e.preventDefault();
                var url = "{{ route('UserSend') }}";

                $.ajax({
                    url: url,
                    type: "post",
                    data: new FormData(this),
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,

                    success: function (res) {
                        console.log(res);
                        if (res == 'error') {
                            new Noty({
                                type: 'error',
                                text: '{{ _i('All fields are required') }}',
                                timeout: 2000,
                                killer: true
                            }).show();
                        } else {
                            $('.modal').modal('hide');
                            $("#send_sms_form").parsley().reset();
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

		$(document).on('click', '.message-type', function(){
			var type = $(this).data('type');
			$('.message-type-tab').attr('hidden', true);
			$('.' + type).removeAttr('hidden');
			$('.message-type').removeClass('bg-red');
			$(this).addClass('bg-red');
			$('.message-type').val(type);
		})


		$(document).on('change', '.js-switch-table', function (e) {
			e.preventDefault();

			var id = $(this).data('id');
			console.log(id);
			var url = "{{route('users.block',"/id")}}";
			url = url.replace('/id',id)




			$.ajax({
				url:url,
				method: "POST",
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data: {id:id},
				dataType: 'json',
				cache       : false,
				contentType : false,
				processData : false,
				success: function (response) {

					new Noty({
						type: 'success',
						layout: 'topRight',
						text: "{{ _i('User status updated successfully')}}",
						timeout: 2000,
						killer: true
					}).show();
				},
			});
		});






    </script>

@endpush
