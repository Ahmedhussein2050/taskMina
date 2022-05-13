<div class="modal modal_edit fade" id="modal-edit">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="header"> {{_i('Edit Banner')}} </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="form_edit" class="form-horizontal" method="POST" data-parsley-validate="" enctype="multipart/form-data">
					@csrf
					<div class="box-body">
						<input type="hidden" id="banner_id" name="banner_id">
						<div class="form-group row" >
							<label class=" col-sm-2 col-form-label"><?=_i('Banner Place')?> </label>
							<div class="col-sm-10">
								<select class="form-control" name="place" id="place">
                                    <option selected disabled><?=_i('CHOOSE')?></option>
                                    <option value="1"
                                    <?=old('place') == 1 ? 'selected' : ''?>>{{ _i('Banner #1') }}
                                    </option>
                                    <option value="2"
                                    <?=old('place') == 2 ? 'selected' : ''?>>{{ _i('Banner #2') }}
                                    </option>
                                    <option value="3"
                                    <?=old('place') == 3 ? 'selected' : ''?>>{{ _i('Banner #3') }}
                                    </option>
                                    <option value="4"
                                    <?=old('place') == 4 ? 'selected' : ''?>>{{ _i('Banner #4') }}
                                    </option>

								</select>
							</div>
						</div>
						<div class="form-group row" >
							<label for="url" class=" col-sm-2 col-form-label"><?=_i('Link')?> <span style="color: #F00;">*</span></label>
							<div class="col-sm-10">
								<input  id="link" type="url" class="form-control" name="link" required="" placeholder="{{_i('Place Enter Banner Link')}}">
							</div>
						</div>
						<div class="form-group row" >
							<label class="col-sm-2 col-form-label" for="checkboxx">
								{{_i('Publish')}}
							</label>
							<div class="checkbox-fade fade-in-primary col-sm-6">
								<label>
									<input type="checkbox"  id="checkboxx" name="published" value="1">
									<span class="cr">
									<i class="cr-icon icofont icofont-ui-check txt-primary"></i>
								</span>
								</label>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label" for="image">{{_i('Image')}} <span style="color: #F00;">*</span></label>
							<div class="col-sm-10">
								<input type="file" name="image" id="image" onchange="showImg(this)"
									   class="btn btn-default" accept="image/*" >
								<img class="img-responsive pad" id="old_img" style=" width: 100px; height: 100px;"
									 src="">
								<span class="text-danger invalid-feedback">
									<strong>{{$errors->first('image')}}</strong>
								</span>
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
		$('body').on('click', '.edit', function (e) {
			e.preventDefault();
			var banner_id = $(this).data('id');
			var lang_id = $(this).data('lang_id');
			var link = $(this).data('link');
			var published = $(this).data('published');
			var image = $(this).data('image');
			var description = $(this).data('description');
			var place = $(this).data('place');

			console.log(place);

			$('#modal-edit #banner_id').val(banner_id);
			$('#modal-edit #lang_id').val(lang_id);
			$('#modal-edit #link').val(link);
			if(published == 1){
				$('#modal-edit #checkboxx').prop('checked',true);
			}
			$('#modal-edit #place').val(place);
			$('#modal-edit #description').val(description);
			$("#modal-edit #old_img").attr('src',"{{asset('')}}/"+image);
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
					url: "{{url('admin/settings/banners/update')}}",
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
