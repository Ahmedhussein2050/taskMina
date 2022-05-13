<section class="sections-slider py-5">
    <div class="container">
        <div class="section-title mb-3"><?php echo e(_i('categories')); ?></div>
        <div class="products-slider">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($category->dataa != null): ?>
                    <div class="single-section-item">
                        <a href="<?php echo e(route('category', $category->id)); ?>">
                            <div class="item-icon">
                                <img src="<?php echo e(asset($category->icon)); ?>g" alt="" class="img-fluid" loading="lazy">
                            </div>
                            <h3 class="item-title">
                                <?php echo e($category->dataa->title); ?>

                            </h3>
                        </a>
                    </div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php /**PATH C:\xampp\htdocs\taskMina\app\Modules\Portal\views/portal/include/category.blade.php ENDPATH**/ ?>