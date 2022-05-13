@extends('admin.layout.index',
[
'title' => _i('Sections'),
'subtitle' => _i('Sections'),
'activePageName' => _i('Sections'),
'activePageUrl' => route('section.index', 'categories_sections'),
'additionalPageName' => _i('Settings'),
'additionalPageUrl' => route('settings.index')
])
@section('content')
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12 mb-3">
                <span class="pull-left">
                     
					<a href="{{ url('admin/settings/section/create/categories') }}">
						<input type="button" class="btn btn-primary" value="{{ _i('Create New Section') }}" />
					 </a>
                </span>
            </div>
            <div class="col-sm-12">
                <!-- Zero config.table start -->
                <div class="card">
                    <div class="card-header">
                        <h5>{{ _i('Sections') }}</h5>
                        <div class="card-header-right">
                            <i class="icofont icofont-rounded-down"></i>
                            <i class="icofont icofont-refresh"></i>
                            <i class="icofont icofont-close-circled"></i>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="dt-responsive table-responsive text-center">
                            <table id="slider_table" class="table table-bordered table-striped dataTable text-center">
                                <thead>
                                    <tr role="row">
                                        <th class="text-center"> {{ _i('ID') }}</th>
                                        <th class="text-center"> {{ _i('Title') }}</th>
                                        <th class="text-center"> {{ _i('Type') }}</th>
                                        <th class="text-center"> {{ _i('Status') }}</th>
                                        <th class="text-center"> {{ _i('Display order') }}</th>
                                        <th class="text-center"> {{ _i('Total Products') }}</th>
                                        <th class="text-center"> {{ _i('Create Time') }}</th>
                                        <th class="text-center"> {{ _i('Category Master') }}</th>
                                        <th class="text-center"> {{ _i('Controll') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.settings.sections.trans')
@endsection
@push('js')
    <script type="text/javascript">
        var table;
        $('body').on('change', '.type', function(e) {
            var _val = $(this).val();
            $('.products').hide();
            $('.image_video').hide();
            $('.banner').hide();
            $('.banner2').hide();
            $('.banner3').hide();
            $('.services').hide();
            $(".success_Products").hide();
            $('.success_partners').hide();

            if (_val == 'image_video') {
                $('.image_video').removeAttr('hidden').show();
                // $('.banner').removeAttr('hidden').show();

            } else if (_val == 'banner') {
                $('.banner').removeAttr('hidden').show();
				$("#select_banner2").val('0').selectpicker('refresh');
				$("#select_banner3").val('0').selectpicker('refresh');

            }else if (_val == 'banner2') {
                $('.banner').removeAttr('hidden').show();
                $('.banner2').removeAttr('hidden').show();
				$("#select_banner3").val('0').selectpicker('refresh');

			}else if (_val == 'banner3') {
			$('.banner').removeAttr('hidden').show();
			$('.banner2').removeAttr('hidden').show();
			$('.banner3').removeAttr('hidden').show();


            } else if (_val == 'services') {
                $('.services').removeAttr('hidden').show();

            } else if (_val == 'success_partners') {
                $('.success_partners').removeAttr('hidden').show();

            } else if (_val == 'random_products') {
                $('.success_Products').removeAttr('hidden').show();

            } else {
                $('.products').removeAttr('hidden').show();

            }
        })
        $(function() {
            table = $('#slider_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url('admin/settings/section/categories_sections') }}',
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'title'
                    },
                    {
                        data: 'type'
                    },
                    {
                        data: 'published'
                    },
                    {
                        data: 'display_order'
                    },
                    {
                        data: 'total'
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'master'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    }
                ]
            });
        });

        $('body').on('click', '.lang_ex', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var lang_id = $(this).data('lang');
            $.ajax({
                url: '{{ url('admin/settings/sections/get/lang/value') }}',
                method: "get",
                data: {
                    lang_id: lang_id,
                    id: id,
                },
                success: function(response) {
                    if (response.data == 'false') {
                        $('#langedit #titletrans').val('');
                        $('#langedit #desctrans').val('');
                    } else {
                        $('#langedit #titletrans').val(response.data.title);
                        $('#langedit #desctrans').val(response.data.description);
                    }
                }
            });
            $.ajax({
                url: "{{ url('admin/get/lang') }}",
                method: "get",
                data: {
                    {{-- _token: '{{ csrf_token() }}', --}}
                    lang_id: lang_id,
                },
                success: function(response) {
                    $('#langedit #header').empty();
                    $('#langedit #header').text('Translate to : ' + response);

                    $('#id_data').val(id);
                    $('#lang_id_data').val(lang_id);
                }
            });
        });
        $('body').on('submit', '#lang_submit', function(e) {
            e.preventDefault();
            let url = $(this).attr('action');
            $.ajax({
                url: url,
                method: "post",
                data: new FormData(this),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    if (response.errors) {
                        $('#masages_model').empty();
                        $.each(response.errors, function(index, value) {
                            $('#masages_model').show();
                            $('#masages_model').append(value + "<br>");
                        });
                    }
                    if (response == 'SUCCESS') {
                        new Noty({
                            type: 'warning',
                            layout: 'topRight',
                            text: "{{ _i('Translated Successfully') }}",
                            timeout: 2000,
                            killer: true
                        }).show();
                        $('.modal.modal_trans').modal('hide');
                        table.ajax.reload();
                    }
                },
            });
        });
        $('body').on('submit', '#delform', function(e) {
            e.preventDefault();
            var url = $(this).attr('action');
            // alert(url);
            $.ajax({
                url: url,
                method: "delete",
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.data === true) {
                        new Noty({
                            type: 'error',
                            layout: 'topRight',
                            text: "{{ _i('Deleted Successfully') }}",
                            timeout: 2000,
                            killer: true
                        }).show();
                        table.ajax.reload();
                    }
                }
            });
        })
    </script>
@endpush
