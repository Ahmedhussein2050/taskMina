<?php $__env->startSection('content'); ?>
    <div style="clear:both;"></div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <!-- Zero config.table start -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-right">
                            <i class="icofont icofont-rounded-down"></i>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="dt-responsive table-responsive text-center">
                            <table id="dataTable" class="table table-bordered table-striped dataTable text-center">
                                <thead>
                                <tr role="row">
                                    <th><?php echo e(_i('Review ID')); ?></th>
                                    <th><?php echo e(_i('User Id')); ?></th>
                                    <th><?php echo e(_i('User Name')); ?></th>
                                    <th><?php echo e(_i('User Number')); ?></th>
                                    <th><?php echo e(_i('Product Id')); ?></th>
                                    <th><?php echo e(_i('Product Title')); ?></th>
                                    <th><?php echo e(_i('Review')); ?></th>
                                    <th><?php echo e(_i('Status')); ?></th>
                                    <th><?php echo e(_i('Creation Time')); ?></th>
                                    <th><?php echo e(_i('Last Edit')); ?></th>
                                    <th><?php echo e(_i('Accept Review')); ?></th>
                                    <th><?php echo e(_i('Delete')); ?></th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade modal_create" id="modal_create" aria-hidden="true">
            <div class="modal-dialog" style="top: 50% !important;" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <b><?php echo e(_i('Review Content')); ?></b>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span style="cursor: pointer" aria-hidden="true">×</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <span></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo e(_i('close')); ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $__env->startPush('css'); ?>
        <style>
            .modal_create  {
                margin: 2px auto;
                z-index: 1100 !important;
            }
        </style>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>
    <script>
        $(function () {
            CKEDITOR.editorConfig = function (config) {
                config.baseFloatZIndex = 102000;
                config.FloatingPanelsZIndex = 100005;
            };
            CKEDITOR.replace('editor1', {
                extraPlugins: 'colorbutton,colordialog',
                filebrowserUploadUrl: "<?php echo e(asset('admin_/bower_components/ckeditor/ck_upload_master')); ?>",
                filebrowserUploadMethod: 'form'
            });
        });
        $(document).ready(function () {
            table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '<?php echo e(route('reviews.admin')); ?>',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'user_id', name: 'user_id'},
                    {
                        data: 'user_name',
                        name: 'user_name',
                        searchable: true
                    },
                    {data: 'phone', name: 'phone'},
                    {data: 'product_id', name: 'product_id'},
                    {data: 'title', name: 'title'},
                    {
                        data: function (o) {
                            if (o.body.length < 17){
                                return o.body
                            }
                            else {
                                return  '<a href class="text-decoration-none read-more" data-fulldata="'+o.body+'" data-toggle="modal" data-target="#modal_create">' + o.body.substring(0, 15) + '...more</a>';
                            }
                            // return '<a href="" data-comment="' + o.comment + '" class="text-decoration-none read-more">' + o.comment.substring(0, 20) + '...more</a>'
                        }
                    },
                    {
                        data: function (o) {
                            if (o.status == 1){
                                return 'تمت الموافقة'
                            }
                            else {
                                return 'في انتظار الموافقة'
                            }


                            // return '<a href="" data-comment="' + o.comment + '" class="text-decoration-none read-more">' + o.comment.substring(0, 20) + '...more</a>'
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        searchable: false
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at',
                        searchable: false
                    },
                    {
                        data: 'change_status',
                        name: 'change_status',
                        searchable: false
                    },
                    {
                        data: 'delete',
                        name: 'delete',
                        searchable: false
                    },

                ]
            });
            $(document).on('click', '.change-status', function (event){
                event.preventDefault();
                let id = $(this).data('id')
                let link = '<?php echo e(route('reviews.status')); ?>'
                $.ajax({
                    url: link,
                    method: 'post',
                    data: {
                        "id": id,
                        "_token": "<?php echo e(csrf_token()); ?>",
                    },
                    success: function (res){
                        if (res){
                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: "<?php echo e(_i('Review Approved successfully')); ?>",
                                timeout: 2000,
                                killer: true
                            }).show();
                            table.ajax.reload();
                        }
                    }
                })
            })
            $(document).on('click', '.read-more', function (event) {
                let body = $(this).data('fulldata')
                $('.modal-body span').empty().text(body)
            })
            $(document).on('click', '.delete', function (event) {
                event.preventDefault();
                let id = $(this).data('id')
                let link = '<?php echo e(route('reviews.destroy')); ?>'
                $.ajax({
                    url: link,
                    method: 'post',
                    data: {
                        "id": id,
                        "_token": "<?php echo e(csrf_token()); ?>",
                    },
                    success: function (res){
                        if (res){
                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: "<?php echo e(_i('Review Deleted successfully')); ?>",
                                timeout: 2000,
                                killer: true
                            }).show();
                            table.ajax.reload();
                        }
                    }
                })
            })
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout.index',[
	'title' => _i('Reviews'),
	'subtitle' => _i('Reviews'),
    'activePageName' => _i('Reviews'),
	'activePageUrl' => '',
] , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\mashora\app\Modules\Admin\views/admin/reviews/index.blade.php ENDPATH**/ ?>