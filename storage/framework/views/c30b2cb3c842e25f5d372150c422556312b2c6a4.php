<?php if($sliders->isNotEmpty()): ?>
    <section class="sections-nav-slider">
        <div class="container">
            <div class="main-slider">
                <div class="main-slider-trigger">
                    <?php $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="item"><img src="<?php echo e(asset($slider->image)); ?>" alt=""></div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\taskMina\app\Modules\Portal\views/portal/include/slider.blade.php ENDPATH**/ ?>