@extends('admin.layout.index',[
	'title' => _i('Edit Template'),
	'subtitle' => _i('Edit Template'),
	'activePageName' => _i('Edit Template'),
	'activePageUrl' => '',
	'additionalPageUrl' => route('mailing_templates.index') ,
	'additionalPageName' => _i('Mailing Templates'),
] )

@section('content')
	<div class="page-body">
		<div class="row">
			<div class='col-md-9'>
				<div class="card blog-page" id="blog">
					<div class="card-block">
						<form method='post' action='{{ route('mailing_templates.store') }}' class='form-group'>
							@csrf
							<input type="hidden" name="id" value='{{request()->segment(3)}}'>
							<input type="hidden" name="lang_id" value='{{request()->segment(5)}}'>

							<div class="form-group row">
								<label for="title" class="col-sm-2 col-form-label"> {{_i('Title')}} <span style="color: #F00;">*</span></label>
								<div class="col-sm-10">
									<input type="text" name="title" class='form-control' value='{{$template->title ?? ''}}'>
								</div>
							</div>

							<div class="form-group row">
								<label for="subject" class="col-sm-2 col-form-label"> {{_i('Mail Subject')}} <span style="color: #F00;">*</span></label>
								<div class="col-sm-10">
									<input type="text" name="subject" class='form-control' value='{{$template->subject ?? ''}}'>
								</div>
							</div>

							<div class="form-group row">
								<div class="col-sm-2">
									<label for="body" class="control-label"> {{_i('Mail Body')}} <span style="color: #F00;">*</span></label>
								</div>
								<div class="col-sm-10">
									<textarea id="editor1" class="form-control" name="body" placeholder="{{_i('Mail Body')}}">{{$template->body ?? ''}}</textarea>
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
			<div class='col-md-3'>
				<div class="card blog-page" id="blog">
					<div class="card-block">
						<div class='m-1'><b>{{ _i('Availabel Variables') }}</b></div>
						<div class="dropdown-divider"></div>
						<div class='m-1'><small>{activate_url}</small> {{ _i('User Activate URL') }}</div>
						<div class='m-1'><small>{forgot_url}</small> {{ _i('User Forgot Password URL') }}</div>
						<div class="dropdown-divider"></div>
						<div class='m-1'><small>{user_id}</small> {{ _i('User ID') }}</div>
						<div class='m-1'><small>{user_name}</small> {{ _i('User Name') }}</div>
						<div class='m-1'><small>{user_lasname}</small> {{ _i('User Last Name') }}</div>
						<div class='m-1'><small>{user_phone}</small> {{ _i('User Phone') }}</div>
						<div class='m-1'><small>{user_image}</small> {{ _i('User Image') }}</div>
						<div class="dropdown-divider"></div>
						<div class='m-1'><small>{site_name}</small> {{ _i('Site Name') }}</div>
						<div class='m-1'><small>{site_description}</small> {{ _i('Site Description') }}</div>
						<div class='m-1'><small>{site_url}</small> {{ _i('Site URL') }}</div>
						<div class='m-1'><small>{site_email}</small> {{ _i('Site Email') }}</div>
						<div class='m-1'><small>{site_address}</small> {{ _i('Site Adress') }}</div>
						<div class='m-1'><small>{site_logo}</small> {{ _i('Site Logo') }}</div>
					</div>
				</div>
			</div>
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
