@extends('admin.layout.index',[
'title' => _i('Add Role'),
'subtitle' => _i('Add Role'),
'activePageName' => _i('Add Role'),
'activePageUrl' => '',
'additionalPageUrl' => url('/admin/role') ,
'additionalPageName' => _i('All'),
] )

@section('content')
    <!-- Page-body start -->
    <div class="page-body">
        <!-- Blog-card start -->
        <div class="card blog-page" id="blog">
            <div class="card-block">

            <form  action="{{route('role.store')}}" method="post" class="form-horizontal"  id="demo-form" data-parsley-validate="">
                @csrf
                <div class="box-body">
                <div class="form-group row">
                </div>
                    <div class="form-group row" >
                        <label class="col-sm-2 col-form-label"  >
                            {{_i('Language')}} </label>
                        <div class="col-sm-6">
                            <select  class="form-control" name="lang_id" id="selected_lang">
                                <option selected disabled><?= _i('CHOOSE')?></option>
                                @foreach($languages as $lang)
                                <option value="{{$lang->id}}">{{_i($lang->title)}}</option>
                                @endforeach
                            </select>
                            <small  class="form-text text-muted">{{_i('Please select language to change Permissions name according to language selected')}}</small>
                        </div>
                    </div>
                <div class="form-group row" >
                    <label class="col-sm-2 col-form-label" for="txtUser">
                        {{_i('Role Name')}} </label>
                    <div class="col-sm-6">
                        <input type="text" name="name" id="txtUser" required="" class="form-control">
                        @if ($errors->has('name'))
                            <span class="text-danger ">
                                    <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row ">
                    <label class="col-sm-2 col-form-label">
                        {{_i('Permissions')}} </label>
                </div>
                <div class="form-group row "  id="permissions">

                    @foreach($permissions as $permission)
                        <div class="col-sm-3">
                            <div class="checkbox-fade fade-in-primary">
                                <label>
                                    <input id="{{$permission->id}}" type="checkbox" name="groups[]" value="{{$permission->id}}" data-parsley-multiple="groups">
                                    <span class="cr">
                                   <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                </span>
                                    {{$permission['title']}}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="form-group row " {{-- style="margin-right: 60%; margin-top: 5%;"--}}>
                    <div class="col-sm-offset-2 col-sm-2">
                        {{--<input type="submit" class="btn btn-default" value="Save">--}}
                        <button type="submit" class="btn btn-primary pull-leftt"> {{_i('Add Role')}}</button>
                    </div>
                </div>
                </div>
            </form>
        </div>
        </div>
    </div>
@endsection

