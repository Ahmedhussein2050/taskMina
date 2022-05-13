@extends('admin.layout.index',[
	'title' => _i('Voucher '),
	'subtitle' => _i('Voucher'),
	'activePageName' => _i('Voucher') ,
	'activePageUrl'  => route('admin.getUsers',$id),
	'additionalPageName' => _i('Settings'),
	'additionalPageUrl' => route('settings.index')
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
			<table class=" table table-bordered table-striped table-responsive text-center" id="order_data"
				width="100%">
 				<thead>
					<tr role="row">

						<th>{{_i('Code')}}</th>
						<th>{{_i('Using Time')}}</th>
						<th>{{_i('Title')}}</th>
						<th>{{_i('Description')}}</th>
						<th>{{_i( 'From')}}</th>
						<th>{{_i('To')}}</th>
						<th>{{_i('Bonus')}}</th>

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
		var url ="{{route('admin.getUsers',1)}}";
		var id ={{ $id }};
		 $('#order_data').DataTable({


			processing: true,
			serverSide: true,
			ajax: {
				url:url,
				data:{'id':id }
			},

			columns: [

				{data: 'code'},
				{data: 'using_time'},
				{data: 'title'},
				{data: 'description'},
				{data: 'max_amount'},
				{data: 'min_amount'},
				{data: 'bonus'},
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
