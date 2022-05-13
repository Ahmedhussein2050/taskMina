<div class="modal modal_trans fade" id="langedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{_i('Company translation')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{url('admin/shipping_company/storeLang')}}" id="lang_submit" method="post" data-parsley-validate="">
                {{method_field('post')}}
                {{csrf_field()}}
                <div class="modal-body" >

                    <h3 id="header" style="text-align: center"></h3>
                    <input type="hidden" name="id" id="id_data" value="">
                    <input type="hidden" name="lang_id_data" id="lang_id_data" value="" >

                    <label>{{_i('Title')}}</label>
                    <input type="text" value="" name="title" id="titletrans" class="form-control" data-parsley-required="true" placeholder="<?=_i('Please enter translation title')?>">

                    <label>{{_i('Description')}}</label>
                    <textarea class="form-control" name="description" id="description_trans" placeholder="<?=_i('Please enter translation description')?>"></textarea>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{_i('close')}}</button>
                    <button type="submit" class="btn btn-primary">{{_i('save')}}</button>
                </div>

            </form>
        </div>
    </div>
</div>

@push('js')

    <script>
        // get lang id
        $('body').on('click','.lang_ex',function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            var lang_id = $(this).data('lang');
             // alert(id);

            $.ajax({
                url: '{{ url('admin/shipping_company/get/lang/value') }}',
                method: "get",
                data: {
                    {{--_token: '{{ csrf_token() }}',--}}
                    lang_id: lang_id,
                    id: id,
                },
                success: function (response) {
                    if (response.data == 'false'){
                        $('#title').val('');
                        $('#description_trans').val('');
                    }else{
                        console.log(response.data.description);
                        $('#titletrans').val(response.data.title);
                        $('#description_trans').val(response.data.description);

                    }

                }
            });

            $.ajax({
                url: "{{ url('admin/get/lang') }}",
                method: "get",
                data: {
                     lang_id: lang_id,
                },
                success: function (response) {
                    $('#header').empty();
                    $('#header').text('Translate to : '+response);

                    $('#id_data').val(id);
                    $('#lang_id_data').val(lang_id);
                }
            });
        })
        // submit the lang form
        $('body').on('submit','#lang_submit',function (e) {
            e.preventDefault();

            let url = $(this).attr('action');
            // alert(url);
            $.ajax({
                url: url,
                method: "post",
                data: new FormData(this),
                dataType: 'json',
                cache       : false,
                contentType : false,
                processData : false,

                success: function (response) {

                    console.log(response);
                    if (response.errors){
                        $('#masages_model').empty();
                        $.each(response.errors, function( index, value ) {
                            $('#masages_model').show();
                            $('#masages_model').append(value + "<br>");
                        });
                    }
                    if (response == 'SUCCESS'){

                        new Noty({
                            type: 'warning',
                            layout: 'topRight',
                            text: "{{ _i('Translated Successfully')}}",
                            timeout: 2000,
                            killer: true
                        }).show();
                        $('.modal.modal_trans').modal('hide');
                        window.location.reload();

                    }
                    // table.ajax.reload();
                    // window.location.reload();
                },

            });

        });
    </script>
@endpush
