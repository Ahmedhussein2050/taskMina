@extends('admin.layout.index',[
'title' => _i('Edit Brand'),
'subtitle' => _i('Edit Brand'),
'activePageName' => _i('Edit Brand'),
'activePageUrl' => '',
'additionalPageUrl' => route('brands.index') ,
'additionalPageName' => _i('All'),
] )

@section('content')

<div class="page-header">
	<div class="page-header-title">
	</div>
	<div class="page-header-breadcrumb">
		<ul class="breadcrumb-title">
			<li class="breadcrumb-item">
				<a href="javascript:void(0)">
					<i class="icofont icofont-home"></i>
				</a>
			</li>
			<li class="breadcrumb-item"><a href="{{route('brands.index')}}">{{_i('Brands')}}</a>
			</li>
		</ul>
	</div>
</div>
<!-- Page-header end -->
<!-- Page-body start -->
<div class="page-body">
	<!-- Blog-card start -->
	<div class="card blog-page" id="blog">
		<div class="card-block">
			@include('admin.layout.swal')
			<form method='post' action='{{ route('brands.update', $brand->id) }}' class='form-group' enctype='multipart/form-data' data-parsley-validate>
				@csrf
				@method('PATCH')
				<div class="form-group row">
					<label for="name" class="col-sm-1 col-form-label"> {{_i('Name')}}</label>
					<div class="col-sm-11">
						<input type="text" name="name" class='form-control' value='{{ $brand_data->name }}' disabled>
						@if ($errors->has('name'))
						<span class="text-danger invalid-feedback" role="alert">
							<strong>{{ $errors->first('name') }}</strong>
						</span>
						@endif
				  </div>
				</div>
				<div class="form-group row">
					<label for="link" class="col-sm-1 col-form-label"> {{_i('link')}} <span style="color: #F00;">*</span></label>
					<div class="col-sm-11">
						<input class="form-control" name="link" placeholder="{{_i('link')}}" value="{{$brand->link}}" type="url" data-parsley-type="link" required="">
						<span class="text-danger invalid-feedback">
							<strong>{{$errors->first('link')}}</strong>
						</span>
					</div>
				</div>
				<div class="form-group row" >
					<label class="col-sm-1 col-form-label" for="checkbox">
						{{_i('Publish')}}
					</label>
					<div class="checkbox-fade fade-in-primary col-sm-6">
						<label>
							<input type="checkbox"  id="checkbox" name="published" value="1" {{$brand->published == 1 ? 'checked' : ''}}>
							<span class="cr">
								<i class="cr-icon icofont icofont-ui-check txt-primary"></i>
							</span>
						</label>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-1 col-form-label">{{_i('Image')}}</label>
					<div class="col-sm-4">
						<input type="file" name="image" id="filex" onchange="showImg(this)" class="btn btn-default" accept="image/gif, image/jpeg, image/png" value="{{old('image')}}">
						<span class="text-danger invalid-feedback">
							<strong>{{$errors->first('image')}}</strong>
						</span>
					</div>
					<div class="col-sm-6">
						<img class="img-responsive pad" id="old_img" style="margin-left:50px;margin-top: -50px; height: 200px;"
						src="{{asset($brand->image)}}">
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
</div>

@endsection

@push('js')

<script>
	function showImg(input) {
		var filereader = new FileReader();
		filereader.onload = (e) => {
			console.log(e);
			$("#old_img").attr('src', e.target.result).width(300).height(250);
		};
		console.log(input.files);
		filereader.readAsDataURL(input.files[0]);
	}
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
