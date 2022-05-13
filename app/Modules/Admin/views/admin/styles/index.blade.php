@extends('admin.layout.index',[
'title' => _i('Store Style'),
'subtitle' => _i('Store Style'),
'activePageName' => _i('Store Style'),
'activePageUrl' => '',
] )
@section('header')

@endsection
@section('content')
    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <a href="{{ route('admin.style.create') }}" class='btn btn-primary mb-2'>
                    {{ _i('Create New Style') }}
                </a>
                <div class="card">
                    <div class="card-header">
                        <h5> {{ _i('Styles') }}</h5>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive dt-responsive">
                            <table id="datatable" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ _i('Name') }}</th>
                                        <th>{{ _i('Start Date') }}</th>
                                        <th>{{ _i('End Date') }}</th>
                                        <th>{{ _i('Enable') }}</th>
                                        <th>{{ _i('Options') }}</th>

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
        $(document).ready(function() {
            $('#datatable').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                "paging": false,
                ajax: {
                    url: "{{ route('admin.style.index') }}",
                    type: "GET"
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'start_date'
                    },
                    {
                        data: 'end_date'
                    },
                    {
                        data: function(data, row) {
                            if (data.active == 1) {
                                return '<input class="form-control enable " data-id="' + data.id +
                                    '" data-active="' + data.active +
                                    '" type="checkbox" value="' + data.active +
                                    '"  checked  >  ';
                            } else {
                                return '<input class="form-control enable " data-id="' + data.id +
                                    '" data-active="' + data.active +
                                    '" type="checkbox" value="' + data.active + '"     >  ';
                            }
                        }
                    },

                    {
                        data: function(data, type, row) {
                            return '<button class="btn btn-info open-modal edit " data-id="' + data
                                .id +
                                '">Edit</button><button  class="btn btn-danger destroy" data-id="' +
                                data.id + '">Delete</button>';
                        }
                    }

                ]
            });

            $('body').on('change', '.enable', function() {
                var active = $(this).data('active');
                var id = $(this).data('id');
                console.log(active)

                $.ajax({
                    url: "{{ route('admin.style.active') }}",
                    type: "POST",
                    data: {
                        active: active,
                        id: id,
                    },
                    dataType: 'json',
                    success: function(result) {

                        if (result == 'success') {
                            new Noty({
                                type: 'success',
                                text: '{{ _i('Updated Successfully') }}',
                                timeout: 2000,
                                killer: true
                            }).show();
                        }
                        var oTable = $('#datatable').dataTable();
                        oTable.fnDraw(false);
                    }
                });


            });
            $('body').on('click', '.destroy', function() {

                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('admin.style.destroy') }}",
                    type: "POST",
                    data: {

                        id: id,
                    },
                    dataType: 'json',
                    success: function(result) {

                        if (result == 'success') {
                            new Noty({
                                type: 'error',
                                text: '{{ _i('Deleted Successfully') }}',
                                timeout: 2000,
                                killer: true
                            }).show();
                        }
                        var oTable = $('#datatable').dataTable();
                        oTable.fnDraw(false);
                    }
                });


            });
            $('body').on('click', '.edit', function() {
                var id = $(this).data('id');
                var url = "{{ route('admin.style.edit', '/id') }}"
                url = url.replace('/id', id)
                window.location.href = url;

            });
        })
    </script>

@endpush
