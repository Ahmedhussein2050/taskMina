@extends('admin.layout.index',[
	'title' => _i('Create Affiliate User'),
	'subtitle' => _i('Create Affiliate User'),
	'activePageName' => _i('Create Affiliate User'),
	'activePageUrl' => '',
	'additionalPageUrl' => route('affiliate_users.index') ,
	'additionalPageName' => _i('Affiliate Users'),
] )

@section('content')
	<div class="row">
		<div class="col-sm-12">
			<form method="POST" action="{{ route('affiliate_users.store') }}" class="form-horizontal"  id="demo-form" data-parsley-validate="" enctype="multipart/form-data">
				@csrf
				<div class="card">
					<div class="card-header">
						<h5> {{ _i('Create Affiliate User') }} </h5>
						<div class="card-header-right">
							<i class="icofont icofont-rounded-down"></i>
							<i class="icofont icofont-refresh"></i>
							<i class="icofont icofont-close-circled"></i>
						</div>
					</div>
					<!-- Blog-card start -->
					<div class="card-block">
						<div class="card-body card-block">
							<div class="form-group row">
								<label for="name" class="col-sm-2 control-label" >{{ _i('First Name :') }}</label>
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
								<label for="name" class="col-sm-2 control-label" >{{ _i('Last Name :') }}</label>
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
								<label for="email" class="col-sm-2 control-label">{{ _i('E-Mail Address :') }}</label>
								<div class="col-sm-6">
									<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder=" Email" required="" data-parsley-maxlength="191">
									@if ($errors->has('email'))
										<span class="text-danger invalid-feedback" role="alert">
											<strong>{{ $errors->first('email') }}</strong>
										</span>
									@endif
								</div>
							</div>
							<div class="form-group row">
								<label for="password" class="col-sm-2 control-label">{{ _i('Password :') }}</label>
								<div class="col-sm-6">
									<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{_i('Password')}}" required="" data-parsley-maxlength="191">
									@if ($errors->has('password'))
										<span class="text-danger invalid-feedback" role="alert">
											<strong>{{ $errors->first('password') }}</strong>
										</span>
									@endif
								</div>
							</div>
							<div class="form-group row">
								<label for="password-confirm" class="col-sm-2 control-label">{{ _i('Confirm Password :') }}</label>
								<div class="col-sm-6">
									<input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="{{_i('Confirm Password')}}" min="6" data-parsley-min="6" data-parsley-equalto="#password" required="" >
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 col-form-label" for="image">{{_i('Image')}}</label>
								<div class="col-sm-10">
									<input type="file" name="image" id="image" onchange="showBannerImage(this)"
										class="btn btn-default" accept="image/gif, image/jpeg, image/png" value="{{old('image')}}">
									<span class="text-danger invalid-feedback">
										<strong>{{$errors->first('image')}}</strong>
									</span>
								</div>
							</div>
							<div class="form-group row">
								<label for="email" class="col-sm-2 control-label">{{ _i('Mobile') }}</label>
								<div class="col-sm-6">
									<input  type="number" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{old('phone')}}" data-parsley-maxlength="15">
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
									<select class="form-control{{ $errors->has('role') ? ' is-invalid' : '' }}" name="role" required="">
										@foreach($roles as $role)
											<option value="{{$role->id}}"> {{$role->name}} </option>
										@endforeach
										@if ($errors->has('role'))
											<span class="text-danger invalid-feedback" role="alert">
												<strong>{{ $errors->first('role')}}</strong>
											</span>
										@endif
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-header">
						<h5> {{ _i('Categories & Products') }} </h5>
						<div class="card-header-right">
							<i class="icofont icofont-rounded-down"></i>
							<i class="icofont icofont-refresh"></i>
							<i class="icofont icofont-close-circled"></i>
						</div>
					</div>
					<!-- Blog-card start -->
					<div class="card-block">
						<div class="card-body card-block">
							<div class="form-group row">
								<label for="categories" class="col-sm-2 control-label">{{ _i('Categories') }}</label>
								<div class="col-sm-6">
									<select class="selectpicker show-tick form-control{{ $errors->has('categories') ? ' is-invalid' : '' }}" name="categories[]" data-live-search=true multiple title='{{ _i('please select categories') }}'>
										@foreach($categories as $category)
											<option value="{{$category->category_id}}"> {{$category->title}} </option>
										@endforeach
										@if ($errors->has('categories'))
											<span class="text-danger invalid-feedback" role="alert">
												<strong>{{ $errors->first('categories')}}</strong>
											</span>
										@endif
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label for="categories" class="col-sm-2 control-label">{{ _i('Products') }}</label>
								<div class="col-sm-6">
									<select class="selectpicker show-tick form-control{{ $errors->has('products') ? ' is-invalid' : '' }}" name="products[]" data-live-search=true multiple title='{{ _i('please select products') }}'>
										@foreach($products as $product)
											<option value="{{$product->product_id}}"> {{$product->title}} </option>
										@endforeach
										@if ($errors->has('products'))
											<span class="text-danger invalid-feedback" role="alert">
												<strong>{{ $errors->first('products')}}</strong>
											</span>
										@endif
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-header">
						<div class="card-header-right">
							<i class="icofont icofont-rounded-down"></i>
						</div>
					</div>
					<div class="card-block">
						<div class="form-group row" >
							<label class="col-sm-2 col-form-label" for="checkbox">
								{{_i('Commission Type')}}
							</label>
							<div class="checkbox-fade fade-in-primary col-sm-6">
								<label class='mr-5'>
									<input type="radio" id="checkbox" name="commission_type" value="percentage">
									{{ _i('Percentage') }}
									<span class="cr">
										<i class="cr-icon icofont icofont-ui-check txt-primary"></i>
									</span>
								</label>
								<label>
									<input type="radio" id="checkbox" name="commission_type" value="amount">
									{{ _i('Amount') }}
									<span class="cr">
										<i class="cr-icon icofont icofont-ui-check txt-primary"></i>
									</span>
								</label>
							</div>
						</div>
						<div class="form-group row">
							<label for="name" class="col-sm-2 col-form-label"> {{_i('Commission Value')}} <span style="color: #F00;">*</span></label>
							<div class="col-sm-10">
								<input type="text" name="commission_value" class='form-control'>
							</div>
						</div>

						<div class="form-group row" >
							<label class="col-sm-2 col-form-label" for="checkbox2">
								{{_i('Pend Amount')}}
							</label>
							<div class="checkbox-fade fade-in-primary col-sm-6">
								<label class='mr-5'>
									<input type="radio" class='pend-amount' id="checkbox2" name="pend_amount" value="1">
									{{ _i('Yes') }}
									<span class="cr">
										<i class="cr-icon icofont icofont-ui-check txt-primary"></i>
									</span>
								</label>
								<label>
									<input type="radio" class='pend-amount' id="checkbox2" name="pend_amount" value="0">
									{{ _i('No') }}
									<span class="cr">
										<i class="cr-icon icofont icofont-ui-check txt-primary"></i>
									</span>
								</label>
							</div>
						</div>
						<div class="form-group row d-none is-d-none">
							<label for="name" class="col-sm-2 col-form-label"> {{_i('Pend Period')}} <span style="color: #F00;">*</span></label>
							<div class="col-sm-10">
								<input type="text" name="pend_period" class='form-control'>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-offset-2 col-sm-2">
						<button type="submit" class="btn btn-primary pull-leftt">{{ _i('Save') }}</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection
@push('js')
<script>
	$(function () {
		$('.pend-amount').change(function(){
			var _val = $(this).val();
			if( _val == 1)
			{
				$('.is-d-none').removeClass('d-none');
			}
			else
			{
				$('.is-d-none').addClass('d-none');
			}
		})
	});
</script>
@endpush
