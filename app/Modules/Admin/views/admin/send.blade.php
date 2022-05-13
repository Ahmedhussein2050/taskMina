@extends('admin.layout.index',[
	'title' => _i('Send Email & SMS'),
	'subtitle' => _i('Send Email & SMS'),
	'activePageName' => _i('Send Email & SMS'),
	'activePageUrl' => '',
	'additionalPageUrl' => '' ,
	'additionalPageName' => '',
] )

@section('content')

<div class="box-body">
	<div class="row">
		<div class="col-sm-12">
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item">
					<a class="nav-link active btn btn-primary" id="email-tab" data-toggle="tab" href="#email" role="tab" aria-controls="email" aria-selected="true">
						{{ _i('Send email') }}
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link btn btn-primary" id="sms-tab" data-toggle="tab" href="#sms" role="tab" aria-controls="sms" aria-selected="false">
						{{ _i('Send SMS') }}
					</a>
				</li>
			</ul>
			<div class="tab-content" id="myTabContent">
				<div class="tab-pane fade show active" id="email" role="tabpanel" aria-labelledby="email-tab">
					<div class="card">
						<div class="card-header">
							<h5>{{_i('Send Email')}}</h5>
							<div class="card-header-right">
								<i class="icofont icofont-rounded-down"></i>
								<i class="icofont icofont-refresh"></i>
								<i class="icofont icofont-close-circled"></i>
							</div>
						</div>
						<div class="card-block">
							<form id="send_email_form" data-parsley-validate=""
								style="box-shadow:none; background: none">
								@csrf
								<input type="hidden" name='type' value='email'>
								<input type="hidden" name='message_type' value='' class='message-type'>
								<div class="j-content">
									<div class="row mb-1">
										<div class="col-md-12">
											<div class="form-group">
												<label for="exampleInputEmail1">{{ _i('Group') }}</label>
												<select name="group" class='selectpicker form-control'>
													<option value="0">{{ _i('Nothing selected') }}</option>
													@foreach( $groups AS $group )
													<option value="{{ $group->id }}">{{ $group->title }}</option>
													@endforeach
												</select>
											</div>
										</div>
									</div>
									<div class="row mb-1">
										<div class="col-md-12">
											<div class="form-group">
												<label for="exampleInputEmail1">{{ _i('User') }}</label>
												<select name="users[]" class='selectpicker form-control' data-live-search=true multiple>
													@foreach( $users AS $user )
													<option value="{{ $user->id }}">{{ $user->name }}</option>
													@endforeach
												</select>
											</div>
										</div>
									</div>
									<div class="row mb-1">
										<div class="col-md-6">
											<div class="form-group">
												<button type='button' class='col-md-12 btn btn-default message-type' data-type='template'>
													<i class="icofont icofont-file-text"></i>
													{{ _i('Choose from templates') }}
												</button>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<button type='button' class='col-md-12 btn btn-default message-type' data-type='message'>
													<i class="icofont icofont-file-text"></i>
													{{ _i('Write your message') }}
												</button>
											</div>
										</div>
									</div>
									<div class="row mb-1 template message-type-tab" hidden>
										<div class="col-md-12">
											<div class="form-group">
												<label for="exampleInputEmail1">{{ _i('Choose template') }}</label>
												<select name="template" class='selectpicker form-control'>
													<option value="0">{{ _i('Nothing selected') }}</option>
													@foreach( $templates AS $template )
													<option value="{{ $template->id }}">{{ $template->title }}</option>
													@endforeach
												</select>
											</div>
										</div>
									</div>
									<div class="j-unit message message-type-tab" hidden>
										<div class="j-input">
											<textarea form="send_email_form" placeholder="{{ _i('Message Text') }}"
												spellcheck="false" id="message" name="message" class='mb-2 form-control' rows=7></textarea>
										</div>
									</div>
									<button type="submit" form="send_email_form" class="btn btn-primary">
										{{ _i('Send') }}
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="sms" role="tabpanel" aria-labelledby="sms-tab">
					<div class="card">
						<div class="card-header">
							<h5>{{_i('Send SMS')}}</h5>
							<div class="card-header-right">
								<i class="icofont icofont-rounded-down"></i>
								<i class="icofont icofont-refresh"></i>
								<i class="icofont icofont-close-circled"></i>
							</div>
						</div>
						<div class="card-block">
							<form id="send_sms_form" data-parsley-validate=""
								style="box-shadow:none; background: none">
								@csrf
								<input type="hidden" name='type' value='sms'>
								<input type="hidden" name='message_type' value='' class='message-type'>
								<div class="j-content">
									<div class="row mb-1">
										<div class="col-md-12">
											<div class="form-group">
												<label for="exampleInputEmail1">{{ _i('Group') }}</label>
												<select name="group" class='selectpicker form-control'>
													<option value="0">{{ _i('Nothing selected') }}</option>
													@foreach( $groups AS $group )
													<option value="{{ $group->id }}">{{ $group->title }}</option>
													@endforeach
												</select>
											</div>
										</div>
									</div>
									<div class="row mb-1">
										<div class="col-md-12">
											<div class="form-group">
												<label for="exampleInputEmail1">{{ _i('User') }}</label>
												<select name="users[]" class='selectpicker form-control' data-live-search=true multiple>
													@foreach( $users AS $user )
													<option value="{{ $user->id }}">{{ $user->name }}</option>
													@endforeach
												</select>
											</div>
										</div>
									</div>
									<div class="row mb-1">
										<div class="col-md-6">
											<div class="form-group">
												<button type='button' class='col-md-12 btn btn-default message-type' data-type='template'>
													<i class="icofont icofont-file-text"></i>
													{{ _i('Choose from templates') }}
												</button>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<button type='button' class='col-md-12 btn btn-default message-type' data-type='message'>
													<i class="icofont icofont-file-text"></i>
													{{ _i('Write your message') }}
												</button>
											</div>
										</div>
									</div>
									<div class="row mb-1 template message-type-tab" hidden>
										<div class="col-md-12">
											<div class="form-group">
												<label for="exampleInputEmail1">{{ _i('Choose template') }}</label>
												<select name="template" class='selectpicker form-control'>
													<option value="0">{{ _i('Nothing selected') }}</option>
													@foreach( $templates AS $template )
													<option value="{{ $template->id }}">{{ $template->title }}</option>
													@endforeach
												</select>
											</div>
										</div>
									</div>
									<div class="j-unit message message-type-tab" hidden>
										<div class="j-input">
											<textarea form="send_sms_form" placeholder="{{ _i('Message Text') }}"
												spellcheck="false" id="message" name="message" class='mb-2 form-control' rows=7></textarea>
										</div>
									</div>
									<button type="submit" form="send_sms_form" class="btn btn-primary">
										{{ _i('Send') }}
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@push('js')
    <script>
		$(function() {
            $('#send_email_form').submit(function (e) {
                e.preventDefault();
                var url = "{{ route('UserSend') }}";
				var form = $("#send_email_form").serialize();
                $.ajax({
                    url: url,
                    type: "post",
                    data: new FormData(this),
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,

                    success: function (res) {
                        console.log(res);
                        if (res == 'error') {
                            new Noty({
                                type: 'error',
                                text: '{{ _i('All fields are required') }}',
                                timeout: 2000,
                                killer: true
                            }).show();
                        } else {
                            $('.modal').modal('hide');
                            $("#send_email_form").parsley().reset();
                            $('#message').val("");
                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: "{{ _i('Message on its Way')}}",
                                timeout: 2000,
                                killer: true
                            }).show();
                        }
                    }
                })
			});

			$('#send_sms_form').submit(function (e) {
                e.preventDefault();
                var url = "{{ route('UserSend') }}";

                $.ajax({
                    url: url,
                    type: "post",
                    data: new FormData(this),
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,

                    success: function (res) {
                        console.log(res);
                        if (res == 'error') {
                            new Noty({
                                type: 'error',
                                text: '{{ _i('All fields are required') }}',
                                timeout: 2000,
                                killer: true
                            }).show();
                        } else {
                            $('.modal').modal('hide');
                            $("#send_sms_form").parsley().reset();
                            $('#message').val("");
                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: "{{ _i('Message on its Way')}}",
                                timeout: 2000,
                                killer: true
                            }).show();
                        }
                    }
                })
			});
        });

		$(document).on('click', '.message-type', function(){
			var type = $(this).data('type');
			$('.message-type-tab').attr('hidden', true);
			$('.' + type).removeAttr('hidden');
			$('.message-type').removeClass('bg-red');
			$(this).addClass('bg-red');
			$('.message-type').val(type);
		})
    </script>

@endpush
