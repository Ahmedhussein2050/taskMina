<div class="modal fade modal_create" id="modal_create" aria-hidden="true">
    <div class="modal-dialog" style="top: 10% !important;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b>{{ _i('Add City')}}</b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span style="cursor: pointer" aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="create_form_city" method="post" action="{{ route('cities.store') }}" data-parsley-validate="">
                @csrf
                <!-- Title -->
                    <div class="form-group">
                        <label for="add_name">{{ _i('City name') }}</label>
                        <input id="add_name" type="text" class="form-control" name="city_title" required maxlength="100"
                               aria-describedby="helpId">
                    </div>
                    <div class="row">
                        <div class="col-md-6 pr-0" data-toggle="tooltip" data-placement="top" title="{{ _i('Lat') }}">
                            <div class="form-group">
                                <input type="number" step="any" maxlength="10" data-parsley-maxlength="10" class="form-control cost mr-2"
                                       name="lat" required="" placeholder="{{ _i('Lat') }}">
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-6 pr-0" data-toggle="tooltip" data-placement="top" title="{{ _i('Price') }}">
                            <div class="form-group">
                                <input type="number" step="any" maxlength="10" data-parsley-maxlength="10" class="form-control price mr-2"
                                       name="lng" required="" placeholder="{{ _i('Lng') }}">
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lang_id">{{ _i('Language') }}</label>
                        <select class="form-control" name="lang_id" id="add_lang">
                            <option selected disabled=""><?= _i('CHOOSE') ?></option>
                            @foreach ($langs as $lang)
                                <option value="{{ $lang['id'] }}"> {{ $lang['title'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="create_form_city" class="btn btn-primary  createBtn">{{ _i('save') }}</button>
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
        $(document).ready(function() {
            $(document).on('submit', '#create_form_city', function(e) {
                e.preventDefault();
                let url = $(this).attr('action')
                $.ajax({
                    url: url,
                    method: "post",
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res === 'success')
                        {
                            $('.modal.modal_create').modal('hide');
                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: "{{ _i('City Added Successfully')}}",
                                timeout: 2000,
                                killer: true
                            }).show();
                            table.ajax.reload(null, false);
                            document.getElementById('create_form_city').reset();
                            $("#create_form_city").parsley().reset();
                        }else {
                            new Noty({
                                type: 'error',
                                layout: 'topRight',
                                text: "{{ _i('An Error Occurred, please try again')}}",
                                timeout: 2000,
                                killer: true
                            }).show();
                        }
                    }
                })
            })
        })
    </script>
@endpush
