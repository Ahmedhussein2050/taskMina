<!-- Modal -->


<div class="modal fade bd-example-modal-lg" id="addCountry" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo e(_i('Add Product')); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add_form" method="POST" class="j-pro" enctype="multipart/form-data"
                    data-parsley-validate style="box-shadow:none; background: none"
                    action="<?php echo e(route('products.store')); ?>">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('POST'); ?>
                    <div class="j-unit">
                        <div class="j-input">
                            <label class="j-icon-left" for="title">
                                <i class="icofont icofont-ui-check"></i>
                            </label>
                            <input type="text" id="title" name="title" placeholder="Title" required>
                        </div>
                        <span class="text-danger">
                            <strong id="title-error"></strong>
                        </span>
                    </div>

                    <div class="row form-group" data-content="attributes">
                        <h4 class="mt-2 col-sm-12"><?php echo e(_i('Attributes')); ?></h4>
                        <?php $__currentLoopData = $attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label for="attribute_5"
                                class="col-sm-1 <?php echo e($attribute->required == 1 ? 'text-danger' : ''); ?> "><?php echo e($attribute->Data->where('lang_id', App\Bll\Lang::getSelectedLangId())->first()? $attribute->Data->where('lang_id', App\Bll\Lang::getSelectedLangId())->first()->title: $attribute->Data->first()->title); ?><?php echo e($attribute->required == 1 ? '*' : ''); ?></label>
                            <div class="j-input">
                                <select class="form-control selectpicker attribute " data-live-search="true"
                                    name="attribute[<?php echo e($attribute->id); ?>]"  <?php echo e($attribute->required == 1 ? 'reqtired' : ''); ?>>
                                    <option value=""  ><?php echo e(_i('Select Option')); ?></option>
                                    <?php $__currentLoopData = $attribute->Options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($option->id); ?>"><?php echo e($option->translation->title); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="j-unit">
                        <div class="j-input">
                            <label class="j-icon-left" for="title">
                                <i class="icofont icofont-ui-clip-board"></i>
                            </label>
                            <textarea placeholder="<?php echo e(_i('Description')); ?>" id="description" class="form-control" name="description"></textarea>
                        </div>
                        <span class="text-danger">
                            <strong id="description-error"></strong>
                        </span>
                    </div>

                    <div class="j-unit">
                        <div class="j-input">
                            <label class="j-icon-left" for="tags">
                                <i class="icofont icofont-ui-clip-board"></i>
                            </label>
                            <textarea placeholder="<?php echo e(_i('tags')); ?>" id="tags" class="form-control" name="tags"></textarea>
                        </div>
                        <span class="text-danger">
                            <strong id="tags-error"></strong>
                        </span>
                    </div>
                    <div class="j-unit">
                        <div class="j-input">
                            <label class="j-icon-left" for="related">
                                <i class="icofont icofont-ui-clip-board"></i>
                            </label>
                            <input type="text" placeholder="<?php echo e(_i('Related Products')); ?>" id="related" class="form-control" name="related">
                        </div>
                        <span class="text-danger">
                            <strong id="related-error"></strong>
                        </span>
                    </div>
                    <div class="j-unit">
                        <div class="j-input">
                            <label class="j-icon-left" for="price">
                                <i class="icofont icofont-ui-v-card"></i>
                            </label>
                            <input type="text" step=".01" id="price" name="price" placeholder="Price" required>
                        </div>
                        <span class="text-danger">
                            <strong id="price-error"></strong>
                        </span>
                    </div>
                    
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $levelCategories): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="j-unit">
                            <div class="j-input">
                                <select class="form-control selectpicker category_id" data-live-search="true"
                                    name="category[]">
                                    <option disabled selected value="-1">
                                        <?php echo e('Categories from level: ' . $levelCategories->first()->level); ?></option>
                                    <?php $__currentLoopData = $levelCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                        // $title = $category->data?$category->data->where('lang_id', \App\Bll\Lang::getSelectedLangId())->first() ? $category->data->where('lang_id', \App\Bll\Lang::getSelectedLangId())->first()->title: $category->data->first()['title']:'no data';
                                        $title = '';
                                        if ($category->data) {
                                            if ($category->data->where('lang_id', \App\Bll\Lang::getSelectedLangId())->first()) {
                                                $title = $category->data->where('lang_id', \App\Bll\Lang::getSelectedLangId())->first()->title;
                                            }

                                            # code...
                                        } else {
                                            $title = $category->data->first()['title'];
                                        }
                                        ?>
                                        <option value="<?php echo e($category->id); ?>"><?php echo e($title); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <span class="text-danger">
                                <strong id="category_id-error"></strong>
                            </span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <div class="j-unit">

                        <select name="brand_id" id="brand_id">
                            <option value=""><?php echo e(_('choose your brand')); ?></option>
                            <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option name="brand_id" value="<?php echo e($brand->id); ?>"><?php echo e($brand->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <span class="text-danger">
                            <strong id="brand_id-error"></strong>
                        </span>

                    </div>
                    <div class="j-unit">

                        <select name="classification_id" id="classification_id">
                            <option value=""><?php echo e(_('choose your Classification')); ?></option>
                            <?php $__currentLoopData = $classifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option name="brand_id" value="<?php echo e($classification->id); ?>">
                                    <?php echo e($classification->title); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <span class="text-danger">
                            <strong id="classification_id-error"></strong>
                        </span>

                    </div>

                    <div class="j-unit">

                        <div class="j-input">
                            <?php echo Form::select('status', ['available' => _i('Available'), 'unavailable' => _i('Unavailable')], null, ['class' => '  selectpicker  form-control ', 'required' => '', 'title' => _i('Availability')]); ?>

                        </div>
                        <span class="text-danger">
                            <strong id="store_id-error"></strong>
                        </span>
                    </div>
                    <div class="j-unit">
                        <div class="j-input col-md-4">
                            <label for="exclusive">
                                <i><?php echo e(_i('Exclusive')); ?></i>
                            </label>
                            <input type="checkbox" id="exclusive" name="exclusive" class="form-control"
                                placeholder="exclusive" value="1">
                        </div>
                        
                        
                        
                    </div>

                    <div class="text-danger">
                        <strong id="create_prod_errors"></strong>
                    </div>
                    <div class="row">
                        <div class="col-md-6 pr-0" data-toggle="tooltip" data-placement="top"
                            title="<?php echo e(_i('SKU')); ?>">
                            <div class="form-group">
                                <input type="text" class="form-control cost mr-2" name="sku" required=""
                                    placeholder="<?php echo e(_i('SKU')); ?>">
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-6 pr-0" data-toggle="tooltip" data-placement="top"
                            title="<?php echo e(_i('REF ID')); ?>">
                            <div class="form-group">
                                <input type="text" class=" form-control price mr-2" name="refid" required=""
                                    placeholder="<?php echo e(_i('REF ID')); ?>">
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 pr-0" data-toggle="tooltip" data-placement="top"
                            title="<?php echo e(_i('SKU')); ?>">
                            <div class="form-group">
                                <input type="file" class="form-control cost mr-2" name="image" required=""
                                    placeholder="<?php echo e(_i('Photo')); ?>" required>
                                <div class="clearfix"></div>
                            </div>
                        </div>

                    </div>
                    <div class="j-unit">
                        <div class="j-input">
                            <label class="j-icon-left" for="title">
                                <i class="icofont icofont-ui-video-play"></i>
                            </label>
                            <textarea placeholder="<?php echo e(_i('Video')); ?>" id="video" class="form-control" name="video"></textarea>
                        </div>
                        <span class="text-danger">
                            <strong id="description-error"></strong>
                        </span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(_i('Close')); ?></button>
                <button type="submit" form="add_form" class="btn btn-primary"><?php echo e(_i('Send')); ?></button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade bd-example-modal-lg" id="pics" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo e(_i('Product Images')); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <div class="products-lists">
                    <div class="content">
                        <div class="row btns-row d-flex justify-content-between">
                            <div class="col-md-12 main-btn">
                                <a class="btn btn-tiffany btn-rounded btn-xlg" id="add-btn" onclick="addNewProduct()"><i
                                        class="fa fa-plus"></i><?php echo e(_i('Add Images To Product')); ?></a>
                                <?php echo Form::open(['route' => ['products.dropzone.store', 1], 'files' => true, 'enctype' => 'multipart/form-data', 'class' => 'dropzone', 'id' => 'image-upload']); ?>

                                <div>
                                    <h6>Upload Multiple Image By Click On Box</h6>
                                </div>
                                <input id="product_id" name="product_id" type="text" hidden>
                                <?php echo Form::close(); ?>



                            </div>

                        </div>
                        <hr>
                        <div class="row btns-row d-flex justify-content-between m-b-10">


                            <div class="container">
                                <div class="row " id="images_container"
                                    style="overflow: auto;  height: 500px ">

                                </div>
                            </div>


                        </div>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(_i('Close')); ?></button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade bd-example-modal-lg" id="info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo e(_i('Product Info')); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <div class="products-lists">
                    <div class="content">
                        <div class="row btns-row d-flex justify-content-between">
                            <div class="col-md-12 main-btn">
                                <a class="btn btn-tiffany btn-rounded btn-xlg" id="add-btn"
                                    onclick="addNewProduct()"><i
                                        class="fa fa-plus"></i><?php echo e(_i('Add Info To Product')); ?></a>
                            </div>

                        </div>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <?php $__currentLoopData = \App\Bll\Lang::getLanguages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="nav-item">
                                    <a class="nav-link <?php if($lang->id == \App\Bll\Lang::getSelectedLangId()): ?> active <?php endif; ?> "
                                        id="<?php echo e($lang->id); ?>" data-toggle="tab" href="#lang-<?php echo e($lang->id); ?>"
                                        role="tab" aria-controls="home" aria-selected="true"><?php echo e($lang->title); ?></a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-2"><a id="info_add"
                                    data-lang1="<?php echo e(\App\Bll\Lang::getLanguages()->first()->id ?? 1); ?>"
                                    data-lang2="<?php echo e(\App\Bll\Lang::getLanguages()->skip(1)->first()->id ?? 2); ?>"
                                    class=" btn color-white  waves-effect waves-light btn-primary"> <i
                                        class="ti-plus">
                                    </i></a></div>

                        </ul>

                        <form id="add_info_form" method="post" class="j-pro form" data-parsley-validate=""
                            style="box-shadow:none; background: none">
                            <div class="tab-content" id="myTabContent">

                                <?php $__currentLoopData = \App\Bll\Lang::getLanguages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="tab-pane fade <?php if($lang->id == \App\Bll\Lang::getSelectedLangId()): ?> show active <?php endif; ?>"
                                        id="lang-<?php echo e($lang->id); ?>" role="tabpanel"
                                        aria-labelledby="<?php echo e($lang->id); ?>">
                                        <div class="row btns-row d-flex justify-content-between m-b-10">

                                            <div class="container text-center">

                                                <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
                                                <div class="col-md-12 info_adding_boxes"
                                                    id="info_boxes-<?php echo e($lang->id); ?>" style="overflow: auto;   ">
                                                </div>
                                                <div class="col-md-12 info_adding_boxes"
                                                    id="info_adding_boxes-<?php echo e($lang->id); ?>">

                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(_i('Close')); ?></button>
                <button onclick="info()" class="btn btn-primary"><?php echo e(_i('Save')); ?></button>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('js'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.selectpicker').selectpicker();
            $(".js-example-basic-multiple").select2();
        })
        $('body').on('click', '#images_btn', function(e) {

            var id = $(this).data('id');

            $('#product_id').val(id);
            $('#image-upload').attr('action', '<?php echo e(url('products/images/')); ?>' + '/' + id);


            Dropzone.options.imageUpload = {
                maxFilesize: 100,
                Url: '<?php echo e(url('products/images/')); ?>' + '/' + id,
                acceptedFiles: ".jpeg,.jpg,.png,.zip",

                init: function() {
                    this.on("complete", function(file) {
                        if (this.getUploadingFiles().length === 0 && this.getQueuedFiles()
                            .length === 0) {
                            get_images()
                            location.reload();
                        }
                    });
                }
            };

            

            console.log(id);

            function get_images() {
                $.ajax({
                    url: "<?php echo e(url('admin/products/images')); ?>/" + id,
                    type: "get",
                    //data:form,
                    data: {},
                    dataType: 'json',
                    cache: false,
                    success: function(res) {
                        if (res.data == null) {

                            console.log('error')
                        }
                        if (res.data != null) {


                            $('#images_container').empty();

                            for (i = 0; i < res.data.length; ++i) {
                                var flagsUrl = "<?php echo e(URL::asset('img')); ?>";
                                flagsUrl = flagsUrl.replace("img", res.data[i])

                                $('#images_container').append(
                                    ' <div class="col-md-4 text-center" id="image_container_' +
                                    flagsUrl + '">' +
                                    '                                            <img class="img-thumbnail" src="' +
                                    flagsUrl + '" alt="a picture of a cat">' +
                                    '            <button data-url="' + res.data[i] +
                                    '"  type="button" class="btn btn-outline-danger delete-drop-image"><i class="fa fa-trash-o"></i><?php echo e(_i('Delete')); ?></button>' +
                                    '                                        </div>');

                            }

                        }
                    }
                })
            }

            get_images();
        });
        $('body').on('click', '.delete-drop-image', function() {
            var _url = $(this).data('url');
            $.ajax({
                url: _url,
                method: "get",
                "_token": "<?php echo e(csrf_token()); ?>",
                data: {},
                success: function(response) {
                    console.log(response)
                    if (response.data == 'false') {

                        alert(0);

                    } else {

                        // alert('#image_container_'+response.id);
                        $('#image_container_' + response.id).remove();


                    }
                }
            });
        })

        function delete_image(url) {
            $.ajax({
                url: url,
                method: "get",
                "_token": "<?php echo e(csrf_token()); ?>",
                data: {},
                success: function(response) {
                    console.log(response)
                    if (response.data == 'false') {

                        alert(0);

                    } else {

                        // alert('#image_container_'+response.id);
                        $('#image_container_' + response.id).remove();


                    }
                }
            });
        }
    </script>
