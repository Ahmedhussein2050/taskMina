<div class="modal modal_create fade" id="modal-create">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="header"> {{_i('Create new permission')}} </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="form_add" class="form-horizontal" action="{{route('site.admin.permissions.store')}}" method="POST" data-parsley-validate="">
					@csrf
					<div class="box-body">
						<div class="form-group row" >
							<label class=" col-sm-2 col-form-label"><?=_i('Title')?>
								<span style="color: #F00;">*</span>
							</label>
							<div class="col-sm-10">
								<input type="text" id="title" class="form-control" name="title" required="" placeholder="{{_i('Place Enter Title')}}">
								<span class="text-danger">
									<strong id="title-error"></strong>
								</span>
							</div>
						</div>
						<div class="form-group row" >
							<label class=" col-sm-2 col-form-label"><?=_i('Name')?>
								<span style="color: #F00;">*</span>
							</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="name" id='name' required="" placeholder="{{_i('Place Enter Name')}}">
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
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
