<header>

    <div class="top-nav">
        <div class="container">
            <div class="menu-wrapper py-3 d-md-flex justify-content-between align-items-center flex-wrap">

                <div class="h-box logo">
                    <a href="<?php echo e(route('home')); ?>"><img src="<?php echo e(asset('portal/images/logo.png')); ?>" alt=""
                            class="img-fluid "> </a>
                </div>
                <div class="h-box top-search">

                    <form id="frm_search" class="search-form" method='get' action='<?php echo e(route('search')); ?>'>
                        <?php echo csrf_field(); ?>
                        <input type="text" id="results" placeholder="search about anything" class="form-control">
                        <button type="submit" class="btn btn-link"><i class="fa fa-search"></i></button>
                    </form>
                </div>
                <div class="h-box header-contacts">
                    <ul class="list-inline">
                        <li class="list-inline-item"><i class="fa fa-map-marker"></i> <?php echo e($setting->address); ?>

                        </li>
                        <li class="list-inline-item"><i class="fa fa-phone"></i> <?php echo e($setting->phone1); ?></li>
                        <li class="list-inline-item"><i class="fa fa-envelope"></i> <?php echo e($setting->email); ?> </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="main-menu">
        <div class="container">
            <div class="row">

                <div class="col-lg-9  d-lg-flex   align-items-center">
                    <?php echo $__env->make('layout.nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>

                <div class="col-lg-3  d-flex justify-content-center justify-content-lg-end align-items-center gap-4">
                    <div class="lange-links dropdown">
                        <a class="" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fa fa-globe"><?php echo e(App\Bll\Lang::get_language_title()); ?></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <?php $__currentLoopData = App\Bll\Lang::anotherLang(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><a class="dropdown-item" href="<?php echo e(route('switch.lang', $lang->code)); ?>">
                                        <?php echo e($lang->title); ?></a></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                    <div class="user-links dropdown">
                        <a class="" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fa fa-user"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <?php if(Auth::check()): ?>
                                <li><a class="dropdown-item" href="<?php echo e(route('user.profile')); ?>">
                                        <?php echo e(_i('My Account')); ?></a></li>
                                <li><a class="dropdown-item" href="<?php echo e(route('logout')); ?>"><?php echo e(_i('Logout')); ?></a>
                                </li>
                            <?php else: ?>
                                <li><a class="dropdown-item" href="<?php echo e(route('login')); ?>">
                                        <?php echo e(_i('Login')); ?></a></li>
                                <li><a class="dropdown-item" href="<?php echo e(route('register.index')); ?>">
                                        <?php echo e(_i('Register')); ?></a></li>
                            <?php endif; ?>



                        </ul>
                    </div>
                    <?php echo $__env->make('layout.notification', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php echo $__env->make('layout.cart', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <div class="wishlist"><a href="#" id="wishlist"><i class="fa fa-heart-o"></i></a></div>

                </div>
            </div>

        </div>
    </div>

</header>
<?php /**PATH C:\xampp\htdocs\mashora\app\Modules\portal\views/layout/header.blade.php ENDPATH**/ ?>