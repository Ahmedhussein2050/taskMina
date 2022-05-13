<nav class="pcoded-navbar" pcoded-header-position="relative">
    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
    <div class="pcoded-inner-navbar main-menu">
        <div class="">
            <div class="main-menu-header" hidden>
                <a href='<?php echo e(url('/')); ?>'
                    style='background-image: url(<?php if(\App\Bll\Utility::get_main_settings() != null): ?> <?php echo e(asset('uploads/settings/site_settings/' . \App\Bll\Utility::get_main_settings()->logo)); ?> <?php endif; ?>; background-repeat: no-repeat;background-position: 50% 50%;background-size: cover;display:block;width:100%;height:100%'>
                </a>
            </div>
            <div class="main-menu-content">
                <ul>
                    <li class="more-details">
                        <a href="<?php echo e(url('admin/profile')); ?>"><i
                                class="ti-user"></i><?php echo e(_i('View Profile')); ?></a>
                        <a href="<?php echo e(url('admin/settings')); ?>"><i class="ti-settings"></i><?php echo e(_i('Settings')); ?></a>
                        <a href="<?php echo e(route('admin.logout')); ?>"><i
                                class="ti-layout-sidebar-left"></i><?php echo e(_i('Logout')); ?>

                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation" menu-title-theme="theme5">
            <?php echo e(_i('MAIN NAVIGATION')); ?></div>
        <ul class="pcoded-item pcoded-left-item">

            <?php if(auth('admin')->user()->can('Dashboard')): ?>
                <li class="<?php echo e(request()->url() == route('admin.home') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.home')); ?>">
                        <span class="pcoded-micon"><i class="ti-home"></i></span>
                        <span class="pcoded-mtext" data-i18n="nav.dash.default"><?php echo e(_i('Dashboard')); ?></span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Orders')): ?>
                <li class=" <?php echo e(request()->is('admin/orders/all') ? 'active' : ''); ?>">
                    <a href="<?php echo e(url('/admin/orders/all')); ?>">
                        <span class="pcoded-micon"><i class="ti-shopping-cart"></i></span>
                        <span class="pcoded-mtext" data-i18n="nav.dash.default"><?php echo e(_i('Orders')); ?></span>
                        <span class="pcoded-mcaret"></span>
                        <span
                            class="<?php echo e(LaravelGettext::getLocale() == 'ar' ? 'pull-right-container' : 'pull-left-container'); ?>">
                            <small class="label pull-right bg-red"><?php echo e(\App\Bll\Order::get_total('orders')); ?></small>
                        </span>
                    </a>
                </li>
                <li class=" <?php echo e(request()->is('admin/orders/financial_transactions') ? 'active' : ''); ?>">
                    <a href="<?php echo e(url('/admin/orders/financial_transactions')); ?>">
                        <span class="pcoded-micon"><i class="ti-shopping-cart"></i></span>
                        <span class="pcoded-mtext"
                            data-i18n="nav.dash.default"><?php echo e(_i('Financial Transactions')); ?></span>
                        <span class="pcoded-mcaret"></span>
                        <?php if(\App\Bll\Order::get_total_updated('transactions') != 0): ?>
                            <span
                                class="<?php echo e(LaravelGettext::getLocale() == 'ar' ? 'pull-right-container' : 'pull-left-container'); ?>">
                                <small
                                    class="label pull-right bg-red"><?php echo e(\App\Bll\Order::get_total_updated('transactions')); ?></small>
                            </span>
                        <?php endif; ?>
                    </a>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Products')): ?>
                <li class="<?php echo e(request()->is('admin/categories*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(url('admin/categories')); ?>">
                        <span class="pcoded-micon"><i class="ti-menu-alt"></i></span>
                        <span class="pcoded-mtext" data-i18n="nav.dash.default"><?php echo e(_i('Categories')); ?></span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>

                <li class="<?php echo e(request()->is('admin/products*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(url('admin/products')); ?>">
                        <span class="pcoded-micon"><i class="ti-menu-alt"></i></span>
                        <span class="pcoded-mtext" data-i18n="nav.dash.default"><?php echo e(_i('Products')); ?></span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li class="<?php echo e(request()->is('admin/brands*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(url('admin/brands')); ?>">
                        <span class="pcoded-micon"><i class="ti-menu-alt"></i></span>
                        <span class="pcoded-mtext" data-i18n="nav.dash.default"><?php echo e(_i('Brands')); ?></span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li class="<?php echo e(request()->is('admin/attributes*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(url('admin/attributes')); ?>">
                        <span class="pcoded-micon"><i class="ti-menu-alt"></i></span>
                        <span class="pcoded-mtext" data-i18n="nav.dash.default"><?php echo e(_i('Attributes')); ?></span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li class="<?php echo e(request()->is('admin/contact/all*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(url('admin/contact/all')); ?>">
                        <span class="pcoded-micon"><i class="ti-menu-alt"></i></span>
                        <span class="pcoded-mtext" data-i18n="nav.dash.default"><?php echo e(_i('contact us')); ?></span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li class="<?php echo e(request()->is('admin/discounts*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(url('admin/discounts')); ?>">
                        <span class="pcoded-micon"><i class="ti-menu-alt"></i></span>
                        <span class="pcoded-mtext" data-i18n="nav.dash.default"><?php echo e(_i('Discounts')); ?></span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>

                
                
                
                
                
                
                
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Comments')): ?>
                
                
                
                
                
                
                
                <li class="<?php echo e(request()->is('admin/reviews*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(url('admin/reviews')); ?>">
                        <span class="pcoded-micon"><i class="ti-menu-alt"></i></span>
                        <span class="pcoded-mtext" data-i18n="nav.dash.default"><?php echo e(_i('Reviews')); ?></span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            <?php endif; ?>
            
            
            
            
            
            
            
            

            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Security')): ?>
                <li class="pcoded-hasmenu">
                    <a href="javascript:void(0)"><i class="fa fa-circle-o"></i>
                        <span class="pcoded-micon"><i class="ti-ticket"></i></span>
                        <span class="pcoded-mtext" data-i18n="nav.dash.default"><?php echo e(_i('Security')); ?></span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">

                        <li hidden class="<?php echo e(request()->is('admin/permission*') ? 'active' : ''); ?>">
                            <a href="<?php echo e(url('admin/permission')); ?>">
                                
                                <span class="pcoded-micon"><i class="ti-settings"></i></span>
                                <span class="pcoded-mtext" data-i18n="nav.dash.default"><?php echo e(_i('Permissions')); ?></span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="<?php echo e(request()->is('admin/role*') ? 'active' : ''); ?>">
                            <a href="<?php echo e(url('/admin/role')); ?>">
                                
                                <span class="pcoded-micon"><i class="ti-check-box"></i></span>
                                <span class="pcoded-mtext" data-i18n="nav.dash.default"><?php echo e(_i('Roles')); ?></span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="<?php echo e(request()->is('admin/admin*') ? 'active' : ''); ?>">
                            <a href="<?php echo e(url('/admin/admin')); ?>">
                                
                                <span class="pcoded-micon"><i class="ti-check-box"></i></span>
                                <span class="pcoded-mtext" data-i18n="nav.dash.default"><?php echo e(_i('Admins')); ?></span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Notifications')): ?>
                <li class="<?php echo e(request()->is('admin/notifications') ? 'active' : ''); ?>">
                    <a href="<?php echo e(url('admin/notifications')); ?>">
                        <span class="pcoded-micon"><i class="ti-menu-alt"></i></span>
                        <span class="pcoded-mtext" data-i18n="nav.dash.default"><?php echo e(_i('Notifications')); ?></span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            <?php endif; ?>

            
            
            
            
            

            
            
            
            
            
            
            

            
            

            
            
            
            
            
            
            

            
            
            

            <div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation" menu-title-theme="theme5">
                <?php echo e(_i('Setting')); ?></div>
            <ul class="pcoded-item pcoded-left-item">
                <li
                    class=" <?php echo e(request()->is('admin/settings/*') ||request()->is('admin/settings') ||request()->is('admin/content_management')? 'active': ''); ?>">
                    <a href="<?php echo e(url('/admin/settings')); ?>">
                        <span class="pcoded-micon"><i class="ti-settings"></i></span>
                        <span class="pcoded-mtext" data-i18n="nav.dash.main"><?php echo e(_i('Settings')); ?></span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li class="<?php echo e(request()->is('admin/mailing_list') ? 'active' : ''); ?>">
                    <a href="<?php echo e(url('/admin/mailing_list')); ?>">
                        <span class="pcoded-micon"><i class="ti-layout "></i></span>
                        <span class="pcoded-mtext" data-i18n="nav.dash.default"><?php echo e(_i('Mailing List')); ?></span>
                    </a>
                </li>
                <li class="<?php echo e(request()->is('admin/mailing_templates') ? 'active' : ''); ?>">
                    <a href="<?php echo e(url('/admin/mailing_templates')); ?>">
                        <span class="pcoded-micon"><i class="ti-layout "></i></span>
                        <span class="pcoded-mtext"
                            data-i18n="nav.dash.default"><?php echo e(_i('Mailing Templates')); ?></span>
                    </a>
                </li>
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                


            </ul>
        </ul>

    </div>
</nav>
<?php /**PATH C:\xampp\htdocs\taskMina\app\Modules\Admin\views/admin/layout/nav.blade.php ENDPATH**/ ?>