<div class="modal modal_create fade" id="modal_create">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="header"> {{_i('Create New Currency')}} </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="form_add" class="form-horizontal" action="{{route('currencies.store')}}" method="POST" data-parsley-validate="" enctype="multipart/form-data">
					@csrf
					<div class="box-body">
						<div class="form-group row" >
							<label class="col-sm-4 col-form-label"><?=_i('Name')?> <span style="color: #F00;">*</span></label>
							<div class="col-sm-8">
								<input type="text" id="name" class="form-control" name="name" required="" placeholder="{{_i('Place Enter Currency Name')}}">
								<span class="text-danger">
									<strong id="name-error"></strong>
								</span>
							</div>
						</div>
						<div class="form-group row" >
							<label class="col-sm-4 col-form-label"><?=_i('Short Name')?> <span style="color: #F00;">*</span></label>
							<div class="col-sm-8">
								<input type="text" id="short_name" class="form-control" name="short_name" required="" placeholder="{{_i('Place Enter Currency Short Name')}}">
								<span class="text-danger">
									<strong id="short_name-error"></strong>
								</span>
							</div>
						</div>
						<div class="form-group row" >
							<label class="col-sm-4 col-form-label"><?=_i('Code')?> <span style="color: #F00;">*</span></label>
							<div class="col-sm-8">
								<input type="text" id="code" class="form-control" name="code" required="" placeholder="{{_i('Place Enter Currency Code')}}">
								<span class="text-danger">
									<strong id="code-error"></strong>
								</span>
							</div>
						</div>
						<div class="form-group row" >
							<label class=" col-sm-4 col-form-label"><?=_i('Exchange Rate')?> <span style="color: #F00;">*</span></label>
							<div class="col-sm-8">
								<input type="text" id="rate" class="form-control" name="rate" required="" placeholder="{{_i('Place Enter Exchange Rate')}}">
								<span class="text-danger">
									<strong id="rate-error"></strong>
								</span>
							</div>
						</div>
						<div class="form-group row" >
							<label class=" col-sm-4 col-form-label"><?=_i('Flag')?> <span style="color: #F00;">*</span></label>
							<div class="col-sm-8">
								<input type="text" id="flag" class="form-control" name="flag" required="" placeholder="{{_i('Place Enter Flag Code')}}">
								<span class="text-danger">
									<strong id="flag-error"></strong>
								</span>
							</div>
						</div>
						<div class="form-group row" >
							<label class="col-sm-4 col-form-label" for="checkbox">{{_i('Publish')}}</label>
							<div class="checkbox-fade fade-in-primary col-sm-6">
								<label>
									<input type="checkbox"  id="checkbox" name="published" value="1">
									<span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
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
		$(function() {
			$('#form_add').submit(function(e) {
				e.preventDefault();
				$.ajax({
					url: "{{ route('currencies.store') }}",
					type: "POST",
					"_token": "{{ csrf_token() }}",
					data: new FormData(this),
					dataType: 'json',
					cache       : false,
					contentType : false,
					processData : false,
					success: function(response) {
						if (response.errors){
							if(response.errors.code)
							{
								$( '#code-error' ).html( response.errors.code[0] );
							}
							if(response.errors.rate)
							{
								$( '#rate-error' ).html( response.errors.rate[0] );
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
							$('.modal.modal_create').modal('hide');
							$('#dataTable').DataTable().draw(false);
							$('#name').val("");
							$('#short_name').val("");
							$('#code').val("");
							$('#rate').val("");
							$('#checkbox').val("");
							$('#checkboxx').prop('checked', false);
						}
					}
				});
			});
		});
	</script>
@endpush
