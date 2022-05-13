<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.products.includes.product_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php $__env->startPush('css'); ?>
        <style>
            .star-ratings-css {
                unicode-bidi: bidi-override;
                color: #c5c5c5;
                font-size: 25px;
                height: 25px;
                width: 100px;
                margin: 0 auto;
                position: relative;
                padding: 0;
                text-shadow: 0px 1px 0 #a2a2a2;
            }

            .star-ratings-css-top {
                color: #e7711b;
                padding: 0;
                position: absolute;
                z-index: 1;
                display: block;
                top: 0;
                right: 0;
                overflow: hidden;
            }

            .star-ratings-css-bottom {
                padding: 0;
                display: block;
                z-index: 0;
            }

            .star-ratings-sprite {
                background: url("https://s3-us-west-2.amazonaws.com/s.cdpn.io/2605/star-rating-sprite.png") repeat-x;
                font-size: 0;
                height: 21px;
                line-height: 0;
                overflow: hidden;
                text-indent: -999em;
                width: 110px;
                margin: 0 auto;
            }

            .star-ratings-sprite-rating {
                background: url("https://s3-us-west-2.amazonaws.com/s.cdpn.io/2605/star-rating-sprite.png") repeat-x;
                background-position: 0 100%;
                float: left;
                height: 21px;
                display: block;
            }

        </style>
    <?php $__env->stopPush(); ?>
    <div class="flash-message">
        <?php $__currentLoopData = ['danger', 'warning', 'success', 'info']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(Session::has($msg)): ?>
                <p class="alert alert-<?php echo e($msg); ?>"><?php echo e(Session::get($msg)); ?></p>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <div class="page-body">
        <div class="main-btn">
            <a data-toggle="modal" data-target="#addCountry" class="btn btn-primary"><i class="ti-plus"></i>
                <?php echo e(_i('Add New Product')); ?>

            </a>
            <a id="import" data-toggle="modal" data-target="#import-modal"
                class="btn color-white  waves-effect waves-light btn-success"><i class="ti-save-alt"></i></a>

        </div>
        <!-- Blog-card start -->
        <div class="card blog-page" id="blog">
            <div class="card-block">
                <?php echo $__env->make('admin.layout.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php echo $dataTable->table(
    [
        'class' => 'table table-bordered table-striped table-responsive text-center',
    ],
    true,
); ?>


                <?php echo $__env->make('admin.products.translate', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?php echo e(_i('Edit Products')); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="edit_form" method="POST" class="j-pro" enctype="multipart/form-data"
                        data-parsley-validate="" style="box-shadow:none; background: none">
                        <?php echo csrf_field(); ?>
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

                        <div class="j-unit">
                            <div class="j-input">
                                <label class="j-icon-left" for="tags">
                                    <i class="icofont icofont-ui-clip-board"></i>
                                </label>
                                <textarea placeholder="<?php echo e(_i('tags')); ?>" id="tags1" class="form-control" name="tags"></textarea>
                            </div>
                            <span class="text-danger">
                                <strong id="tags-error"></strong>
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
                                            $title = '';
                                            if ($category->data) {
                                                if ($category->data->where('lang_id', \App\Bll\Lang::getSelectedLangId())->first()) {
                                                    $title = $category->data->where('lang_id', \App\Bll\Lang::getSelectedLangId())->first()->title;
                                                }

                                                # code...
                                            } else {
                                                $title = $category->data->first()['title'];
                                            } ?>
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
                                <div class="form-group">
                                    <input type="text" class="form-control cost mr-2" id="skuEdit" name="sku" required=""
                                        placeholder="<?php echo e(_i('SKU')); ?>">
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="col-md-6 pr-0" data-toggle="tooltip" data-placement="top"
                                title="<?php echo e(_i('REF ID')); ?>">
                                <div class="form-group">
                                    <input type="text" class=" form-control price mr-2" id="refidEdit" name="refid"
                                        required="" placeholder="<?php echo e(_i('REF ID')); ?>">
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <div class="j-unit">

                            <div class="col-md-6 pr-0" data-toggle="tooltip" data-placement="top"
                                title="<?php echo e(_i('Image')); ?>">
                                <div class="form-group">
                                    <input type="file" class="form-control cost mr-2" name="image" id="image"
                                        placeholder="<?php echo e(_i('Photo')); ?>">
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
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-dismiss="modal"><?php echo e(_i('Close')); ?></button>
                            <button type="submit" class="btn btn-primary"><?php echo e(_i('Send')); ?></button>
                        </div>
                    </form>


                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="import-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?php echo e(_i('Import Products')); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="import_form" method="POST" class="j-pro" enctype="multipart/form-data"
                        data-parsley-validate="" style="box-shadow:none; background: none" action="">
                        
                        <div class="j-unit">
                            <div class="j-input">
                                <label class="j-icon-left" for="price">
                                    <i class="icofont icofont-ui-v-card"></i>
                                </label>
                                <input type="file" id="import" name="file" required>
                            </div>
                            <span class="text-danger">
                                <strong id="price-error"></strong>
                            </span>
                        </div>
                        <div class="j-unit">
                            <button type="button" class="btn btn-secondary"
                                data-dismiss="modal"><?php echo e(_i('Close')); ?></button>
                            <button type="submit" class="btn btn-primary"><?php echo e(_i('Start Uploading')); ?></button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <style>
        .table {
            display: table !important;
        }

        .row,
        #jobtypes_table_wrapper {
            width: 100% !important;
        }

    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>
    <?php echo $dataTable->scripts(); ?>



    <script type="text/javascript">
        //var table = window.LaravelDataTables["dataTableBuilder"];

        $(document).on('submit', '#edit_form', function(e) {
            e.preventDefault();
            let url = $('#edit_country_btn').data('url');
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
                        $('.modal').modal('hide');
                        $("#edit_form").parsley().reset();
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: "<?php echo e(_i('Updated Successfully')); ?>",
                            timeout: 2000,
                            killer: true
                        }).show();
                        setTimeout(function() {
                            // location.reload();
                            $('#dataTableBuilder').DataTable().ajax.reload()

                        }, 2000);
                    }
                }
            });
        })
        
        
        
        
        
        
        

        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        

        
        
        
        
        

        function info() {

            var url = "<?php echo e(route('products.info.store')); ?>";
            var form = new FormData(document.getElementById("add_info_form"));
            //console.log(form);
            $.ajax({
                url: url,
                type: "post",
                data: form,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: form,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,

                success: function(res) {
                    if (res.errors) {

                    }
                    if (res == 'SUCCESS') {
                        $('.modal').modal('hide');
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: "<?php echo e(_i('Added Successfully')); ?>",
                            timeout: 2000,
                            killer: true
                        }).show();
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    }
                    if (res == 'empty') {
                        // $('.modal').modal('hide');
                        new Noty({
                            type: 'error',
                            layout: 'topRight',
                            text: "<?php echo e(_i('Empty Value')); ?>",
                            timeout: 2000,
                            killer: true
                        }).show();

                    }
                }
            })
        }

        //  $('body').on('click', '#edit_country_btn', function(e) {
        //      var price = $(this).data('price');
        //      var category_id = $(this).data('category_id');
        //      var status = $(this).data('status');
        //      var start_date = $(this).data('start_date');
        //      var video = $(this).data('video');
        //      var tags = $(this).data('tags');
        //      var exclusive = $(this).data('exclusive');
        //     var id = $('#edit_form').data('id');
        //     url = $(this).data('url');
        //     $('#edit_form').attr('action', url).submit();
        //      $('#edit_form').find('input[name="price"]').val(price);
        //      $('#edit_form').find('select[name="category_id"]').val(category_id);
        //      $('#edit_form').find('select[name="status"]').val(status);
        //      $('#edit_form').find('textarea[name="tags"]').val(tags);
        //    console.log(exclusive == 1)
        //     if (exclusive == 1) {
        //        $(":checkbox[name='exclusive']").attr('checked', true);
        //    }
        //    $('#edit_form').find('input[name="start_date"]').val(start_date);
        //    $('#edit_form').find('textarea[name="video"]').val(video);
        //    $('.selectpicker').selectpicker('refresh')
        //});

        
        

        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        

        
        $(document).on('submit', '#import_form', function(e) {
            e.preventDefault();
            let url = "<?php echo e(route('products.import')); ?>"
            $.ajax({
                url: url,
                method: "POST",
                "_token": "<?php echo e(csrf_token()); ?>",
                data: new FormData(this),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function(res) {
                    if (res.errors) {
                        if (res.errors.title) {
                            $('#code-error').html(res.errors.title[0]);
                        }
                    }
                    if (res === 'success') {
                        alert('asas')
                        $('.modal').modal('hide');
                        $("#import_form").parsley().reset();
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: "<?php echo e(_i('Updated Successfully')); ?>",
                            timeout: 2000,
                            killer: true
                        }).show();
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    }
                }
            });

        });

        $('#add_form').submit(function(e) {
            e.preventDefault();
            var url = "<?php echo e(route('products.store')); ?>";

            var form = $("#add_form").serialize();
            $.ajax({
                url: url,
                type: "post",
                //data:form,
                data: new FormData(this),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,

                success: function(res) {
                    if (res.errors) {
                        if (res.errors.title) {
                            $('#title-error').html(res.errors.title[0]);
                        }
                        if (res.errors.category_id) {
                            $('#category_id-error').html(res.errors.category_id[0]);
                        }
                        if (res.errors.brand_id) {
                            $('#brand_id-error').html(res.errors.brand_id[0]);
                        }
                        if (res.errors.classification_id) {
                            $('#classification_id-error').html(res.errors.classification_id[0]);
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
                    if (res === 'success') {
                        $('.modal').modal('hide');
                        $("#add_form").parsley().reset();
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: "<?php echo e(_i('Added Successfully')); ?>",
                            timeout: 2000,
                            killer: true
                        }).show();
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    }
                }
            })
        });
        $('#add_info_form').submit(function(e) {

            console.log('AAAAAAAA');
            e.preventDefault();
            var url = "<?php echo e(route('products.info.store')); ?>";

            var form = $("#add_form").serialize();
            $.ajax({
                url: url,
                type: "post",
                //data:form,
                data: new FormData(this),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,

                success: function(res) {
                    if (res.errors) {

                    }
                    if (res == 'SUCCESS') {
                        $('.modal').modal('hide');
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: "<?php echo e(_i('Added Successfully')); ?>",
                            timeout: 2000,
                            killer: true
                        }).show();
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    }
                }
            })
        });

        $(document).on('click', '.remove-record', function(e) {
            e.preventDefault();
            let url = $(this).data('url');
            $.ajax({
                url: url,
                method: "get",
                success: function(response) {
                    if (response === 'success') {
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: "<?php echo e(_i('Deleted Successfully')); ?>",
                            timeout: 2000,
                        }).show();
                        //table.ajax.reload();
                        $('#dataTableBuilder').DataTable().ajax.reload()


                    }
                }

            })

        })
    </script>

    <script>
        $('body').on('click', '.lang_ex', function(e) {

            //  console.log($(this).data('id'),$(this).data('lang'))
            e.preventDefault();
            var transRowId = $(this).data('id');
            var lang_id = $(this).data('lang');

            $.ajax({
                url: '<?php echo e(route('products.get.translation')); ?>',
                method: "get",
                "_token": "<?php echo e(csrf_token()); ?>",
                data: {
                    'lang_id': lang_id,
                    'product_id': transRowId,
                },
                success: function(response) {
                    console.log(response)
                    if (response.data == 'false') {
                        $('#langedit #title').val('');
                        $('#langedit #label').val('');
                        $('#langedit #description').val('');
                    } else {
                        console.log(response.data);
                        $('#langedit #title').val(response.data.title);
                        $('#langedit #label').val(response.data.label);
                        $('#langedit #description').val(response.data.description);

                    }
                }
            });
            $.ajax({
                url: '<?php echo e(route('admin.get.lang')); ?>',
                method: "get",
                data: {
                    lang_id: lang_id,
                },
                success: function(response) {
                    $('#header').empty();
                    $('#langedit #header').text('Translate to : ' + response);
                    $('#id_data').val(transRowId);
                    $('#lang_id_data').val(lang_id);
                }
            });
            $('body').on('submit', '#lang_submit', function(e) {
                e.preventDefault();
                let url = $(this).attr('action');
                $.ajax({
                    url: url,
                    method: "post",
                    "_token": "<?php echo e(csrf_token()); ?>",
                    data: new FormData(this),
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.errors) {
                            $('#masages_model').empty();
                            $.each(response.errors, function(index, value) {
                                $('#masages_model').show();
                                $('#masages_model').append(value + "<br>");
                            });
                        }
                        if (response == 'SUCCESS') {
                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: "<?php echo e(_i('Translated Successfully')); ?>",
                                timeout: 2000,
                                killer: true
                            }).show();
                            $('.modal').modal('hide');
                            // window.reload();
                            $('#dataTableBuilder').DataTable().ajax.reload()

                        }
                    },
                });
            });
        });
    </script>


    <script>
        $(document).on('change', 'select.country_select', function() {
            var country_id = $(this).val();
            $.ajax({
                url: ' <?php echo e(route('countries.cities')); ?>',
                type: "post",
                //data:form,
                data: {
                    'country_id': country_id,
                },
                dataType: 'json',
                cache: false,
                success: function(res) {
                    if (res.data == []) {

                    }
                    if (res.data != []) {
                        var select = $(".selectpicker.city_selector");
                        select.find('option').remove();
                        select.selectpicker('refresh');

                        select.selectpicker({
                            title: "Please Select City"
                        });
                        $.each(res.data, function(i, obj) {
                            console.log(i, obj)
                            select.append('<option value="' + i + '">' + obj + '</option>');
                        });
                        select.selectpicker('refresh');

                    }
                }
            })
        });


        $('body').on('click', '#edit_country_btn', function(e) {

            //      var country_id = $('select.edit_country_select').val();
            //      console.log(country_id)
            //      $.ajax({
            //         url: ' <?php echo e(route('countries.cities')); ?>',
            //         type: "post",
            //data:form,
            //          data: {
            //              'country_id': country_id,
            //          },
            //          dataType: 'json',
            //           cache: false,
            //          success: function(res) {
            //               if (res.data == []) {

            //               }
            //               if (res.data != []) {
            //                   var select = $(".selectpicker.city_selector");
            //                   select.find('option').remove();
            //                   select.selectpicker('refresh');
            //
            //                    select.selectpicker({
            //                        title: "Please Select City"
            //                    });
            //                  $.each(res.data, function(i, obj) {


            //                      if (jQuery.inArray(parseInt(i), $('#edit_country_btn').data(
            ///                              'cities')) != -1) {
            //                         select.append('<option value="' + i + '" selected>' + obj +
            //                            '</option>');
            //                    } else {
            //                         select.append('<option value="' + i + '" >' + obj +
            //                            '</option>');


            //                     }
            //                 });
            //
            //                 select.selectpicker('refresh');


            //                select.selectpicker('refresh');

            //           }
            //        }
            //    })
            document.getElementById("edit_form").reset();

            let price = $(this).data('price');
            let category_id = $(this).data('category_id');
            let status = $(this).data('status');
            let start_date = $(this).data('start_date');
            let video = $(this).data('video');
            let image = $(this).data('image');
            let tags = $(this).data('tags');
            let exclusive = $(this).data('exclusive');
            let id = $('#edit_form').data('id');
            let url = $(this).data('url');
            let sku = $(this).data('sku');
            let refid = $(this).data('refid');
            // $('#edit_form').attr('action', url).submit();
            $('#edit_form').find('input[name="price"]').val(price);
            $('#edit_form').find('input[name="sku"]').val(sku);
            $('#edit_form').find('input[name="refid"]').val(refid);
            $('#edit_form').find('input[name="image"]').val(image);
            $('#edit_form').find('select[name="category_id"]').val(category_id);
            $('#edit_form').find('select[name="status"]').val(status).change();
            // $('#edit_form').find('textarea[name="tags"]').text(tags);
            $('#tags1').val(tags)
            if (exclusive == 1) {
                $(":checkbox[name='exclusive']").attr('checked', true);
            }
            $('#edit_form').find('input[name="start_date"]').val(start_date);
            $('#edit_form').find('textarea[name="video"]').val(video);
            $('.selectpicker').selectpicker('refresh');
        });

        $('body').on('click', '#info_btn', function(e) {
            e.preventDefault();
            document.getElementById("add_info_form").reset();
            //$("form[data-parsley-validate]").parsley().refresh();
            $(".info_adding_boxes").empty();
            var product_id = $(this).data('id');

            $.ajax({
                url: '<?php echo e(route('products.get.info')); ?>',
                type: "get",
                //data:form,
                data: {
                    'product_id': product_id,
                },
                success: function(res) {
                    console.log(res)
                }
                
                

                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                


                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
            })
            $('.info_adding_boxes').append('<input type="hidden" form="add_info_form" name="product_id" value="' +
                product_id + '">');
        });
        var i = 1;
        $('body').on('click', '#info_add', function(e) {
            var lang1 = $(this).data('lang1');
            var lang2 = $(this).data('lang2');

            $('#info_adding_boxes-' + lang1).append(
                ' <div class="col-md-12 row remove' + i +
                '"> <div class="col-md-10"><input   type="text"  class="form-control<?php echo e($errors->has('new_info') ? ' is-invalid' : ''); ?>" placeholder="<?php echo e(_i('Set Info Title')); ?>" name="new_info[' +
                lang1 + '][]" required></div> <div class="col-md-2"><a id="info_remove" data-lang="' + lang1 +
                '" data-i="' + i +
                '" class=" btn color-white  waves-effect waves-light btn-danger info_remove"><i class="ti-trash"></i></a></div></div>'
            );
            $('#info_adding_boxes-' + lang2).append(
                ' <div class="col-md-12 row remove' + i +
                '"> <div class="col-md-10"><input   type="text" class="form-control<?php echo e($errors->has('new_info') ? ' is-invalid' : ''); ?>"  placeholder="<?php echo e(_i('Set Info Title')); ?>" name="new_info[' +
                lang2 + '][]" required></div> <div class="col-md-2"><a id="info_remove" data-lang="' + lang2 +
                '" data-i="' + i +
                '"   class=" btn color-white  waves-effect waves-light btn-danger info_remove"><i class="ti-trash"></i></a></div></div>'
            );
            i++
        });
        $('body').on('click', '.info_remove', function(e) {
            e.preventDefault();
            var data = $(this).data('i');
            $('.remove' + data).remove();
            var old = $(this).data('j');
            if (old) {
                $('.clear' + old).remove();
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout.index',[
'title' => _i('Products'),
'subtitle' => _i('Products'),
'activePageName' => _i('Products'),
'activePageUrl' => '',
'additionalPageUrl' => '' ,
'additionalPageName' => '',
] , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\mashora\app\Modules\Admin\views/admin/products/index.blade.php ENDPATH**/ ?>