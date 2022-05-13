<div class="notifications-dropdown">
    <?php if(auth()->check()): ?>
        <a href="#" id="notifications">
            <div class="cart-text"><i class="fa fa-bell"></i>
                <div class="cart-badge notCount">
                    <?php echo e(\App\Bll\Utility::showNotifications()->count()); ?>

                </div>
            </div>
        </a>

        <div class="notification-wrapper">

            <div class="inner-items slimscroll">
                <?php $__empty_1 = true; $__currentLoopData = \App\Bll\Utility::showNotifications()->take(10)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $not): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="single-notification-item" id="delete-<?php echo e($not->id); ?>">

                        <div class="d-flex align-self-center justify-content-between ">
                            <?php
                                $data = json_encode($not->notificationType($not));
                            ?>
                            <a href="#" class="read" data-id="<?php echo e($not->id); ?>">
                                <h6
                                    class="text-dark notydata<?php echo e($not->id); ?> <?php if($not->read_at == null): ?> text-color1 <?php endif; ?>">
                                    <?php echo e(json_decode($data)->title); ?>

                                </h6>
                                <small class="text-muted"><?php echo e($not->created_at); ?></small>
                            </a>

                            <button href="#" class="delete-item trash" id="trash" data-id="<?php echo e($not->id); ?>"
                                data-date="<?php echo e($not->created_at); ?>"><i class="fa fa-trash"></i>
                            </button>

                        </div>
                    </div>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <h5 class="text-center"><?php echo e(_('you dont have notifications')); ?></h5>
                <?php endif; ?>
            </div>
            <?php if(\App\Bll\Utility::showNotifications()->get()->isNotEmpty()): ?>
                <a href="<?php echo e(route('showNotification')); ?>"
                    class="btn btn-color1 mt-3 py-2 w-100"><?php echo e(_i('All notifications')); ?></a>
            <?php endif; ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->startPush('js'); ?>
    <script>
        $('.notification-wrapper .trash').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var url = "<?php echo e(route('notification.trash')); ?>";
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    id: id,
                },
                success: function(res) {

                    $("#delete-" + id).remove();
                    var count = $(".notCount").html();
                    console.log(count)
                    $(".notCount").html(count - 1);
                }
            })
        })
        $('.notification-wrapper .read').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var url = "<?php echo e(route('notification.read')); ?>";
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    id: id,
                },
                success: function(res) {

                    $(".notydata" + id).removeClass("text-color1");

                }
            })
        })
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\xampp\htdocs\taskMina\app\Modules\Portal\views/layout/notification.blade.php ENDPATH**/ ?>