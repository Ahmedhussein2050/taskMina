@extends('admin.layout.index',[
	'title' => _i('Categories'),
	'subtitle' => _i('Categories'),
	'activePageName' => _i('Categories'),
	'activePageUrl' => route('categories.index'),
	'additionalPageName' => '',
	'additionalPageUrl' => '' ,
] )

@push('css')
	<link rel="stylesheet" href="{{asset('css/custom.css')}}">
@endpush
@section('content')
	<!-- Page-body start -->
	<div class="page-body">
		<!-- Blog-card start -->
		<div class="card blog-page" id="blog">
			<div class="card-block">
				@include("admin.categories.categories")
				@include("admin.categories.translate")
			</div>
		</div>
@endsection
@push('js')
<script>
	$('body').on('click', '.lang_ex', function (e) {
		e.preventDefault();
		var transRowId = $(this).data('id');
		var lang_id = $(this).data('lang');
		$.ajax({
			url: '{{route('categories.get.translation')}}',
			method: "get",
			"_token": "{{ csrf_token() }}",
			data: {
				'lang_id': lang_id,
				'transRow': transRowId,
			},
			success: function (response) {
				if (response.data == 'false'){
					$('#langedit #title').val('');
					$('#langedit #description').val('');
					$('#langedit #keywords').val('');
				} else{
					$('#langedit #title').val(response.data.title);
					$('#langedit #description').val(response.data.description);
					$('#langedit #keywords').val(response.data.keywords);
				}
			}
		});
		$.ajax({
			url: '{{route('admin.get.lang')}}',
			method: "get",
			data: {
				lang_id: lang_id,
			},
			success: function (response) {
				$('#header').empty();
				$('#langedit #header').text('Translate to : ' + response);
				$('#id_data').val(transRowId);
				$('#lang_id_data').val(lang_id);
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
			cache       : false,
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
					window.reload();
				}
			},
		});
	});
</script>
@endpush