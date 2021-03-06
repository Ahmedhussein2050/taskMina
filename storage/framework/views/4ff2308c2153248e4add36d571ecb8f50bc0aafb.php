<?php
$images = \App\Bll\Utility::get_default_images();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php if($settings != null): ?>
        <title> <?php echo e($settings->title); ?> | <?php echo e(!empty($title) ? $title : _i('title')); ?></title>
    <?php else: ?>
        <title><?php echo e(env('APP_NAME')); ?> | <?php echo e(!empty($title) ? $title : _i('Admin login')); ?></title>
    <?php endif; ?>
    <!-- HTML5 Shim and Respond.js IE9 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Phoenixcoded">
    <meta name="keywords"
        content=", Flat ui, Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="Phoenixcoded">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" href="<?php echo e(asset('uploads')); ?>/favicon.png">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css"
        href="<?php echo e(asset('admin_dashboard/bower_components/bootstrap/css/bootstrap.min.css')); ?>">
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css"
        href="<?php echo e(asset('admin_dashboard/assets/icon/themify-icons/themify-icons.css')); ?>">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('admin_dashboard/assets/icon/icofont/css/icofont.css')); ?>">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('admin_dashboard/assets/css/style.css')); ?>">
    <!-- color .css -->
</head>

<body class="fix-menu">
    <section class="login p-fixed d-flex text-center " style="background-color: #E3F0FF !important">
        <!-- Container-fluid starts -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Authentication card start -->
                    <div class="login-card card-block auth-body">

                        <form class="md-float-material" method="post" action="<?php echo e(route('admin.do.login')); ?>">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('POST'); ?>
                            <div class="auth-box">
                                <div class="row m-b-20">
                                    <div class="col-md-12">


                                        <div class=" text-center">
                                            <img src="<?php echo e(asset('images/MASH.png')); ?>" alt="logo.png"
                                                style="max-width: 200px; max-height: 200px">
                                        </div>
                                        <div class="text-center " style="padding-top:20px">

                                            <?php if($errors->all()): ?>
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <li><?php echo e($error); ?></li>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </ul>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <h3 class="text-left txt-primary"><?php echo e(_i('Login')); ?></h3>
                                    </div>
                                </div>
                                <hr />
                                <div class="input-group">
                                    <input type="email" name="email" class="form-control"
                                        placeholder="<?php echo e(_i('email')); ?>">
                                    <span class="md-line"></span>
                                </div>
                                <div class="input-group">
                                    <input type="password" name="password" class="form-control"
                                        placeholder="<?php echo e(_i('password')); ?>">
                                    <span class="md-line"></span>
                                </div>

                                <div class="row m-t-25 text-left">
                                    <div class="col-sm-7 col-xs-12">

                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" id="remember" name="remember_me" value="1">
                                                <span class="cr"><i
                                                        class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span class="text-inverse"><?php echo e(_i('remember me')); ?></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-sm-5 col-xs-12 forgot-phone text-right">
                                        <a href="<?php echo e(url('forgetPassword')); ?>"
                                            class="text-right f-w-600 text-inverse"> <?php echo e(_i('forget password')); ?>

                                            ?</a>
                                    </div>
                                </div>
                                <div class="row m-t-30">
                                    <div class="col-md-12">
                                        <button type="submit"
                                            class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20"><?php echo e(_i('login')); ?></button>
                                    </div>
                                </div>
                                <hr />
                            </div>
                        </form>
                        <!-- end of form -->
                    </div>
                    <!-- Authentication card end -->
                </div>
                <!-- end of col-sm-12 -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container-fluid -->
    </section>
    <!-- Warning Section Starts -->
    <!-- Required Jquery -->
    <script type="text/javascript" src="<?php echo e(asset('admin_dashboard/bower_components/jquery/js/jquery.min.js')); ?>">
    </script>
    <script type="text/javascript" src="<?php echo e(asset('admin_dashboard/bower_components/jquery-ui/js/jquery-ui.min.js')); ?>">
    </script>
    <script type="text/javascript" src="<?php echo e(asset('admin_dashboard/bower_components/popper.js/js/popper.min.js')); ?>">
    </script>
    <script type="text/javascript" src="<?php echo e(asset('admin_dashboard/bower_components/bootstrap/js/bootstrap.min.js')); ?>">
    </script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript"
        src="<?php echo e(asset('admin_dashboard/bower_components/jquery-slimscroll/js/jquery.slimscroll.js')); ?>"></script>
    <!-- modernizr js -->
    <script type="text/javascript" src="<?php echo e(asset('admin_dashboard/bower_components/modernizr/js/modernizr.js')); ?>">
    </script>
    <script type="text/javascript" src="<?php echo e(asset('admin_dashboard/bower_components/modernizr/js/css-scrollbars.js')); ?>">
    </script>
    <!-- i18next.min.js -->
    <script type="text/javascript" src="<?php echo e(asset('admin_dashboard/bower_components/i18next/js/i18next.min.js')); ?>">
    </script>
    <script type="text/javascript"
        src="<?php echo e(asset('admin_dashboard/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js')); ?>"></script>
    <script type="text/javascript"
        src="<?php echo e(asset('admin_dashboard/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js')); ?>">
    </script>
    <script type="text/javascript"
        src="<?php echo e(asset('admin_dashboard/bower_components/jquery-i18next/js/jquery-i18next.min.js')); ?>"></script>
    <!-- Custom js -->
    <!--<script type="text/javascript" src="assets/js/script.js"></script>-->
    <!---- color js --->
    <script type="text/javascript" src="<?php echo e(asset('admin_dashboard/assets/js/common-pages.js')); ?>"></script>
    <?php echo $__env->yieldPushContent('js'); ?>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\taskMina\app\Modules\Admin\views/admin/login.blade.php ENDPATH**/ ?>