@extends('site.admin.layout.app',[
	'title' => _i('Admins'),
	'level1' => _i('Admins'),
	'level1_url' => route('site.admin.admins'),
	'level2' => _i('Admins'),
	'level2_url' => route('site.admin.admins'),
])
@section('content')

    <div class="row">
        <div class="col-sm-12 ">
           <span class="pull-left">
               <a href="{{ route('site.admin.admins.create') }}" class="btn btn-primary create add-permission mb-1">
				   <i class="ti-plus"></i>
				   {{_i('Create new admin')}}
               </a>
           </span>
        </div>

        <div class="col-sm-12">
            <!-- Zero config.table start -->
            <div class="card">
                <div class="card-header">
                    <h5>{{_i('Admins')}}</h5>
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
									<th>{{_i('Image')}}</th>
									<th>{{_i('Email')}}</th>
									<th>{{_i('Created At')}}</th>
									<th>{{_i('Options')}}</th>
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
    <script>
        $(function() {
            var table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('site.admin.admins') }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'image', name: 'image'},
                    {data: 'email', name: 'email'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'options', name: 'options', orderable: false, searchable: false}
                ]
			});

			$('#dataTable').on('click', '.btn-delete[data-url]', function (e) {
				e.preventDefault();
				var url = $(this).data('url');
				$.ajax({
					url: url,
					type: 'DELETE',
					dataType: 'json',
					data: {method: '_DELETE', submit: true}
				}).always(function (data) {
					$('#dataTable').DataTable().draw(false);
				});
			});
        });
    </script>
@endpush
