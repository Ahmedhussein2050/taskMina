@extends('admin.layout.index',[
'title' => _i('Edit Role'),
'subtitle' => _i('Edit Role'),
'activePageName' => _i('Edit Role'),
'activePageUrl' => '',
'additionalPageUrl' => url('/admin/role') ,
'additionalPageName' => _i('All'),
] )

@section('content')

    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has($msg))
                <p class="alert alert-{{ $msg }}">{{ Session::get($msg) }}</p>
            @endif
        @endforeach
    </div>

    <!-- Page-body start -->
    <div class="page-body">
        <!-- Blog-card start -->
        <div class="card blog-page" id="blog">
            <div class="card-block">

            <form method="post" action="{{ route('role.update', $role->id) }}" class="form-horizontal"  id="demo-form" data-parsley-validate="">
                @csrf
                @method('PATCH')
                <div class="form-group row" >
                    <label class="col-sm-2 col-form-label">{{_i('Language')}} </label>
                    <div class="col-sm-6">
                        <select  class="form-control" name="lang_id" id="selected_lang">
                            <option selected disabled><?= _i('CHOOSE')?></option>
                            @foreach($languages as $lang)
                                <option value="{{$lang->id}}" >{{_i($lang->title)}}</option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">{{_i('Please select language to change Permissions name according to language selected')}}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">{{ _i('Role Name') }}</label>
                    <div class="col-sm-6">
                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $role->name }}" required="">
                        @if ($errors->has('name'))
                            <span class="text-danger " role="alert">
                                 <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row " >
                    <label class="col-sm-2">
                        {{_i('Permissions')}} </label>
                </div>
                <div class="form-group" {{-- style="margin-left: 3%;"--}}>
                    <div id="permissions" class="row">
                        @foreach($permissions as $permission)
                            <div class="col-sm-3">
                                <div class="checkbox-fade fade-in-primary">
                                    <label for="{{$permission->id}}">
                                        <input data-name='{{$permission->name}}' id="{{$permission->id}}" type="checkbox" name="permissions[]" value="{{$permission->id}}" data-parsley-multiple="groups" required {{$role->hasPermissionTo($permission->name) ? 'checked' : ''}}>
                                        <span class="cr">
                                            <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                        </span>
                                        {{$permission['title']}}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary "> {{_i('Save')}}</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
        </div>
    </div>
@endsection

@push('js')
    <script  type="text/javascript">
        $('#selected_lang').on('change', function(){
            $("#permissions").empty();
            var langId = $('#selected_lang').val();
            $.ajax({
                url: "{{url('/admin/role/get_permissions')}}/"+langId+"",
                type: "get",
                success: function (result) {
                    var data = result;
                   // console.log(data.length);
                    var html = "";
                    for (var i = 0; i < data.length; i++)
                    {
                        html += '<div class="col-sm-3"> <div class="checkbox-fade fade-in-primary"><label>' +
                            '<input  id="check'+i+'" type="checkbox" name="permissions[]" value="'+ data[i].id +'"  data-parsley-multiple="groups"  required=""> ' +
                            '<span class="cr"> <i class="cr-icon icofont icofont-ui-check txt-primary"></i> </span> '+data[i].title +
                            '</label> </div> </div>';
                    }
                    $("#permissions").html(html);
                }
            });
        });

    </script>
@endpush
