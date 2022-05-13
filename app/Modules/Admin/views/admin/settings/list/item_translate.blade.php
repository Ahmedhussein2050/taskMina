	<div class="modal fade " id="itemlangedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top:40px;">
		<div class="modal-dialog" role="document">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="header"> {{_i('Trans To')}} : </h5>
					</div>
					<div class="modal-body">
						<form  action="{{route('list_items.store.translation')}}" method="post" class="form-horizontal"  id="item_lang_submit" data-parsley-validate="">
							{{method_field('post')}}
							{{csrf_field()}}
							<input type="hidden" name="id" id="item_id_data" value="">
							<input type="hidden" name="lang_id" id="item_lang_id_data" value="" >
							<div class="box-body">
								<div class="form-group row">
									<label for="" class="col-sm-2 control-label "> {{_i('Name')}} </label>
									<div class="col-md-10">
										<input type="text" name="name"  value="" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" required="" id="name">
										<span class="text-danger">
											<strong id="name-error"></strong>
										</span>
									</div>
								</div>

							</div>
							<!-- /.box-body -->
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">{{_i('Close')}}</button>
								<button type="submit" class="btn btn-primary" >
								{{_i('Save')}}
								</button>
							</div>
							<!-- /.box-footer -->
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
