<div style="clear:both;"></div>
<div class="box-body">
    <div class="row">
        <div class="col-sm-12">
            <!-- Zero config.table start -->
            <div class="card">
                <div class="card-header">
                    <h5>{{_i('All Cities')}}</h5>
                    <div class="card-header-right">
                        <i class="icofont icofont-rounded-down"></i>
                    </div>
                </div>
                <div class="card-block">
                    <div class="dt-responsive table-responsive text-center">
                        <table id="dataTable" class="table table-bordered table-striped dataTable text-center">
                            <thead>
                            <tr role="row">
                                <th>{{ _i('City ID')}}</th>
                                <th>{{ _i('Lat')}}</th>
                                <th>{{ _i('Lng')}}</th>
                                <th>{{ _i('City Name')}}</th>
                                <th>{{ _i('Creation Time')}}</th>
                                <th>{{ _i('Last Edit')}}</th>
                                <th>{{ _i('Action')}}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('css')
    <style>
        .modal_create  {
            margin: 2px auto;
            z-index: 1100 !important;
        }
    </style>
@endpush
@push('js')
    <!-- DataTable Styles -->
    <script>
        $(function () {
            CKEDITOR.editorConfig = function (config) {
                config.baseFloatZIndex = 102000;
                config.FloatingPanelsZIndex = 100005;
            };
            CKEDITOR.replace('editor1', {
                extraPlugins: 'colorbutton,colordialog',
                filebrowserUploadUrl: "{{asset('admin_dashboard/bower_components/ckeditor/ck_upload_master')}}",
                filebrowserUploadMethod: 'form'
            });
        });
        $(document).ready(function () {

            table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                stateSave: true,
                ajax: '{{route('cities.index')}}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'lat', name: 'lat'},
                    {data: 'lng', name: 'lng'},

                    {data: 'name', name: 'name'},

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
                        data: 'action',
                        name: 'action',
                        searchable: false
                    },

                ]
            });


            $(document).on('click', '.delete-btn', function (e) {
                e.preventDefault();
                let id = $(this).data('id');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{csrf_token()}}"
                        }
                })
                $.ajax({
                    url: "{{route('cities.destroy')}}",
                    method: 'post',
                    data: {
                        'id': id,
                        '_token': "{{csrf_token()}}"
                    },
                    success: function (response) {
                        if (response === 'SUCCESS') {
                            new Noty({
                                type: 'error',
                                layout: 'topRight',
                                text: "{{ _i('Deleted Successfully')}}",
                                timeout: 2000,
                                killer: true
                            }).show();
                            table.ajax.reload(null, false);
                        }else {
                            new Noty({
                                type: 'warning',
                                layout: 'topRight',
                                text: "{{ _i('An error Occurred, please try again')}}",
                                timeout: 2000,
                                killer: true
                            }).show();
                        }
                    }
                })
            });
        });
    </script>
@endpush
