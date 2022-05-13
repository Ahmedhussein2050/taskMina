

<?php $__env->startPush('css'); ?>
    <style>
        .blog-page {
            margin: 43px;
            height: 200px;
        }

        h3 i {
            font-size: 45px !important;
        }

        .counter-card-1 [class*="card-"] div > i,
        .counter-card-2 [class*="card-"] div > i,
        .counter-card-3 [class*="card-"] div > i {
            font-size: 30px;
            color: #1abc9c !important;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-body">
        <div class="row">
            <div class="col-md-12 col-xl-4">
                <div class="card counter-card-1">
                    <div class="card-block-big d-flex justify-content-between">
                        <div>
                            <h3><a href="<?php echo e(url('admin/settings/get')); ?>"
                                   class="text-primary"><?php echo e(_i('Basic Settings')); ?></a></h3>
                            <p><?php echo e(_i('Link, logo, name, location')); ?></p>
                            <div class="progress ">
                                <div class="progress-bar progress-bar-striped progress-xs progress-bar-pink"
                                     role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0"
                                     aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div>
                            <i class="icofont icofont-gear"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-xl-4">
                <div class="card counter-card-1">
                    <div class="card-block-big d-flex justify-content-between">
                        <div>
                            <h3><a href="<?php echo e(url('admin/shipping')); ?>"
                                   class="text-primary"><?php echo e(_i('Shipping Settings')); ?></a></h3>
                            <p><?php echo e(_i('setting')); ?></p>
                            <div class="progress ">
                                <div class="progress-bar progress-bar-striped progress-xs progress-bar-pink"
                                     role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0"
                                     aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div>
                            <i class="icofont icofont-gear"></i>
                        </div>
                    </div>
                </div>
            </div>

            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            

            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            

            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            

            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            

            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            

            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            

            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            

            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            

        </div>

    </div>
    
    <div class="page-header">
        <div class="page-header-title">
            <h4><?php echo e(_i('Advanced settings')); ?></h4>
        </div>
    </div>
    <div class="page-body">
        <!-- Blog-card group-widget start -->
        <div class="row">
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            

            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            

            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            

            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            

        </div>
    </div>
    

    <div class="page-header">
        <div class="page-header-title">
            <h4><?php echo e(_i('Media')); ?></h4>
        </div>
    </div>
    <div class="page-body">
        <!-- Blog-card group-widget start -->
        <div class="row">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Sections')): ?>
                <div class="col-md-12 col-xl-4">
                    <div class="card counter-card-1">
                        <div class="card-block-big d-flex justify-content-between">
                            <div>
                                <h3>
                                    <a href="<?php echo e(route('section.index', 'home_sections')); ?>"
                                       class="text-primary"><?php echo e(_i('Home Sections')); ?></a>
                                </h3>
                                <p><?php echo e(_i('Control Home Page Sections')); ?></p>
                                <div class="progress ">
                                    <div class="progress-bar progress-bar-striped progress-xs progress-bar-pink"
                                         role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0"
                                         aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div>
                                <i class="icofont icofont-pencil-alt-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="col-md-12 col-xl-4">
                <div class="card counter-card-1">
                    <div class="card-block-big d-flex justify-content-between">
                        <div>
                            <h3>
                                <a href="<?php echo e(url('admin/settings/banners')); ?>"
                                   class="text-primary"><?php echo e(_i('Banners')); ?></a>
                            </h3>
                            <p><?php echo e(_i('Show banners to customers in the store')); ?></p>
                            <div class="progress ">
                                <div class="progress-bar progress-bar-striped progress-xs progress-bar-pink"
                                     role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0"
                                     aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div>
                            <i class="icofont icofont-file-image"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-xl-4">
                <div class="card counter-card-1">
                    <div class="card-block-big d-flex justify-content-between">
                        <div>
                            <h3>
                                <a href="<?php echo e(url('admin/settings/sliders')); ?>"
                                   class="text-primary"><?php echo e(_i('Sliders')); ?></a>
                            </h3>
                            <p><?php echo e(_i('Show sliders to customers in the Home Page')); ?></p>
                            <div class="progress ">
                                <div class="progress-bar progress-bar-striped progress-xs progress-bar-pink"
                                     role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0"
                                     aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div>
                            <i class="icofont icofont-files"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-xl-4">
                <div class="card counter-card-1">
                    <div class="card-block-big d-flex justify-content-between">
                        <div>
                            <h3>
                                <a href="<?php echo e(url('admin/pages')); ?>"
                                   class="text-primary"><?php echo e(_i('Pages')); ?></a>
                            </h3>
                            <p><?php echo e(_i('Control In Pages')); ?></p>
                            <div class="progress ">
                                <div class="progress-bar progress-bar-striped progress-xs progress-bar-pink"
                                     role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0"
                                     aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div>
                            <i class="icofont icofont-files"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<div class="page-header">
		<div class="page-header-title">
			<h4><?php echo e(_i('Cities')); ?></h4>
		</div>
	</div>
	<div class="page-body">
		<!-- Blog-card group-widget start -->
		<div class="row">
			<div class="col-md-12 col-xl-4">
				<div class="card counter-card-1">
					<div class="card-block-big d-flex justify-content-between">
						<div>
							<h3>
								<a href="<?php echo e(route('cities.index')); ?>"
								   class="text-primary"><?php echo e(_i('Cities')); ?></a>
							</h3>
							<p><?php echo e(_i('Control All Cities')); ?></p>
							<div class="progress ">
								<div class="progress-bar progress-bar-striped progress-xs progress-bar-pink"
									 role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0"
									 aria-valuemax="100"></div>
							</div>
						</div>
						<div>
							<i class="icofont icofont-file-image"></i>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.index',
[
	'title' => _i('Settings'),
	'subtitle' => _i('Settings'),
	'activePageName' => _i('Settings'),
	'activePageUrl' => route('settings.index'),
	'additionalPageName' => '',
	'additionalPageUrl' => route('settings.index') ,
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\mashora\app\Modules\Admin\views/admin/settings/index.blade.php ENDPATH**/ ?>