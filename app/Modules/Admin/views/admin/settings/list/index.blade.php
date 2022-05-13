@extends('admin.layout.index',
[
	'title' => _i(' List'),
	'subtitle' => _i(' List'),
	'activePageName' => _i(' List'),
	'activePageUrl' => route('list_items.index'),
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

	@include('admin.settings.list.includes.group_modal')
	@include('admin.settings.list.includes.edit_group_modal')
	@include('admin.settings.list.includes.customer_group_modal')
	@include('admin.settings.list.includes.send_modal')

	@include('admin.settings.list.includes.add_email_modal')
	@include('admin.settings.list.includes.edit_email_modal')
    @include("admin.settings.list.list_translate")
    @include("admin.settings.list.item_translate")


    <!-- Page-body start -->
	<div class="page-body">
		<div class="row">
			<div class="col-md-6 col-xl-3">
				<div class="card client-blocks">
					<div class="card-block">
						<h5>
							<a href="javascript:void(0)" class="groups reload-datatable" data-type="group" data-id='0'>
								{{ _i('All Items') }}
							</a>
						</h5>
						<ul>
							<li>
								<i class="icofont icofont-ui-user-group text-primary"></i>
							</li>
							<li class="text-right text-primary">
								{{ count($lists) }}
							</li>
						</ul>
					</div>
				</div>
			</div>
			@if(count($lists) > 0)
				@foreach($lists as $list)
					<div class="col-md-6 col-xl-3">
						<div class="card client-blocks">
							<div class="card-block">
								<h5>
									<a href="javascript:void(0)" class="groups reload-datatable" data-type="group" data-id="{{ $list->id }}">{{ $list->name }}</a>
								</h5>
								<span class='pull-right'>
									{{-- <a href='{{ route('mailing_list_group.edit', $list->id) }}' data-href='{{ route('mailing_list_group.edit', $list->id) }}' class='edit-group' data-toggle="modal" data-target="#edit-group" id="edit_list_btn" data-id="{{$list->id}}" data-name="{{$list->name}}" data-order="{{$list->order}}" data-items="{{$list->items->pluck('id')}}"><i class="ti ti-pencil"></i></a> --}}
									<a href='#' class='btn-delete' data-remote='{{ route('lists.destroy', $list->id) }}'>
										<i class="ti ti-trash"></i>
									</a>

                                    <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"  title=" '._i('Translation').' ">
                                        <span class="ti ti-settings"></span>
                                    </button>

                                    <ul class="dropdown-menu" style="right: auto; left: 0; width: 5em; " >
                                        @foreach ( App\Bll\Lang::getLanguages()  as $lang)
                                            <li ><a href="#" data-toggle="modal" data-target="#listlangedit" class="lang_ex" data-id="{{$list->id}}" data-lang="{{$lang->id}}" style="display: block; padding: 5px 10px 10px;">{{$lang->title}}</a></li>
                                        @endforeach
                                    </ul>
								</span>
								<ul>

									<li class="text-right text-primary">
										{{ count($list->getitems) }}
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
						<h5>{{ _i('Create New List') }}</h5>
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
				<a href="{{ route('list_items.index') }}" class="btn btn-primary" data-toggle="modal" data-target="#add-email-modal">
					<i class="ti-plus"></i>
					{{ _i('Add New Item') }}
				</a>

			</div>

			{{-- <div class="sub-btn">
				@include('admin.settings.list.ajax.filter')
			</div> --}}
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-header">
						<h5>{{_i('Items')}}</h5>
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
									<th>{{_i('Name')}}</th>
									<th>{{_i('List')}}</th>
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
        $('body').on('click', '.lang_ex', function (e) {

            //  console.log($(this).data('id'),$(this).data('lang'))
            e.preventDefault();
            var transRowId = $(this).data('id');
            var lang_id = $(this).data('lang');

            $.ajax({
                url: '{{route('lists.get.translation')}}',
                method: "get",
                "_token": "{{csrf_token()}}",
                data: {
                    'lang_id': lang_id,
                    'list_id': transRowId,
                },
                success: function (response) {
                    console.log(response)
                    if (response.data == 'false'){
                        $('#listlangedit #name').val('');
                    } else{
                        console.log(response.data);
                        $('#listlangedit #name').val(response.data.name);

                    }
                }
            });
            $.ajax({
                url: '{{route('admin.get.lang')}}',
                method: "get",
                data: {
                    lang_id: lang_id,
                },
                success: function (response) {
                    $('#header').empty();
                    $('#listlangedit #header').text('Translate to : ' + response);
                    $('#id_data').val(transRowId);
                    $('#lang_id_data').val(lang_id);
                }
            });
            $('body').on('submit', '#lang_submit', function (e) {
                e.preventDefault();
                let url = $(this).attr('action');
                $.ajax({
                    url: url,
                    method: "post",
                    "_token": "{{ csrf_token() }}",
                    data: new FormData(this),
                    dataType: 'json',
                    cache       : false,
                    contentType : false,
                    processData : false,
                    success: function (response) {
                        if (response.errors){
                            $('#masages_model').empty();
                            $.each(response.errors, function(index, value) {
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
                            $('.modal').modal('hide');
                            window.reload();
                            location.reload();
                        }
                    },
                });
            });
        });






        $('body').on('click', '.lang_ex_item', function (e) {

            //  console.log($(this).data('id'),$(this).data('lang'))
            e.preventDefault();
            var transRowId = $(this).data('id');
            var lang_id = $(this).data('lang');

            $.ajax({
                url: '{{route('list_items.get.translation')}}',
                method: "get",
                "_token": "{{csrf_token()}}",
                data: {
                    'lang_id': lang_id,
                    'item_id': transRowId,
                },
                success: function (response) {
                    console.log(response)
                    if (response.data == 'false'){
                        $('#itemlangedit #name').val('');
                    } else{
                        console.log(response.data);
                        $('#itemlangedit #name').val(response.data.name);

                    }
                }
            });
            $.ajax({
                url: '{{route('admin.get.lang')}}',
                method: "get",
                data: {
                    lang_id: lang_id,
                },
                success: function (response) {
                    $('#header').empty();
                    $('#itemlangedit #header').text('Translate to : ' + response);
                    $('#item_id_data').val(transRowId);
                    $('#item_lang_id_data').val(lang_id);
                }
            });
            $('body').on('submit', '#item_lang_submit', function (e) {
                e.preventDefault();
                let url = $(this).attr('action');
                $.ajax({
                    url: url,
                    method: "post",
                    "_token": "{{ csrf_token() }}",
                    data: new FormData(this),
                    dataType: 'json',
                    cache       : false,
                    contentType : false,
                    processData : false,
                    success: function (response) {
                        if (response.errors){
                            $('#masages_model').empty();
                            $.each(response.errors, function(index, value) {
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
                            $('.modal').modal('hide');
                            window.reload();
                            location.reload();
                        }
                    },
                });
            });
        });

    </script>

	<script>
		$(function() {
			var table = $('#dataTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: '{{ route('list_items.index') }}',
				columns: [
					{data: 'id', name: 'id'},
					{data: 'name', name: 'name'},
					{data: 'list', name: 'list'},
					{data: 'created_at', name: 'created_at'},
					{data: 'actions', name: 'actions', orderable: false, searchable: false},
				]
			});
			$('.reload-datatable').click(function(){
				var type = $(this).data('type');
				var id = $(this).data('id');
				table.ajax.url( '{{ route('list_items.index') }}?' + type + '=' + id ).load();
			})
		});

		$(document).on('change', '.selectpicker.country', function(){
			var country = $(this).val();
			var select = $(".selectpicker.city");
			$.ajax({
				url: "{{url('admin/list_items/json/cities')}}",
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
			var url = "{{ route('list_items.store') }}";

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
		$('.selectpicker2').selectpicker('refresh');
		$(document).on('click', '.edit', function(){
			var email = $(this).data('email');
			var groups = $(this).data('groups');
			var category_id = $(this).data('category_id');
			var link = $(this).data('link');
			var lists = $(this).data('lists');
			var id = $(this).data('id');
			//var city_id = $(this).data('city_id');
			$('#edit-email-form #email').val(email);
			$('#edit-email-form #groups').val(groups);
			//$('#edit-email-form .country').val(country_id);
			$('#id').val(id)
			// var select = $("#edit-email-form .selectpicker.city");
			console.log(lists);
			console.log(category_id);
			console.log(link);
			// select.empty();
			$('.selectpicker2').selectpicker('val', lists );
			$('.selectpicker2').selectpicker('refresh');
			$('#category_id').val(category_id)
			$('#link2').val(link)
			if(link == null || !link){
				$(".category").show();
				$(".link").hide();

			}else{
				$(".link").show();
				$(".category").hide();
			}


			// if( country_id != '')
			// {
			// 	$.ajax({
			// 		url: "{{url('admin/mailing_list/json/cities')}}",
			// 		type: 'post',
			// 		data: {"_token":"{{ csrf_token() }}", country_id: country_id},
			// 		success: function(data)
			// 		{
			// 			select.empty();
			// 			select.selectpicker({title: "{{_i('Please Select City')}}"});
			// 			for (var i = 0; i < data.length; i++) {
			// 				select.append('<option value="' + data[i]['id'] + '">' + data[i]['title'] + '</option>');
			// 				select.val(city_id);
			// 				$('.selectpicker').selectpicker('refresh');
			// 			}
			// 		}
			// 	});
			// }
			// else
			// {
			// 	$('#edit-email-form .country').val(0);
			// 	$('.selectpicker').selectpicker('refresh');
			// }

			// url = $(this).attr('href');
		})



        $('body').on('click','#edit_list_btn',function (e) {
            var name = $(this).data('name');
            var order = $(this).data('order');

            var items = $(this).data('items');
            var id =$(this).data('id');
            var url='{{ url('admin/lists') }}/' + id

            $('#edit_list_form').selectpicker('refresh');
            $('#edit_list_form').find('input[name="name"]').val(name);
            $('#edit_list_form').find('select[name="order"]').val(order);
            $('#edit_list_form').find('select[name="items[]"]').val(items);
            $('.selectpicker').selectpicker('refresh')



            $('#edit_list_form').submit(function (e) {
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
        });





		$('#edit-email-form').submit(function (e) {
			e.preventDefault();
			console.log(url);
			var url ="{{ route('list_items.update') }}"
			//var form = $("#edit-email-form").serialize();
			var form =new FormData(document.getElementById('edit-email-form'));
			$.ajax({
				url: url,
				type: "post",
				data:form,
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
				var url = "{{ route('lists.store') }}";

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
