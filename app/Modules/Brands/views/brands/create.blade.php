@extends('admin.layout.index',[
	'title' => _i('Add Brand'),
	'subtitle' => _i('Add Brand'),
	'activePageName' => _i('Add Brand'),
	'activePageUrl' => '',
	'additionalPageUrl' => route('brands.index') ,
	'additionalPageName' => _i('All'),
] )

@section('content')
	<div class="page-body">
		<!-- Blog-card start -->
		<div class="card blog-page" id="blog">
			<div class="card-block">
			@include('admin.layout.swal')
			<form method='post' action='{{ route('brands.store') }}' class='form-group' enctype='multipart/form-data' data-parsley-validate>
			@csrf
			<div class="form-group row">
				<label for="title" class="col-sm-2 control-label" >{{ _i('Language') }} <span style="color: #F00;">*</span></label>
				<div class="col-sm-10">
					<select class="form-control" name="lang_id" id="language_addform" required="">
						<option selected disabled="">{{_i('CHOOSE')}}</option>
						@foreach($languages as $lang)
						<option value="{{$lang->id}}">{{($lang->title)}}</option>
						@endforeach
					</select>
					<small  class="form-text text-muted">{{_i('Please select language')}}</small>
				</div>
			</div>

			<div class="form-group row">
				<label for="name" class="col-sm-2 col-form-label"> {{_i('Name')}} <span style="color: #F00;">*</span></label>
				<div class="col-sm-10">
					<input type="text" name="name" class='form-control'>
					@if ($errors->has('name'))
						<span class="text-danger invalid-feedback" role="alert">
						  <strong>{{ $errors->first('name') }}</strong>
						</span>
					@endif
				</div>
			</div>

			<!-- checkbox -->
				<div class="form-group row" >
					<label class="col-sm-2 col-form-label" for="checkbox">
						{{_i('Publish')}}
					</label>
					<div class="checkbox-fade fade-in-primary col-sm-6">
						<label>
							<input type="checkbox"  id="checkbox" name="published" value="1" >
							<span class="cr">
									<i class="cr-icon icofont icofont-ui-check txt-primary"></i>
								</span>
						</label>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-2 col-form-label">{{_i('Image')}}</label>
					<div class="col-sm-4">
						<input type="file" name="image" id="filex" onchange="showImg(this)" class="btn btn-default" accept="image/gif, image/jpeg, image/png"
							   value="{{old('image')}}">
						<span class="text-danger invalid-feedback">
							<strong>{{$errors->first('image')}}</strong>
						</span>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-2">
						<label for="description" class="control-label"> {{_i('Description')}} </label>
					</div>
					<div class="col-sm-10">
						<textarea id="editor1" class="form-control" name="description" placeholder="{{_i('Brand description')}}">{{old('description')}}</textarea>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-offset-2 col-sm-2">
						<button type="submit" class="btn btn-primary pull-leftt"> {{_i('Save')}}</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection

@push('js')

<script>
	$(function () {
		CKEDITOR.editorConfig = function (config) {
		config.baseFloatZIndex = 102000;
		config.FloatingPanelsZIndex = 100005;
		};
		CKEDITOR.replace('editor1', {
		 language: '{{\App\Bll\Lang::get_language_by_code()->code}}',
		extraPlugins: 'colorbutton,colordialog',
				filebrowserUploadUrl: "{{asset('masterAdmin/bower_components/ckeditor/ck_upload_master')}}",
				filebrowserUploadMethod: 'form'
		});
		});
</script>

@endpush
