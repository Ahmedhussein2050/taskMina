	<div class="modal fade " id="langedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top:40px;">
		<div class="modal-dialog" role="document">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="header"> <?php echo e(_i('Trans To')); ?> : </h5>
					</div>
					<div class="modal-body">
						<form  action="<?php echo e(route('products.store.translation')); ?>" method="post" class="form-horizontal"  id="lang_submit" data-parsley-validate="">
							<?php echo e(method_field('post')); ?>

							<?php echo e(csrf_field()); ?>

							<input type="hidden" name="id" id="id_data" value="">
							<input type="hidden" name="lang_id" id="lang_id_data" value="" >
							<div class="box-body">
								<div class="form-group row">
									<label for="" class="col-sm-2 control-label "> <?php echo e(_i('Title')); ?> </label>
									<div class="col-md-10">
										<input type="text" name="title"  value="" class="form-control<?php echo e($errors->has('title') ? ' is-invalid' : ''); ?>" required="" id="title">
										<span class="text-danger">
											<strong id="title-error"></strong>
										</span>
									</div>
								</div>

                                <div class="form-group row">
                                    <label for="address" class="col-sm-3 control-label"> <?php echo e(_i('Description')); ?> </label>

                                    <div class="col-sm-9">
                                        <textarea id="description" class="form-control editor1" name="description"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="address" class="col-sm-3 control-label"> <?php echo e(_i('Info')); ?> </label>

                                    <div class="col-sm-9">
                                        <textarea id="info" class="form-control editor1" name="info"></textarea>
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
<?php /**PATH C:\xampp\htdocs\taskMina\app\Modules\Admin\views/admin/products/translate.blade.php ENDPATH**/ ?>