<?php $__env->stopPush(); ?>



<?php $__env->startPush('css'); ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">



    <link rel="stylesheet" href="<?php echo e(asset('AdminFlatAble/pages/j-pro/css/demo.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('AdminFlatAble/pages/j-pro/css/j-pro-modern.css')); ?>">

    <style>
        .j-pro {
            border: none;
        }

        .j-pro .j-primary-btn,
        .j-pro .j-file-button,
        .j-pro .j-secondary-btn {
            background: #1abc9c;
        }

        .j-pro .j-primary-btn:hover,
        .j-pro .j-file-button:hover,
        .j-pro .j-secondary-btn:hover {
            background: #1abc9c;
        }

        .j-pro input[type="text"]:focus,
        .j-pro input[type="password"]:focus,
        .j-pro input[type="email"]:focus,
        .j-pro input[type="search"]:focus,
        .j-pro input[type="url"]:focus,
        .j-pro textarea:focus,
        .j-pro select:focus {
            border: #1abc9c solid 2px !important;
        }

        .j-pro input[type="text"]:hover,
        .j-pro input[type="password"]:hover,
        .j-pro input[type="email"]:hover,
        .j-pro input[type="search"]:hover,
        .j-pro input[type="url"]:hover,
        .j-pro textarea:hover,
        .j-pro select:hover {
            border: #1abc9c solid 2px !important;
        }

        .card .card-header span {
            color: #fff;
        }

        .j-pro .j-tooltip,
        .j-pro .j-tooltip-image {
            background-color: #1abc9c;
        }

        .j-pro .j-tooltip-right-top:before {
            border-color: #1abc9c transparent;
        }

    </style>

    <script src="<?php echo e(asset('AdminFlatAble/pages/j-pro/js/jquery.2.2.4.min.js')); ?>"></script>
    <script src="<?php echo e(asset('AdminFlatAble/pages/j-pro/js/jquery.maskedinput.min.js')); ?>"></script>
    <script src="<?php echo e(asset('AdminFlatAble/pages/j-pro/js/jquery.j-pro.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('js'); ?>
    <script>

    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\xampp\htdocs\taskMina\app\Modules\Admin\views/admin/products/includes/product_modal.blade.php ENDPATH**/ ?>