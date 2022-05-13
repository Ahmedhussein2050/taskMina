@extends('admin.layout.index',
[
	'title' => _i('Banks'),
	'subtitle' => _i('Add Bank'),
	'activePageName' => _i('Banks'),
	'activePageUrl' => route('transferBank.index'),
	'additionalPageName' => _i('Settings'),
	'additionalPageUrl' => route('settings.index') ,
])

@section('content')
	<div class="page-body">
		<!-- Blog-card start -->
		<div class="card blog-page" id="blog">
			<div class="card-block">
			<form  action="{{url('/admin/transferBank')}}" method="post" class="form-horizontal" id="fileupload"  enctype="multipart/form-data" data-parsley-validate="">
				@csrf
				<div class="box-body">
					<div class="form-group row">
						<label for="title" class="col-sm-2 control-label" >{{ _i('Language') }} <span style="color: #F00;">*</span></label>
						<div class="col-sm-6">
							<select class="form-control" name="lang_id" id="language_addform" required="" class="form-control">
								<option selected disabled="">{{_i('CHOOSE')}}</option>
								@foreach($languages as $lang)
								<option value="{{$lang->id}}">{{($lang->title)}}</option>
								@endforeach
							</select>
							<small  class="form-text text-muted">{{_i('Please select language')}}</small>
						</div>
					</div>

					<div class="form-group row" >

						<label class="col-sm-2 col-form-label " for="txtUser">
							{{_i('The Name')}} </label>
						<div class="col-sm-6">
							<input type="text" name="title" value="{{old('title')}}" id="title" required="" class="form-control">
							@if ($errors->has('title'))
								<span class="text-danger invalid-feedback">
									<strong>{{ $errors->first('title') }}</strong>
								</span>
							@endif
						</div>
					</div>
					<!-- ================================== holder_name =================================== -->
					<div class="form-group row" >

						<label class="col-sm-2 col-form-label " for="holder_name">
							{{_i('The Holder Name')}} </label>
						<div class="col-sm-6">
							<input type="text" name="holder_name" value="{{old('holder_name')}}" id="holder_name" required="" class="form-control">
							@if ($errors->has('holder_name'))
								<span class="text-danger invalid-feedback">
									<strong>{{ $errors->first('holder_name') }}</strong>
								</span>
							@endif
						</div>
					</div>
					<!-- ================================== iban =================================== -->
					<div class="form-group row" >

						<label class="col-sm-2 col-form-label " for="iban">
							{{_i('Iban')}} </label>
						<div class="col-sm-6">
							<input type="text" name="iban" value="{{old('iban')}}" id="iban" required="" class="form-control">
							@if ($errors->has('iban'))
								<span class="text-danger invalid-feedback">
									<strong>{{ $errors->first('iban') }}</strong>
								</span>
							@endif
						</div>
					</div>
					<!-- ================================== holder_number =================================== -->
					<div class="form-group row" >

						<label class="col-sm-2 col-form-label " for="holder_number">
							{{_i('Holder number')}} </label>
						<div class="col-sm-6">
							<input type="number" min="1" max="999999999" name="holder_number" value="{{old('holder_number')}}" id="holder_number" required="" class="form-control">
							@if ($errors->has('holder_number'))
								<span class="text-danger invalid-feedback">
									<strong>{{ $errors->first('holder_number') }}</strong>
								</span>
							@endif
						</div>
					</div>
				   <!-- ================================== Attachments =================================== -->
					<div class="form-group row">
						<label class="col-sm-2 col-form-label" for="logo">{{_i('Logo')}}</label>
						<div class="col-sm-4">
							<input type="file" name="logo" id="logo" onchange="showImg(this)" class="btn btn-default" accept="image/gif, image/jpeg, image/png"
								   value="{{old('Logo')}}">
							<span class="text-danger invalid-feedback">
								<strong>{{$errors->first('logo')}}</strong>
							</span>
						</div>
						<!-- Photo -->
						<div class="col-sm-6">
							<img class="img-responsive pad" id="article_img" style="margin: 0 auto;display: block;">
						</div>
					</div>



				</div>
				<!-- /.box-body -->
				<div class="box-footer">

					<button type="submit" class="btn btn-info pull-left" >
						{{_i('Add')}}
					</button>
				</div>
				<!-- /.box-footer -->
			</form>

		</div>
	</div>
	</div>


@endsection

@push('js')
	<script>


		function showImg(input) {

			var filereader = new FileReader();
			filereader.onload = (e) => {
				console.log(e);
				$('#article_img').attr('src', e.target.result).width(250).height(250);
			};
			console.log(input.files);
			filereader.readAsDataURL(input.files[0]);

		}
	</script>

@endpush
