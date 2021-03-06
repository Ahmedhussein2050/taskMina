

<?php $__env->startPush('css'); ?>
    <style>
        .card-block ul li:hover a {
            font-weight: bold;
            width: 100%;
        }
        .card-block ul li a{
            /* font-size: 30px; */
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <section class="content">

        <div class="row">
            <div class="col-md-6 col-xl-3">
                <div class="card client-blocks primary-border">
                    <div class="card-block">
                        <a href="<?php echo e(url('admin/')); ?>"><h5><?php echo e(_i('Users')); ?></h5></a>
                        <ul>
                            <li style="float: left; color: #8CDDCD; ">
                                <i class="icofont icofont-ui-user-group "></i>
                            </li>
                            <li class="text-right ">
                                <a  href="<?php echo e(url('admin/')); ?>" style="color: #8CDDCD;" ><?php echo e($users); ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card client-blocks warning-border">
                    <div class="card-block">
                        <a href="<?php echo e(url('admin/admin')); ?>"><h5><?php echo e(_i('Admins')); ?></h5></a>
                        <ul>
                            <li style="float: left">
                                <i class="icofont icofont-ui-user-group text-warning"></i>
                            </li>
                            <li class="text-right text-warning">
                                <a class="text-warning" href="<?php echo e(url('admin/admin')); ?>" ><?php echo e($admins); ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card client-blocks warning-border">
                    <div class="card-block">
                        <a href="<?php echo e(url('admin/')); ?>"><h5><?php echo e(_i('Contacts')); ?></h5></a>
                        <ul>
                            <li style="float: left">
                                <i class="icofont icofont-envelope-open text-warning"></i>
                            </li>
                            <li class="text-right">
                                <a class="text-warning" href="<?php echo e(url('admin/')); ?>" ><?php echo e($contacts); ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>

    </section>
































































































































































































































































































































































































































































































































































<?php $__env->stopSection(); ?>


































































































































































































































































<?php echo $__env->make('admin.layout.index',[
	'title' => _i('Home'),
	'activePageName' => _i('Home'),
	'activePageUrl' => '',
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\taskMina\app\Modules\Admin\views/admin/dashboard.blade.php ENDPATH**/ ?>