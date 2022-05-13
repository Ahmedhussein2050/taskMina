@extends('admin.layout.index',[
'title' => _i('Add Promotor'),
'subtitle' => _i('Add Promotor'),
'activePageName' => _i('Add Promotor'),
'activePageUrl' => '',
'additionalPageUrl' => route('promotors.index') ,
'additionalPageName' => _i('All'),
] )

@section('content')
	<div class="row">
		<div class="col-sm-12">
			<div class="card">

				<!-- Blog-card start -->
				<div class="card-block">
					<form method="POST" action="{{ route('admin.promotor.store') }}" class="form-horizontal"  id="demo-form" data-parsley-validate="" enctype="multipart/form-data">
						@csrf
						<div class="card-body card-block">
									<div class="form-group">
										<label>{{ _i('First Name') }}</label>
										<input type="text" class="form-control" value="{{ old('name') }}" name='name'>
									</div>
									<div class="form-group ">
										<label>{{ _i('Last Name') }}</label>
										<input type="text" class="form-control" value="{{ old('lastname') }}" name='lastname'>
									</div>
									<div class="form-group ">
										<label>{{ _i('Gender') }}</label>
										<select name="gender" class="form-control" id="">
											<option value="">{{_i('Select Type')}}</option>
											<option value="male">{{_i('Male')}}</option>
											<option value="female">{{_i('Female')}}</option>
										</select>
									</div>
									<div class="form-group ">
										<label>{{ _i('Email') }}</label>
										<input type="email" class="form-control" value="{{ old('email') }}" name='email'>
									</div>
									<div class="form-group ">
										<label>{{ _i('Phone') }}</label>
										<input type="text" class="form-control" value="{{ old('phone') }}" name='phone'>
									</div>
									<div class="form-group">
										<label>{{ _i('Password') }}</label>
										<input type="password" class="form-control" value="{{ old('password') }}" name='password'>
									</div>
									<div class="form-group ">
										<label>{{ _i('Confirm Password') }}</label>
										<input type="password" class="form-control" value="{{ old('password_confirmation') }}" name='password_confirmation'>
									</div>
{{--								<div class="form-group ">--}}
{{--									<label>{{ _i('Image') }}</label>--}}
{{--									<input type="file" class="form-control"   name='image'>--}}
{{--								</div>--}}
							     <div class="form-group ">
									<label>{{ _i('Balance') }}</label>
									<input type="text" class="form-control"   name='balance'>
								 </div>
						        <div class="form-group ">
									<label>{{ _i('Promotor Status') }}</label>
									<select name="status" class="form-control" required >
										<option value="">{{_i('Select Type')}}</option>
										<option value="active">{{_i('Active')}}</option>
										<option value="pending">{{_i('Pending')}}</option>
										<option value="inactive">{{_i('Inactive')}}</option>
									</select>
								</div>

						</div>
						<div class="box-footer">
							<button type="submit" class="btn btn-primary "> {{ _i('Add') }}</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('footer')
@endsection
