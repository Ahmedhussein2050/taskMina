<div class="modal modal_edit fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-light" id="header"> {{_i('Edit Currency')}} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_edit" class="form-horizontal" method="POST" data-parsley-validate="" enctype="multipart/form-data">
                    @method('PATCH')
                    @csrf
                    <div class="box-body">
                        <input type="hidden" id="currency_id" name="currency_id">
                        <div class="form-group row" >
                            <label for="code" class=" col-sm-2 col-form-label"><?=_i('Code')?> <span style="color: #F00;">*</span></label>
                            <div class="col-sm-10">
                                <input id="code" type="text" class="form-control" name="code">
                            </div>
                        </div>
                        <div class="form-group row" >
                            <label for="rate" class=" col-sm-2 col-form-label"><?=_i('Exchange Rate')?> <span style="color: #F00;">*</span></label>
                            <div class="col-sm-10">
                                <input id="rate" type="text" class="form-control" name="rate">
                            </div>
                        </div>
                        <div class="form-group row" >
                            <label for="flag" class=" col-sm-2 col-form-label"><?=_i('Flag')?> <span style="color: #F00;">*</span></label>
                            <div class="col-sm-10">
                                <input id="flag" type="text" class="form-control" name="flag">
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
            var currency_id = $(this).data('id');
            var published = $(this).data('published');
            var code = $(this).data('code');
            var rate = $(this).data('rate');
            var flag = $(this).data('flag');

            $('.modal_edit #currency_id').val(currency_id);
            $('.modal_edit #code').val(code);
            $('.modal_edit #rate').val(rate);
            $('.modal_edit #flag').val(flag);
            if(published == 1){
                $('.modal_edit #checkboxx').prop('checked',true);
            }
        });

        $(function() {
            $('#form_edit').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{url('admin/currencies/update')}}",
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
