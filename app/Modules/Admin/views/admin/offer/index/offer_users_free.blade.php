@extends('admin.layout.index',[
	'title' => _i('Members'),
	'subtitle' => _i('Members'),
	'activePageName' => _i('Members') ,
	'activePageUrl'  => route('admin.getUserFree',$id),
	'additionalPageName' => _i('Offers'),
	'additionalPageUrl' => route('admin.offer.index')
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
		var url ="{{route('admin.getUserFree',1)}}";
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
