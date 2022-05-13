<script>
    $(document).ready(function(){
        $('.remove-record').click(function() {
            var id = $(this).attr('data-id');
            var url = $(this).attr('data-url');
            var token = '<?php echo e(csrf_token()); ?>';
            $(".remove-record-model").attr("action",url);
            $('body').find('.remove-record-model').append('<input name="_token" type="hidden" value="'+ token +'">');
            $('body').find('.remove-record-model').append('<input name="_method" type="hidden" value="DELETE">');
            $('body').find('.remove-record-model').append('<input name="id" type="hidden" value="'+ id +'">');
        });
        $('.remove-data-from-delete-form').click(function() {
            $('body').find('.remove-record-model').find( "input" ).remove();
        });
        $('.modal').click(function() {
            // $('body').find('.remove-record-model').find( "input" ).remove();
        });
    });
</script>

<?php
    use App\Modules\Admin\Models\Products\Category;$categories = Category::select('categories.*', 'title')
            ->join('categories_data', 'categories.id', 'categories_data.category_id')
            //->where('parent_id', NULL)
            ->where('lang_id', \App\Bll\Lang::getSelectedLangId())
            ->orderBy('number', 'asc')
            ->get();

    $users = \App\Models\User::get();
?>

<button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"  title=" '._i('Translation').' ">
    <span class="ti ti-settings"></span>
</button>
<ul class="dropdown-menu" style="right: auto; left: 0; width: 5em; " >
    <?php $__currentLoopData = \App\Bll\Lang::getLanguages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <li ><a href="#" data-toggle="modal" data-target="#langedit" class="lang_ex" data-id="<?php echo e($id); ?>" data-lang="<?php echo e($lang->id); ?>" style="display: block; padding: 5px 10px 10px;"><?php echo e($lang->title); ?></a></li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>

<a href="categories/<?php echo e($id); ?>/edit" data-target=".edit_modal" data-toggle="modal" class="edit btn waves-effect waves-light btn-primary" data-id="<?php echo e($id); ?>" data-type="<?php echo e($type); ?>" data-container_type="<?php echo e($container_type); ?>" data-icon="<?php echo e($icon); ?>"
>

    <i class="ti-pencil-alt"></i>
</a>







<a class="btn btn-danger waves-effect waves-light remove-record" data-toggle="modal" data-url="<?php echo e(route('categories.destroy', $id)); ?>" data-id="<?php echo e($id); ?>" data-target="#custom-width-modal" style="color: white;">
    <i class="ti-trash"></i>
</a>

<form action="" method="POST" class="remove-record-model">
    <div id="custom-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog" style="width:55%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="custom-width-modalLabel"><?php echo e(_i('Delete')); ?></h4>
                </div>
                <div class="modal-body">
                    <h4><?php echo e(_i('Are you sure to delete this one?')); ?></h4>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-default waves-effect remove-data-from-delete-form" data-dismiss="modal"><?php echo e(_i('cancel')); ?></button>
                    <button type="submit" class="btn btn-danger waves-effect waves-light"><?php echo e(_i('delete')); ?></button>
                </div>
            </div>
        </div>
    </div>
</form>
<?php /**PATH C:\xampp\htdocs\mashora\app\Modules\Admin\views/admin/category/btn/delete.blade.php ENDPATH**/ ?>