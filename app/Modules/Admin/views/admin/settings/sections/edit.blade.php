<div class="modal modal_edit fade" id="modal-edit">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="header"> {{_i('Edit Section')}} </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="form_edit" class="form-horizontal" method="POST" data-parsley-validate="" enctype="multipart/form-data">
					@csrf
					<div class="box-body">

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
							<label class=" col-sm-3 col-form-label">{{ _i('Content Type') }} </label>
							<div class="col-sm-9">
								<select class="form-control type" name="type">
									<option selected disabled><?=_i('Select Type')?></option>
									<option value="latest_products">{{ _i('Latest Products') }}</option>
									<option value="best_selling_products">{{ _i('Best Selling Products') }}</option>
									<option value="most_visited_products">{{ _i('Most Visited Products') }}</option>
									<option value="random_products">{{ _i('Random Products') }}</option>
									<option value="image_video">{{ _i('Image + Video') }}</option>
									<option value="banner">{{ _i('Banner') }}</option>
									<option value="services">{{ _i('Services') }}</option>
									<option value="success_partners">{{ _i('Success partners') }}</option>
								</select>
							</div>
						</div>

						<div class="form-group row products" >
							<label class="col-sm-3 col-form-label">{{ _i('Categories') }}</label>
							<div class="col-sm-9">
								<select class="form-control selectpicker categories" name="categories[]" multiple data-actions-box="true" title='{{ _i('Select Categories') }}'>
									@foreach($categories AS $key => $val)
									<option value="{{ $key }}">{{ $val }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group row products" >
							<label class=" col-sm-3 col-form-label"><?=_i('Total Products')?></label>
							<div class="col-sm-9">
								<input type="number" min="1" required class="form-control total" name="total" placeholder="{{_i('Place Enter Total Products')}}">
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
								<select class="form-control selectpicker banners" name="banners[]" multiple data-actions-box="true" title='{{ _i('Select Banners') }}'>
									@foreach($banners AS $banner)
									<option value="{{ $banner->id }}">{{ $banner->title }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group row services" hidden>
							<label class="col-sm-3 col-form-label">{{ _i('Services') }}</label>
							<div class="col-sm-9">
								<select class="form-control selectpicker banners" name="banners[]" multiple data-actions-box="true" title='{{ _i('Select Banners') }}'>
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
					<input type="hidden" name="section_id" class='section_id'>
				</form>
			</div>
		</div>
	</div>
</div>

@push('js')
	<script>
		$(document).on('change', '.type', function(){
			console.log($(this).val());
			let type = $(this).val();
			if (type == 'banner' || type == 'image_video') {
				$('.productsTotal').hide();
			}
			else {
				$('.productsTotal').show();
			}
		})
		$('body').on('click', '.edit', function (e) {

			e.preventDefault();
			var section_id = $(this).data('id');
			var published = $(this).data('published');
			var image = $(this).data('image');
			var video = $(this).data('video');
			var display_order = $(this).data('display_order');
			var total = $(this).data('total');
			var categories = $(this).data('categories');
			var banners = $(this).data('banners');
			var services = $(this).data('services');
			var partners = $(this).data('partners');
			var type = $(this).data('type');
			var master = $(this).data('master');
			var is_title_displayed = $(this).data('is_title_displayed');


			if(type == 'image_video')
			{
				$('.image_video').removeAttr('hidden').show();
				$('.products').hide();
				$('.banner').hide();
				$('.services').hide();
				$('.success_partners').hide();
			}
			else if(type == 'banner')
			{
				$('.banner').removeAttr('hidden').show();
				$('.products').hide();
				$('.image_video').hide();
				$('.services').hide();
				$('.success_partners').hide();
			}
			else if(type == 'services')
			{
				$('.services').removeAttr('hidden').show();
				$('.products').hide();
				$('.image_video').hide();
				$('.banner').hide();
				$('.success_partners').hide();
			}
			else if(type == 'success_partners')
			{
				$('.success_partners').removeAttr('hidden').show();
				$('.products').hide();
				$('.image_video').hide();
				$('.banner').hide();
				$('.services').hide();
			}
			else
			{
				$('.products').removeAttr('hidden').show();
				$('.image_video').hide();
				$('.banner').hide();
				$('.services').hide();
				$('.success_partners').hide();
			}

			$('#modal-edit .section_id').val(section_id);
			if(is_title_displayed == 1){
				$('#modal-edit .is_title_displayed').prop('checked',true);
			}
			else
			{
				$('#modal-edit .is_title_displayed').prop('checked',false);
			}
			if(published == 1){
				$('#modal-edit .checkbox').prop('checked',true);
			}
			else
			{
				$('#modal-edit .checkbox').prop('checked',false);
			}

			$('#modal-edit .display_order').val(display_order);
			$('#modal-edit .total').val(total);
			$('#modal-edit .type').val(type);
			$('#modal-edit .categories').val(categories);
			$('#modal-edit .banners').val(banners);
			$('#modal-edit .services').val(services);
			$('#modal-edit .partners').val(partners);
			$("#modal-edit .old_img").attr('src',"{{asset('')}}/"+image);
			$("#modal-edit .old_video").attr('src',"{{asset('')}}/"+video);
			$('#modal-edit .master').val(master);
			$('.selectpicker').selectpicker('refresh');
		});

		function showImg(input) {
			var filereader = new FileReader();
			filereader.onload = (e) => {
				console.log(e);
				$("#old_img").attr('src', e.target.result).width(100).height(100);
			};
			console.log(input.files);
			filereader.readAsDataURL(input.files[0]);
		}

		$(function() {

			$('#form_edit').submit(function(e) {
				e.preventDefault();
 				$.ajax({
					url: "{{url('admin/settings/sections/update')}}",
					type: "POST",
					"_token": "{{ csrf_token() }}",
					data: new FormData(this),
					dataType: 'json',
					cache       : false,
					contentType : false,
					processData : false,
					success: function(response) {
						if (response == 'SUCCESS'){
							new Noty({
								type: 'success',
								layout: 'topRight',
								text: "{{ _i('Saved Successfully')}}",
								timeout: 2000,
								killer: true
							}).show();
							$('.modal.modal_edit').modal('hide');
							table.ajax.reload();
						}
					}
				});
			});
		});
	</script>
@endpush
