@extends('admin.layout.index',
[
'title' => _i('Add Customer'),
'subtitle' => _i('Add Customer'),
'activePageName' => _i('Add Customer'),
'activePageUrl' => '',
'additionalPageName' => _i('Customers'),
'additionalPageUrl' => route('customers.index') ,
])

@section('content')
	<div class="page-body">
		<div class="card blog-page" id="blog">
			<div class="card-block">
		<form method="POST" action="{{ route('customers.store') }}" class="form-horizontal"  id="demo-form" data-parsley-validate="">
			@csrf
			<div class="box-body">
				<div class="form-group row">
				<label for="name" class="col-sm-4 control-label" >{{ _i('Name :') }}</label>
				<div class="col-sm-6">
					<input id="name" type="text"  class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}"  placeholder=" {{_i('First Name')}}" required="">
					@if ($errors->has('name'))
						<span class="text-danger invalid-feedback" role="alert">
							  <strong>{{ $errors->first('name') }}</strong>
						</span>
					@endif
				</div>
			</div>
				<div class="form-group row">
					<label for="name" class="col-sm-4 control-label" >{{ _i('Last Name') }}</label>
					<div class="col-sm-6">
						<input  type="text"  class="form-control{{ $errors->has('lastname') ? ' is-invalid' : '' }}" name="lastname" value="{{ old('lastname') }}"  placeholder=" {{_i('Last Name')}}" data-parsley-maxlength="191">
						@if ($errors->has('lastname'))
							<span class="text-danger invalid-feedback" role="alert">
								<strong>{{ $errors->first('lastname') }}</strong>
							</span>
						@endif
					</div>
				</div>
			<div class="form-group row">
				<label for="email" class="col-sm-4 control-label">{{ _i('E-Mail Address :') }}</label>
				<div class="col-sm-6">
					<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder=" {{_i('Email')}}" required="">
					@if ($errors->has('email'))
						<span class="text-danger invalid-feedback" role="alert">
							   <strong>{{ $errors->first('email') }}</strong>
						 </span>
					@endif
				</div>
			</div>
			<div class="form-group row">
				<label for="password" class="col-sm-4 control-label">{{ _i('Password :') }}</label>
				<div class="col-sm-6">
					<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{_i('Password')}}" required="">
					@if ($errors->has('password'))
						<span class="text-danger invalid-feedback" role="alert">
							   <strong>{{ $errors->first('password') }}</strong>
						</span>
					@endif
				</div>
			</div>
			<div class="form-group row">
				<label for="password-confirm" class="col-sm-4 control-label">{{ _i('Confirm Password :') }}</label>
				<div class="col-sm-6">
					<input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="{{_i('Confirm Password')}}" required="">
				</div>
			</div>
		</div>
			<div class="box-footer">
				<button type="submit" class="btn btn-info "> {{ _i('Add') }}</button>
			</div>
		</form>
	</div>
	</div>
@endsection
@section('footer')
@endsection
