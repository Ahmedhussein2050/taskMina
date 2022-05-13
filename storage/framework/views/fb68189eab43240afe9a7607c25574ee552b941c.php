<div class="modal fade edit_modal" id="editdetails" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo e(_i('edit Category')); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="nav-item"><a href="#couponDetailsEdit" class="nav-link active"
                                                data-toggle="tab"><?php echo e(_i('Category Details')); ?></a></li>
                        
                        
                    </ul>
                    <form id="form_edit" class="j-forms" data-parsley-validate
                    '>
                    <?php echo csrf_field(); ?>


                    <div class="tab-content">

                        <!------------- tap  coupon details ------------------>
                        <div class="tab-pane active" id="couponDetailsEdit">
                            <div class="content">
                                <div class="divider-text gap-top-45 gap-bottom-45">
                                    <span><?php echo e(_i('Category\'s details')); ?></span>
                                </div>
                                <br>
                                <div class="alert alert-danger" style="display:none"></div>
                                <div class="form-group row">
                                    <div class="col-sm-12 text-right">
                                        <div class="row">


                                            <hr>
                                            <div class="col-sm-12 text-center">
                                                <div class="row">


                                                </div>
                                            </div>

                                            <hr>

                                            <div class="col-sm-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <div class="row">
                                                            <label
                                                                class="col-sm-2 col-form-label"><?php echo e(_i('cover')); ?></label>
                                                            <div class="col-sm-10">
                                                                <?php echo e(Form::file('cover',null,['class'=>'form-control','id'=>'cover','form' => 'form_edit','placeholder'=>_i('cover')])); ?>

                                                            </div>
                                                            <?php if($errors->has('cover')): ?>
                                                                <span class="text-danger invalid-feedback" role="alert">
                                                            <strong><?php echo e($errors->first('cover')); ?></strong>
                                                        </span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!------------- end tap coupon details ------------------>

                        <!------------- tap coupon include ------------------>
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    

                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    

                    
                    





                    



                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    

                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    

                    
                    
                    
                    
                    
                    
                    

                    
                    
                    

                    
                    
                    
                    
                    

                    
                    
                    
                    
                    
                    <!------------- end tap coupon include ------------------>

                    </div>
                    </form>


                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" form="form_edit"
                        class="btn btn-primary btn-outline-primary m-b-0 save"><?php echo e(_i('Save')); ?></button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(_i('close')); ?></button>
            </div>
        </div>
    </div>
</div>
<!---------- model for edit discount code end ---------------------->

<!---------- model for create offer---------------------->
<div class="modal fade modal_create" id="editdetailsz" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo e(_i('Add Category')); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="nav-item"><a href="#couponDetails" class="nav-link active"
                                                data-toggle="tab"><?php echo e(_i('Category Details')); ?></a></li>
                        
                        
                    </ul>
                    <form id="form_create" class="j-forms" data-parsley-validate>
                        <?php echo csrf_field(); ?>

                        <div class="tab-content">

                            <!------------- tap  coupon details ------------------>
                            <div class="tab-pane active" id="couponDetails">
                                <div class="content">
                                    <div class="divider-text gap-top-45 gap-bottom-45">
                                        <span><?php echo e(_i('Category\'s details')); ?></span>
                                    </div>
                                    <br>
                                    <div class="alert alert-danger" style="display:none"></div>
                                    <div class="form-group row">
                                        <div class="col-sm-12 text-right">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <div class="row">
                                                                <label
                                                                    class="col-sm-2 col-form-label"><?php echo e(_i('Level')); ?></label>
                                                                <div class="col-sm-10 my-1">
                                                                    <select id="rev-stars" class="form-control" name="level">
                                                                        <option value="5" selected>5</option>
                                                                        <?php for($i = 4; $i >= 1; $i--): ?>
                                                                            <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                                                                        <?php endfor; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <label
                                                                    class="col-sm-2 col-form-label"><?php echo e(_i('title')); ?></label>
                                                                <div class="col-sm-10">
                                                                    <?php echo e(Form::text('title',null,['class'=>'form-control','id'=>'title','form' => 'form_create','placeholder'=>_i('title')])); ?>

                                                                </div>
                                                                <?php if($errors->has('title')): ?>
                                                                    <span class="text-danger invalid-feedback"
                                                                          role="alert">
                                                            <strong><?php echo e($errors->first('title')); ?></strong>
                                                        </span>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <div class="row">
                                                                <label
                                                                    class="col-sm-2 col-form-label"><?php echo e(_i('cover')); ?></label>
                                                                <div class="col-sm-10">
                                                                    <?php echo e(Form::file('cover',null,['class'=>'form-control','id'=>'cover','form' => 'form_create','placeholder'=>_i('cover')])); ?>

                                                                </div>
                                                                <?php if($errors->has('cover')): ?>
                                                                    <span class="text-danger invalid-feedback"
                                                                          role="alert">
                                                            <strong><?php echo e($errors->first('cover')); ?></strong>
                                                        </span>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!------------- end tap coupon details ------------------>

                            <!------------- tap coupon include ------------------>
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        







                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        

                        
                        





                        




                        
                        



                        
                        

                        



                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        

                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        

                        
                        
                        
                        
                        
                        
                        

                        
                        
                        

                        
                        
                        
                        
                        

                        
                        
                        
                        
                        
                        <!------------- end tap coupon include ------------------>

                        </div>
                    </form>


                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" form="form_create"
                        class="btn btn-primary btn-outline-primary m-b-0 save_language"><?php echo e(_i('Save')); ?></button>

                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(_i('close')); ?></button>
            </div>
        </div>
    </div>
</div>


<?php /**PATH C:\xampp\htdocs\mashora\app\Modules\Admin\views/admin/category/model.blade.php ENDPATH**/ ?>