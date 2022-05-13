@extends('admin.layout.index',[
	'title' => _i('Products links'),
	'activePageName' => _i('Products links'),
	'activePageUrl' => '',
	'additionalPageUrl' => '' ,
	'additionalPageName' => '',
] )

@section('content')
<div style="clear:both;"></div>
<div class="box-body">
	<div class="row">
		<div class="col-sm-12">
			<!-- Zero config.table start -->
			<div class="card">
				<div class="card-header">
					<h5>{{_i('Products links')}}</h5>
					<div class="card-header-right">
						<i class="icofont icofont-rounded-down"></i>
					</div>
				</div>
				<div class="card-block">
					<div class="dt-responsive table-responsive text-center">
						<table id="dataTable" class="table table-bordered table-striped dataTable text-center">
							<thead>
								<tr role="row">
									<th class="sorting"> {{_i('Name')}}</th>
									<th class="sorting"> {{_i('Link')}}</th>
									<th class="sorting"> {{_i('Options')}}</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@push('js')
<script>
	$(function () {
		$('#dataTable').DataTable({
			order: [[0,'desc']],
			"pageLength": 50,
			processing: true,
			serverSide: true,
			ajax: '{{route('links.pages')}}',
			columns: [
				{data: 'title', name: 'title'},
				{data: 'link', name: 'link'},
				{data: 'options', name: 'options', orderable: true, searchable: true}
			]
		});
		$(document).on('click', '.copy', function(e){
			e.preventDefault();

			var dummy = document.createElement('input'),
			text = $(this).data('href');

			document.body.appendChild(dummy);
			dummy.value = text;
			dummy.select();
			document.execCommand('copy');
			document.body.removeChild(dummy);

			$(this).html('{{ _i('Copied') }}');
		})
	});
</script>
@endpush
