

<div class="card-block accordion-block color-accordion-block">
	<div class="color-accordion" id="color-accordion">
		@foreach ($langs as $item)

		@php

	$system = ($Discount->systemNotifications->first()==null)? new stdClass() :  $Discount->systemNotifications->first()->message;
		$sms = ($Discount->smsNotifications->first()==null)? new stdClass() :  $Discount->smsNotifications->first()->message;
		$email = ($Discount->emailNotifications->first()==null)? new stdClass() :  $Discount->emailNotifications->first()->message;


		@endphp
			<a class="accordion-msg bg-primary b-none">{{$item->title}}</a>
		<div class="accordion-desc">
			<div class="form-group row">
				<label for="title" class="col-sm-2 col-form-label">
					{{ _i('System Notification') }} </label>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="checkbox"  name="notified_by[]" value="notification" {{$disabled}} 						id="defaultCheck1">
				</div>

				<div class="col-sm-10">
					<input {{$disabled}}  type="text" name="system[{{ $item['code'] }}]" value="@php if(property_exists($system,$item->code)) echo  $system->{$item->code} @endphp" class='form-control edit-Inp'>
				</div>


			</div>

			<div class="form-group row">
				<label for="title" class="col-sm-2 col-form-label"> {{ _i('SMS') }}
				</label>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="checkbox" name="notified_by" value="sms"
						id="defaultCheck1">
				</div>
				<div class="col-sm-10">
					<input type="text" {{$disabled}}  name="sms[{{ $item['code'] }}]" value="@php if(property_exists($sms,$item->code)) echo  $sms->{$item->code} @endphp" class='form-control edit-Inp'>
				</div>


			</div>

			<div class="form-group row">
				<label for="title" class="col-sm-2 col-form-label"> {{ _i('Mail') }}
				</label>
				<div class="form-check form-check-inline">
					<input class="form-check-input " type="checkbox" name="notified_by" value="email"
						id="defaultCheck1">
				</div>
				<div class="col-sm-10">
					<textarea {{$disabled}} name="email[{{ $item['code'] }}]" class='form-control edit-Inp'>@php if(property_exists($email,$item->code)) echo  $email->{$item->code} @endphp</textarea>
				</div>


			</div>
		</div>

		@endforeach

	</div>
</div>

<p>
</p>

<!-- Color Open Accordion ends -->
@push('js')
    <!-- Accordion js -->
    <script type="text/javascript" src="{{ asset('AdminFlatAble/pages/accordion/accordion.js') }}"></script>
@endpush
