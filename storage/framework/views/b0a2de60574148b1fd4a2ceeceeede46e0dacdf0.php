<div class="single-product">

    <?php
        foreach ($product->imagee($product) as $img) {
            $path = preg_replace("/\.[^.]+$/", '', basename($img));
            if ($path == $product->sku) {
                $im = $img ?? null;
            }
        }
    ?>

    <a href="<?php echo e(route('home_product.show', $product->id)); ?>" class="product-img"><img src="<?php echo e(asset($im ?? '')); ?>"
            alt="" class="img-fluid"></a>
    <div class="product-title">
        <a href="<?php echo e(route('home_product.show', $product->id)); ?>">
            <?php if($product->product_details != null): ?>
                <?php echo e($product->product_details->where('lang_id', App\Bll\Lang::getSelectedLangId())->first() ? $product->product_details->where('lang_id', App\Bll\Lang::getSelectedLangId())->first()->title : $product->product_details->first()->title); ?>

            <?php endif; ?>
        </a>
    </div>
    <div class="fixed-button-options">
        <div class="product-prices">
            
            <?php if($product->discounts($product) != null): ?>
                <del><?php echo e($product->getPriceWithTax($product->price)); ?> <?php echo e(_i('SAR')); ?></del>

                 <?php if($product->discounts($product)->calc_type == 'perc'): ?>
                    <div class="sale-price">
                        <?php echo e($product->getPriceWithTax($product->price) - ($product->getPriceWithTax($product->price) * $product->discounts($product)->value) / 100); ?>

                        <?php echo e(_i('SAR')); ?></div>
                <?php else: ?>
                    <div class="sale-price">
                        <?php echo e($product->getPriceWithTax($product->price) - $product->discounts($product)->value); ?>

                        <?php echo e(_i('SAR')); ?></div>
                <?php endif; ?>
            <?php else: ?>
                <div class="regular-price"><?php echo e($product->getPriceWithTax($product->price)); ?> <?php echo e(_i('SAR')); ?>

                </div>
            <?php endif; ?>

        </div>
        <div class="buttons">
            <?php if(auth()->check()): ?>
                <a href="" class="add-to-cart  add-to-cartt" data-id="<?php echo e($product->id); ?>"
                    data-price="<?php echo e($product->getPriceWithTax($product->price)); ?>"><?php echo e(_i('Add to cart')); ?></a>
                <a href="" data-url="<?php echo e(route('favorite.create', $product->id)); ?>" class="add-to-fav addToFav"><i
                        class="fa fa-heart-o"></i></a>
            <?php else: ?>
                <a href="<?php echo e(route('home_login')); ?>" class="add-to-cart"><?php echo e(_i('Add to cart')); ?></a>
                <a href="<?php echo e(route('home_login')); ?>" data-url="<?php echo e(route('favorite.create', $product->id)); ?>"
                    class="add-to-fav "><i class="fa fa-heart-o"></i></a>
            <?php endif; ?>

        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\taskMina\app\Modules\Portal\views/portal/products/productItem.blade.php ENDPATH**/ ?>