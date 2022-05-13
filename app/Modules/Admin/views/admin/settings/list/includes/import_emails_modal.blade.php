<div class="modal fade bd-example-modal-lg" id="import-emails-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">{{ _i('Import Emails') }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="import-emails-form" class="j-pro" enctype="multipart/form-data" data-parsley-validate="" style="box-shadow:none; background: none">
					@csrf
					<div class='m-b-25'>
						<input type="file" name="file" class='form-control' accept=".xlsx,.xls" placeholder="{{ _i('Excel File') }}" required>
						<span class="text-danger">
							<strong id="file-error"></strong>
						</span>
					</div>
					<div class='m-b-25'>
						<label for="groups"></label>
						<select name="groups[]" multiple class="selectpicker form-control" id="groups" title='{{ _i('Please Select Group') }}'>
							<option disabled>{{ _i('Select') }}</option>
								@foreach($groups as $group)
									<option value="{{ $group->id }}">{{ $group->name }}</option>
								@endforeach
						</select>
					</div>
					<div class='m-b-25'>
						<label for="country"></label>
						<select name="country" class="selectpicker country form-control" id="country" title='{{ _i('Please Select Country') }}'>
							<option disabled>{{ _i('Select') }}</option>
								@foreach($countries as $country)
									<option value="{{ $country->id }}">{{ $country->title }}</option>
								@endforeach
						</select>
					</div>
					<div class='m-b-25'>
						<label for="city"></label>
						<select name="city" class="selectpicker city form-control" id="city" title='{{ _i('Please Select Country') }}'>
							<option disabled>{{ _i('Select') }}</option>
								@foreach($cities as $city)
									<option value="{{ $city->id }}">{{ $city->title }}</option>
								@endforeach
						</select>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ _i('Close') }}</button>
				<button type="submit" form="import-emails-form" class="btn btn-primary">{{ _i('Save') }}</button>
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
		.j-pro .j-primary-btn, .j-pro .j-file-button, .j-pro .j-secondary-btn {
			background: #1abc9c;
		}
		.j-pro .j-primary-btn:hover, .j-pro .j-file-button:hover, .j-pro .j-secondary-btn:hover {
			background: #1abc9c;
		}
		.j-pro input[type="text"]:focus, .j-pro input[type="password"]:focus, .j-pro input[type="email"]:focus, .j-pro input[type="search"]:focus, .j-pro input[type="url"]:focus, .j-pro textarea:focus, .j-pro select:focus {
			border: #1abc9c solid 2px !important;
		}
		.j-pro input[type="text"]:hover, .j-pro input[type="password"]:hover, .j-pro input[type="email"]:hover, .j-pro input[type="search"]:hover, .j-pro input[type="url"]:hover, .j-pro textarea:hover, .j-pro select:hover {
			border: #1abc9c solid 2px !important;
		}
		.card .card-header span {
			color: #fff;
		}
		.j-pro .j-tooltip, .j-pro .j-tooltip-image {
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