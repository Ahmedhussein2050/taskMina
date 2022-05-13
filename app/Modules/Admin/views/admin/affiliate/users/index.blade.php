@extends('admin.layout.index',[
'title' => _i('Affiliate Users'),
'subtitle' => _i('Affiliate Users'),
'activePageName' => _i('Affiliate Users'),
'activePageUrl' => '',
'additionalPageUrl' => '' ,
'additionalPageName' => '',
] )

@section('content')
    <div class="row">
        <div class="col-sm-12 ">
           <span class="pull-left">
               <a href="{{ route('affiliate_users.create') }}"  class="btn btn-primary create add-permission">
                   <i class="ti-plus"></i>{{_i('create new user')}}
               </a>
           </span>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{_i('All Admins')}}</h5>
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
                                <th  > {{_i('ID')}}</th>
                                <th  > {{_i('Name')}}</th>
                                <th  > {{_i('Image')}}</th>
                                <th  > {{_i('Email')}}</th>
                                <th  > {{_i('Created At')}}</th>
                                <th  > {{_i('Actions')}}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        $(function() {
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('affiliate_users.index') }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'image', name: 'image'},
                    {data: 'email', name: 'email'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false},
                ]
            });
        });
    </script>
@endpush