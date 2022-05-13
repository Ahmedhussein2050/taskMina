@extends('admin.layout.index',[
    'title' => _i('Edit User'),
    'subtitle' => _i('Edit User'),
    'activePageName' => _i('Edit User'),
    'activePageUrl' => '',
    'additionalPageUrl' => route('affiliate_users.index') ,
    'additionalPageName' => _i('Affiliate Users'),
] )

@section('content')
    <!-- Page-body start -->
    <div class="row">
        <div class="col-sm-12">
			<form method="post" action="{{ route('affiliate_users.update', $user->id) }}" class="form-horizontal" data-parsley-validate>
				@csrf
				@method('PATCH')
				<div class="card">
					<div class="card-header">
						<h5> {{ _i('Edit User') }} </h5>
						<div class="card-header-right">
							<i class="icofont icofont-rounded-down"></i>
							<i class="icofont icofont-refresh"></i>
							<i class="icofont icofont-close-circled"></i>
						</div>
					</div>
					<div class="card-block">
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
							<button type="button" class="btn btn-info waves-effect" data-toggle="modal" data-target="#default-Modal">{{_i('Change Password')}}</button>
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
											<option value="{{$category->category_id}}" {{ in_array( $category->category_id, $o_categories) ? 'selected' : '' }}>
												{{$category->title}}
											</option>
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
											<option value="{{$product->product_id}}" {{ in_array( $product->product_id, $o_products) ? 'selected' : '' }}>
												{{$product->title}}
											</option>
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
									<input type="radio" id="checkbox" name="commission_type" value="percentage" @if($options->commission_type == 'percentage') checked @endif>
									{{ _i('Percentage') }}
									<span class="cr">
										<i class="cr-icon icofont icofont-ui-check txt-primary"></i>
									</span>
								</label>
								<label>
									<input type="radio" id="checkbox" name="commission_type" value="amount" @if($options->commission_type == 'amount') checked @endif>
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
								<input type="text" name="commission_value" class='form-control' value='{{$options->commission_value}}'>
							</div>
						</div>

						<div class="form-group row" >
							<label class="col-sm-2 col-form-label" for="checkbox2">
								{{_i('Pend Amount')}}
							</label>
							<div class="checkbox-fade fade-in-primary col-sm-6">
								<label class='mr-5'>
									<input type="radio" class='pend-amount' id="checkbox2" name="pend_amount" value="1" @if($options->pend_amount == 1) checked @endif>
									{{ _i('Yes') }}
									<span class="cr">
										<i class="cr-icon icofont icofont-ui-check txt-primary"></i>
									</span>
								</label>
								<label>
									<input type="radio" class='pend-amount' id="checkbox2" name="pend_amount" value="0" @if($options->pend_amount == 0) checked @endif>
									{{ _i('No') }}
									<span class="cr">
										<i class="cr-icon icofont icofont-ui-check txt-primary"></i>
									</span>
								</label>
							</div>
						</div>
						<div class="form-group row @if($options->pend_amount == 0) d-none @endif is-d-none">
							<label for="name" class="col-sm-2 col-form-label"> {{_i('Pend Period')}} <span style="color: #F00;">*</span></label>
							<div class="col-sm-10">
								<input type="text" name="pend_period" class='form-control' value='{{$options->pend_period}}'>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<button type="submit" class="btn btn-primary "> {{ _i('Save') }}</button>
					</div>
				</div>
			</form>
        </div>
	</div>
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
