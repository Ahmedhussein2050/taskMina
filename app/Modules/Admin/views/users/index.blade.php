@extends('admin.layout.index',[
	'title' => _i('All Users'),
		'subtitle' => _i('All Users'),
'activePageName' => _i('All Users'),
	'activePageUrl' => '',
] )

@section('content')
    <div style="clear:both;"></div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <!-- Zero config.table start -->
                <div class="card">
                    <div class="card-header">
                        <h5>{{_i('All Users')}}</h5>
                        <div class="card-header-right">
                            <i class="icofont icofont-rounded-down"></i>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="dt-responsive table-responsive text-center">
                            <table id="dataTable" class="table table-bordered table-striped dataTable text-center">
                                <thead>
                                <tr role="row">
                                    <th>{{ _i('User ID')}}</th>
                                    <th>{{ _i('Fist Name')}}</th>
                                    <th>{{ _i('Family Name')}}</th>
                                    <th>{{ _i('Phone Number')}}</th>
                                    <th>{{ _i('Email Address')}}</th>
                                    <th>{{ _i('Activity Status')}}</th>
                                    <th>{{ _i('Creation Time')}}</th>
                                    <th>{{ _i('Last Edit')}}</th>
                                    <th>{{ _i('Change Activity')}}</th>
                                    <th>{{ _i('Edit Password')}}</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade modal_create" id="modal_edit_userPass" aria-hidden="true">
            <div class="modal-dialog" style="top: 10% !important;" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <b class="model_edit_title">{{_i('edit password')}}</b>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span style="cursor: pointer" aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="edit_user_pass" method="post" action="{{route('users.password')}}">
                        @csrf
                        <!-- Title -->
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">{{_i('Password')}}</label>
                                <input id="user_id" type="hidden" name="id">
                                <input type="password" name="password"
                                       style=" @error('password') border-color:red; @enderror" class="form-control"
                                       id="exampleInputPassword1">
                                @error('password')
                                <div class="text-danger mt-2">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword" class="form-label">{{_i('Repeat Password')}}</label>
                                <input type="password" name="password_confirmation"
                                       style=" @error('password_confirmation') border-color:red; @enderror"
                                       class="form-control" id="exampleInputPassword">
                                @error('password_confirmation')
                                <div class="text-danger mt-2">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" form="edit_user_pass"
                                class="btn btn-primary ml-1 createBtn">{{ _i('save') }}</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">{{ _i('close') }}</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @push('css')
    @endpush
@endsection
@push('js')
    <script>
        $(function () {
            CKEDITOR.editorConfig = function (config) {
                config.baseFloatZIndex = 102000;
                config.FloatingPanelsZIndex = 100005;
            };
            CKEDITOR.replace('editor1', {
                extraPlugins: 'colorbutton,colordialog',
                filebrowserUploadUrl: "{{asset('admin_/bower_components/ckeditor/ck_upload_master')}}",
                filebrowserUploadMethod: 'form'
            });
        });
        $(document).ready(function () {
            table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{route('users.any')}}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {
                        data: 'lastname',
                        name: 'lastname',
                        searchable: true
                    },
                    {data: 'phone', name: 'phone'},
                    {data: 'email', name: 'email'},

                    {
                        data: function (o) {
                            if (o.is_active === 1) {
                                return 'active'
                            } else {
                                return 'deactivated'
                            }
                        }
                    },

                    {
                        data: 'created_at',
                        name: 'created_at',
                        searchable: false
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at',
                        searchable: false
                    },
                    {
                        data: 'active',
                        name: 'active',
                        searchable: false
                    },
                    {
                        data: 'edit',
                        name: 'edit',
                        searchable: false
                    },

                ]
            });
            $(document).on('click', '.change-active', function (event) {
                event.preventDefault();
                let id = $(this).data('id')
                let link = '{{route('users.activity')}}'
                $.ajax({
                    url: link,
                    method: 'post',
                    data: {
                        "id": id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function (res) {
                        if (res) {
                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: "{{ _i('Activity Status has been changed successfully')}}",
                                timeout: 2000,
                                killer: true
                            }).show();
                            table.ajax.reload();
                        }
                    }
                })
            })
            $(document).on('click', '#edit_user', function (e) {
                e.preventDefault();
                let id = $(this).data('id');
                $('#user_id').val(id)
            })
            $(document).on('submit', '#edit_user_pass', function (event) {
                let url = $(this).attr('action')
                event.preventDefault();
                $.ajax({
                    url: url,
                    method: "post",
                    data: new FormData(this),
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (res) {
                        if (res === 'success') {
                            $('.modal.modal_create').modal('hide');
                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: "{{ _i('Updated Successfully')}}",
                                timeout: 2000,
                                killer: true
                            }).show();
                            table.ajax.reload(null, false);
                            document.getElementById('edit_user_pass').reset();
                            $("#edit_user_pass").parsley().reset();
                        } else {
                            new Noty({
                                type: 'warning',
                                layout: 'topRight',
                                text: "{{ _i('An Error Occurred, please try again')}}",
                                timeout: 2000,
                                killer: true
                            }).show();
                        }
                    }
                })
            })
        });
    </script>
@endpush
