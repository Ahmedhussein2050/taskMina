<div class="modal modal_edit fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="header"> {{_i('Edit Type')}} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_edit" class="form-horizontal" method="POST" data-parsley-validate="" enctype="multipart/form-data">
                    @method('PATCH')
                    @csrf
                    <div class="box-body">
                        <input type="hidden" id="type_id" name="type_id">
                        <div class="form-group row" >
                            <label for="name" class=" col-sm-2 col-form-label"><?=_i('Name')?> <span style="color: #F00;">*</span></label>
                            <div class="col-sm-10">
                                <input id="name" type="text" class="form-control" name="name" disabled>
                            </div>
                        </div>

                        <div class="form-group row" >
                            <label class="col-sm-2 col-form-label" for="checkboxx">
                                {{_i('Publish')}}
                            </label>
                            <div class="checkbox-fade fade-in-primary col-sm-6">
                                <label>
                                    <input type="checkbox"  id="checkboxx" name="published" value="1">
                                    <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i> </span>
                                </label>
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

@push('js')
    <script>
        $('body').on('click', '.edit', function (e) {
            e.preventDefault();
            var type_id = $(this).data('id');
            var lang_id = $(this).data('lang_id');
            var published = $(this).data('published');
            var name = $(this).data('name');

            $('.modal_edit #type_id').val(type_id);
            $('.modal_edit #lang_id').val(lang_id);
            $('.modal_edit #name').val(name);
            if(published == 1){
                $('.modal_edit #checkboxx').prop('checked',true);
            }
        });

        $(function() {
            $('#form_edit').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{url('admin/types/update')}}",
                    type: "POST",
                    "_token": "{{ csrf_token() }}",
                    data: new FormData(this),
                    dataType: 'json',
                    cache       : false,
                    contentType : false,
                    processData : false,
                    success: function(response) {
                        if (response == 'SUCCESS'){
                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: "{{ _i('Saved Successfully')}}",
                                timeout: 2000,
                                killer: true
                            }).show();
                            $('.modal.modal_edit').modal('hide');
                            $('#dataTable').DataTable().draw(false);
                        }
                    }
                });
            });
        });

    </script>

@endpush
