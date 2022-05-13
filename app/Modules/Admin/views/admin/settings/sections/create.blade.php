<div class="modal modal_create fade" id="modal-default">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="header"> {{_i('Add Section')}} </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="form_add" class="form-horizontal" action="{{url('admin/settings/sections/store')}}" method="POST" data-parsley-validate="" enctype="multipart/form-data">
					@csrf
					<div class="box-body">

						<div class="form-group row" >
							<label class="col-sm-3 col-form-label">{{ _i('Title') }} <span style="color: #F00;">*</span></label>
							<div class="col-sm-9">
								<input type="text" class="form-control title" name="title" required="" placeholder="{{_i('Place Enter Section Title')}}">
							</div>
						</div>
						<div class="form-group row" >
							<label class="col-sm-3 col-form-label" for="checkbox">
								{{_i('Display Title')}}
							</label>
							<div class="checkbox-fade fade-in-primary col-sm-6">
								<label>
									<input type="checkbox" name="is_title_displayed" value="1" class='is_title_displayed'>
									<span class="cr">
									<i class="cr-icon icofont icofont-ui-check txt-primary"></i>
								</span>
								</label>
							</div>
						</div>
						<div class="form-group row" >
							<label class="col-sm-3 col-form-label">{{ _i('Description') }}</label>
							<div class="col-sm-9">
								<textarea class="form-control description" name="description" placeholder="{{_i('Place Enter description')}}"></textarea>
							</div>
						</div>
						<div class="form-group row" >
							<label class=" col-sm-3 col-form-label">{{ _i('Content Type') }} </label>
							<div class="col-sm-9">
								<select class="form-control type" name="type" id="select">
									<option selected disabled><?=_i('Select Type')?></option>
									<option value="latest_products" selected>{{ _i('Latest Products') }}</option>
										<option value="best_selling_products">{{ _i('Best Selling Products') }}</option>
										<option value="most_visited_products">{{ _i('Most Visited Products') }}</option>
										<option value="random_products">{{ _i('Random Products') }}</option>
										<option value="image_video">{{ _i('Image + Video') }}</option>
										<option value="banner">{{ _i('Banner') }}</option>
										<option value="banner2">{{ _i('Banner2') }}</option>
										<option value="banner3">{{ _i('Banner3') }}</option>
								</select>
							</div>
						</div>
						<div class="form-group row products" >
							<label class="col-sm-3 col-form-label">{{ _i('Categories') }}</label>
							<div class="col-sm-9">
								<select class="form-control selectpicker categories" name="categories[]" id="cate_id" data-live-search="true"  multiple data-actions-box="true" title='{{ _i('Select Categories') }}'>

									@foreach($categories AS $key => $val)
									<option value="{{ $key }}">{{ $val }}</option>
									@endforeach

								</select>
							</div>
						</div>
						<div class="form-group row success_Products"  hidden>
							<label class="col-sm-3 col-form-label">{{ _i('Products') }}</label>
							<div class="col-sm-9">
								<select class="form-control selectpicker Products" name="products[]" multiple data-actions-box="true" data-live-search="true"  title='{{ _i('Select Products') }}'>
									@foreach($products AS $product)
									<option value="{{ $product->product_id }}">{{ $product->cat}} &gt;&gt; {{ $product->title}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group row productsTotal" >
							<label class=" col-sm-3 col-form-label">{{_i('Total Products')}}</label>
							<div class="col-sm-9">
								<input type="text" class="form-control total" name="total" placeholder="{{_i('Place Enter Total Products')}}">
							</div>
						</div>
						<div class="form-group row image_video" hidden>
							<label class="col-sm-3 col-form-label" for="image">{{_i('Image')}}</label>
							<div class="col-sm-9">
								<input type="file" name="image" class="btn btn-default image" accept="image/*">
								<span class="text-danger invalid-feedback">
									<strong>{{$errors->first('image')}}</strong>
								</span>
							</div>
						</div>
						<div class="form-group row image_video" hidden>
							<label class="col-sm-3 col-form-label" for="video">{{_i('Video')}}</label>
							<div class="col-sm-9">
								<input type="text" name="video" class="form-control video" placeholder="{{_i('Youtube Link')}}">
								<span class="text-danger invalid-feedback">
									<strong>{{$errors->first('video')}}</strong>
								</span>
							</div>
						</div>
						<div class="form-group row banner" hidden>
							<label class="col-sm-3 col-form-label">{{ _i('Banners') }}</label>
							<div class="col-sm-9">
								<select class="form-control selectpicker banners" name="banners[]" id="select_banner"  data-actions-box="true" title='{{ _i('Select Banners') }}'>
									@foreach($banners AS $banner)
									<option value="{{ $banner->id }}">{{ $banner->title }}</option>
									@endforeach
								</select>
							</div>
						</div>
						{{-- Banner 2 --}}
						<div class="form-group row banner2" hidden>
							<label class="col-sm-3 col-form-label">{{ _i('Banners') }}</label>
							<div class="col-sm-9">
								<select class="form-control selectpicker banners" name="banners[]" id="select_banner2" data-actions-box="true" title='{{ _i('Select Banners') }}'>
									@foreach($banners AS $banner)
									<option value="{{ $banner->id }}">{{ $banner->title }}</option>
									@endforeach
								</select>
							</div>
						</div>
						{{-- Banner 3 --}}
						<div class="form-group row banner3" hidden>
							<label class="col-sm-3 col-form-label">{{ _i('Banners') }}</label>
							<div class="col-sm-9">
								<select class="form-control selectpicker banners" name="banners[]" id="select_banner3"  data-actions-box="true" title='{{ _i('Select Banners') }}'>
									@foreach($banners AS $banner)
									<option value="{{ $banner->id }}">{{ $banner->title }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group row services" hidden>
							<label class="col-sm-3 col-form-label">{{ _i('Services') }}</label>
							<div class="col-sm-9">
								<select class="form-control selectpicker services" name="services[]" multiple data-actions-box="true" title='{{ _i('Select services') }}'>
									@foreach($services AS $service)
									<option value="{{ $service->id }}">{{ $service->title }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group row success_partners" hidden>
							<label class="col-sm-3 col-form-label">{{ _i('Success partners') }}</label>
							<div class="col-sm-9">
								<select class="form-control selectpicker partners" name="success_partners[]" multiple data-actions-box="true" title='{{ _i('Select Partners') }}'>
									@foreach($success_partners AS $partner)
									<option value="{{ $partner->id }}">{{ $partner->title }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group row" >
							<label class=" col-sm-3 col-form-label"><?=_i('Display Order')?></label>
							<div class="col-sm-9">
								<input type="text" class="form-control display_order" name="display_order" placeholder="{{_i('Place Enter Section Order')}}">
							</div>
						</div>
						<div class="form-group row" >
							<label class="col-sm-3 col-form-label" for="checkbox">
								{{_i('Publish')}}
							</label>
							<div class="checkbox-fade fade-in-primary col-sm-6">
								<label>
									<input type="checkbox" name="published" value="1" class='checkbox'>
									<span class="cr">
									<i class="cr-icon icofont icofont-ui-check txt-primary"></i>
								</span>
								</label>
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default pull-left" data-dismiss="modal"> {{_i('Close')}}
						</button>
						<button class="btn btn-info" type="submit" id="s_form_1"> {{_i('Save')}} </button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@push('js')
<script>

$(document).ready(function(){
		$(document).on('change', '.type', function(){
			console.log($(this).val());
			let type = $(this).val();
			if (type == 'banner'||type == 'banner2' ||type == 'banner3' || type == 'image_video') {
				$('.productsTotal').hide();
			}
			else {
				$('.productsTotal').show();
			}
		})


	$(document).on('click','.add-permissiont',function(e){
		$.ajax({
			type: "GET",
			url: "{{url('admin/settings/sections/autocomplete')}}",
			dataType: 'json',
            delay: 250,

			success: function (response) {
				//console.log(response.data);

				$.each(response.data,function(key ,value){
					console.log(value);

					$('#make_select1').append('<option>'+value.title+'</option>')

				})

			},
			error: function () {

			}
		});
	})



		// $('#model_select').selectpicker('refresh');
	});


		$(function() {
			$('#form_add').submit(function(e) {
			//	debugger;
				e.preventDefault();
				$.ajax({
					url: "{{url('admin/settings/sections/store').'/'.$page_section}}",
					type: "POST",
					"_token": "{{ csrf_token() }}",
					data: new FormData(this),
					dataType: 'json',
					cache       : false,
					contentType : false,
					processData : false,
					success: function(response) {
					//	debugger;

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
								text: "{{ _i('Saved Successfully')}}",
								timeout: 2000,
								killer: true
							}).show();
							$('.modal.modal_create').modal('hide');
							table.ajax.reload();
							document.getElementById('form_add').reset();
                            $("#form_add").parsley().reset();
							$("#select_banner").val('0').selectpicker('refresh');
							$("#select_banner2").val('0').selectpicker('refresh');
							$("#select_banner3").val('0').selectpicker('refresh');
                            $(".banner").hide();
                            $(".banner2").hide();
                            $(".banner3").hide();
							$('#lang_add').val("");
							$('#title_add').val("");
							$('#link_add').val("");
							$('#image_add').val("");
							$('#checkbox').val("");
							$('#description_add').val("");
						}
					}
				});
			});
		});

	</script>
@endpush
