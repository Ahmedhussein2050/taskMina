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
						<button type="button" class="btn btn-default pull-left" data-dismiss="modal">
							{{_i('Close')}}
						</button>
						<button class="btn btn-info" type="submit" id="s_form_1"> {{_i('Save')}} </button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
