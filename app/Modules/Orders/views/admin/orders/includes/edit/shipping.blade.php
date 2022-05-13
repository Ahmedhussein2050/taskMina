<div class="col-md-4">
	<div>
		<div class="card ship">
			<div class="card-header">
				<h5>{{_i("shipping")}}</h5>
				<button class="btn btn-tiffany f-right" data-toggle="modal" data-target="#shipping" type="button">
					<i class="fa fa-edit"></i>{{_i("Edit")}}
				</button>
			</div>
			<div class="clearfix"></div>
			<div class="card-body position-relative">
				@php
					$address2 = $order->addresses()->orderBy('id' , 'DESC')->first() ;
				@endphp
				@if($address == null)
				<span>
					<i class="ti-truck"></i>{{_i("No shipping is required")}}
					<span class="truckIcon"></span>
				</span>
				@elseif( $order->user_id ==0 && $address2  )
					{{--								{{dd($address)}}--}}
					<p><span>{{_i('Country')}} :
										{{\App\Models\countries::find($address2->country_id) ? \App\Models\countries::find($address2->country_id)->data->title : ""}}
									</span></p>
					<p><span>{{_i('City')}} :
										{{\App\Models\cities::find($address2->city_id) ? \App\Models\cities::find($address2->city_id)->data->title : ""}}
									</span></p>
					<p><span>{{_i('Region')}} :
										{{ \App\Site\Region::find($address2->region_id) && \App\Site\Region::find($address2->region_id)->data()->first() ? \App\Site\Region::find($address2->region_id)->data()->first()->title : ""}}
								</span></p>
					<p><span>{{_i('Block')}} :
								{{$address2->block}}
								</span></p>
					<p><span>{{_i('note')}} :
								{{$address2->note}}
								</span></p>
					@if( $order->shipping_option_id != null)
						<div class="truckIcon">
							<div>{{ _i('Country') }} / {{ _i('City') }}
								@if($address->country != NULL && $address->country->data)
									: {{ $address->country->data->title . ' -- ' . $address->city->data->title }}
								@endif
							</div>
							<div>{{ _i('Address') }} : {{ $address->address }}, {{$address->Neighborhood}} , {{$address->street}}  , {{$address->block}} ,{{$address->note}} </div>
							<div>{{ _i('Postal Code') }} : {{ $address->code }}</div>
							@if($company)
								<div>{{ _i('Company') }} : {{ $company->title }}</div>
							@endif
						</div>
					@endif
				@else
					<div class="truckIcon">
						<div>{{ _i('Country') }} / {{ _i('City') }}
							@if($address->country != NULL && $address->country->data)
							: {{ $address->country->data->title . ' -- ' . $address->city->data->title }}
							@endif
						</div>
						<div>{{ _i('Address') }} : {{ $address->address }}, {{$address->Neighborhood}} , {{$address->street}}</div>
						<div>{{ _i('Postal Code') }} : {{ $address->code }}</div>
						@if($company)
						<div>{{ _i('Company') }} : {{ $company->title }}</div>
						@endif
					</div>


					@endif
			</div>
		</div>
	</div>
	<div class="modal fade" ref="shipping" id="shipping" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">{{_i("shipping")}}</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<select class="form-control selectpicker" id="required" onchange="getRequired()">
							<option value="">{{_i("Does It Require Shipping ?")}}</option>
							<option value="0">{{_i("No Shipping Required")}}</option>
							<option value="1">{{_i("Yes Shipping is Required")}}</option>
						</select>
						<input type="hidden" class="Shipping__cost_original">
					</div>
					<div class="shipping_details">


					@if($address != null)
						<input type="hidden" name="countries" value="{{ $address->country_id }}">
						<input type="hidden" name="cities" value="{{ $address->city_id }}">
						<input type="hidden" name="neighborhood" value="{{ $address->Neighborhood }}">
						<input type="hidden" name="street" value="{{ $address->street }}">
						<input type="hidden" name="address" value="{{ $address->address }}">
						<input type="hidden" name="block" value="{{ $address->block }}">
						<input type="hidden" name="note" value="{{ $address->note }}">
						<input type="hidden" name="code" value="{{ $address->code }}">
						@endif
					</div>
					<div class="shipping_options">
						<input type="hidden" form="prod-form" id="shipping_option" name="shipping_option" value="{{ $order->shipping_option_id }}">
					</div>
					<br>
					<input type="hidden" name="order_id" id="order_id" value="{{ $order->id }}">
					<button class="btn btn-tiffany" type="button" onclick="saveshipping()">{{_i("save")}}</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</div>

