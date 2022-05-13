<script>
    $(document).ready(function(){
        // For A Delete Record Popup
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

<a target="_blank" href="{{route('products.edit', $id)}}" class=" btn color-white  waves-effect waves-light btn-primary"><i class="ti-pencil-alt"></i></a>
<a id="images_btn"    data-toggle="modal"  data-id="{{$id}}" data-target="#pics" class=" btn color-white  waves-effect waves-light btn-primary"><i class="ti-apple"></i></a>
{{--<a id="info_btn"    data-toggle="modal"  data-id="{{$id}}" data-target="#info" class=" btn color-white  waves-effect waves-light btn-primary"><i class="ti-list-ol"></i></a>--}}

<a class="btn btn-danger btn-circle waves-effect waves-light remove-record" data-url="{{route('products.destroy', $id) }}" data-id="{{$id}}"><i class="ti-trash"></i></a>
<button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"  title=" '._i('Translation').' ">
    <span class="ti ti-settings"></span>
</button>

<ul class="dropdown-menu" style="right: auto; left: 0; width: 5em; " >
    <?php
    $data = \App\Modules\Admin\Models\Products\ProductData::query()->where('product_id', $id)->get();
    ?>
    @foreach (\App\Bll\Lang::getLanguages()  as $lang)
        <li ><a href="#" data-title="{{$data->where('lang_id', $lang->id)->first()->title}}" data-info="{{$data->where('lang_id', $lang->id)->first()->info}}" data-desc="{{$data->where('lang_id', $lang->id)->first()->description}}" data-toggle="modal" data-target="#langedit" class="lang_ex1" data-id="{{$id}}" data-lang="{{$lang->id}}" style="display: block; padding: 5px 10px 10px;">{{$lang->title}}</a></li>
    @endforeach
</ul>
</div>

<form action="" method="POST" class="remove-record-model">
    <div id="custom-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog" style="width:55%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="custom-width-modalLabel">{{_i('delete')}}</h4>
                </div>
                <div class="modal-body">
                    <h4>{{_i('are you sure to delete this one?')}}</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect remove-data-from-delete-form" data-dismiss="modal">{{_i('cancel')}}</button>
                    <button type="submit" class="btn btn-danger waves-effect waves-light">{{_i('delete')}}</button>
                </div>
            </div>
        </div>
    </div>
</form>
