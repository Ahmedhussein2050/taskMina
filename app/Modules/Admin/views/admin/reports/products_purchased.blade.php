@extends('admin.layout.index',[
	'title' => _i('Reports'),
	'subtitle' => _i('Reports'),
	'activePageName' => _i('Reports'),
	'activePageUrl' => route('reports.index'),
	'additionalPageUrl' => '' ,
	'additionalPageName' => '',
] )
@section('content')
<div class="page-body">
	<div class="box-body">
		<div class="row mb-3">
			<div class="col-md-3">
				<select name="filter" class='form-control custom-select reload-datatable filter'>
					<option value=0>{{ _i('Filter') }}</option>
					<option value="best_selling" data-type='filter' data-value='best'>{{ _i('Best selling') }}</option>
					<option value="less_selling" data-type='filter' data-value='less'>{{ _i('Less selling') }}</option>
				</select>
			</div>
			<div class="col-md-3">
				<select name="category" class='form-control custom-select reload-datatable category'>
					<option value=0>{{ _i('Category') }}</option>
					@foreach( $categories as $category )
					<option value="{{ $category->category_id }}">{{ $category->title }}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-header">
						<h5>{{_i('Products purchased')}}</h5>
						<div class="card-header-right">
							<i class="icofont icofont-rounded-down"></i>
							<i class="icofont icofont-refresh"></i>
							<i class="icofont icofont-close-circled"></i>
						</div>
					</div>
					<div class="card-block">
						<div class="dt-responsive table-responsive">
							<table id="slider_table" class="table table-bordered table-striped dataTable">
								<thead>
									<tr role="row">
										<th> {{_i('ID')}}</th>
										<th> {{_i('Title')}}</th>
										<th> {{_i('Type')}}</th>
										<th> {{_i('Purchased count')}}</th>
										<th> {{_i('Sales total')}}</th>
										<th> {{_i('Details')}}</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	@push('js')
		<script type="text/javascript">
		$(function () {
			var table = $('.dataTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: '{{ route('reports.products.purchased') }}',
				columns: [
					{data: 'id'},
					{data: 'title'},
					{data: 'type'},
					{data: 'purchased_count'},
					{data: 'sales_total'},
					{data: 'details'},
				],
				"order": []
			});
			$('.reload-datatable').change(function(){
				var filter = $('.filter').find('option:selected').val();
				var category = $('.category').find('option:selected').val();
				console.log(filter, category);
				table.ajax.url( '{{ route('reports.products.purchased') }}?filter=' + filter + '&category=' + category ).load();
			})
		});
		</script>
	@endpush
	@endsection
