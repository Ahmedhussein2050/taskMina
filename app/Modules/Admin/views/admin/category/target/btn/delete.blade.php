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

<a href="{{ route('offers.edit', $id) }}" class="edit btn btn-primary">
    <i class="ti-pencil-alt"></i>
</a>
<a class="btn btn-danger btn-circle waves-effect waves-light remove-record" data-toggle="modal" data-url="{{ route('offers.destroy', $id) }}" data-id="{{$id}}" data-target="#custom-width-modal" style="color: white;"><i class="ti-trash"></i></a>


<form action="" method="POST" class="remove-record-model">
    <div id="custom-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog" style="width:55%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="custom-width-modalLabel">{{_i('Delete')}}</h4>
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
