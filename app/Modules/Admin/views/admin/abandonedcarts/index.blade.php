@extends('admin.layout.index',[
	'title' => _i('Abandoned Carts'),
	'subtitle' => _i('Abandoned Carts'),
	'activePageName' => _i('Abandoned Carts'),
	'activePageUrl' => route('abandoned_carts.index'),
	'additionalPageUrl' => '' ,
	'additionalPageName' => '',
] )

@push('js')
	<script>
	$(document).ready(function(){
		$("#type-report").change(function(){
			$(this).find("option:selected").each(function(){
				var optionValue = $(this).attr("value");
				if(optionValue){
					$(".report").not("." + optionValue).hide();
					$("." + optionValue).show();
				} else{
					$(".report").hide();
				}
			});
		}).change();
	});
	</script>
@endpush
@section('content')
<div class="page-body">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{_i('Product prices report')}}</h5>
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
										<th> {{_i('User')}}</th>
										<th> {{_i('Products names')}}</th>
										<th> {{_i('Products count')}}</th>
										<th> {{_i('Total price')}}</th>
										<th> {{_i('Created at')}}</th>
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
			$('.dataTable').DataTable({
				order: [[0,'desc	']],
				processing: true,
				serverSide: true,
				ajax: '{{ route('abandoned_carts.index') }}',
				columns: [{
						data: 'id'
					},
					{
						data: 'user'
					},
					{
						data: 'products_names'
					},
					{
						data: 'products_count'
					},
					{
						data: 'total_price'
					},
					{
						data: 'created_at'
					},
				]
			});
		});
	</script>
@endpush
	@endsection
