<div class="modal modal_create fade" id="modal_create">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="header"> {{_i('Add Type')}} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_add" class="form-horizontal" action="{{route('types.store')}}" method="POST" data-parsley-validate="" enctype="multipart/form-data">
                    @csrf
                    <div class="box-body">
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
                        <div class="form-group row" >
                            <label class=" col-sm-2 col-form-label"><?=_i('Name')?> <span style="color: #F00;">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" id="name" class="form-control" name="name" required="" placeholder="{{_i('Place Enter Type Name')}}">
								<span class="text-danger">
									<strong id="name-error"></strong>
								</span>
                            </div>
                        </div>
                        <div class="form-group row" >
                            <label class="col-sm-2 col-form-label" for="checkbox">{{_i('Publish')}}</label>
                            <div class="checkbox-fade fade-in-primary col-sm-6">
                                <label>
                                    <input type="checkbox"  id="checkbox" name="published" value="1">
                                    <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row" >
                            <label class="col-sm-2 col-form-label" for="txtUser">{{_i('Description')}} </label>
                            <div class="col-sm-10">
                                <textarea id="description"  class="form-control" name="description" placeholder="{{_i('Place write description here...')}}"></textarea>
                            </div>
                        </div>
                        <div class="form-group row" >
                            <label class="col-sm-2 col-form-label" for="txtUser">{{_i('Keywords')}} </label>
                            <div class="col-sm-10">
                                <textarea id="keywords"  class="form-control" name="keywords" placeholder="{{_i('Place write keywords here...')}}"></textarea>
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
        $(function() {
            $('#form_add').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('types.store') }}",
                    type: "POST",
                    "_token": "{{ csrf_token() }}",
                    data: new FormData(this),
                    dataType: 'json',
                    cache       : false,
                    contentType : false,
                    processData : false,
                    success: function(response) {
                        if (response.errors){
							if(response.errors.name)
							{
								$( '#name-error' ).html( response.errors.name[0] );
							}
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
							$('#dataTable').DataTable().draw(false);
                            $('#lang_add').val("");
                            $('#name').val("");
                            $('#description').val("");
                            $('#keywords').val("");
                            $('#checkbox').val("");
                        }
                    }
                });
            });
        });
    </script>
@endpush
