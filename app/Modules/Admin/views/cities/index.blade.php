@extends('admin.layout.index',
[
	'title' => _i('Cities'),
	'subtitle' => _i('Cities'),
	'activePageName' => _i('Cities'),
	'activePageUrl' => route('cities.index'),
	'additionalPageName' => '',
	'additionalPageUrl' => route('settings.index') ,
])
@section('content')
        <a href class="text-decoration-none btn btn-primary" data-toggle="modal" data-target="#modal_create">{{_i('Add City')}}</a>
    @include('cities.table')
    @include('cities.create')
    @include('cities.edit')

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
                        filebrowserUploadUrl: "{{asset('admin_dashboard/bower_components/ckeditor/ck_upload_master')}}",
                        filebrowserUploadMethod: 'form'
                    });
                });
                $(document).ready(function () {

                });
            </script>
    @endpush
