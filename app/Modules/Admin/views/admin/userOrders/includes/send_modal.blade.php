<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="send-email" tabindex="-1" role="dialog"
	aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">{{ _i('Send email') }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="send_email_form" class="j-pro" enctype="multipart/form-data" data-parsley-validate=""
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
								<label class="j-icon-left" for="subject">
									<i class="icofont icofont-file-text"></i>
								</label>
								<input type="text" form="send_email_form" placeholder="{{ _i('Message Subject') }}"
									spellcheck="false" id="subject" name="subject">
									<br>
								<label class="j-icon-left" for="message">
									<i class="icofont icofont-file-text"></i>
								</label>
								<textarea form="send_email_form" placeholder="{{ _i('Message Text') }}"
									spellcheck="false" id="message" name="message"></textarea>
								<span
									class="j-tooltip j-tooltip-right-top">{{ _i('Describe your Message as detailed as possible') }}</span>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ _i('Close') }}</button>
				<button type="submit" form="send_email_form" class="btn btn-primary">{{ _i('Send') }}</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-lg" id="send-sms" tabindex="-1" role="dialog"
	aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">{{ _i('Send sms') }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="send_sms_form" class="j-pro" enctype="multipart/form-data" data-parsley-validate=""
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
								<label class="j-icon-left" for="message">
									<i class="icofont icofont-file-text"></i>
								</label>
								<textarea form="send_sms_form" placeholder="{{ _i('Message Text') }}"
									spellcheck="false" id="message" name="message"></textarea>
								<span
									class="j-tooltip j-tooltip-right-top">{{ _i('Describe your Message as detailed as possible') }}</span>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ _i('Close') }}</button>
				<button type="submit" form="send_sms_form" class="btn btn-primary">{{ _i('Send') }}</button>
			</div>
		</div>
	</div>
</div>

@push('css')

<link rel="stylesheet" href="{{asset('AdminFlatAble/pages/j-pro/css/demo.css')}}">
<link rel="stylesheet" href="{{asset('AdminFlatAble/pages/j-pro/css/j-pro-modern.css')}}">

<style>
	.j-pro {
		border: none;
	}

	.j-pro .j-primary-btn,
	.j-pro .j-file-button,
	.j-pro .j-secondary-btn {
		background: #1abc9c;
	}

	.j-pro .j-primary-btn:hover,
	.j-pro .j-file-button:hover,
	.j-pro .j-secondary-btn:hover {
		background: #1abc9c;
	}

	.j-pro input[type="text"]:focus,
	.j-pro input[type="password"]:focus,
	.j-pro input[type="email"]:focus,
	.j-pro input[type="search"]:focus,
	.j-pro input[type="url"]:focus,
	.j-pro textarea:focus,
	.j-pro select:focus {
		border: #1abc9c solid 2px !important;
	}

	.j-pro input[type="text"]:hover,
	.j-pro input[type="password"]:hover,
	.j-pro input[type="email"]:hover,
	.j-pro input[type="search"]:hover,
	.j-pro input[type="url"]:hover,
	.j-pro textarea:hover,
	.j-pro select:hover {
		border: #1abc9c solid 2px !important;
	}

	.card .card-header span {
		color: #fff;
	}

	.j-pro .j-tooltip,
	.j-pro .j-tooltip-image {
		background-color: #1abc9c;
	}

	.j-pro .j-tooltip-right-top:before {
		border-color: #1abc9c transparent;
	}
</style>

<script src="{{asset('AdminFlatAble/pages/j-pro/js/jquery.2.2.4.min.js')}}"></script>
<script src="{{asset('AdminFlatAble/pages/j-pro/js/jquery.maskedinput.min.js')}}"></script>
<script src="{{asset('AdminFlatAble/pages/j-pro/js/jquery.j-pro.js')}}"></script>

@endpush
