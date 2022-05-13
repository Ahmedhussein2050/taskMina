<nav class="navbar header-navbar pcoded-header" header-theme="theme4">
    <div class="navbar-wrapper">
        <div class="navbar-logo">

            <a class="mobile-menu" id="mobile-collapse" href="#!">
                <i class="ti-menu"></i>
            </a>
            <a href="<?php echo e(url('/')); ?>">
                <img class="img-fluid img-responsive" style="width: 160px;height: 50px" src="<?php echo e(asset('images/MASH.png')); ?>"
                     alt="Logo"/>
            </a>
            <a class="mobile-options">
                <i class="ti-more"></i>
            </a>
        </div>
        <div class="navbar-container container-fluid">
            <div>
                <ul class="nav-left">
                    <li>
                        <div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a>
                        </div>
                    </li>
                    <li>
                        <a href="#!" onclick="javascript:toggleFullScreen()">
                            <i class="ti-fullscreen"></i>
                        </a>
                    </li>
                </ul>
                <ul class="nav-right">
                    <li class="header-notification lng-dropdown">
                        <?php
                        use Xinax\LaravelGettext\Facades\LaravelGettext;$languages = App\Models\Language::where('code', '!=', LaravelGettext::getLocale())->get();
                        ?>
                        <a href="#" id="dropdown-active-item">
                            <i class="ti-world"></i> <?php echo e(_i('Language')); ?>

                            <?php
                            $selected_lang = \App\Models\Language::where('code', LaravelGettext::getLocale())->first();
                            if ($selected_lang == null) {
                                $selected_lang = \App\Models\Language::first();
                            }

                            //                            $admin = Auth()->user();

                            ?>

                            <img src="<?php echo e(asset('images/' . $selected_lang['flag'])); ?>" alt="">
                            <?php echo e(_i($selected_lang['title'])); ?>

                        </a>
                        <ul class="show-notification">
                            <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <a href="<?php echo e(url('/admin/lang/' . $lang['code'])); ?>" data-lng="en">
                                        <img src="<?php echo e(asset('images/' . $lang['flag'])); ?>"
                                             style="max-width:25px; max-height:25px; !important;" alt="">
                                        <?php echo e(_i($lang['title'])); ?>

                                    </a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </ul>
                    </li>
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    

                    


                    


                    
                    

                    
                    
                    

                    
                    

                    

                    
                    
                    <li class="user-profile header-notification">
                        <a href="#!">
                            <?php
                                $user = auth()->guard('admin')->user();
                            ?>
                            <?php if($user->first()->image): ?>)
                            <img src="<?php echo e(asset('/uploads/users/' . $user->first()->id . '/' . $user->first()->image)); ?>"
                                 alt="User-Profile-Image">
                            <?php else: ?>
                                <img src="<?php echo e(asset('admin_dashboard/assets/images/user.png')); ?>"
                                     alt="User-Profile-Image">
                            <?php endif; ?>
                            <?php echo e(auth()->guard('admin')->user()->name); ?>

                            <i class="ti-angle-down"></i>
                        </a>
                        <ul class="show-notification profile-notification">
                            <li>
                                <a href="<?php echo e(route('admin.editProfile', auth()->guard("admin")->user()->id)); ?>">
                                    <i class="ti-user"></i> <?php echo e(_i('Edit Profile')); ?>

                                </a>
                            </li>
                            
                            <li>
                                <a href="<?php echo e(url('admin/settings')); ?>">
                                    <i class="ti-settings"></i> <?php echo e(_i('Settings')); ?>

                                </a>
                            </li>
                            
                            <li>
                                <a href="<?php echo e(url('admin/logout')); ?>">
                                    <i class="ti-layout-sidebar-left"></i>
                                    <?php echo e(_i('Logout')); ?>

                                </a>
                            </li>

                        </ul>
                    </li>


                </ul>
            </div>
        </div>
    </div>
</nav>
<?php /**PATH C:\xampp\htdocs\mashora\app\Modules\Admin\views/admin/layout/header.blade.php ENDPATH**/ ?>