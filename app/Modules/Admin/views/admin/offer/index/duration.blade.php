@extends('admin.layout.index',[
	'title' => _i('Duration '),
	'subtitle' => _i('Duration'),
	'activePageName' => _i('Duration') ,
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
						<th>{{_i('action')}}</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>
<div class="class card">
	<div class="form-group row">
		<div class="col-sm-2">
			{{ _i('Title') }}
		</div>
		<div class="col-sm-3">
			{{ _i('Description') }}
		</div>

		<div class="col-sm-2">

			{{ _i('From') }}

		</div>
		<div class="col-sm-2">

			{{ _i('To') }}

		</div>
		<div class="col-sm-2">

			{{ _i('Bonus') }}

		</div>
		<div class="col-sm-1"></div>

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
<script>

	$('#plusVou').click(function(event){
		event.preventDefault();

		$('#get_vou_data').append(
			`
			<div class="form-group row" >
				<div class="col-sm-2">

			<input class="form-control" type="text"  name="TitleitrNew[]"    >
			</div>
			<div class="col-sm-3">

			<input class="form-control" type="text"  name="descriptionNew[]"     >
			</div>

			<div class="col-sm-2">

			<input class="form-control" type="number" min="1"    name="minimumNew[]" >
			</div>
			<div class="col-sm-2">

			<input class="form-control" type="number" min="1" name="maximumNew[]"    >
			</div>
			<div class="col-sm-2">

			<input class="form-control" type="number"  min="1" name="bonusNew[]" >
			</div>
				<button type="button" style="height: 33px;width: 51px; " class=" remove-tr"><i class="ion-minus"></i></button>
			</div>

			`
		);
	})
	$(document).on('click', '.remove-tr', function(){
		$(this).parent('div').remove();
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
