<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
        <a class="navbar-brand d-block d-lg-none" href="#"><img src="images/logo.png" class="img-fluid" alt=""></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main_nav"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="main_nav">
            
            <ul class="navbar-nav">
                 <?php $__currentLoopData = App\Bll\Utility::mainNav(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $valuee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($valuee->products->isNotEmpty()): ?>
                        <?php
                            $brands = $valuee->getBrands($valuee->products);
                        ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="" data-bs-toggle="dropdown">
                                <?php echo e($valuee->dataa->title ?? ''); ?></a>
                            <ul class="dropdown-menu">
                                <?php if(isset($brands)): ?>
                                    <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $class = $brand->brand->getclassifications($brand->brand_id) ?? '';
                                        ?>
                                        <?php if(isset($brand)): ?>
                                            <li><a class="dropdown-item"
                                                    href="<?php echo e(route('brand', $brand->brand_id)); ?>">
                                                    <?php echo e($brand->name); ?> </a>
                                                <?php if(isset($class)): ?>
                                                    <ul class="submenu dropdown-menu">
                                                        <?php $__currentLoopData = $class; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <li><a class="dropdown-item"
                                                                    href="<?php echo e(route('classification', $classf->id)); ?>"><?php echo e($classf->data ? $classf->data->title : ''); ?></a>
                                                            </li>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </ul>
                                                <?php endif; ?>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                
                
            </ul>


        </div> <!-- navbar-collapse.// -->
    </div> <!-- container-fluid.// -->
</nav>
<?php /**PATH C:\xampp\htdocs\mashora\app\Modules\portal\views/layout/nav.blade.php ENDPATH**/ ?>