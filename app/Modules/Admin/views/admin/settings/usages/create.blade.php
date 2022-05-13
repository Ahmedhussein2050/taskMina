<div class="modal modal_create fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="header"> {{_i('Add Usage')}} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_add" class="form-horizontal" action="{{url('admin/settings/usages/store')}}" method="POST"
                      data-parsley-validate="" enctype="multipart/form-data">
                    {{method_field('post')}}
                    {{csrf_field()}}
                    <div class="box-body">
                        <!-- ================================== lang =================================== -->
                        <div class="form-group row" >
                            <label class=" col-sm-2 col-form-label"><?=_i('Language')?> </label>
                            <div class="col-sm-10">
                                <select class="form-control" name="lang_id" id="lang_add">
                                    <option selected disabled><?=_i('CHOOSE')?></option>
                                    @foreach($languages as $lang)
                                        <option value="<?=$lang['id']?>"
                                        <?=old('lang_id') == $lang['id'] ? 'selected' : ''?>><?=_i($lang['title'])?>
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- ================================== title =================================== -->
                        <div class="form-group row" >
                            <label class=" col-sm-2 col-form-label"><?=_i('Title')?> <span style="color: #F00;">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" id="title_add" class="form-control" name="name" required="" placeholder="{{_i('Place Enter Usage Title')}}">
                            </div>
                        </div>

                        <!----==========================  published ==========================--->
                        <!-- checkbox -->
                        <div class="form-group row" >
                            <label class="col-sm-2 col-form-label" for="checkbox">
                                {{_i('Publish')}}
                            </label>
                            <div class="checkbox-fade fade-in-primary col-sm-6">
                                <label>
                                    <input type="checkbox"  id="checkbox" name="published" value="1">
                                    <span class="cr">
                                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                </span>
                                </label>
                            </div>
                        </div>
                        <!-- ================================== image =================================== -->
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="image">{{_i('Image')}} <span style="color: #F00;">*</span></label>
                            <div class="col-sm-10">
                                <input type="file" name="image" id="image_add"
                                       class="btn btn-default" accept="image/*" required="">
                                <span class="text-danger invalid-feedback">
                                    <strong>{{$errors->first('image')}}</strong>
                                </span>
                            </div>
                        </div>
                        <!-- ================================== description =================================== -->
                        <div class="form-group row" >
                            <label class="col-sm-2 col-form-label" for="txtUser">
                                {{_i('Description')}} </label>
                            <div class="col-sm-10">
                                <textarea id="description_add"  class="form-control" name="description" placeholder="{{_i('Place write description here...')}}"></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- ================================Submit==================================== -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal"> {{_i('Close')}}
                        </button>
                        <button class="btn btn-info" type="submit" id="s_form_1"> {{_i('Save')}} </button>
                    </div>
                </form>

            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@push('js')
    <script>
        $(function() {
            $('#form_add').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{url('admin/settings/usages/store')}}",
                    type: "POST",
                    "_token": "{{ csrf_token() }}",
                    data: new FormData(this),
                    dataType: 'json',
                    cache       : false,
                    contentType : false,
                    processData : false,
                    success: function(response) {
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
                                text: "{{ _i('Saved Successfully')}}",
                                timeout: 2000,
                                killer: true
                            }).show();
                            $('.modal.modal_create').modal('hide');
                            table.ajax.reload();
                            $('#lang_add').val("");
                            $('#title_add').val("");
                            $('#link_add').val("");
                            $('#image_add').val("");
                            $('#checkbox').val("");
                            $('#description_add').val("");
                        }

                    }
                });
            });
        });

    </script>

@endpush
