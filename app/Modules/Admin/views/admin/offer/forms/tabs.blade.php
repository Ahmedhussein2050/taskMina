<div class="card-block accordion-block color-accordion-block">
	<div class="color-accordion" id="color-accordion">
		@foreach ($langs as $item)
		<a class="accordion-msg bg-primary b-none">{{$item->title}}</a>
		<div class="accordion-desc">
			<div class="form-group row">
				<label for="title" class="col-sm-2 col-form-label">
					{{ _i('System Notification') }} </label>

					
				{{-- <div class="form-check form-check-inline"> --}}
					
				{{-- </div> --}}

				<div class="col-sm-10">
					<input class="form-check-input" type="checkbox" name="notified_by" value="system"
					id="defaultCheck1">
					<input type="text" name="not_name{{ $item['code'] }}" class='form-control edit-Inp'>
				</div>

			</div>

			<div class="form-group row">
				<label for="title" class="col-sm-2 col-form-label"> {{ _i('SMS') }}
				</label>
				 
				<div class="col-sm-10">
					<input class="form-check-input" type="checkbox" name="notified_by" value="sms"
						id="defaultCheck1">
					<input type="text" name="sms_name{{ $item['code'] }}" class='form-control edit-Inp'>
				</div>


			</div>

			<div class="form-group row">
				<label for="title" class="col-sm-2 col-form-label"> {{ _i('Mail') }}
				</label>
				
				<div class="col-sm-10">
					<input class="form-check-input " type="checkbox" name="notified_by" value="email"
						id="defaultCheck1"> 
					<textarea name="email_name{{ $item['code'] }}" class='form-control edit-Inp'></textarea>
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
