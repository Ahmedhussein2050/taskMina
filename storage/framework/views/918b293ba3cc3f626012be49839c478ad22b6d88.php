<?php if(auth()->check()): ?>
    <?php

        $count = App\Models\AbandonedCart::where('user_id', auth()->user()->id)->count();
    ?>
    <div class="cart-wrapper">
        <a href="<?php echo e(route('cart')); ?>" id="cart">
            <i class="fas fa-shopping-basket"></i> <span class="badge cartcount"><?php echo e($count); ?> </span>

        </a>
    </div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\taskMina\app\Modules\Portal\views/layout/cart.blade.php ENDPATH**/ ?>