@push('js')
<script language="javascript">
	function getRequired() {
		window.required = $('#required').val();
		if (required == 1)
		{
			$('.shipping_details').empty();
			$('.shipping_details').append('<div class="section-title" style="background: #f5f5f5;text-align: center;padding: 10px;color: #333;margin: 20px 0;">{{_i("Shipping Details")}}</div>');
			$('.shipping_details').append('<div class="form-group"><select name="countries" class="selectpicker countries" onchange="getcities()"><option selected>{{_i("Choose Country")}}</option></select></div> </br>');
			@foreach($countries as $index => $country)
					$('.countries').append('<option value="{{$index}}">{{$country}}</option>');
			@endforeach
            $('.selectpicker').selectpicker('refresh')
            $('.shipping_details').append('<div class="form-group"><select name="cities" class="form-control cities"  onchange="checkHasSkip()"><option selected>{{_i("Choose City")}}</option></select></div>');
			$('.shipping_details').append('<div class="form-group"><input type="text" class="form-control" name="neighborhood" id="neighborhood" placeholder="{{_i("Neighborhood Name")}}"></div>');
			$('.shipping_details').append('<div class="form-group"><input type="text" class="form-control" name="street" id="street" placeholder="{{_i("Street Name")}}"></div>');
			$('.shipping_details').append('<div class="form-group"><input type="text" class="form-control" name="address" id="address" placeholder="{{_i("House Description")}}"></div>');
			$('.shipping_details').append('<div class="form-group"><input type="text" class="form-control" name="code" id="code" placeholder="{{_i("Postal Code")}}"></div>');
			$('.shipping_options').append('<div class="section-title" style="background: #f5f5f5;text-align: center;padding: 10px;color: #333;margin: 20px 0;">{{_i("Shipping Options")}}</div>');


        }
		else
		{
			$('.shipping_details').empty();
			$('.shipping_options').empty();
			$('.shipping_options').append('<input type="hidden" form="prod-form" id="shipping_option" name="shipping_option" value="0">');
		}



	}

	function getcities()
	{
		country = $('[name="countries"]').val();
		if (country != null)
		{
			$.ajax({
			type: "GET",
				url: "{{ route('getCitiesByCountry') }}",
				dataType: 'json',
				data: {country: country},
				success: function (response) {
				if (response) {
				$(".cities").empty();
				$(".cities").append('<option>{{ _i('select') }}</option>');
				$.each(response, function (key, value) {
				$(".cities").append('<option value="' + key + '">' + value + '</option>');
				});
				} else {
				$(".cities").empty();
				}
				}
			});
		}
	}

	function checkHasSkip()
	{
		window.cityId = $('.cities').val();
		window.route = "{{ route('getShippingOptions') }}";
		axios.post(route, {
		country: JSON.parse(country),
				city: cityId
		}).then((response) =>
		{
			if (response.data.length > 0)
			{
				$('.shipping_options').empty();
				$('.shipping_options').append('<div class="options">');
				$.each(response.data,function(i,option)
				{
					option.delay = option.delay == null ? '' : option.delay;
					$('.options').append('' +
					'<div class="option-column row">' +
					'<div class="col-sm-12 form-radio">' +
					'<div class="radio radio-inline">' +
					'<label for="' + option.id + '" class="delivery_commission"> {{ _i('Company') }} : ' + option.title + ' {{ _i('Delay') }} : ' + option.delay +
					'<input type="radio" onclick="getoptionid(' + option.id +')" id="' + option.id + '" name="shipping_option" value="' + option.id + '" data-delay="' + option.title + ' ' + option.delay + '">' +
					'<i class="helper"></i>' +
					'</label>' +
					'</div>' +
					'</div>' +
					'</div>' +
					'</div>'
					);
					if (option.cash_delivery_commission != null)
					{
						var cash_delivery_commission = Number(option.cash_delivery_commission);
						$('.delivery_commission_payment').text(cash_delivery_commission);
					}
					$('.Shipping__cost').html(option.cost);
					$('.Shipping__cost_original').val(option.cost);
				});

				var total = parseInt($('.total__befor').html());
				var Shipping__cost = parseInt($('.Shipping__cost').html());
				$('.total').html(Number(total + Shipping__cost, 2));
				window.shipping = 1
			}
			else
			{
				$('.shipping_options').empty();
				$('.shipping_options').append('<span class="option-message">{{_i("Shipping is not available for this country or city")}}</span>');
				window.shipping = 0
			}
		});
	}

	function getoptionid(id) {
	window.optionId = id;
	}

	function saveshipping() {
		if (required == 1)
		{
			this.country = JSON.parse(country);
			axios.get(`../../../admin/getcitybyid/${cityId}`).then((response) =>
			{
				$('.truckIcon').empty();
				if (shipping == 1)
				{

                    axios.post('../../orders/updateShippingAddress', {
                        id: $('#order_id').val(),
                        countries: $('select[name="countries"]').find('option:selected').val(),
                        cities: $('select[name="cities"]').find('option:selected').val(),
                        neighborhood: $('#neighborhood').val(),
                        street: $('#street').val(),
                        address: $('#address').val(),
                        code: $('#code').val(),
                        shipping_option: $('input[name="shipping_option"]:checked').val(),
                    }).then((data) => {
                        Swal.fire({
                            position: 'top-end',
                            type: 'success',
                            title: '{{_i("Saved Successfuly")}}',
                            showConfirmButton: false,
                            timer: 2000
                        })

                        $('.truckIcon').append('<div>{{ _i("Country") }} / {{ _i("City") }} : ' + response.data.country_title + ' -- ' + response.data.title + '</div>');
                        $('.truckIcon').append('<div>{{ _i('Address') }} : ' + $('#address').val() + '</div>');
                        $('.truckIcon').append('<div>{{ _i('Shipping Company') }} : ' + $('input[name="shipping_option"]:checked').data('delay') + '</div>');
                        window.shipping_option_id = this.optionId;
                        window.neighborhood = $('#neighborhood').val();
                        window.street = $('#street').val();
                        window.address = $('#address').val();

                    }).catch(function (error) {
                        var errors = error.response.data.errors;
                        var errormessage = []
                        if (errors.name != null) {
                            errormessage.push(errors.name[0])
                        }
                        if (errors.email != null) {
                            errormessage.push(errors.email[0])
                        }
                        Swal.fire({
                            title: '{{_i("Notify")}}',
                            text: errormessage,
                            type: 'warning',
                        })
                    });

				}
				else
				{
					Swal.fire({
					title: '{{ _i('Alert') }}',
							text: "{{ _i('Shipping is not available for Country') }} " + response.data.country_title + " {{ _i('and city') }} " + response.data.title + "",
							type: 'warning',
					});
					$('.truckIcon').append(`{{ _i('Shipping is not available for Country') }} ${response.data.country_title} {{ _i('and city') }} ${response.data.title}`);
					window.shipping_option_id = 'not_existed';
					return;
				}
			});
		}
		else
		{
			$('.truckIcon').empty();
			$('.truckIcon').append(`{{_i("No Shipping Required")}}`);
			window.shipping_option_id = null
		}
		$('#shipping').modal('toggle');
	}
</script>
@endpush
