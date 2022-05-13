<div class="modal fade bd-example-modal-lg" id="edit-group" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ _i('Edit List') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form id="edit_list_form" class="j-pro" enctype="multipart/form-data" data-parsley-validate="" style="box-shadow:none; background: none">
                    @csrf

                    <div class="j-unit">
                        <div class="j-input">

                            <label for="order"></label>
                            <select name="order" title="{{ _i('Order') }}"  class="selectpicker form-control" id="order">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>

                        </div>
                    </div>




                    <div>
                        <label for="items"></label>
                        <select name="items[]"  title="{{ _i('items') }}" multiple class="selectpicker form-control" id="items">
                            @foreach($items as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ _i('Close') }}</button>
                <button type="submit" onclick="$('#edit_list_form').submit()" form="update_form" class="btn btn-primary">{{ _i('Save') }}</button>
            </div>
        </div>
    </div>
</div>
