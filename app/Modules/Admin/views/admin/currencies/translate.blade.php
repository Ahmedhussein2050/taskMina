<div class="modal fade " id="langedit" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
    style="margin-top:40px;">
    <div class="modal-dialog" role="document">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-light" id="header"> {{ _i('Trans To') }} : </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('currencies.store.translation') }}" method="post"
                        class="form-horizontal" id="lang_submit" data-parsley-validate="">
                        {{ method_field('post') }}
                        {{ csrf_field() }}
                        <input type="hidden" name="id" id="id_data" value="">
                        <input type="hidden" name="lang_id" id="lang_id_data" value="">
                        <div class="box-body">
                            <div class="form-group row">
                                <label for="" class="col-sm-2 control-label "> {{ _i('Name') }} </label>
                                <div class="col-md-10">
                                    <input type="text" name="name" value=""
                                        class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                        required="" id="name">
                                    <span class="text-danger">
                                        <strong id="name-error"></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-2 control-label "> {{ _i('Short Name') }} </label>
                                <div class="col-md-10">
                                    <input type="text" name="short_name" value=""
                                        class="form-control{{ $errors->has('short_name') ? ' is-invalid' : '' }}"
                                        required="" id="short_name">
                                    <span class="text-danger">
                                        <strong id="short_name-error"></strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{ _i('Close') }}</button>
                            <button type="submit" class="btn btn-primary">
                                {{ _i('Save') }}
                            </button>
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
