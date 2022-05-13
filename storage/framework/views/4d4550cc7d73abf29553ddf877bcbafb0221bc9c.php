	<div class="modal fade " id="langedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top:40px;">
		<div class="modal-dialog" role="document">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="header"> <?php echo e(_i('Trans To')); ?> : </h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form  action="<?php echo e(route('settings.update_translation')); ?>" method="post" class="form-horizontal"  id="lang_submit" data-parsley-validate="">
							<?php echo csrf_field(); ?>
							<?php echo method_field('PATCH'); ?>
							<input type="hidden" name="id" id="id_data" value="">
							<input type="hidden" name="lang_id" id="lang_id_data" value="" >
							<div class="box-body">
								<div class="form-group row">
									<label for="" class="col-sm-2 control-label "> <?php echo e(_i('Name')); ?> </label>
									<div class="col-md-10">
										<input type="text" name="title"  value="" class="form-control<?php echo e($errors->has('title') ? ' is-invalid' : ''); ?>" required="" id="title">
										<span class="text-danger">
											<strong id="title-error"></strong>
										</span>
									</div>
								</div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-2 control-label "> <?php echo e(_i('Address')); ?> </label>
                                    <div class="col-md-10">
                                        <input type="text" name="address"  value="" class="form-control<?php echo e($errors->has('address') ? ' is-invalid' : ''); ?>" required="" id="address">
                                        <span class="text-danger">
											<strong id="address-error"></strong>
										</span>
                                    </div>
                                </div>

                                <div class="form-group row">
									<label for="description" class="col-sm-2 control-label"> <?php echo e(_i('Description')); ?> </label>
									<div class="col-sm-10">
										<textarea id="description" class="form-control" name="description"></textarea>
										<span class="text-danger">
											<strong id="description-error"></strong>
										</span>
									</div>
								</div>
                                <div class="form-group row">
									<label for="header_description" class="col-sm-2 control-label"> <?php echo e(_i('Header Description')); ?> </label>
									<div class="col-sm-10">
										<textarea id="header_description" class="form-control" name="header_description"></textarea>
										<span class="text-danger">
											<strong id="header_description-error"></strong>
										</span>
									</div>
								</div>
								<div class="form-group row">
									<label for="keywords" class="col-sm-2 control-label"> <?php echo e(_i('Keywords')); ?> </label>
									<div class="col-sm-10">
										<textarea id="keywords" class="form-control" name="keywords"></textarea>
										<span class="text-danger">
											<strong id="keywords-error"></strong>
										</span>
									</div>
								</div>
							</div>
							<!-- /.box-body -->
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(_i('Close')); ?></button>
								<button type="submit" class="btn btn-primary" >
								<?php echo e(_i('Save')); ?>

								</button>
							</div>
							<!-- /.box-footer -->
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php /**PATH C:\xampp\htdocs\mashora\app\Modules\Admin\views/admin/settings/translate.blade.php ENDPATH**/ ?>