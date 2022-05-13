<div class="col-md-4">
	<div>
		<div class="card ship">
			<div class="card-header">
				<h5>{{_i("shipping")}}</h5>
				<button class="btn btn-tiffany f-right" data-toggle="modal" data-target="#shipping"
						type="button"><i
						class="fa fa-edit"></i>{{_i("edit")}}</button>
			</div>
			<div class="clearfix"></div>
			<div class="card-body position-relative">
				<span>
					<i class="ti-truck fa-5x"></i>
					<span class="truckIcon"></span>
				</span>

			</div>
		</div>

	</div>
	<div class="modal fade" ref="shipping" id="shipping" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">{{_i("shipping")}}</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<select class="form-control" placeholder="select" id="required"
								onchange="getRequired()">
							<option value="">{{_i("Does It Require Shipping ?")}}</option>
							<option value="0">{{_i("No Shipping Required")}}</option>
							<option value="1">{{_i("Yes Shipping is Required")}}</option>
						</select>
						<input type="hidden" class="Shipping__cost_original">
					</div>
					<div class="shipping_details">

					</div>
					<div class="shipping_options">

					</div>
					<br>
					<button class="btn btn-tiffany" type="button" onclick="saveshipping()">{{_i("save")}}</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</div>

@push('js')

	<script language="javascript">
		function getRequired() {
			window.required = $('#required').val()
			if (required == 1) {
				$('.shipping_details').empty();
				$('.shipping_details').append('<div class="section-title" style="background: #f5f5f5;text-align: center;padding: 10px;color: #333;margin: 20px 0;">{{_i("Shipping Details")}}</div>');
				$('.shipping_details').append('<div class="form-group"><select name="countries" class="form-control countries" onchange="getcities()"><option selected>{{_i("Choose Country")}}</option></select></div>');
				@foreach(\App\Modules\Admin\Models\countries_data::where('lang_id', \App\Bll\Lang::getSelectedLangId())->get() as $country)
				$('.countries').append('<option value="{{$country->country_id}}">{{$country->title}}</option>');
				@endforeach
				$('.shipping_details').append('<div class="form-group"><select name="cities" class="form-control cities"  onchange="checkHasSkip()"><option selected>{{_i("Choose City")}}</option></select></div>');
				$('.shipping_details').append('<div class="form-group"><input type="text" class="form-control" name="neighborhood" id="neighborhood" placeholder="{{_i("Neighborhood Name")}}"></div>');
				$('.shipping_details').append('<div class="form-group"><input type="text" class="form-control" name="street" id="street" placeholder="{{_i("Street Name")}}"></div>');
				$('.shipping_details').append('<div class="form-group"><input type="text" class="form-control" name="address" id="address" placeholder="{{_i("House Description")}}"></div>');
				$('.shipping_details').append('<div class="form-group"><input type="text" class="form-control" name="code" id="code" placeholder="{{_i("Postal Code")}}"></div>');
				$('.shipping_options').append('<div class="section-title" style="background: #f5f5f5;text-align: center;padding: 10px;color: #333;margin: 20px 0;">{{_i("Shipping Options")}}</div>');
			} else {
				$('.shipping_details').empty();
				$('.shipping_options').empty();
			}
		}

		function getcities() {
			country = $('[name="countries"]').val();
			$.ajax({
				url: '{{ url('/admin/getcitiesbycountry') }}/' +country,
				type: 'get',
				data: {country: country},
				success(response) {
					//window.cities = response.data;
					//console.log(response);
					$('.cities').empty();
					$('.cities').append('<option selected>{{_i("Choose City")}}</option>');

					$.each(response, function (key, value) {
						//console.log(value.city_id);
						$(".cities").append('<option value="' + value.city_id + '"  class="city">' + value.title + '</option>');
					});
				}
			});

			//axios.get(`../admin/getcitiesbycountry/${country}`).then((response) => {
				// window.cities = response.data;
				// $('.cities').empty();
				//$('.cities').append('<option selected>{{_i("Choose City")}}</option>');
				// for (let city of cities) {
				//
				// 	$('.cities').append(`<option value="${city.city_id}" class="city">${city.title}</option>`)
				// }
			//})
		}

		var shipping = 0;
		function checkHasSkip() {
			window.cityId = $('.cities').val();
			axios.post('../admin/getShippingOptions', {
				country: JSON.parse(country),
				city: cityId
			}).then((response) => {
				if (response.data.length > 0) {
					shipping = 1
					$('.shipping_options').empty();
					$('.shipping_options').append('<div class="options">');
					for (option of response.data) {
						option.delay = option.delay != null ? option.delay : '';
						$('.options').append('' +
							'<div class="option-column row">' +
							'<div class="col-sm-12 form-radio">' +
							'<div class="radio radio-inline">' +
							'<label for="' + option.id + '" class="delivery_commission"> {{ _i('Company') }} : ' + option.title + ' {{ _i('Delay') }} : ' + option.delay +
							'<input type="radio" onclick="getoptionid(' + option.id +')" id="' + option.id + '" name="shipping_option" class="shipping-option-selected" value="' + option.id + '" data-delay="' + option.title + ' ' + option.delay + '" data-cost="'+option.cost+'" data-cod="'+option.cash_delivery_commission+'">' +
							'<i class="helper"></i>' +
							'</label>' +
							'</div>' +
							'</div>' +
							'</div>' +
							'</div>'
						);
					}
					var total = parseInt($('.total__befor').html());
					var Shipping__cost = parseFloat($('.Shipping__cost').html());
					$('.total').html($.number(total + Shipping__cost, 3));
				} else {
					$('.shipping_options').empty();
					$('.shipping_options').append('<span class="option-message">{{_i("Shipping is not available for this country or city")}}</span>');
					shipping = 0
					$('.Shipping__cost').html('');
					$('.Shipping__cost_original').val(0);
				}
				calculate();
			});
		}
		function getoptionid(id) {
			window.optionId = id;
		}

		$(document).on('click', '.shipping-option-selected', function(){
			var $this = $(this);
			$('.cod__cost').text($this.data('cod'));
			$('.cod_input').val($this.data('cod'));
			$('.Shipping__cost').html($this.data('cost'));
			$('.Shipping__cost_original').val($this.data('cost'));
			calculate();
		})

		function saveshipping() {
			if (required == 1) {
				this.country = JSON.parse(country);
				axios.get(`../admin/getcitybyid/${cityId}`).then((response) => {
					console.log(response);
					$('.truckIcon').empty();
					if (shipping == 1) {
						let country = response.data.country_title;
						let city = response.data.title;
						let address = $('#address').val();
						let shipping_option = $('input[name="shipping_option"]:checked').data('delay');
						$('.truckIcon').append('<div>{{ _i('Country') }} / {{ _i('City') }} : ' + country + ' -- ' + city + '</div>');
						$('.truckIcon').append('<div>{{ _i('Address') }} : ' + address + '</div>');
						$('.truckIcon').append('<div>{{ _i('Shipping Company') }} : ' + $('input[name="shipping_option"]:checked').data('delay') + '</div>');
						$('.truckIcon').append(`
							<input type="hidden" name="country" id="${country}" value="${country}">
							`);
						$('.truckIcon').append(`
							<input type="hidden" name="city" id="${city}" value="${city}">
							`);
						$('.truckIcon').append(`
							<input type="hidden" name="house" id="${address}" value="${address}">
							`);
						$('.truckIcon').append(`
							<input type="hidden" name="shipping_option" id="${shipping_option}" value="${shipping_option}">
							`);
						window.shipping_option_id = this.optionId;
						window.neighborhood = $('#neighborhood').val();
						window.street = $('#street').val();
						window.address = $('#address').val();
					} else {
						Swal.fire({
							title: '{{ _i('Alert') }}',
							text: "{{ _i('Shipping is not available for Country') }} " + country.title + " {{ _i('and city') }} " + response.data.title + "",
							type: 'warning',
						});
						$('.truckIcon').append(`{{ _i('Shipping is not available for Country') }} ${country.title} {{ _i('and city') }} ${response.data.title}`);
						window.shipping_option_id = 'not_existed';
						return;
					}
				});
			} else {
				$('.truckIcon').empty();
				$('.truckIcon').append(`{{_i("No Shipping Required")}}`);
				window.shipping_option_id = null
			}
			$('#shipping').modal('toggle');
		}
	</script>
@endpush
