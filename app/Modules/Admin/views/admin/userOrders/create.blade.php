@extends('admin.layout.index',[
'title' => _i('Add User'),
'subtitle' => _i('Add User'),
'activePageName' => _i('Add User'),
'activePageUrl' => '',
'additionalPageUrl' => route('user.index') ,
'additionalPageName' => _i('All'),
] )

@section('content')
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<h5> {{ _i('Add Admin') }} </h5>
					<div class="card-header-right">
						<i class="icofont icofont-rounded-down"></i>
						<i class="icofont icofont-refresh"></i>
						<i class="icofont icofont-close-circled"></i>
					</div>
				</div>
				<!-- Blog-card start -->
				<div class="card-block">
					<form method="POST" action="{{ route('customer.store') }}" class="form-horizontal"  id="demo-form" data-parsley-validate="" enctype="multipart/form-data">
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
									<div class="form-group">
										<label class="col-form-label">{{ _i('Country') }}:</label>
										<select name='country' class='form-control   selectpicker'  data-live-search=true data-actions-box="true" required>
											<option value=''>{{ _i('Select Your Country') }}</option>
											@foreach($countries AS $country)
												<option value='{{$country->id}}'>{{ $country->data->title ?? '' }}</option>
											@endforeach
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
