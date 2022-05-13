
@extends('admin.layout.index',[
	'title' => _i('Discount Transaction'),
	'subtitle' =>  _i('Transaction'),
	'activePageName' => _i('Transaction') ,
	'activePageUrl'  => route('discount.transactions', $code),
	'additionalPageName' =>_i('Discounts'),
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

<div class="card">
	<h5 class="card-header">Discout Code Details</h5>
	<div class="card-body">

	  {{-- <h5 class="card-text"> Code : {{ $discout->code }}  Created By :{{ $user }}</h5> --}}
	  <div class="card-text"> {{ _i('Code') }} : {{  $code }} </div>
	  <div class="card-text"> {{ _i('Created By') }} :{{ $discount->creator->name }}<{{ $discount->creator->email }}></div>
	  <div class="card-text"> {{ _i('Type') }} :{{ $discount->type }}</div>
	  <div class="card-text"> {{ _i('Title') }} :{{ $discount->title }}</div>

	  <div class="card-text"> {{ _i('Created At') }} :{{ $discount->created_at }}</div>
	  <div class="card-text"> {{ _i('Start Date') }} :{{ $discount->start_date }}    {{ _i('End Date') }} :{{ $discount->end_date }}</div>
	  <div class="card-text"> {{ _i('Counter') }} :{{ $discount->using_times }}</div>
 	  <div class="card-text"> {{ _i('Discount') }} :{{($discount->calc_type == 'perc') ?  $discount->value .'%' : get_default_currency()->name }}</div>


	</div>
</div>

<div class="page-body">
	<div class="card blog-page" >
		<div class="card-block ">

			<table class=" table table-bordered table-striped table-responsive  " id="order_data"
				width="100%">
				<thead>
					<tr role="row">
						<th>{{_i('ID')}}</th>

						<th>{{_i('Transactions')}}</th>
						<th>{{_i('Member')}}</th>
						<th>{{_i('MemberShip')}}</th>

					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>
@push('js')
<script type="text/javascript">

	$(function () {
		var id ='{{ $code }}';
	//	 console.log(id);
		 var url ="{{route('discount.transactions',"id")}}";
		 url = url.replace('id', id);

 		 $('#order_data').DataTable({

			processing: true,
			serverSide: true,
			ajax: {
				 url:url,
				//  data:{'id':id },

			},

			columns: [
				{data: 'ID'},

				{data: 'transactions'},
				{data: 'members'},
				{data: 'membership'},

				// {
				// data: 'action',
				// 	orderable: false,
				// 	searchable: false
				// }
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
