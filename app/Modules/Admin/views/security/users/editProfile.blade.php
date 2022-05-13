@extends('admin.layout.index',[
	'title' => _i('Edit Profile'),
	'subtitle' => _i('Profile'),
	'activePageName' => _i('Profile'),
	'activePageUrl' => '',

] )

@section('content')
    {{-- {{_i('Edit User')}} --}}
    {{-- {{$user->name}} --}}
        <!-- =============================== Model Body password div ============================================== -->

    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{_i('Change Password')}}</h4>
                </div>
                <div class="modal-body">

                    <form method="post" action="{{route('admin.updatePassword')}}" class="form-horizontal"  id="demo-form" data-parsley-validate="">
                        @csrf


                        <div class="form-group row">
                            <label for="name" class="col-md-4 control-label">{{ _i('Change Password') }}</label>

                            <div class="col-md-10">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} ml-2" name="password"
                                       value="{{old('password')}}" required="" min="6" data-parsley-min="6" placeholder="{{_i('Change Password')}}">

                                @if ($errors->has('password'))
                                    <span class="text-danger invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                         </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 control-label">{{ _i('Confirm Password') }}</label>

                            <div class="col-md-10">
                                <input type="password" name="password_confirmation"  class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }} ml-2"
                                       value="{{old('password_confirmation')}}" required=""  min="6" data-parsley-min="6" placeholder="{{_i('Confirm Password')}}">

                                @if ($errors->has('password_confirmation'))
                                    <span class="text-danger invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                @endif
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">{{_i('Close')}}</button>
                            <button  class="btn btn-info" type="submit"  id="s_form_1">{{_i('Save')}}</button>
                        </div>

                    </form>
                </div>



            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!------================ end passwor div =================--->
    <div class="box box-info">
        <!-- /.box-header -->
        <div class="box-body">
            <form method="post" action="{{route('admin.updateprofile')}}" class="form-horizontal"  id="demo-form" data-parsley-validate="">
                @csrf
                <div class="form-group row">
                    <label for="name" class="col-md-2 control-label">{{ _i('First Name') }}</label>

                    <div class="col-md-10">
                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }} ml-3" name="name" value="{{ $user->name }}" required="">

                        @if ($errors->has('name'))
                            <span class="text-danger invalid-feedback" role="alert">
                                 <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
				<div class="form-group row">
                    <label for="lastname" class="col-md-2 control-label">{{ _i('Last Name') }}</label>

                    <div class="col-md-10">
                        <input id="lastname" type="text" class="form-control{{ $errors->has('lastname') ? ' is-invalid' : '' }} ml-3" name="lastname" value="{{ $user->lastname }}" required="">

                        @if ($errors->has('lastname'))
                            <span class="text-danger invalid-feedback" role="alert">
                                 <strong>{{ $errors->first('lastname') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label for="phone" class="col-md-2 control-label">{{ _i('Phone No.') }}</label>

                    <div class="col-md-10">
                        <input id="phone" type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }} ml-3" name="phone" value="{{ $user->phone }}" required="">

                        @if ($errors->has('phone'))
                            <span class="text-danger invalid-feedback" role="alert">
                                 <strong>{{ $errors->first('phone') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-md-2 control-label">{{ __('Mail Address') }}</label>

                    <div class="col-md-10">
                        <input id="email" type="email" disabled class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} ml-1" name="email" value="{{$user->email}}" required="">

                        @if ($errors->has('email'))
                            <span class="text-danger invalid-feedback" role="alert">
                                  <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>


                {{--<div class="form-group row">--}}
                    {{--<label for="password" class="col-xs-4 control-label">{{ _i('Password') }}</label>--}}

                    {{--<div class="col-xs-6">--}}
                        {{--<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" >--}}

                        {{--@if ($errors->has('password'))--}}
                            {{--<span class="text-danger invalid-feedback" role="alert">--}}
                                  {{--<strong>{{ $errors->first('password') }}</strong>--}}
                            {{--</span>--}}
                        {{--@endif--}}
                    {{--</div>--}}
                {{--</div>--}}


                {{--<div class="form-group row">--}}
                    {{--<label for="password" class="col-xs-4 control-label">{{ _i('Confirm Password') }}</label>--}}

                    {{--<div class="col-xs-6">--}}
                        {{--<input id="password-confirm" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password_confirmation" >--}}

                        {{--@if ($errors->has('password'))--}}
                            {{--<span class="text-danger invalid-feedback" role="alert">--}}
                                 {{--<strong>{{ $errors->first('password_confirmation') }}</strong>--}}
                            {{--</span>--}}
                        {{--@endif--}}
                    {{--</div>--}}
                {{--</div>--}}

                <!-- /.box-body -->
                <div class="box-footer">

                    <button type="submit" class="btn btn-primary"> {{ _i('Save')}}</button>

                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-default">
                        {{_i('Change Password')}}
                    </button>

                </div>
                <!-- /.box-footer -->
            </form>
        </div>
    </div>
@endsection


