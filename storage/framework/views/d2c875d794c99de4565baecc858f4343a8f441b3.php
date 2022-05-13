<?php if($errors->any()): ?>
    <?php $__env->startPush('js'); ?>
        <script>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                new Noty({
                type: 'error',
                layout: 'topRight',
                text: "<?php echo e($error); ?>",
                timeout: 5000,
                killer: true
                }).show();
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
        </script>
    <?php $__env->stopPush(); ?>
<?php endif; ?>
<?php if(Session::has('error_message')): ?>
    <?php $__env->startPush('js'); ?>
        <script>
            new Noty({
                type: 'error',
                layout: 'topRight',
                text: "<?php echo e(Session::get('error_message')); ?>",
                timeout: 2000,
                killer: true
            }).show();
        </script>
    <?php $__env->stopPush(); ?>
<?php endif; ?>
<?php if(Session::has('flash_message')): ?>
    <?php $__env->startPush('js'); ?>
        <script>
            new Noty({
                type: 'success',
                layout: 'topRight',
                text: "<?php echo e(Session::get('flash_message')); ?>",
                timeout: 2000,
                killer: true
            }).show();
        </script>
    <?php $__env->stopPush(); ?>
<?php endif; ?>
<?php $__currentLoopData = ['error', 'warning', 'success', 'info']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if(Session::has($msg)): ?>
        <?php $__env->startPush('js'); ?>
            <script>
                new Noty({
                    type: $msg,
                    layout: 'topRight',
                    text: "<?php echo e(Session::get($msg)); ?>",
                    timeout: 2000,
                    killer: true
                }).show();
            </script>
        <?php $__env->stopPush(); ?>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH C:\xampp\htdocs\taskMina\app\Modules\Admin\views/admin/layout/message.blade.php ENDPATH**/ ?>