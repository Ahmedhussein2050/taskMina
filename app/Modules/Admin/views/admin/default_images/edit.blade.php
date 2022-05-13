<div class="modal modal_edit fade" id="edit-row">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="header"> {{_i('Edit images')}} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-form" class="form-horizontal" method="POST" data-parsley-validate="" enctype="multipart/form-data">
                    {{method_field('post')}}
                    {{csrf_field()}}
                    <div class="box-body">
                        <input type="hidden" id="image_id" name="image_id">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="image">{{_i('Favicon')}} </label>
                            <div class="col-sm-10">
                                <input type="file" name="image" id="image" class="btn btn-default" accept="image/*" >
                                <img class="img-responsive pad" id="favicon" style=" width: 100px; height: 100px;"
                                     src="">
                                <span class="text-danger invalid-feedback">
                                    <strong>{{$errors->first('image')}}</strong>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="image">{{_i('Header')}} </label>
                            <div class="col-sm-10">
                                <input type="file" name="image" id="image" class="btn btn-default" accept="image/*" >
                                <img class="img-responsive pad" id="header" style=" width: 100px; height: 100px;"
                                     src="">
                                <span class="text-danger invalid-feedback">
                                    <strong>{{$errors->first('image')}}</strong>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="image">{{_i('Footer')}} </label>
                            <div class="col-sm-10">
                                <input type="file" name="image" id="image" class="btn btn-default" accept="image/*" >
                                <img class="img-responsive pad" id="footer" style=" width: 100px; height: 100px;"
                                     src="">
                                <span class="text-danger invalid-feedback">
                                    <strong>{{$errors->first('image')}}</strong>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="image">{{_i('Not found')}} </label>
                            <div class="col-sm-10">
                                <input type="file" name="image" id="image" class="btn btn-default" accept="image/*" >
                                <img class="img-responsive pad" id="not_found" style=" width: 100px; height: 100px;"
                                     src="">
                                <span class="text-danger invalid-feedback">
                                    <strong>{{$errors->first('image')}}</strong>
                                </span>
                            </div>
                        </div>
                        
                       
                    
                        
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal"> {{_i('Close')}}
                        </button>
                        <button class="btn btn-info" type="submit" id="s_form_1"> {{_i('Save')}} </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>