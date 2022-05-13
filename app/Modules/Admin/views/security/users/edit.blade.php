@extends('admin.layout.index', [
    'title' => _i('Edit Customer') . ' | ' . $user->name,
    'subtitle' => _i('Edit Customer'),
    'activePageName' => _i('Edit Customer'),
    'activePageUrl' => '',
    'additionalPageName' => _i('Customers'),
    'additionalPageUrl' => route('customers.index') ,
])
@section('content')

	<div class="page-body">
		<!-- Blog-card start -->
		<div class="card blog-page" id="blog">
			<div class="card-block">
				<form method="post" action="{{url('/adminpanel/'.$user->id.'/edit')}}" class="form-horizontal"  id="demo-form" data-parsley-validate="">
					@csrf
					@method('PATCH')
					<div class="form-group row">
						<label for="name" class="col-sm-4 control-label">{{ _i('Name') }}</label>
						<div class="col-sm-6">
							<input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $user->name }}" required="">
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
							<input  type="text"  class="form-control{{ $errors->has('lastname') ? ' is-invalid' : '' }}" name="lastname" value="{{ $user->lastname }}"  placeholder=" {{_i('Last Name')}}" data-parsley-maxlength="191">
							@if ($errors->has('lastname'))
								<span class="text-danger invalid-feedback" role="alert">
									<strong>{{ $errors->first('lastname') }}</strong>
								</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label for="email" class="col-sm-4 control-label">{{ _i('E-Mail Address') }}</label>
						<div class="col-sm-6">
							<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{$user->email}}" required="">
							@if ($errors->has('email'))
								<span class="text-danger invalid-feedback" role="alert">
									  <strong>{{ $errors->first('email') }}</strong>
								</span>
							@endif
						</div>
					</div>

					<div class="form-group row">
						<label for="password" class="col-sm-4 control-label">{{ _i('Password') }}</label>
						<div class="col-sm-6">
							<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" >
							@if ($errors->has('password'))
								<span class="text-danger invalid-feedback" role="alert">
									  <strong>{{ $errors->first('password') }}</strong>
								</span>
							@endif
						</div>
					</div>

					<div class="form-group row">
						<label for="password" class="col-sm-4 control-label">{{ _i('Confirm Password') }}</label>
						<div class="col-sm-6">
							<input id="password-confirm" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password_confirmation" >
							@if ($errors->has('password'))
								<span class="text-danger invalid-feedback" role="alert">
									 <strong>{{ $errors->first('password_confirmation') }}</strong>
								</span>
							@endif
						</div>
					</div>

					<div class="box-footer">
						<button type="submit" class="btn btn-info pull-leftt"> {{ _i('Save')}}</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
@section('footer')
@endsection