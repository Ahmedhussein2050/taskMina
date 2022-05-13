<div class="modal fade modal_create" id="modal_create1" aria-hidden="true">
    <div class="modal-dialog" style="top: 10% !important;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b class="model_edit_title"></b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span style="cursor: pointer" aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit_form_city" method="post" action="{{ route('cities.update') }}" data-parsley-validate="">
                @csrf
                    <div class="row">
                        <div class="col-md-6 pr-0" data-toggle="tooltip" data-placement="top" title="{{ _i('Lat') }}">
                            <div class="form-group">
                                <input id="city-lat" type="number" step="any" maxlength="10" data-parsley-maxlength="10" class="form-control cost mr-2"
                                       name="lat" required="" placeholder="{{ _i('Lat') }}">
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-6 pr-0" data-toggle="tooltip" data-placement="top" title="{{ _i('Lng') }}">
                            <div class="form-group">
                                <input id="city-lng" type="number" step="any" maxlength="10" data-parsley-maxlength="10" class="form-control price mr-2"
                                       name="lng" required="" placeholder="{{ _i('Lng') }}">
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <input id="city_id_hidden" name="city_id" type="hidden" value="">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="edit_form_city"
                        class="btn btn-primary  createBtn">{{ _i('save') }}</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ _i('close') }}</button>
            </div>
        </div>
    </div>
</div>





<div class="modal fade modal_create" id="modal_trans1" aria-hidden="true">
    <div class="modal-dialog" style="top: 10% !important;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b class="model_trans_title"></b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span style="cursor: pointer" aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="trans_form_city" method="post" action="{{ route('cities.translate') }}">
                @csrf
                <!-- Title -->
                    <div class="form-group">
                        <label for="edit_name">{{ _i('City name') }}</label>
                        <input type="hidden" name="lang" id="city-lang">
                        <input id="trans_name" type="text" class="form-control" name="city_title" required
                               maxlength="100"
                               aria-describedby="helpId">
                        <input id="city_id_hidden_trans" name="city_id" type="hidden" value="">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="trans_form_city"
                        class="btn btn-primary  createBtn">{{ _i('save') }}</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ _i('close') }}</button>
            </div>
        </div>
    </div>
</div>


@push('js')
    <script>
        $(function () {
            CKEDITOR.editorConfig = function (config) {
                config.baseFloatZIndex = 102000;
                config.FloatingPanelsZIndex = 100005;
            };
            CKEDITOR.replace('editor1', {
                extraPlugins: 'colorbutton,colordialog',
                filebrowserUploadUrl: "{{asset('admin_/bower_components/ckeditor/ck_upload_master')}}",
                filebrowserUploadMethod: 'form'
            });
        });
        $(document).ready(function () {
            let type_id;
            $(document).on('click', '.edit-btn', function (e) {
                e.preventDefault();
                $('.model_edit_title').empty()
                let lat = $(this).data('lat');
                let lng = $(this).data('lng');
                let id = $(this).data('id');
                type_id = id;
                $('#city-lat').val(lat);
                $('#city-lng').val(lng);
                $('#city_id_hidden').val(type_id)
            });

            $(document).on('click', '.trans-btn', function (e){
                e.preventDefault();
                $('.model_trans_title').empty()
                $('#city-lang').val('')
                $('#trans_name').val('')
                $('#city-lang').val('')
                let lang = $(this).data('lang')
                let name = $(this).data('name')
                let id = $(this).data('id')
                $('#city-lang').val(lang)
                $('#trans_name').val(name)
                $('#city_id_hidden_trans').val(id)
            })
            $(document).on('submit', '#edit_form_city', function (e){
                e.preventDefault();
                let url = $(this).attr('action')
                $.ajax({
                    url: url,
                    method: 'post',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: new FormData(this),
                    success: function (res){
                        if (res === 'success') {
                            $('.modal.modal_create').modal('hide');
                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: "{{ _i('Updated Successfully')}}",
                                timeout: 2000,
                                killer: true
                            }).show();
                            table.ajax.reload(null, false);
                            document.getElementById('edit_form_city').reset();
                            $("#edit_form_city").parsley().reset();
                        }
                        else {
                            new Noty({
                                type: 'warning',
                                layout: 'topRight',
                                text: "{{ _i('An Error Occurred, please try again')}}",
                                timeout: 2000,
                                killer: true
                            }).show();
                        }
                    }
                })
            })
            $(document).on('submit', '#trans_form_city', function (e) {
                let url = $(this).attr('action')
                e.preventDefault();
                $.ajax({
                    url: url,
                    method: "post",
                    data: new FormData(this),
                    cache: false,
                    contentType: false,
                    processData: false,

                    success: function (res) {
                        if (res === 'success') {
                            $('.modal.modal_create').modal('hide');
                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: "{{ _i('Updated Successfully')}}",
                                timeout: 2000,
                                killer: true
                            }).show();
                            table.ajax.reload(null, false);
                            document.getElementById('trans_form_city').reset();
                            $("#trans_form_city").parsley().reset();
                        }
                        else {
                            new Noty({
                                type: 'warning',
                                layout: 'topRight',
                                text: "{{ _i('An Error Occurred, please try again')}}",
                                timeout: 2000,
                                killer: true
                            }).show();
                        }
                    }
                });
            });
        })
    </script>
@endpush
