

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12 mbl mb-3">
            <span class="pull-left">
                  <a href="<?php echo e(url('admin/notifications/create')); ?>" data-toggle="modal" data-target="#create" class="btn btn-primary create add-permission">
                        <i class="ti-plus"></i><?php echo e(_i('Send new notification')); ?>

                    </a>
            </span>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5> <?php echo e(_i('Notifications')); ?> </h5>
                    <div class="card-header-right">
                        <i class="icofont icofont-rounded-down"></i>
                        <i class="icofont icofont-refresh"></i>
                        <i class="icofont icofont-close-circled"></i>
                    </div>
                </div>
                <div class="card-block">
                    <div class="dt-responsive table-responsive text-center">
                        <table class="table table-striped table-bordered nowrap text-center datatable">
                            <thead>
                            <tr role="row">
                                <th> <?php echo e(_i('ID')); ?></th>
                                <th> <?php echo e(_i('User')); ?></th>
                                <th> <?php echo e(_i('Text')); ?></th>
                                <th> <?php echo e(_i('Created at')); ?></th>
                                <th> <?php echo e(_i('Options')); ?></th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> <?php echo e(_i('Send new notification')); ?> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form  action="<?php echo e(url('admin/notifications')); ?>" method="post" class="form-horizontal"  id="form" data-parsley-validate="">
                        <?php echo csrf_field(); ?>
                        <div class="box-body">
							<div class='row'>
								<div class="col-md-6">
									<div class="form-group">
										<label for="" class="col-form-label"> <?php echo e(_i('Select country')); ?> </label>
										<div>
											<select name="country" class='selectpicker show-tick show-menu-arrow form-control' data-live-search=true id="sel_country" title="<?php echo e(_i('Please select country')); ?>" multiple>
												<?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<option value="<?php echo e($country->country_id); ?>"><?php echo e($country->title); ?></option>
												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											</select>
											<?php if($errors->has('title')): ?>
												<span class="text-danger invalid-feedback" >
													<strong><?php echo e($errors->first('title')); ?></strong>
												</span>
											<?php endif; ?>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="" class="col-form-label"> <?php echo e(_i('Select city')); ?> </label>
										<div>
											<select name="city" multiple class='selectpicker show-tick show-menu-arrow form-control' data-live-search=true id="sel_city" title="<?php echo e(_i('Please select city')); ?>">
												
											</select>
											<?php if($errors->has('title')): ?>
												<span class="text-danger invalid-feedback" >
													<strong><?php echo e($errors->first('title')); ?></strong>
												</span>
											<?php endif; ?>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="" class="col-form-label"> <?php echo e(_i('Select group')); ?> </label>
										<div>
											<select name="group" class='selectpicker show-tick show-menu-arrow form-control' data-live-search=true title="<?php echo e(_i('Please select group')); ?>">
												<?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<option value="<?php echo e($group->id); ?>"><?php echo e($group->title); ?></option>
												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											</select>
											<?php if($errors->has('title')): ?>
												<span class="text-danger invalid-feedback" >
													<strong><?php echo e($errors->first('title')); ?></strong>
												</span>
											<?php endif; ?>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="" class="col-form-label"> <?php echo e(_i('Select users')); ?> </label>
										<div>
											<select name="users[]" class='selectpicker show-tick show-menu-arrow form-control' data-live-search=true multiple title="<?php echo e(_i('Please select users')); ?>">
												<?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											</select>
											<?php if($errors->has('title')): ?>
												<span class="text-danger invalid-feedback" >
													<strong><?php echo e($errors->first('title')); ?></strong>
												</span>
											<?php endif; ?>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="" class="col-form-label"> <?php echo e(_i('Select Promoters')); ?> </label>
										<div>
											<select name="users[]" class='selectpicker show-tick show-menu-arrow form-control' data-live-search=true multiple title="<?php echo e(_i('Please select Promoters')); ?>">
												<?php $__currentLoopData = $promotors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
													<option value="<?php echo e($user->user_id); ?>"><?php echo e($user->user->name ?? ''); ?></option>
												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											</select>
											<?php if($errors->has('title')): ?>
												<span class="text-danger invalid-feedback" >
													<strong><?php echo e($errors->first('title')); ?></strong>
												</span>
											<?php endif; ?>
										</div>
									</div>
								</div>
							</div>
                            <div class="form-group row">
                                <label for="" class="col-md-12 col-form-label"> <?php echo e(_i('Notification text')); ?> </label>
                                <div class="col-md-12">
                                    <textarea type="text" name="text" class="form-control<?php echo e($errors->has('text') ? ' is-invalid' : ''); ?>" required="" ></textarea>
                                    <?php if($errors->has('text')): ?>
                                        <span class="text-danger invalid-feedback" >
                                            <strong><?php echo e($errors->first('text')); ?></strong>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(_i('Close')); ?></button>
                            <button type="submit" class="btn btn-primary" >
                                <?php echo e(_i('Send')); ?>

                            </button>
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>
    <script  type="text/javascript">
        $(function() {
			$('#sel_country').change(function () {
				$.ajax({
				url: "ajax_city",
				type: "get",
				data: {
					ids:$("#sel_country").val()
				},
				success: function (res) {

					if (res.data) {
						$("#sel_city").children().remove().end();
						$("#sel_city").selectpicker("refresh");
						//if(data.length>0)
						{
							$.each(res.data,function(i,item)
							{
								$("#sel_city").append('<option value="'+i+'">'+item+'</option>')
							});
						}

						$("#sel_city").selectpicker("refresh");
					}
				}
			})

				});


            $('.datatable').DataTable({
				order: [[0,'desc']],
                processing: true,
                serverSide: true,
                ajax: '<?php echo e(url('admin/notifications')); ?>',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'user', name: 'user'},
                  	{data: 'text', name: 'text'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'options', name: 'options'},
                ]
            });
        });

		$('#form').submit(function (e) {
			e.preventDefault();
			var url = "<?php echo e(route('notification.store')); ?>";
			$.ajax({
				url: url,
				type: "post",
				data: new FormData(this),
				dataType: 'json',
				cache: false,
				contentType: false,
				processData: false,

				success: function (res) {
					if (res == 'error') {
						new Noty({
							type: 'error',
							layout: 'topRight',
							text: "<?php echo e(_i('All fields are required')); ?>",
							timeout: 2000,
							killer: true
						}).show();
					}
					if (res == 'success') {
						$('.modal').modal('hide');
						new Noty({
							type: 'success',
							layout: 'topRight',
							text: "<?php echo e(_i('Added Successfully')); ?>",
							timeout: 2000,
							killer: true
						}).show();
					}
				}
			})
		});

		$(document).on('click', '.btn-delete[data-remote]', function (e) {
			e.preventDefault();
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			var url = $(this).data('remote');
			$.ajax({
				url: url,
				type: 'DELETE',
				dataType: 'json',
				data: {method: '_DELETE', submit: true},
				success: function(res){
					if (res == 'success') {
						new Noty({
							type: 'success',
							layout: 'topRight',
							text: "<?php echo e(_i('Deleted successfully')); ?>",
							timeout: 3000,
							killer: true
						}).show();
						$('.datatable').DataTable().draw(false);
					}
				}
			})
		});
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout.index',[
'title' => _i('Notifications'),
'subtitle' => _i('Notifications'),
'activePageName' => '',
'activePageUrl' => '',
'additionalPageUrl' => url('/admin/notifications') ,
'additionalPageName' => _i('Notifications'),
] , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\mashora\app\Modules\Admin\views/admin/notifications/index.blade.php ENDPATH**/ ?>