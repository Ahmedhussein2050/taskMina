<div class="modal fade" id="modal-default">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ _i('Create new service') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('service.store') }}" method='post' id='add-form'>
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mtn-2">
                                <input type="checkbox" class="js-switch" name='status' checked>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputOrder1">{{ _i('Image') }}</label>
                                <input type="file" class="form-control modal-title" name='image' accept="image/jpeg,image/jpg,image/png">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputOrder1">{{ _i('Title') }}</label>
                                <input type="text" class="form-control modal-title" name='title'>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">{{ _i('Body') }}</label>
                                <textarea class="form-control modal-name ckeditor" name='body'></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect"
                        data-dismiss="modal">{{ _i('Close') }}</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light"
                        form='add-form'>{{ _i('Save') }}</button>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="default-Modal-create">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ _i('Upload Attachment') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('service.attach') }}" method='post' id='add-attach-form' enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputOrder1">{{ _i('File:') }}</label>
                                <input type="hidden" name="service" id="service-attach-id">
                                <input type="file" class="form-control modal-title" name='file'>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect"
                        data-dismiss="modal">{{ _i('Close') }}</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light"
                        form='add-attach-form'>{{ _i('Save') }}</button>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="default-Modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ _i('Edit Service') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method='post' id='edit-form'>
                    @method('post')
                    @csrf
                    <input type="hidden" name='id' id='modal-id'>
                    <div class="box-body">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="checkbox">
                                {{_i('Status')}}
                            </label>
                            <div class="checkbox-fade fade-in-primary col-sm-6">
                                <label>
                                    <input type="checkbox" name="status" value="1" class='status'>
                                    <span class="cr">
									<i class="cr-icon icofont icofont-ui-check txt-primary"></i>
								</span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class=" col-sm-3 col-form-label">{{ _i('Image') }} </label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control modal-price" name='image'  accept="image/jpeg,image/jpg,image/png">
                                <img style="width: 150px" id="image_service" class="img-thumbnail" src="">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect"
                        data-dismiss="modal">{{ _i('Close') }}</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light"
                        form='edit-form'>{{ _i('Save') }}</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modal_create" id="langedit">
    <div class="modal-dialog" role="document">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="header"> {{_i('Trans To')}} : </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('services.store.translation')}}" method="post" class="form-horizontal"
                          id="lang_submit" data-parsley-validate="">
                        @csrf
                        <input type="hidden" name="id" id="id_data" value="">
                        <input type="hidden" name="lang_id" id="lang_id_data" value="">
                        <div class="form-group">
                            <label for="exampleInputEmail1">{{ _i('Title') }}</label>
                            <input type="text" class="form-control modal-title chek" name='title'>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">{{ _i('Body') }}</label>
                            <textarea class="form-control modal-body ckeditor" name='body' id='editor1'></textarea>
                        </div>
                        <!-- /.box-body -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">{{_i('Close')}}</button>
                            <button type="submit" class="btn btn-primary">
                                {{_i('Save')}}
                            </button>
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
