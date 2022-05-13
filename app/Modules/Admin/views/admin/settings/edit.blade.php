@extends('admin.layout.index',
[
	'title' => _i('Settings'),
	'subtitle' => _i('Settings'),
	'activePageName' => _i('Settings'),
	'activePageUrl' => route('settings.edit'),
	'additionalPageName' => _i('Settings'),
	'additionalPageUrl' => route('settings.index') ,
])

@section('content')

<form action="{{route('settings.update')}}" method="post" class="form-horizontal" id="fileupload" enctype="multipart/form-data" data-parsley-validate="">
	@csrf
	@method('PATCH')
	<div class="row">
		<div class="card col-md-12">
			<div class="card-header">
				<h5>{{ _i('Main Settings') }}</h5>
				<div class="btn-group">
					 <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"  title="{{ _i('Translation') }}">
						{{ _i('Translation') }}
					</button>
					<ul class="dropdown-menu" style="right: auto; left: 0; width: 5em; " >
					@foreach ($languages as $lang)
						<li ><a href="#" data-toggle="modal" data-target="#langedit" class="lang_ex" data-id="1" data-lang="{{ $lang->id }}" style="display: block; padding: 5px 10px 10px;">{{ $lang->title }}</a></li>
					@endforeach
					</ul>
				 </div>
			</div>
			<div class="card-block">
				<img class="img-fluid img-circle" onclick="document.getElementById('image').click()" src="{{ asset(  \App\Bll\Utility::get_main_settings()->logo ) }}" style="width:100px;height:100px;margin: 19px 423px;">
				<input onchange="document.getElementById('fileupload').submit()" style="display: none;"  id="image" type="file" name="logo">
				<div class="form-group row">
					<label class="col-sm-2 col-form-label " for="title">
						{{_i('Site Name')}} </label>
					<div class="col-sm-6">
						<input name="title" value="{{ $site_settings->title }}" id="title" class="form-control" placeholder="{{_i('Site Name')}}" type="text" data-parsley-type="text" disabled>
					</div>
				</div>

                <div class="form-group row">
					<label class="col-sm-2 col-form-label " for="title">
						{{_i('Site Address')}} </label>
					<div class="col-sm-6">
						<input name="address" value="{{ $site_settings->address }}" id="address" class="form-control" placeholder="{{_i('Site Address')}}" type="text" data-parsley-type="text" disabled>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label " for="worktime">
						{{_i('Site Worktime')}} </label>
					<div class="col-sm-6">
						<input name="work_time" value="{{ $site_settings->work_time }}" id="work_time" class="form-control" placeholder="{{_i('Site Worktime')}}" type="text" data-parsley-type="text">
						@if ($errors->has('work_time'))
						<span class="text-danger invalid-feedback">
							<strong>{{ $errors->first('work_time') }}</strong>
						</span>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="card col-md-12">
			<div class="card-header"><h5>{{ _i('technical support') }}</h5></div>
			<div class="card-block">
				<!-- Custom Tabs -->
				<div class="form-group row">
					<label class="col-sm-2 col-form-label " for="phone1">
						{{_i('phone 1')}} </label>
					<div class="col-sm-6">
						<input name="phone1" value="{{ $site_settings->phone1 }}" id="phone1" class="form-control"
							placeholder="{{_i('phone 1')}}" type="text"
							data-parsley-type="text">
						@if ($errors->has('phone1'))
						<span class="text-danger invalid-feedback">
							<strong>{{ $errors->first('phone1') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label " for="phone2">
						{{_i('Phone 2')}} </label>
					<div class="col-sm-6">
						<input name="phone2" value="{{ $site_settings->phone2 }}" id="phone2" class="form-control"
							placeholder="{{_i('Phone 2')}}" type="text"
							data-parsley-type="text">
						@if ($errors->has('phone2'))
						<span class="text-danger invalid-feedback">
							<strong>{{ $errors->first('phone2') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label " for="phone2">
						{{_i('WhatsApp')}} </label>
					<div class="col-sm-6">
						<input name="whats_app" value="{{ $site_settings->whats_app }}" id="whats_app" class="form-control"
							placeholder="{{_i('WhatsApp')}}" type="text"
							data-parsley-type="text">
						@if ($errors->has('whats_app'))
						<span class="text-danger invalid-feedback">
							<strong>{{ $errors->first('whats_app') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label " for="email">
						{{_i('Email')}} </label>
					<div class="col-sm-6">
						<input name="email" value="{{ $site_settings->email }}" id="email" class="form-control"
							placeholder="{{_i('Website Email')}}" type="email"
							data-parsley-type="email">
						@if ($errors->has('email'))
						<span class="text-danger invalid-feedback">
							<strong>{{ $errors->first('email') }}</strong>
						</span>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="card col-md-12">
			<div class="card-header"><h5>{{ _i('socialmedia sites') }}</h5></div>
			<div class="card-block">
				<div class="form-group row">
					<label class="col-sm-2 col-form-label " for="facebook">
						{{_i('Facebook')}} </label>
					<div class="col-sm-6">
						<input name="facebook_url" value="{{ $site_settings->facebook_url }}" id="facebook" class="form-control"
							placeholder="{{_i('Facebook')}}" type="text"
							data-parsley-type="text">
						@if ($errors->has('facebook'))
						<span class="text-danger invalid-feedback">
							<strong>{{ $errors->first('facebook') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label " for="instagram">
						{{_i('Instagram')}} </label>
					<div class="col-sm-6">
						<input name="instagram_url" value="{{ $site_settings->instagram_url }}" id="instagram" class="form-control"
							placeholder="{{_i('instagram')}}" type="text"
							data-parsley-type="text">
						@if ($errors->has('instagram'))
						<span class="text-danger invalid-feedback">
							<strong>{{ $errors->first('instagram') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label " for="twitter">
						{{_i('Twitter')}} </label>
					<div class="col-sm-6">
						<input name="twitter_url" value="{{ $site_settings->twitter_url }}" id="twitter" class="form-control"
							placeholder="{{_i('Twtter')}}" type="twitter"
							data-parsley-type="twitter">
						@if ($errors->has('twitter'))
						<span class="text-danger invalid-feedback">
							<strong>{{ $errors->first('twitter') }}</strong>
						</span>
						@endif
					</div>
				</div>

                <div class="form-group row">
					<label class="col-sm-2 col-form-label " for="twitter">
						{{_i('Youtube')}} </label>
					<div class="col-sm-6">
						<input name="youtube_url" value="{{ $site_settings->youtube_url }}" id="youtube" class="form-control"
							placeholder="{{_i('Youtube')}}" type="twitter"
							data-parsley-type="twitter">
						@if ($errors->has('youtube'))
						<span class="text-danger invalid-feedback">
							<strong>{{ $errors->first('youtube') }}</strong>
						</span>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="card col-md-12">
			<div class="card-header"><h5>{{ _i('App Download Links ') }}</h5></div>
			<div class="card-block">
				<div class="form-group row">
					<label class="col-sm-2 col-form-label " for="facebook">
						{{_i('App Store Link')}} </label>
					<div class="col-sm-6">
						<input name="app_store_url" value="{{ $site_settings->app_store_url }}" id="app_store_url" class="form-control"
							placeholder="{{_i('App Store Link')}}" type="text"
							data-parsley-type="text">
						@if ($errors->has('App Store Link'))
						<span class="text-danger invalid-feedback">
							<strong>{{ $errors->first('App Store Link') }}</strong>
						</span>
						@endif
					</div>
				</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label " for="twitter">
						{{_i('Google Play Link')}} </label>
					<div class="col-sm-6">
						<input name="google_play_url" value="{{ $site_settings->google_play_url }}" id="google_play_url" class="form-control"
							placeholder="{{_i('Google Play Link')}}" type="google_play_url"
							data-parsley-type="google_play_url">
						@if ($errors->has('Google Play Link'))
						<span class="text-danger invalid-feedback">
							<strong>{{ $errors->first('Google Play Link') }}</strong>
						</span>
						@endif
					</div>
				</div>

			</div>
		</div>
	<div class="row">
		<div class="card col-md-12">
			<div class="card-header"><h5>{{ _i('Location') }}</h5></div>
			<div class="card-block">
				<div class="form-group row">
					<label class="col-sm-2 col-form-label " for="facebook">
						{{_i('Location Code')}} </label>
					<div class="col-sm-6">
						<textarea name="location_code"  id="location_code" class="form-control"
							placeholder="{{_i('Location Code')}}"
							data-parsley-type="text">
                            {!!   $site_settings->location_code !!}
                        </textarea>
						@if ($errors->has('App Store Link'))
						<span class="text-danger invalid-feedback">
							<strong>{{ $errors->first('App Store Link') }}</strong>
						</span>
						@endif
					</div>
				</div>
				</div>

			</div>
		</div>
	</div>
    <div class="row">
        <div class="card col-md-12">
            <div class="card-header"><h5>{{ _i('Taxs') }}</h5></div>
            <div class="card-block">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label " for="facebook">
                        {{_i('Tax on Product percent (%)')}} </label>
                    <div class="col-sm-6">
						<input name="product_tax"  id="product_tax" class="form-control"
                                  placeholder="{{_i('Tax on Product')}}"
                                  data-parsley-type="text" value="{!! $site_settings->tax_on_product !!}">
                        @if ($errors->has('Tax on Product'))
                            <span class="text-danger invalid-feedback">
							<strong>{{ $errors->first('Tax on Product') }}</strong>
						</span>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
    <div class="row">
		<div class="card col-md-12">
			<div class="card-header"><h5>{{ _i('Chat Settings') }}</h5></div>
			<div class="card-block">
				<div class="form-group row">
					<label class="col-sm-2 col-form-label">
						{{_i('Chat Mode')}} </label>
					<div class="col-sm-6">
						<input type="checkbox" value="1" name="chat_mode" class="js-switch" {{$site_settings['chat_mode'] == 1 ? "checked" : ""}} />
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label">
						{{_i('Chat Code')}} </label>
					<div class="col-sm-6">
						<textarea name="chat_code" class="form-control" rows=15>{{ $site_settings->chat_code }}</textarea>
						@if ($errors->has('chat_code'))
							<span class="text-danger invalid-feedback">
							<strong>{{ $errors->first('chat_code') }}</strong>
						</span>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<button type="submit" class="btn btn-info col-md-12">
			{{_i('Save')}}
		</button>
	</div>
</form>

@include('admin.settings.translate')
@endsection

@push('js')
<script>
	$(document).ready(function () {
		$('#sliders-table').DataTable({
			processing: true,
			serverSide: true,
			ajax: '{{url("/admin/settings/slider/datatable")}}',
			columns: [{
					data: 'id',
					name: 'id'
				},
				{
					data: 'title',
					name: 'title'
				},
				{
					data: 'url',
					name: 'url'
				},
				{
					data: 'image',
					name: 'image'
				},
				{
					data: 'created_at',
					name: 'created_at'
				},

				// {data: 'action', name: 'action', orderable: false, searchable: false}
				{
					data: 'delete',
					name: 'delete',
					orderable: false,
					searchable: false
				}
			]
		});

	});


	$("#sort_order").bind('keyup', function () {
		// console.log($('#sort_order').val() == 5)
		if ($('#sort_order').val() == 5) {
			$('#category').css('display', 'block');
		} else {
			$('#category').css('display', 'none');
		}
	});

	function showSliderImage(input) {
		var filereader = new FileReader();
		filereader.onload = (e) => {
			console.log(e);
			$('#slider_img').attr('src', e.target.result).width(180).height(120);
		};
		console.log(input.files);
		filereader.readAsDataURL(input.files[0]);
	}
	//show slider logo
	function showSliderLogo(input) {
		var filereader = new FileReader();
		filereader.onload = (e) => {
			console.log(e);
			$('#slider_logo').attr('src', e.target.result).width(180).height(120);
		};
		console.log(input.files);
		filereader.readAsDataURL(input.files[0]);
	}

	function showImg(input) {

		var filereader = new FileReader();
		filereader.onload = (e) => {
			console.log(e);
			$('#setting_img').attr('src', e.target.result).width(250).height(250);
		};
		console.log(input.files);
		filereader.readAsDataURL(input.files[0]);

	}

	function showOldImg(input) {

		var filereader = new FileReader();
		filereader.onload = (e) => {
			console.log(e);
			$("#old_img").attr('src', e.target.result).width(300).height(250);

		};
		console.log(input.files);
		filereader.readAsDataURL(input.files[0]);

	}

	function apperImage(input) {

		var filereader = new FileReader();
		filereader.onload = (e) => {
			// console.log(e);
			$('#new_img').attr('src', e.target.result).width(300).height(250);
		};
		// console.log(input.files);
		filereader.readAsDataURL(input.files[0]);

	}
	$(document).ready(function () {
		// For A Delete Record Popup
		$('.remove-record').click(function () {
			var id = $(this).attr('data-id');
			var url = $(this).attr('data-url');
			var token = '{{csrf_token()}}';
			$(".remove-record-model").attr("action", url);
			$('body').find('.remove-record-model').append(
				'<input name="_token" type="hidden" value="' + token + '">');
			$('body').find('.remove-record-model').append(
				'<input name="_method" type="hidden" value="DELETE">');
			$('body').find('.remove-record-model').append(
				'<input name="id" type="hidden" value="' + id + '">');
		});
		$('.remove-data-from-delete-form').click(function () {
			$('body').find('.remove-record-model').find("input").remove();
		});
		$('.modal').click(function () {
			// $('body').find('.remove-record-model').find( "input" ).remove();
		});
	});

	$(document).ready(function () {
		// For A Delete Record Popup
		$('.remove-edit').click(function () {
			var id = $(this).attr('data-id');
			var url = $(this).attr('data-url');
			var token = '{{csrf_token()}}';
			console.log(id, url, token);
			$(".remove-edit-model").attr("action", url);
			$('body').find('.remove-edit-model').append(
				'<input name="_token" type="hidden" value="' + token + '">');
			$('body').find('.remove-edit-model').append(
				'<input name="_method" type="hidden" value="DELETE">');
			$('body').find('.remove-edit-model').append(
				'<input name="id" type="hidden" value="' + id + '">');
		});
		$('.remove-data-from-delete-form').click(function () {
			$('body').find('.remove-edit-model').find("input").remove();
		});
		$('.modal').click(function () {
			// $('body').find('.remove-edit-model').find( "input" ).remove();
		});
	});
	$('body').on('click', '.lang_ex', function (e) {
		e.preventDefault();
		var transRowId = $(this).data('id');
		var lang_id = $(this).data('lang');
		$.ajax({
			url: '{{route('settings.translation')}}',
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
					$('#langedit #address').val('');
					$('#langedit #header_description').val('');
				} else{
					$('#langedit #title').val(response.data.title);
					$('#langedit #description').val(response.data.description);
					$('#langedit #keywords').val(response.data.keywords);
					$('#langedit #address').val(response.data.address);
					$('#langedit #header_description').val(response.data.header_description);
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
					}
				},
			});
		});
	});
</script>
<script>
	$(function () {
		'use strict'
		$('#sliders-table_wrapper').removeClass('form-inline');
	});
</script>
@endpush
