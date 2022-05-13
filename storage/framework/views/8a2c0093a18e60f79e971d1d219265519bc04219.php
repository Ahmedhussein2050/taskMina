<div class="single-product">
    <a href="<?php echo e(route('home_product.show', $product->id)); ?>" class="product-img"><img
            src="<?php echo e(asset($product->image)); ?>" alt="" class="img-fluid"></a>
    <div class="product-title">
        <a href="<?php echo e(route('home_product.show', $product->id)); ?>">
            <?php if($product->detailes == null): ?>
                <?php echo e($product->product_details ? $product->product_details->first()->title : ''); ?>

            <?php else: ?>
                <?php echo e($product->detailes ? $product->detailes->title : ''); ?>

            <?php endif; ?>
        </a>
    </div>
    <div class="fixed-button-options">
        <div class="product-prices">
            <div class="regular-price"><?php echo e($product->getPriceWithTax($product->price)); ?> <?php echo e(_i('SAR')); ?></div>

        </div>
        <div class="buttons">
            <a href="" data-id="<?php echo e($product->id); ?>" data-price="<?php echo e($product->getPriceWithTax($product->price)); ?>"
                class="add-to-cart"><?php echo e(_i('Add to cart')); ?></a>
            <a href="" class="add-to-fav"><i class="fa fa-heart-o"></i></a>
        </div>
    </div>
</div>

<?php /**PATH C:\xampp\htdocs\mashora\app\Modules\portal\views/portal/products/productItem.blade.php ENDPATH**/ ?>