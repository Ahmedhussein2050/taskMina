<?php if(session('success')): ?>

    <script>
        new Noty({
            type: 'success',
            layout: 'topRight',
            text: "<?php echo e(session('success')); ?>",
            timeout: 2000,
            killer: true
        }).show();
    </script>

<?php endif; ?>
<?php if(session('error')): ?>

    <script>
        new Noty({
            type: 'error',
            layout: 'topRight',
            text: "<?php echo e(session('error')); ?>",
            timeout: 2000,
            killer: true
        }).show();
    </script>

<?php endif; ?>

<?php if(session('warning')): ?>

    <script>
        new Noty({
            type: 'warning',
            layout: 'topRight',
            text: "<?php echo e(session('warning')); ?>",
            timeout: 2000,
            killer: true
        }).show();
    </script>

<?php endif; ?><?php /**PATH C:\xampp\htdocs\mashora\app\Modules\Admin\views/admin/layout/session.blade.php ENDPATH**/ ?>