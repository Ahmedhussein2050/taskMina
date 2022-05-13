
<?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($loop->index == 1): ?>
        <?php if(isset($category) && count($category->products) > 0): ?>
            <section class="store-sections mt-5">
                <div class="container">

                    <div class="five_items_carousel">
                        <?php if($category->products != null): ?>
                            <?php
                                $items = count($category->products) >= 5 ? $category->products->random(5) : $category->products;
                            ?>
                            
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    <?php endif; ?>
    <?php if($section->type == 'best_selling_products' || $section->type == 'latest_products'): ?>
        <section class="products-section py-4 my-3">
            <div class="container">
                <div class="section-title mb-3">
                    <?php if($section->is_title_displayed == 1): ?>
                        <?php echo e($section->translation ? $section->translation->title : ''); ?>

                    <?php endif; ?>
                </div>
                <div class="products-slider">
                    <?php if($section->products() != null): ?>
                        <?php $__currentLoopData = $section->products(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo $__env->make('portal.products.productItem', [
                                'product' => $product,
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    <?php elseif($section->type == 'random_products'): ?>
    <section class="products-section py-4 my-3">
        <div class="container">
            <div class="section-title mb-3">
                <?php if($section->is_title_displayed == 1): ?>
                    <?php echo e($section->translation ? $section->translation->title : ''); ?>

                <?php endif; ?>
            </div>
            <div class="products-slider">
                <?php if($section->products() != null): ?>
                    <?php $__currentLoopData = $section->products(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo $__env->make('portal.products.productItem', [
                            'product' => $product,
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php elseif($section->type == 'banner'): ?>
        <section class="adv">
            <div class="container">
                <?php $__currentLoopData = $section->banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="single-wide-ad">
                        <a href="<?php echo e($banner->link); ?>"><img src="<?php echo e(asset($banner->image)); ?>" alt=""
                                class="img-fluid w-100"></a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>
        </section>
    <?php elseif($section->type == 'banner2'): ?>
        
        <section class="adv two-ads-row mt-4">
            <div class="container">
                <?php if($section->is_title_displayed == '1'): ?>
                    <?php echo e($section->translation ? $section->translation->title : ''); ?>

                <?php endif; ?>
                <div class="row">
                    <?php $__currentLoopData = $section->banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-6">
                            <div class="single-wide-ad">
                                <a href=""><img src="<?php echo e(asset($banner->image)); ?>" alt="" class="img-fluid w-100"></a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH C:\xampp\htdocs\mashora\app\Modules\portal\views/portal/include/home_section.blade.php ENDPATH**/ ?>