<?php $__env->startSection('content'); ?>

	<?php if($errors->all()): ?>
		<div class="alert alert-danger">
			<ul>
				<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<li><?php echo e($error); ?></li>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</ul>
		</div>
	<?php endif; ?>

	<!-- Page-body start -->
	<div class="page-body">
		<!-- Blog-card start -->
		<div class="card blog-page" id="blog">
			<div class="card-block">
				<?php echo $__env->make('admin.layout.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php echo $dataTable->table([
					'class'=> 'table table-bordered table-striped dataTable text-center'
				],true); ?>

			</div>
		</div>
	</div>
	<?php echo $__env->make('admin.category.model' , ['categories' => $categories , 'users' => $users], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make("admin.category.translate", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php $__env->startPush('js'); ?>
		<?php echo $dataTable->scripts(); ?>





        <script>
            $('body').on('click', '.lang_ex', function (e) {

                //  console.log($(this).data('id'),$(this).data('lang'))
                e.preventDefault();
                var transRowId = $(this).data('id');
                var lang_id = $(this).data('lang');

                $.ajax({
                    url: '<?php echo e(route('categories.get.translation')); ?>',
                    method: "get",
                    "_token": "<?php echo e(csrf_token()); ?>",
                    data: {
                        'lang_id': lang_id,
                        'category_id': transRowId,
                    },
                    success: function (response) {
                        console.log(response)
                        if (response.data == 'false'){
                            $('#langedit #title').val('');
                        } else{
                            console.log(response.data);
                            $('#langedit #title').val(response.data.title);

                        }
                    }
                });
                $.ajax({
                    url: '<?php echo e(route('admin.get.lang')); ?>',
                    method: "get",
                    data: {
                        lang_id: lang_id,
                    },
                    success: function (response) {
                        $('#header').empty();
                        $('#langedit #header').text('Translate to : ' + response);
                        $('#id_data').val(transRowId);
                        $('#lang_id_data').val(lang_id);
                    }
                });
                $('body').on('submit', '#lang_submit', function (e) {
                    e.preventDefault();
                    let url = $(this).attr('action');
                    $.ajax({
                        url: url,
                        method: "post",
                        "_token": "<?php echo e(csrf_token()); ?>",
                        data: new FormData(this),
                        dataType: 'json',
                        cache       : false,
                        contentType : false,
                        processData : false,
                        success: function (response) {
                            if (response.errors){
                                $('#masages_model').empty();
                                $.each(response.errors, function(index, value) {
                                    $('#masages_model').show();
                                    $('#masages_model').append(value + "<br>");
                                });
                            }
                            if (response == 'SUCCESS'){
                                new Noty({
                                    type: 'success',
                                    layout: 'topRight',
                                    text: "<?php echo e(_i('Translated Successfully')); ?>",
                                    timeout: 2000,
                                    killer: true
                                }).show();
                                $('.modal').modal('hide');

								$('#dataTableBuilder').DataTable().ajax.reload()


                            }
                        },
                    });
                });
            });

        </script>


        <script>
			$('.percentage').on("click", function () {
				$('.amount').prop("checked", false);
				$('.item').prop("checked", false);
			});
			$('.amount').on("click", function () {
				$('.percentage').prop("checked", false);
				$('.item').prop("checked", false);
			});
			$('.item').on("click", function () {
				$('.amount').prop("checked", false);
				$('.percentage').prop("checked", false);
			});
			$(function () {
				$('.create').attr('data-toggle','modal').attr('data-target','.modal_create')
			});
			$(function () {
				$('body').on('submit','#form_create',function (e) {
                    console.log('click')
					e.preventDefault();
					var table = $('.dataTable').DataTable();
					var type = 'type';
					var formData = new FormData(this);

					$.ajax({
						url:'<?php echo e(route('categories.store')); ?>',
						method: "post",
						data: formData,
						dataType: 'json',
						cache: false,
						processData: false,
						contentType: false,
						success:function (res) {
							console.log(res);
                            $('#rev-stars').val(5).change()
                            if(res[0] == false) {
								$.each(res.errors, function(key, value){
									$('.alert-danger').show();
									$('.alert-danger').append('<p>'+value+'</p>');
								});
							} else {
								$('.modal.modal_create').modal('hide');
								$("#form_create").parsley().reset();
                                    $('#form_create')[0].reset();
                                 //  location.reload();
								//table.ajax.reload();
								$('#dataTableBuilder').DataTable().ajax.reload()
								new Noty({
									type: 'success',
									layout: 'topRight',
									text: "<?php echo e(_i('Added Successfully')); ?>",
									timeout: 2000,
									killer: true
								}).show();
							}
						},error: function(jqXHR, textStatus, errorThrown) {
							console.log(jqXHR.responseText);
						}
					})
				});
				var id = '';
				$(".edit").unbind('click');
				$('body').on('click','.edit',function (e) {
					var type = $(this).data('type');
					var category_id = $(this).data('category_id');
					var parent_id = $(this).data('parent_id');
					var store_id = $(this).data('store_id');
					var container_type = $(this).data('container_type');
					id = $(this).data('id');
					$('#type').val(type);

					$('#container_type').val(container_type);
					$('#container_type').selectpicker('refresh');
                    if(type=='brand') {
                         $('.brand_categories_filed').show();
                        $('.sub_categories_filed').hide();
                        $("#brand_parent_id").val(parent_id)
                        $("#brand_parent_id").selectpicker('refresh');
                        $(":radio[value='brand']").attr('checked', true);

                    } else if(type=='sub_category') {
                        $('.brand_categories_filed').hide();
                        $('.sub_categories_filed').show();
                        $("#sub_parent_id").val(parent_id)
                        $("#sub_parent_id").selectpicker('refresh');

                        $(":radio[value='sub_category']").attr('checked', true);

                    }
                    else {
                        console.log(type)

                        $('.sub_categories_filed').hide();
                        $('.brand_categories_filed').hide();
                        $(":radio[value='main_category']").attr('checked', true);
                    }

				});
				$(".save").unbind('click');
				$('body').on('submit','#form_edit',function (e) {
					e.preventDefault();
					var table = $('.dataTable').DataTable();
					$.ajax({
						url: '<?php echo e(url('admin/categories')); ?>/' + id,
                        method: "post",
                        "_token": "<?php echo e(csrf_token()); ?>",
                        data: new FormData(this),
						dataType: 'json',
						cache       : false,
						contentType : false,
						processData : false,
						success: function (res) {
							if(res[0] == false) {
								$.each(res.errors, function(key, value){
									$('.alert-danger').show();
									$('.alert-danger').append('<p>'+value+'</p>');
								});
							} else {
								$('.modal.edit_modal').modal('hide');
 								$('#dataTableBuilder').DataTable().ajax.reload();
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
				});
			});




            $('input[name=type]').change(function(){
                if($(this).val()=='sub_category') {
                    $('.brand_categories_filed').hide();
                    $('.sub_categories_filed').show();
                } else if($(this).val()=='brand') {
                    $('.brand_categories_filed').show();
                    $('.sub_categories_filed').hide();
                }else {
                    $('.sub_categories_filed').hide();
                    $('.brand_categories_filed').hide();

                }
            });
		</script>
	<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.index',
[
	'title' => _i('Category'),
	'subtitle' => _i('Category'),
	'activePageName' => _i('Category'),
	'activePageUrl' => route('categories.index'),
	'additionalPageName' => '',
	'additionalPageUrl' => '' ,
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\mashora\app\Modules\Admin\views/admin/category/index.blade.php ENDPATH**/ ?>