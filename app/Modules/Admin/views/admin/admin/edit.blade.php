@extends('admin.layout.index',[
'title' => _i('Edit Admin'),
'subtitle' => _i('Edit Admin'),
'activePageName' => _i('Edit Admin'),
'activePageUrl' => '',
'additionalPageUrl' => route('admin.index') ,
'additionalPageName' => _i('All'),
] )

<div class="modal fade" id="default-Modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> {{_i('Change Password')}} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{ route('admin.change_password', $user->id) }}" class="form-horizontal"  data-parsley-validate="">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="name" class="col-sm-4 control-label">{{ _i('Change Password') }}</label>
                        <div class="col-sm-8">
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                                   value="{{old('password')}}" required="" min="6" data-parsley-min="6" placeholder="{{_i('Change Password')}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-sm-4 control-label">{{ _i('Confirm Password') }}</label>
                        <div class="col-sm-8">
                            <input type="password" name="password_confirmation"  class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                                   value="{{old('password_confirmation')}}" required=""  min="6" data-parsley-min="6" data-parsley-equalto="#password" placeholder="{{_i('Confirm Password')}}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">{{_i('Close')}}</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light "> {{_i('Save')}} </button>
                </div>
            </form>
        </div>
    </div>
</div>
@section('content')
    <!-- Page-body start -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5> {{ _i('Edit Admin') }} </h5>
                    <div class="card-header-right">
                        <i class="icofont icofont-rounded-down"></i>
                        <i class="icofont icofont-refresh"></i>
                        <i class="icofont icofont-close-circled"></i>
                    </div>
                </div>
                <div class="card-block">
                    <form method="post" action="{{ route('admin.update', $user->id) }}" class="form-horizontal"   data-parsley-validate="">
                        @csrf
                        @method('PATCH')
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 control-label">{{ _i('First Name') }}</label>
                            <div class="col-sm-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $user->name }}" required="" data-parsley-maxlength="191">
                                @if ($errors->has('name'))
                                    <span class="text-danger invalid-feedback" role="alert">
                                 <strong>{{ $errors->first('name') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="last_name" class="col-sm-2 control-label">{{ _i('Last Name') }}</label>
                            <div class="col-sm-6">
                                <input id="last_name" type="text" class="form-control{{ $errors->has('lastname') ? ' is-invalid' : '' }}" name="lastname" value="{{ $user->lastname }}" data-parsley-maxlength="191">
                                @if ($errors->has('lastname'))
                                    <span class="text-danger invalid-feedback" role="alert">
                                 <strong>{{ $errors->first('lastname') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 control-label">{{ _i('E-Mail Address') }}</label>
                            <div class="col-sm-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{$user->email}}" required="" data-parsley-maxlength="191">
                                @if ($errors->has('email'))
                                    <span class="text-danger invalid-feedback" role="alert">
                                  <strong>{{ $errors->first('email') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 control-label">{{ _i('Mobile') }}</label>
                            <div class="col-sm-6">
                                <input  type="number" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{$user->phone}}" data-parsley-maxlength="15">
                                @if ($errors->has('phone'))
                                    <span class="text-danger invalid-feedback" role="alert">
                                  <strong>{{ $errors->first('phone') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-sm-2 control-label">{{ _i('Rolles') }}</label>
                            <div class="col-sm-6">
                                <select class="form-control{{ $errors->has('roles') ? ' is-invalid' : '' }}" name="roles" required="">
                                    @foreach($roles as $role)
                                        <option   value="{{$role->id}}"{{($user->hasRole($role->name)) ? 'selected':''}} > {{$role->name}} </option>
                                    @endforeach
                                    @if ($errors->has('roles'))
                                        <span class="text-danger invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('roles')}}</strong>
                                </span>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary"> {{ _i('Save')}}</button>
                            <button type="button" class="btn btn-info waves-effect" data-toggle="modal" data-target="#default-Modal">{{_i('Change Password')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


