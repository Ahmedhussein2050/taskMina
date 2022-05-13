<a class="btn btn-success waves-effect waves-light color-white reply-btn" data-toggle="modal" data-url="{{ route('comments.reply', $id) }}" data-id="{{$id}}" data-target="#reply-modal" data-comment='{{ $comment }}'><i class="ti-back-right"></i>{{ _i('Reply') }}</a>

<a class="btn btn-info waves-effect waves-light color-white edit-btn" data-toggle="modal" data-url="{{ route('comments.update', $id) }}" data-id="{{$id}}" data-target="#edit-modal" data-comment='{{ $comment }}'><i class="ti-pencil-alt"></i>{{ _i('Edit') }}</a>

<a class="btn btn-danger waves-effect waves-light color-white delete-btn" data-toggle="modal" data-url="{{ route('comments.destroy', $id) }}"  data-target="#delete-modal" data-id='{{ $id }}'><i class="ti-trash"></i>{{ _i('Delete') }}</a>