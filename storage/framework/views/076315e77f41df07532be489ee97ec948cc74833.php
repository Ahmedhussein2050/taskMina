<?php
$setting = App\Bll\Site::getSettings();
$settings = App\Setting::first();
$lang = App\Bll\Lang::getSelectedLangId();
$lang = session('locale');
?>
<html lang="<?php echo e($lang); ?>" dir="<?php echo e($lang == 'ar' ? 'rtl' : 'ltr'); ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $__env->yieldContent('title'); ?> - <?php echo e($setting->title); ?></title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <?php if(LaravelGettext::getLocale() == 'ar'): ?>
        <link href="<?php echo e(asset('portal/css/bootstrap.rtl.min.css')); ?>" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo e(asset('portal/css/jquery-ui.css')); ?>">
        <link href=" <?php echo e(asset('portal/css/rtl.css')); ?>" rel="stylesheet">
    <?php else: ?>
        <link href="<?php echo e(asset('portal/css/bootstrap.min.css')); ?>" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo e(asset('portal/css/jquery-ui.css')); ?>">
        <link href="<?php echo e(asset('portal/css/en.css')); ?>" rel="stylesheet">
    <?php endif; ?>

</head>

<body>
    <?php echo $__env->make('layout.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldContent('breadcrumb'); ?>
    <?php echo $__env->yieldContent('main'); ?>
    <?php echo $__env->make('layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- / Pre-Loader -->
    <!-- Return to Top -->
    <a href="javascript:" id="return-to-top"><i class="fas fa-chevron-up"></i></a>

    <script src="<?php echo e(asset('portal/js/jquery-3.3.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('portal/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="https://kit.fontawesome.com/e5696f83c8.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.8/jquery.slimscroll.min.js"></script>
    <script src="<?php echo e(asset('portal/js/jquery-ui.min.js')); ?>"></script>

    <?php if(LaravelGettext::getLocale() == 'ar'): ?>
        <script src="<?php echo e(asset('portal/js/custom-rtl.js')); ?>"></script>
    <?php else: ?>
        <script src="<?php echo e(asset('portal/js/custom-en.js')); ?>"></script>
    <?php endif; ?>
    <script>
        $(function() {

            $("#results").autocomplete({
                appendTo: $("#results").parent(),
                source: "<?php echo e(route('auto_search')); ?>",
                'open': function(e, ui) {
                    $(".ui-autocomplete").append(
                        '<li><div style="text-align:center"><a href="javascript:$(\'#frm_search\').submit()"><?php echo e(_i('More')); ?></a></div></li>'
                    );
                },
            }).autocomplete("instance")._renderItem = function(ul, item) {
                var float = "float:<?php echo e($lang == 'ar' ? 'right' : 'left'); ?>";
                var item = $('<div class="image"><a href="' + item.url +
                    '"><img width="50px" height="50px" style="' + float + '" src="' + item.image + '">' +
                    item.title + '</a></div>')
                return $("<li>").append(item).appendTo(ul);
            };


        });
        $('body').on('click', '.add-to-cart', function(e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            console.log(id)
            var price = $(this).attr('data-price');
            var url = "<?php echo e(route('cart.single.add', '/id')); ?>";
            url = url.replace('/id', id)
            console.log(url)
            $.ajax({
                url: url,
                method: "post",
                data: {
                    "_token": "<?php echo e(csrf_token()); ?>",
                    id: id,
                    price: price,
                },
                success: function(response) {
                    console.log(response)
                    if (response.fail == false) {

                        Swal.fire({
                            icon: 'success',
                            title: response.message,
                        })

                        $('.cartcount').html('')
                        $('.cartcount').html(response.product)
                        new Noty({
                            type: 'error',
                            layout: 'topRight',
                            text: response.message,
                            timeout: 2000,
                            killer: true
                        }).show();

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: response.message,
                        })

                    }
                }
            });
        });
    </script>
    <?php echo $__env->yieldPushContent('js'); ?>
    <?php if($settings->chat_mode == 1): ?>
        <?php echo $settings->chat_code; ?>

    <?php endif; ?>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\mashora\app\Modules\portal\views/layout/index.blade.php ENDPATH**/ ?>