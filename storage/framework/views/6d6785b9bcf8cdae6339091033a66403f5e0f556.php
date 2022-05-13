<?php
$count = App\Models\AbandonedCart::where('user_id', auth()->user()->id)->count();
?>
<div class="cart-wrapper">
    <a href="<?php echo e(route('cart')); ?>" id="cartt"><i class="fas fa-shopping-basket"></i> <span class="badge cartcount"><?php echo e($count); ?> </span></a>

    
    <!--end shopping-cart -->
</div>
<?php /**PATH C:\xampp\htdocs\mashora\app\Modules\portal\views/layout/cart.blade.php ENDPATH**/ ?>