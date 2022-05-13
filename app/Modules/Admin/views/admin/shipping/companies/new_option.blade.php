@push('js')
    <script>
        var number_of_iteration = 0;
        $('body').on('change', '.delivery_method', function() {
            var selectedMethod = $(this).children("option:selected").val();
            if (selectedMethod == 'available') {


                $(this).closest('.single_shipping_price').find('.cach_commission').show();

            } else {
                // $(this).closest('.single_shipping_price').find('.cach_commission').empty();
                $(this).closest('.single_shipping_price').find('.cach_commission').hide();
            }
            //alert("You have selected the country - " + selectedMethod);
        });

        $('body').on('change', '.pricing_type', function() {
            var selectedType = $(this).children("option:selected").val();
            if (selectedType == 'by_weight') {
                $(this).closest('.single_shipping_price').find('.pricing_type_by_weight').show();
                $(this).closest('.single_shipping_price').find('.pricing_type_fixed').hide();



                $(this).closest('.single_shipping_price').find($('.no_kg').prop('required', true));
                $(this).closest('.single_shipping_price').find($('.cost_no_kg').prop('required', true));
                $(this).closest('.single_shipping_price').find($('.cost_increase').prop('required', true));
                $(this).closest('.single_shipping_price').find($('.kg_increase').prop('required', true));
                $(this).closest('.single_shipping_price').find($('.cost').prop('required', false));

            } else {
                $(this).closest('.single_shipping_price').find('.pricing_type_fixed').show();
                $(this).closest('.single_shipping_price').find('.pricing_type_by_weight').hide();

                $(this).closest('.single_shipping_price').find($('.cost').prop('required', true));
                $(this).closest('.single_shipping_price').find($('.no_kg').prop('required', false));
                $(this).closest('.single_shipping_price').find($('.cost_no_kg').prop('required', false));
                $(this).closest('.single_shipping_price').find($('.cost_increase').prop('required', false));
                $(this).closest('.single_shipping_price').find($('.kg_increase').prop('required', false));
            }
            //alert("You have selected the country - " + selectedMethod);
        });

        $(document).on('click', '.add_shipping_price', function() {
			var section_shipping_price_add = "section_shipping_price_add";
            // var html = ` <div class="card">
            //             <div class="card-block">
            //                 <div class="card-body card-block text-center">`;
            html = ' <div class="single_shipping_price single_shipping_price_v2" data-number="' +
                (number_of_iteration++) + '" id="option_' + number_of_iteration + '">';

				 html += ` <div class="card">
                        <div class="card-block">
                            <div class="card-body card-block text-center">`;

            html += '<div class="form-group row "> <div class="col-sm-12"> <div class="input-group ">';
            html += '<select class="form-control country_id" name="country_id[' + number_of_iteration +
                ']" required="" data-id="' + number_of_iteration + '">';
            html += '<option selected disabled  >{{ _i('Choose Country') }}</option>';
            html += '<option  value="all" >{{ _i('All Countries') }}</option>';
            @foreach ($countries as $country)
                html += '<option value="{{ $country->id }}">{{ $country->title }}</option>';
            @endforeach
            html += '</select>';
            html +=
                '<span class="input-group-addon input-group-addon-small" id="basic-addon5"> <i class="ti ti-map"></i></span>';
            html += '</div> </div> </div>';

            //<!--------------------------- cities--------------------->
            html += '<div class="form-group row "> <div class="col-sm-12"> <div class="input-group ">';

            html += '<select class="form-control selectpicker city_id" data-live-search="true" multiple="multiple" name="city_id[' + number_of_iteration +
                '][]"  required="">';
			html += '<option  value="all">{{ _i('All Cities') }}</option>';
            html += '</select>';
            html +=
                '<span class="input-group-addon input-group-addon-small" id="basic-addon5"> <i class="ti ti-map-alt"></i></span>';
            html += '</div> </div> </div>';
            //<!--------------------------- regions--------------------->
            html += '<div style="display:none" class="form-group row "> <div class="col-sm-12"> <div class="input-group ">';

            html +=
                '<select  class="form-control  region_id "  name="region_id[' +
                number_of_iteration + '][]"  multiple="multiple" >';
            html += '<option  value="all">{{ _i("All Regions") }}</option>';
            html += '</select>';
            html +=
                '<span class="input-group-addon input-group-addon-small" id="basic-addon5"> <i class="ti ti-map-alt"></i></span>';
            html += '</div> </div> </div>';
            //<!--------------------------- pricing type --------------------->
            html += '<div class="form-group row "> <div class="col-sm-12"> <div class="input-group ">';
            html += '<select class="form-control  pricing_type"  name="pricing_type[' + number_of_iteration +
                ']" >';
            html += '<option selected value="fixed">{{ _i('Pricing Type : Fixed') }}</option>';
            html += '<option  value="by_weight">{{ _i('Pricing Type : By Weight') }}</option>';
            html += '</select>';
            html +=
                '<span class="input-group-addon input-group-addon-small" id="basic-addon5"><i class="ti ti-wallet"></i></span>';
            html += '</div> </div> </div>';

            //<!--------------------------------------------------------- shipping cost --------------------->
            //<!----------------------- if Pricing Type : By Weight ----------------->
            html += '<div class="pricing_type_by_weight" style="display: none" >';
            html +=
                '<div class="form-group row "><div class="col-sm-12"><label  > {{ _i('Cost') }}</label></div>';
            html += ' <div class="col-sm-6"><div class="input-group ">';
            html +=
                ' <input class="form-control no_kg" type="number"  name="no_kg[' + number_of_iteration +
                ']" placeholder="{{ _i('The first kilogram') }}">';
            html += ' <button type="button" class="btn btn-tiffany btn-sm mr-3 ">{{ _i('KG') }}</button>';
            html += ' </div> </div>';
            html += ' <div class="col-sm-6"><div class="input-group ">';
            html +=
                ' <input class="form-control cost_no_kg" type="number"  name="cost_no_kg[' + number_of_iteration +
                ']" placeholder="{{ _i('Shipping Cost') }}">';
            html += ' <button type="button" class="btn btn-tiffany btn-sm mr-3 ">{{ _i('SR') }}</button>';
            html += ' </div> </div> </div>';
            //<!-------------- Cost of the increase ---------->
            html +=
                ' <div class="form-group row "><div class="col-sm-12"><label  > {{ _i('Cost of the increase') }}</label></div>';
            html += ' <div class="col-sm-6"><div class="input-group ">';
            html +=
                ' <input class="form-control cost_increase " type="number"  name="cost_increase[' +
                number_of_iteration + ']" placeholder="{{ _i('Cost of the increase') }}">';
            html += ' <button type="button" class="btn btn-tiffany btn-sm mr-3 ">{{ _i('SR') }}</button>';
            html += ' </div> </div>';
            html += ' <div class="col-sm-6"><div class="input-group ">';
            html +=
                ' <input class="form-control kg_increase" type="number"  name="kg_increase[' + number_of_iteration +
                ']" placeholder="{{ _i('Cost by weight') }}">';
            html += ' <button type="button" class="btn btn-tiffany btn-sm mr-3 ">{{ _i('KG') }}</button>';
            html += ' </div> </div> </div> </div>';

            //<!--------------------------- if Pricing Type : Fixed --------------------->
            html +=
                ' <div class="pricing_type_fixed"><div class="form-group row "><div class="col-sm-12"><div class="input-group ">';
            html +=
                ' <input class="form-control cost" type="number"  name="cost[' + number_of_iteration +
                ']" placeholder="{{ _i('Shipping Cost') }}">';
            html +=
                ' <span class="input-group-addon input-group-addon-small" id="basic-addon5">SAR</span>';

            html += ' </div> </div> </div> </div>';

            // <!--------------------------- shipping time -------------------------------------------------------->
            html += '<div class="form-group row "><div class="col-sm-6"><div class="input-group ">';
            html +=
                '<input type="number" class="form-control " name="delay[' + number_of_iteration +
                ']" placeholder="{{ _i('Shipping time (For example 3-5 days)') }}">';
            html +=
                '<span class="input-group-addon input-group-addon-small" id="basic-addon5"><i class="fa fa-clock-o"></i></span>';
            html += ' </div> </div><div class="col-sm-6"><div class="input-group "><input type="number" class="form-control " name="hours_delay[' + number_of_iteration +
                ']" placeholder="{{_i('Shipping time by hours (For example 3-5 hours)')}}"><span class="input-group-addon input-group-addon-small" id="basic-addon5"><i class="fa fa-clock-o"></i></span></div></div> </div>';

            //<!--------------------------- Paiement on delivery ------------------------------>
            html += ' <div class="form-group row "><div class="col-sm-12"><div class="input-group ">';
            html += ' <select class="form-control  delivery_method"  name="delivery_method[' + number_of_iteration +
                ']"  >';
            html += ' <option selected >{{ _i('Paiement on delivery ?') }}</option>';
            html += ' <option  value="available">{{ _i('Payment on delivery: Available') }}</option>';
            html += ' <option  value="not_available">{{ _i('Payment on delivery: Not available') }}</option>';
            html += ' </select>';
            html +=
                ' <span class="input-group-addon input-group-addon-small" id="basic-addon5"><i class="ti ti-wallet"></i></span>';
            html += ' </div> </div> </div>';

            //<!--------------------------- cash_delivery_commission ------------------------------>
            html += ' <div class="cach_commission" style="display: none">';
            html += ' <div class="form-group row "> <div class="col-sm-12"> <div class="input-group ">';
            html +=
                ' <input type="number" class="form-control " name="cash_delivery_commission[' +
                number_of_iteration + ']" placeholder="{{ _i('Cash delivery commission') }}">';
            html +=
                ' <span class="input-group-addon input-group-addon-small" id="basic-addon5"> <i class="ti ti-money"></i> </span> ';
            html += ' <button type="button" class="btn btn-tiffany btn-sm mr-3 ">{{ _i('SR') }}</button> ';
            html += ' </div> </div> </div> ';
            html += ' </div>';

            //<!--------------------------- delete shipping price --------------------->


            html += '</div> ';
            html += '</div> ';
            html += ' <div class="card-footer ">';
            html +=
                '<button type="button" class="btn btn-danger "  onclick="delete_shipping_price_section(this , null)"  ><i class="fa fa-times"></i> {{ _i('Delete Condition') }}</button>';
            html += ' </div>' +
                ' </div> </div></div> ';

            console.log('here');
            $('.' + section_shipping_price_add).append(html);
            $(".js-example-basic-multiple").select2();
            $(".js-example-basic-multiple").select2({
                placeholder: "Select City",
                allowClear: true
            });
			rarrange();

        });
        $('body').on('change', '.country_id', function() {
            var cityId = $(this).closest('.single_shipping_price').find('.city_id');
            var countryId = $(this).children("option:selected").val();
            console.log(countryId);
            let number = $(this).data('id');
            cityId.attr("name", "city_id[" + number + "][]");
            $.ajax({
                url: '{{ url('admin/shipping/get_cities') }}',
                method: "get",
                data: {
                    country_id: countryId,
                },
                success: function(response) {
                    cityId.empty();
                    var html = '';
                    cityId.append('<option selected value="all">{{ _i('All Cities') }}</option>');
                    $.each(response, function(key, row) {
                        html += '<option  value="' + row.id + '">' + row.title + '</option>';

                    });
					$('.selectpicker').selectpicker();
					$(".js-example-basic-multiple").select2();
					cityId.append(html);

                }
            });
        });
        // get  regions
        {{--$('body').on('change', '.city_id', function() {--}}
        {{--    // alert($(this).find('option:selected').val()) ;--}}
        {{--    let city_id = $(this).find('option:selected').val();--}}
        {{--    var regionId = $(this).closest('.single_shipping_price').find('.region_id');--}}
        {{--    console.log(city_id);--}}
        {{--    regionId.attr("name", "region_id[" + number_of_iteration + "][]");--}}
        {{--    $.ajax({--}}
        {{--        url: '{{ url('admin/shipping/get_regions') }}',--}}
        {{--        method: "get",--}}
        {{--        data: {--}}
        {{--            city_id: city_id,--}}
        {{--        },--}}
        {{--        success: function(response) {--}}
        {{--            console.log(response);--}}
        {{--            regionId.empty();--}}
        {{--            var html = '';--}}

        {{--            regionId.append('<option selected value="all">{{ _i('All regions') }}</option>');--}}
        {{--            $.each(response, function(key, row) {--}}
        {{--                html += '<option  value="' + row.id + '">' + row.title + '</option>';--}}

        {{--            });--}}
        {{--            $(".js-example-basic-multiple").select2();--}}
        {{--            regionId.append(html);--}}
        {{--        }--}}
        {{--    });--}}
        {{--});--}}

        function delete_shipping_price_section(obj, option_id) {


            if (option_id == null) {

                $(document).find(obj).parents('.single_shipping_price:first').remove().removeClass(
                    'single_shipping_price single_shipping_price_v2');

            } else {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ url('admin/shipping_option/delete') }}',
                    data: {
                        '_method': 'DELETE',
                        'optionId': option_id
                    },
                    type: "POST",
                    success: function(response) {
                        if (response) {
                            $(document).find(obj).parents('.single_shipping_price:first').remove().removeClass(
                                'single_shipping_price single_shipping_price_v2');


                            $('.modal.modal_create').modal('hide');
                            Swal.fire({
                                //position: 'top-end',
                                icon: 'success',
                                title: '{{ _i('Deleted Successfully') }}',
                                showConfirmButton: false,
                                timer: 5000
                            });
                        } else {
                            Swal.fire({
                                //position: 'top-end',
                                icon: 'Error',
                                title: '{{ _i('Element is linked to data!') }}',
                                showConfirmButton: false,
                                timer: 5000
                            });
                        }

                    }
                });
            }



            rarrange();

        }

        function rarrange() {
			return ;
            $('.section_shipping_price_add:first').find('.single_shipping_price_v2').each(function(i, obj) {
                $(document).find(obj).attr('id');
                let counter = i + 1;
                // $('.section_shipping_price_add:first').find(obj).find('.country_id:first').attr('data-id', counter);
                let country_id = $('.section_shipping_price_add:first').find(obj).find('.country_id:first').find(
                    ":selected").val();
                $('.section_shipping_price_add:first').find(obj).find('.city_id:first').attr('name', 'city_id[' + counter + '][]');

            });
        }
    </script>
@endpush
