<script>
    $(document).ready(function(){
        $('.remove-record').click(function() {
            var id = $(this).attr('data-id');
            var url = $(this).attr('data-url');
            var token = '{{csrf_token()}}';
            $(".remove-record-model").attr("action",url);
            $('body').find('.remove-record-model').append('<input name="_token" type="hidden" value="'+ token +'">');
            $('body').find('.remove-record-model').append('<input name="_method" type="hidden" value="DELETE">');
            $('body').find('.remove-record-model').append('<input name="id" type="hidden" value="'+ id +'">');
        });
        $('.remove-data-from-delete-form').click(function() {
            $('body').find('.remove-record-model').find( "input" ).remove();
        });
        $('.modal').click(function() {
            // $('body').find('.remove-record-model').find( "input" ).remove();
        });
    });
</script>

@php
    $categories = \App\Category::select('categories.*', 'title')
            ->join('categories_data', 'categories.id', 'categories_data.category_id')
            ->where('parent_id', NULL)
            ->where('lang_id', Lang::getSelectedLangId())
            ->orderBy('number', 'asc')
            ->get();
    $products = \App\Models\product\product_details::select('products.id as prod_id','product_details.title as title')
               ->join('products','products.id','=','product_details.product_id')
              ->get();
    $users = \App\Models\Group::get();
@endphp

<a href="discount_code/{{$id}}/edit" data-target=".edit_modal" data-toggle="modal" class="edit btn waves-effect waves-light btn-primary" data-id="{{ $id }}" data-title="{{ $title }}" data-code="{{ $code }}" data-discount="{{ $discount }}" data-count="{{ $count }}" data-type="{{ $type }}" data-expire_date="{{ $expire_date }}" data-include_all="{{ $include_all }}"
>
    <i class="ti-pencil-alt"></i>
</a>

<a class="btn btn-danger waves-effect waves-light remove-record" data-toggle="modal" data-url="{{ route('discount_code.destroy', $id) }}" data-id="{{$id}}" data-target="#custom-width-modal" style="color: white;">
    <i class="ti-trash"></i>
</a>

<form action="" method="POST" class="remove-record-model">
    <div id="custom-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog" style="width:55%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="custom-width-modalLabel">{{_i('Delete')}}</h4>
                </div>
                <div class="modal-body">
                    <h4>{{_i('Are you sure to delete this one?')}}</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect remove-data-from-delete-form" data-dismiss="modal">{{_i('cancel')}}</button>
                    <button type="submit" class="btn btn-danger waves-effect waves-light">{{_i('delete')}}</button>
                </div>
            </div>
        </div>
    </div>
</form>
