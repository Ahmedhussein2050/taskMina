<?php $__env->startSection('content'); ?>

    <!-- Page-header end -->
    <!-- Page-body start -->
    <div class="page-body">
        <!-- Blog-card start -->
        <div class="card">

            <div class="card-title">
                <h5><?php echo e(_i('Edit Product')); ?></h5>
            </div>

            <div class="card-block">
                <form id="edit_form" action="<?php echo e(route('products.update', $product->id)); ?>" method="POST" class="form-horizontal" enctype="multipart/form-data"
                      data-parsley-validate="" style="box-shadow:none; background: none">
                    <?php echo csrf_field(); ?>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="price">
                            <i class="icofont icofont-ui-v-card"></i>
                            <?php echo e(_i(' Price:')); ?>

                        </label>
                        <input class="form-control col-sm-8" value="<?php echo e($product->price); ?>" type="text" step=".01"
                               id="price" name="price"
                               placeholder="Price" required>
                        <span class="text-danger">
                                <strong id="price-error"></strong>
                            </span>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="tags">
                            <i class="icofont icofont-ui-clip-board"></i>
                            <?php echo e(_i(' Tags:')); ?>

                        </label>
                        <textarea placeholder="<?php echo e(_i('tags')); ?>" id="tags1" class="form-control col-sm-8"
                                  name="tags"><?php echo e($product->tags); ?></textarea>

                        <span class="text-danger">
                                <strong id="tags-error"></strong>
                            </span>
                    </div>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $levelCategories): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">
                                <?php echo e(_i('Choose category:')); ?>

                            </label>
                            <select class="form-control selectpicker category_id col-sm-8" data-live-search="true"
                                    name="category[]">
                                <option disabled selected value="-1">
                                    <?php echo e('Categories from level: ' . $levelCategories->first()->level); ?></option>
                                <?php $__currentLoopData = $levelCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                    $title = '';
                                    if ($category->data) {
                                        if ($category->data->where('lang_id', \App\Bll\Lang::getSelectedLangId())->first()) {
                                            $title = $category->data->where('lang_id', \App\Bll\Lang::getSelectedLangId())->first()->title;
                                        }

                                        # code...
                                    } else {
                                        $title = $category->data->first()['title'];
                                    } ?>
                                    <option
                                        value="<?php echo e($category->id); ?>" <?php echo e($cats->where('level', $category->level)->first()?$cats->where('level', $category->level)->first()->id == $category->id? 'Selected': '': ''); ?>><?php echo e($title? :'title not translated'); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <span class="text-danger">
                                    <strong id="category_id-error"></strong>
                                </span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">
                            <?php echo e(_i('Choose Brand:')); ?>

                        </label>
                        <select class="form-control selectpicker category_id col-sm-8" data-live-search="true"
                                name="brand_id">
                            <option disabled selected value="-1">
                                <?php echo e(_i('Brand: ')); ?></option>
                            <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option
                                    value="<?php echo e($brand->id); ?>" <?php echo e($brand->id == $product->brand_id? 'Selected': ''); ?>><?php echo e($brand->name? : 'name not translated'); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <span class="text-danger">
                                    <strong id="brand_id-error"></strong>
                                </span>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">
                            <?php echo e(_i('Choose Class:')); ?>

                        </label>
                        <select class="form-control selectpicker category_id col-sm-8" data-live-search="true"
                                name="class_id">
                            <option disabled selected value="-1">
                                <?php echo e(_i('Class: ')); ?></option>
                            <?php $__currentLoopData = $classifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option
                                    value="<?php echo e($class->id); ?>" <?php echo e($class->id == $product->classification_id? 'Selected': ''); ?>><?php echo e($class->title? :'title not translated'); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <span class="text-danger">
                                    <strong id="class_id-error"></strong>
                                </span>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">
                            <?php echo e(_i('Choose:')); ?>

                        </label>
                        <select class="form-control selectpicker category_id col-sm-8" data-live-search="true"
                                name="status">
                            <option disabled selected value="-1">
                                <?php echo e(_i('Availability: ')); ?></option>
                            <option
                                value="available" <?php echo e($product->status == 'available'? 'Selected': ''); ?>><?php echo e(_i('Available')); ?></option>
                            <option
                                value="unavailable" <?php echo e($product->status == 'unavailable'? 'Selected': ''); ?>><?php echo e(_i('Unavailable')); ?></option>
                        </select>
                        <span class="text-danger">
                                <strong id="status-error"></strong>
                            </span>
                    </div>
                    <div class="form-group row">
                        <label for="exclusive" class="col-sm-2 col-form-label">
                            <i><?php echo e(_i('Exclusive:')); ?></i>
                        </label>
                        <input type="checkbox" id="exclusive" name="exclusive" class="my-2"
                               placeholder="exclusive" value="1" <?php echo e($product->exclusive == 1? 'checked': ''); ?>>
                        <span class="text-danger">
                                <strong id="exclusive-error"></strong>
                            </span>
                    </div>
                    <div class="text-danger">
                        <strong id="create_prod_errors"></strong>
                    </div>
                    <div class="row">
                        <div class="col-md-6 pr-0" data-toggle="tooltip" data-placement="top"
                             title="<?php echo e(_i('SKU')); ?>">
                            <label for="exclusive" class="col-sm-2 col-form-label">
                                <i><?php echo e(_i('SKU:')); ?></i>
                            </label>
                            <div class="form-group">
                                <input value="<?php echo e($product->sku); ?>" type="text" class="form-control cost mr-2" id="skuEdit" name="sku" required=""
                                       placeholder="<?php echo e(_i('SKU')); ?>">
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-6 pr-0" data-toggle="tooltip" data-placement="top"
                             title="<?php echo e(_i('REF ID')); ?>">
                            <label for="exclusive" class="col-sm-2 col-form-label">
                                <i><?php echo e(_i('REF ID:')); ?></i>
                            </label>
                            <div class="form-group">
                                <input value="<?php echo e($product->refid); ?>" type="text" class=" form-control price mr-2" id="refidEdit" name="refid"
                                       required="" placeholder="<?php echo e(_i('REF ID')); ?>">
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="j-unit">

                        <div class="col-md-6 pr-0" data-toggle="tooltip" data-placement="top"
                             title="<?php echo e(_i('Image')); ?>">
                            <label for="exclusive" class="col-sm-2 col-form-label">
                                <i><?php echo e(_i('Image:')); ?></i>
                            </label>
                            <div class="form-group">
                                <input type="file" class="form-control cost mr-2" name="image" id="image"
                                       placeholder="<?php echo e(_i('Photo')); ?>">
                                <img class="img-fluid" src="<?php echo e(asset($product->image)); ?>" alt="">
                                <div class="clearfix"></div>
                            </div>
                        </div>

                    </div>
                    <div class="j-unit">
                        <div class="j-input">
                            <label class="j-icon-left" for="title">
                                <i class="icofont icofont-ui-video-play"></i>
                            </label>
                            <textarea placeholder="<?php echo e(_i('Video')); ?>" id="video" class="form-control"
                                      name="video"></textarea>
                        </div>
                        <span class="text-danger">
                                <strong id="description-error"></strong>
                            </span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal"><?php echo e(_i('Close')); ?></button>
                        <button type="submit" class="btn btn-primary"><?php echo e(_i('Send')); ?></button>
                    </div>
                </form>

            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
    <script>

        $(document).on('submit', '#edit_form', function(e) {
            e.preventDefault();
            let url = $(this).attr('action');
            alert(url)
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>"
                }
            });
            $.ajax({
                url: url,
                method: "post",
                datatype: 'json',
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function(res) {
                    if (res.errors) {
                        if (res.errors) {
                            if (res.errors.title) {
                                $('#title-error').html(res.errors.title[0]);
                            }
                            if (res.errors.category_id) {
                                $('#category_id-error').html(res.errors.category_id[0]);
                            }
                            if (res.errors.status) {
                                $('#status-error').html(res.errors.status[0]);
                            }
                            if (res.errors.sku) {
                                $('#create_prod_errors').html(res.errors.sku[0])
                            }
                            if (res.errors.refid) {
                                $('#create_prod_errors').html(res.errors.refid[0])
                            }
                        }
                    }
                    if (res === 'success') {
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: "<?php echo e(_i('Updated Successfully')); ?>",
                            timeout: 2000,
                            killer: true
                        }).show();
                    }
                }
            });
        })


    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout.index',[
'title' => _i('Products'),
'subtitle' => _i('Products'),
'activePageName' => _i('Products'),
'activePageUrl' => '',
'additionalPageUrl' => '' ,
'additionalPageName' => '',
] , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\mashora\app\Modules\Admin\views/admin/products/edit.blade.php ENDPATH**/ ?>