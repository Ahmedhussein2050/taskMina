@extends('admin.layout.index',[
	'title' => _i('All Promotors'),
	'subtitle' => _i('All Promotors'),
	'activePageName' => _i('All Promotors'),
	'activePageUrl' => '',
	'additionalPageUrl' => route('promotors.index') ,
	'additionalPageName' => _i('Add'),
] )

@section('content')
	<div class="row page-body">


		<div class="col-sm-12">
			<a href="{{route('admin.promotor.create')}}" class="btn btn-primary  ">
				<i class="ti-plus"></i>{{_i('Create Promotor')}}
			</a>
			<div class="card">

				<div class="card-block">
					<div class="dt-responsive table-responsive  ">
						<table id="dataTable" class="table table-bordered table-striped dataTable ">
							<thead>
							<tr role="row">
								<th  > {{_i('ID')}}</th>
								<th  > {{_i('Name')}}</th>
								<th  > {{_i('Email')}}</th>
                                <th  > {{_i('Status')}}</th>
                                <th  > {{_i('Balance')}}</th>
{{--								<th  > {{_i('Membership_id')}}</th>--}}
								<th  > {{_i('Edit')}}</th>
								<th  > {{_i('Delete')}}</th>
							</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	@include('admin.promotor.edit');
@endsection
@push('js')
	<script  type="text/javascript">
		$(function() {
			$('#dataTable').DataTable({
				// order:[[0,'desc']],
				processing: true,
				serverSide: true,
				ajax: '{{ route('promotors.index') }}',
				columns: [
					{data: 'id', name: 'id'},
					{data: 'name', name: 'name'},
					{data: 'email', name: 'email'},
                    {data: 'status', name: 'status'},
                    {data: 'balance', name: 'balance'},
				    // {data: 'membership_id', name: 'membership_id'},
					{data: 'edit', name: 'edit', orderable: false, searchable: false},
					{data: 'delete', name: 'delete', orderable: false, searchable: false}
				]
			});
		});

            $('#dataTable').on('click', '.btn-delete[data-url]', function(e) {

                e.preventDefault();
                var url = $(this).data('url');
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        method: '_DELETE',
                        submit: true
                    },
                    success: function(response) {

                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: "{{ _i('Promoter deleted Successfully') }}",
                            timeout: 2000,
                            killer: true
                        }).show();

                    }
                }).always(function(data) {
                    $('#dataTable').DataTable().draw(false);
                });
            });


		$('body').on('click','.edit-btn1',function(e){
			e.preventDefault();

                userId = $(this).data('id');

                var name = $(this).data('name');
				var email = $(this).data('email');
				$('#name').val(name);
				$('#email').val(email);


		});
		$('body').on('submit', '#edit-form', function (e) {
			e.preventDefault();

			var url = "{{route('admin.promotors.update',"id")}}";
			url = url.replace('id', userId)
			$.ajax({
				url: url,
				method: "post",
				"_token": "{{ csrf_token() }}",
				data: new FormData(this),
				dataType: 'json',
				cache       : false,
				contentType : false,
				processData : false,
				dataType: 'json',

				success: function (response) {
					$('#edit-modal').modal('hide');
					$('#datatable').DataTable().draw(false);
					new Noty({
						type: 'success',
						layout: 'topRight',
						text: "{{_i('Promotor Updated Successfully')}}",
						timeout: 2000,
						killer: true
					}).show();
				},

			}).always(function(data) {
                    $('#dataTable').DataTable().draw(false);
                });
		});


		function changeStatus(obj){

			userId = $(obj).data('id');
            var status = $(obj ,'.statusChang option:selected').val();

			//alert(status);
			var url = "{{route('admin.promotors.updateStatus',"id")}}";
			url = url.replace('id', userId)
			$.ajax({
				url: url,
				method: "post",
				 data:{  "_token": "{{ csrf_token() }}",
                         "select": status
					},
				dataType: 'json',

				success: function (response) {

					$('#datatable').DataTable().draw(false);
					new Noty({
						type: 'success',
						layout: 'topRight',
						text: "{{_i('Status Updated Successfully')}}",
						timeout: 2000,
						killer: true
					}).show();
				},

			}).always(function(data) {
                    $('#dataTable').DataTable().draw(false);
                });

		}
	</script>
@endpush
