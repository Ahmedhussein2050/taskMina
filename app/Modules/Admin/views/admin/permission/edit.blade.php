<div class="modal modal_edit fade" id="modal-edit">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="header"> {{_i('Edit Permission')}} </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="form_edit" class="form-horizontal" method="POST" data-parsley-validate="">
					@method('PATCH')
					@csrf
					<div class="box-body">
						<input type="hidden" id="permission_id" name="permission_id">
						<div class="form-group row" >
							<label class=" col-sm-2 col-form-label" for="lang_id"><?=_i('Language')?> </label>
							<div class="col-sm-10">
								<select class="form-control" name="lang_id" id="lang_id">
									<option selected disabled><?=_i('CHOOSE')?></option>
									@foreach($languages as $lang)
										<option value="<?=$lang['id']?>"
										<?=old('lang_id') == $lang['id'] ? 'selected' : ''?>><?=_i($lang['title'])?>
										</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group row" >
							<label for="permission_title" class=" col-sm-2 col-form-label"><?=_i('Title')?> <span style="color: #F00;">*</span></label>
							<div class="col-sm-10">
								<input id="permission_title" type="text" class="form-control" name="title" required="" placeholder="{{_i('Permission Title')}}">
								<span class="text-danger">
									<strong id="title-error"></strong>
								</span>							
							</div>
						</div>
						<div class="form-group row" >
							<label for="permission_name" class=" col-sm-2 col-form-label"><?=_i('Name')?> <span style="color: #F00;">*</span></label>
							<div class="col-sm-10">
								<input  id="permission_name" type="text" class="form-control" name="name" required="" placeholder="{{_i('Permission Name')}}">
								<span class="text-danger">
									<strong id="name-error"></strong>
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
			var permission_id = $(this).data('id');
			var lang_id = $(this).data('lang_id');
			var permission_name = $(this).data('name');
			var permission_title = $(this).data('title');

			$('#permission_id').val(permission_id);
			$('#lang_id').val(lang_id);
			$('#permission_name').val(permission_name);
			$('#permission_title').val(permission_title);
		});

		$(function() {
			$('#form_edit').submit(function(e) {
				e.preventDefault();
				$.ajax({
					url: "{{url('admin/permission/update')}}",
					type: "POST",
					"_token": "{{ csrf_token() }}",
					data: new FormData(this),
					dataType: 'json',
					cache       : false,
					contentType : false,
					processData : false,
					success: function(response) {
						if (response.errors){
							if(response.errors.name)
							{
								$( '#form_edit #name-error' ).html( response.errors.name[0] );
							}
							if(response.errors.title)
							{
								$( '#form_edit #title-error' ).html( response.errors.title[0] );
							}
						}
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
