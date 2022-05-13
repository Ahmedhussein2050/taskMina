<div id="example2_wrapper"
     class="dataTables_wrapper form-inline dt-bootstrap text-center">
    <div class="row">
        <div class="col-sm-12">
            <table class="table table-bordered yajra-datatable" id="any2">
                <thead>
                <tr>
                    <th>{{ _i('User ID')}}</th>
                    <th>{{ _i('Fist Name')}}</th>
                    <th>{{ _i('Family Name')}}</th>
                    <th>{{ _i('Phone Number')}}</th>
                    <th>{{ _i('Email Address')}}</th>
                    <th>{{ _i('Activity Status')}}</th>
                    <th>{{ _i('Creation Time')}}</th>
                    <th>{{ _i('Last Edit')}}</th>
                    {{--                    <th></th>--}}
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

</div>
@push('js')
{{--    <link rel="stylesheet" href="{{ asset('admin_lte/bower_components/datatables.net/jquery.dataTables.min.css') }}">--}}
{{--    <script src="{{ asset('admin_lte/bower_components/datatables.net/js/jquery.dataTables.min.js') }}">--}}
{{--    </script>--}}
    <script>
        {{--$(function () {--}}
        {{--    CKEDITOR.editorConfig = function (config) {--}}
        {{--        config.baseFloatZIndex = 102000;--}}
        {{--        config.FloatingPanelsZIndex = 100005;--}}
        {{--    };--}}
        {{--    CKEDITOR.replace('editor1', {--}}
        {{--        extraPlugins: 'colorbutton,colordialog',--}}
        {{--        filebrowserUploadUrl: "{{asset('admin_/bower_components/ckeditor/ck_upload_master')}}",--}}
        {{--        filebrowserUploadMethod: 'form'--}}
        {{--    });--}}
        {{--});--}}
        $(document).ready(function () {
            let link = "{{ route('users.any') }}"
            let table = $('#any2').DataTable({
                processing: true,
                serverSide: true,
                columnDefs: [
                    {
                        className: "dt-head-center", targets: [ 0,1,2,3,4,5,6 ]
                    }
                ],
                ajax: {
                    url:link,
                    method: 'get'
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'first_name', name: 'first_name'},
                    {
                        data: 'last_name',
                        name: 'last_name',
                        searchable: true
                    },
                    {data: 'phone_number', name: 'phone_number'},
                    {data: 'email', name: 'email'},
                    {data: 'is_active', name: 'is_active'},

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

                ]
            });
        });
    </script>
@endpush