@extends('admin.layout.index',[
	'title' => _i('Discount Promotors'),
	'subtitle' => _i('Promotors'),
	'activePageName' => _i('Promotors') ,
	'activePageUrl'  => route('discount.promotors.index',$id),
	'additionalPageName' => _i('Discount'),
	'additionalPageUrl' => route('discounts.index')
] )
@section('content')
<div class="flash-message">
	@foreach (['danger', 'warning', 'success', 'info'] as $msg)
	@if(Session::has($msg))
	<p class="alert alert-{{ $msg }}">{{ Session::get($msg) }}</p>
	@endif
	@endforeach
</div>

<div class="page-body">
	<div class="card blog-page" >
		<div class="card-block ">
			@include('admin.layout.message')
			<table class=" table table-bordered table-striped table-responsive  " id="order_data"
				width="100%">
				<thead>
					<tr role="row">
						<th>{{_i('User Code')}}</th>
						<th>{{_i('Member')}}</th>
						<th>{{_i('Code')}}</th>
						<th>{{_i('Using Time')}}</th>

						<th>{{_i('action')}}</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>
@push('js')
<script type="text/javascript">

	$(function () {
		var url ="{{route('discount.promotors.index',1)}}";
		var id ={{ $id }};
		 $('#order_data').DataTable({


			processing: true,
			serverSide: true,
			ajax: {
				url:url,
				data:{'id':id }
			},

			columns: [
				{data: 'user_code'},
				{data: 'members'},
				{data: 'code'},
				{data: 'using_time'},

				{
				data: 'action',
					orderable: false,
					searchable: false
				}
			],
			'drawCallback': function () {
			}
	    });
	});


	$('#order_data').on('click', '.btn-delete[data-url]', function(e) {
                e.preventDefault();
				//debugger;
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
                            text: "{{ _i('Promotor deleted Successfully') }}",
                            timeout: 2000,
                            killer: true
                        }).show();

                    },
                    error: function(response) {

                        new Noty({
                            type: 'error',
                            layout: 'topRight',
							text: '{{_i("Can not deleted refrenced data")}}',

                            timeout: 2000,
                            killer: true
                        }).show();

                    },
                }).always(function(data) {
                    $('#order_data').DataTable().draw(false);
             });
    });

</script>
@endpush
<style>
	.table {
	display: table !important;
	}
	.row {
	width: 100% !important;
	}
</style>
@endsection
