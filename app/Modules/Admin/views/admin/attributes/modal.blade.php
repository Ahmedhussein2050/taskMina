{{-- Create New Attribute Modal --}}
<div class="modal fade" id="attribute-Modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ _i('Create new Attribute') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method='post' id='add-form' enctype="multipart/form-data">
                    @csrf
                    {{-- <input type="hidden" name="category_id" value="{{ request()->input('id') }}"> --}}
                    <div class="row">
                        <div class="col-md-12">
                            <label for="title">{{ _i('Attribute Name') }}</label>
                            <div class="form-group row">
                                @foreach ($languages as $lang)
                                    <label for="" class="col-sm-2 control-label "> {{ $lang->code }} </label>
                                    <div class="col-sm-4">
                                        <input type="text" name="title[{{ $lang->id }}]" value=""
                                            class="form-control" required id="title">
                                    </div>
                                @endforeach
                                @error('name')
                                    <small class='text-danger'>{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        {{-- <div class="col-sm-12"  >
                            <div class="form-group row">
                                <label for="select" class="col-sm-3 control-label">{{ _i('Attribute Type') }}</label>
                                <select name="type" id="type_create" data-types="types" class="form-control col-sm-9" required>
                                    <option disabled selected>{{ _i('Select Type') }}</option>
                                    <option value="text">{{ _i('Text') }}</option>
                                    <option value="number">{{ _i('Numerical') }}</option>
                                    <option value="select" selected>{{ _i('Options') }}</option>
                                </select>
                            </div>
                        </div> --}}
                        <div class="col-sm-6">
                            <input type="checkbox" value="1" name="required" class="js-switch"/>
                            <label for="required">{{ _i('Required') }}</label>
                        </div>
                        {{-- <div class="col-sm-6">
                            <input type="checkbox" value="1" name="front" class="js-switch"/>
                            <label for="front">{{ _i('Appear at Front') }}</label>
                        </div> --}}
                        {{-- <label for="title" class="mt-4 mb-2">{{ _i('Placeholder') }}</label>
                        <div class="form-group row">
                            @foreach ($languages as $lang)
                                <label for="" class="col-sm-2 control-label "> {{ $lang->code }} </label>
                                <div class="col-sm-4">
                                    <input type="text" name="placeholder[{{ $lang->id }}]" value=""
                                        class="form-control" required id="placeholder">
                                </div>
                            @endforeach
                        </div> --}}
                        <div data-options="options" class="col-sm-12">
                            <div class="col-sm-6 mb-4 mt-4">
                                <label for="title">{{ _i('Attribute Options') }}</label>
                                <button class="btn btn-sm btn-success float-right" data-add="plus">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                            <div class="row" data-group="options-group">
                                <div class="form-group row" data-group="row">
                                    @foreach ($languages as $lang)
                                        <label for="" class="col-sm-1 control-label"> {{ $lang->code }} </label>
                                        <div class="col-sm-4">
                                            <input type="text" name="option[1][{{ $lang->code }}]" value=""
                                                class="form-control" data-require="true" data-value="option" />
                                        </div>
                                    @endforeach
                                </div>
                                <div class="form-group row" data-group="row">
                                    @foreach ($languages as $lang)
                                        <label for="" class="col-sm-1 control-label"> {{ $lang->code }} </label>
                                        <div class="col-sm-4">
                                            <input type="text" name="option[2][{{ $lang->code }}]" value=""
                                                class="form-control" data-require="true" data-value="option" />
                                        </div>
                                    @endforeach
                                </div>
                                <div class="form-group row" data-group="row">
                                    @foreach ($languages as $lang)
                                        <label for="" class="col-sm-1 control-label"> {{ $lang->code }} </label>
                                        <div class="col-sm-4">
                                            <input type="text" name="option[3][{{ $lang->code }}]" value=""
                                                class="form-control" data-value="option" />
                                        </div>
                                    @endforeach
                                    <div class="col-sm-1 float-right">
                                        <button class="btn btn-sm btn-danger" data-add="minus">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
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

{{-- Attribute Icon Modal --}}
<div class="modal fade modal_create " id="image" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" style="margin-top:40px;">
    <div class="modal-dialog" role="document">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="header"> {{ _i('Icon') }} : <span id="titletrans"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('attribute.icon.upload') }}" method="post" class="form-horizontal" id="imageform" data-parsley-validate="" data-form="icon">
                        @csrf
                        <input type="hidden" name="id" data-form="icon-id" value="">

                        <div class="form-group  ">
                            <label for="" class="col-sm-2 control-label "> {{ _i('  Image') }} </label>
                            <div class="col-md-10">
                                <input type="file" placeholder="{{ _i('Name') }}" name="icon" id="icon"
                                    class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" required>
                                @error('name')
                                    <small class='text-danger'>{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div id="imagee" class="col-md-12" data-form="icon-preview">
                        </div>
                        <!-- /.box-body -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{ _i('Close') }}</button>
                            <button type="submit" class="btn btn-primary saveimage" form="imageform">
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

{{-- Edit Attribute --}}
<div class="modal fade" id="attribute-edit" tabindex="-1" role="dialog" style="z-index: 1050; display: none;"
    aria-hidden="true" data-modal="edit_attributes">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ _i('Edit Attribute') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method='post' id='edit-form' enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="id-edit" data-edit="id">
                    <div class="row" data-edit="body">

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

{{-- Edit Options Modal --}}
<div class="modal fade" id="options-edit" tabindex="-1" role="dialog" style="z-index: 1050; display: none;"
    aria-hidden="true" data-modal="edit_attributes">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ _i('Edit Attribute Options') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method='post' id='edit-form' enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="id-edit" data-edit="option-id">
                    <button class="btn btn-sm btn-success float-right mb-4" data-manage="add">
                        <i class="fa fa-plus"></i>
                    </button>
                    <div class="row" data-edit="options">

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect"
                    data-dismiss="modal">{{ _i('Close') }}</button>
            </div>
        </div>
    </div>
</div>
