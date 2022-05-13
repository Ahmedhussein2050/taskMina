@extends('admin.layout.index',
[
	'title' => _i('Chat Settings'),
	'subtitle' => _i('Chat Settings'),
	'activePageName' => _i('Chat Settings'),
	'activePageUrl' => route('chat_settings.index'),
	'additionalPageName' => _i('Settings'),
	'additionalPageUrl' => route('settings.index') ,
])
@section('content')
<div class="card">
	<div class="card-header">
		<h5>{{ _i('Chat Settings') }}</h5>
	</div>
	<div class="card-block">
		<div class="row">
			<div class="col-sm-12 col-xl-12 m-b-10">
				<form action="{{ route('chat_settings.update', 1) }}" method="post" id="form_store">
					@csrf
					@method('PATCH')
					<div class="row form-group">
						<label class="col-md-4" for="maintenance"> {{ _i('Chat Mode') }}</label>
						<div class="col-md-8">
							<input type="checkbox" form="form_store_maintenance" class="js-single" id="maintenance"
							name="maintenance"
							@if($settings->maintenance == 1) checked=""
							@endif data-switchery="true"
							style="display: none;">
						</div>
					</div>
					<div class="row form-group">
						<label class="col-md-4" for="chat_code"> {{ _i('Chat Code') }}</label>
						<div class="col-md-8">
							<textarea form="form_store" class="form-control"
								name="chat_code"
								id="chat_code"
								placeholder="{{ _i('Chat Plugin Code') }}">{{ ($settings->chat_code != null) ? $settings->chat_code : '' }}</textarea>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-md-12 d-flex justify-content-center">
							<button type="submit" form="form_store"
								class="btn btn-primary m-b-0">{{ _i('Submit') }}</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
@push('js')
<script type="text/javascript">
	$('body').on('submit', '#form_store', function (e) {
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
			error: function (response) {
				if (response.responseJSON.errors){
					$.each(response.responseJSON.errors, function(index, value) {
						new Noty({
							type: 'error',
							layout: 'topRight',
							text: value,
							timeout: 4000,
						}).show();
					});
				}
			},
			success: function (response) {
				if (response == 'SUCCESS'){
					new Noty({
						type: 'success',
						layout: 'topRight',
						text: "{{ _i('Updated Successfully !')}}",
						timeout: 2000,
						killer: true
					}).show();
				}
			},
		});
	});
</script>
@endpush