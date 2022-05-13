<section class="sponsors  py-4 my-3">
    <div class="container">

        <div class="section-title mb-3"><?php echo e(_i('Brands')); ?></div>
        <div class="sponsors-slider">
            <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="single-sponsor"><a href="<?php echo e(route('brand',$brand->id)); ?>"><img src="<?php echo e(asset($brand->image)); ?>" alt="" class="img-fluid"></a></div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php /**PATH C:\xampp\htdocs\taskMina\app\Modules\Portal\views/portal/include/brands.blade.php ENDPATH**/ ?>