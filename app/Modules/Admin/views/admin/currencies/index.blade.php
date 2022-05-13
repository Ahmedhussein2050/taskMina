@extends('admin.layout.index',[
	'title' => _i('Currencies'),
	'subtitle' => _i('Currencies'),
	'activePageName' => _i('Currencies'),
	'activePageUrl' => route('currencies.index'),
	'additionalPageName' => '',
	'additionalPageUrl' => '' ,
] )

@section('content')

<div style="clear:both;"></div>
<div class="box-body">
	<div class="row">
		<div class="col-sm-12">
			<!-- Zero config.table start -->
			<div class="card">
				<div class="card-header">
					<h5>{{_i('Currencies')}}</h5>
					<div class="card-header-right">
						<i class="icofont icofont-rounded-down"></i>
					</div>
				</div>
				<div class="card-block">
					<div class="dt-responsive table-responsive text-center">
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_create">{{_i('Add New')}}</button>
						<table id="dataTable" class="table table-bordered table-striped dataTable text-center">
							<thead>
								<tr role="row">
									<th class="sorting"> {{_i('Code')}}</th>
									<th class="sorting"> {{_i('Exchange Rate')}}</th>
									<th class="sorting"> {{_i('Status')}}</th>
									<th class="sorting"> {{_i('Default')}}</th>
									<th class="sorting"> {{_i('Settings')}}</th>
								</tr>
							</thead>
						</table>
						@include('admin.currencies.create')
						@include('admin.currencies.edit')
						@include('admin.currencies.translate')
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
		var table = $('#dataTable').DataTable({
			processing: true,
			serverSide: true,
			ajax: '{{route('currencies.index')}}',
			columns: [
				{data: 'code', name: 'code'},
				{data: 'rate', name: 'rate'},
				{data: 'published', name: 'published'},
				{data: 'default', name: 'default'},
				{data: 'action', name: 'action'},
			]
		});
		if (typeof table !== 'undefined') {
			table.on('draw', function () {
				console.log('Redraw occurred at: ' + new Date().getTime());
				var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch-table'));
				elems.forEach(function (html) {
					var switchery = new Switchery(html, {
						size: 'small'
					});
				});
			});
		}
	});
	$(document).on('change', '.change-status', function(e){
		e.preventDefault();
		var id = $(this).data('id');
		$.ajax({
			url: "{{ route('currencies.activate') }}",
			method: "patch",
			data: {
				_token: '{{ csrf_token() }}',
				id: id
			},
			success: function (response) {
				if (response.data === true){
					new Noty({
						type: 'success',
						layout: 'topRight',
						text: "{{ _i('Updated Successfully !')}}",
						timeout: 2000,
						killer: true
					}).show();
					$('#dataTable').DataTable().draw(false);
				}
			}
		});
	});
	$(document).on('change', '.set-default', function(e){
		e.preventDefault();
		var id = $(this).data('id');
		$.ajax({
			url: "{{ route('currencies.set_default') }}",
			method: "patch",
			data: {
				_token: '{{ csrf_token() }}',
				id: id
			},
			success: function (response) {
				if (response.data === true){
					new Noty({
						type: 'success',
						layout: 'topRight',
						text: "{{ _i('Updated Successfully !')}}",
						timeout: 2000,
						killer: true
					}).show();
					$('#dataTable').DataTable().draw(false);
				}
			}
		});
	});
	$(document).on('keyup', '.change-rate', function(e){
		var id = $(this).data('id');
		var rate = $(this).val();
		$.ajax({
			url: "{{ route('currencies.change.rate') }}",
			method: "patch",
			data: {
				_token: '{{ csrf_token() }}',
				id: id,
				rate: rate
			},
			success: function (response) {
				if (response.data === true){
					new Noty({
						type: 'success',
						layout: 'topRight',
						text: "{{ _i('Updated Successfully !')}}",
						timeout: 2000,
						killer: true
					}).show();
				}
			}
		});
	});
	$(document).on('click', '.delete_currency', function (e) {
		var id = $(this).data('id');
		// console.log(id);
		$.ajax({
			url: "{{ route('currencies.delete') }}",
			method: "post",
			data: {
				_token: '{{ csrf_token() }}',
				id: id,
			},
			success: function (response) {
				if (response === 'SUCCESS'){
					new Noty({
						type: 'success',
						layout: 'topRight',
						text: "{{ _i('Deleted Successfully !')}}",
						timeout: 2000,
						killer: true
					}).show();
					$('#dataTable').DataTable().draw(false);
				}
			}
		})
	});

	$('body').on('click', '.lang_ex', function (e) {
		e.preventDefault();
		var transRowId = $(this).data('id');
		var lang_id = $(this).data('lang');
		var lang_title = $(this).data('lang-title');
		$('#id_data').val(transRowId);
		$('#lang_id_data').val(lang_id);
		// console.log(lang_id)
		$.ajax({
			url: '{{route('currencies.get.translation')}}',
			method: "get",
			"_token": "{{ csrf_token() }}",
			data: {
				'lang_id': lang_id,
				'transRow': transRowId,
			},
			success: function (response) {
				$('#langedit #header').text('Translate to : ' + lang_title);
				if (response.data == 'false'){
					$('#langedit #name').val('');
					$('#langedit #short_name').val('');
				} else{
					$('#langedit #name').val(response.data.name);
					$('#langedit #short_name').val(response.data.short_name);
				}
			}
		});

	});

	$('body').on('submit', '#lang_submit', function (e) {
		e.preventDefault();
		let url = $(this).attr('action');
		$.ajax({
			url: url,
			method: "post",
			"_token": "{{ csrf_token() }}",
			data: new FormData(this),
			dataType: 'json',
			cache             : false,
			contentType : false,
			processData : false,
			success: function (response) {
			if (response.errors){
				$('#masages_model').empty();
				$.each(response.errors, function(index, value) {
					$('#masages_model').show();
					$('#masages_model').append(value + "<br>");
				});
			}
			if (response == 'SUCCESS'){
				new Noty({
					type: 'success',
					layout: 'topRight',
					text: "{{ _i('Translated Successfully')}}",
					timeout: 2000,
					killer: true
				}).show();
				$('.modal').modal('hide');
				}
			},
		});
	});

</script>
@endpush
