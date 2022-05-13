

@push('js')


    <script>

        $(function(){$(".js-example-basic-multiple").select2(); });


        $('body').on('click','.add_condition', function () {

            var section_condition_add="section_condition_add";
            var html='';
            html += ' <div class="single_section_condition">';

            html += '<div class="form-group row "> <div class="col-sm-12"> <div class="input-group ">';
            html += '<select class="form-control country_id" name="country_id[]" onchange="get_cities(this)" >';
            html += '<option selected value="all" >{{_i('All Countries')}}</option>';
            @foreach($countries as $country)
                html += '<option value="{{$country->id}}" >{{$country->title}}</option>';
            @endforeach
                html += '</select>';
            html += '<span class="input-group-addon input-group-addon-small" id="basic-addon5"> <i class="ti ti-map"></i></span>';
            html += '</div> </div> </div>';

            //<!--------------------------- cities--------------------->
            html += '<div class="form-group row "> <div class="col-sm-12"> <div class="input-group ">';
            // html += '<select class="form-control selectpicker city_id" multiple="multiple" name="city_id[]" >';
            html += '<select class="form-control js-example-basic-multiple city_id"  multiple="multiple" name="city_id[]"   required="" >';
            html += '<option selected value="all">{{_i('All Cities')}}</option>';
            html += '</select>';
            //  html += '<span class="input-group-addon input-group-addon-small" id="basic-addon5"> <i class="ti ti-map-alt"></i></span>';
            html += '</div> </div> </div>';

            //<!--------------------------- Minimum purchases --------------------->
            html += '<div class="form-group row "> <div class="col-sm-12"> <div class="input-group ">';
            html += '<input type="number" class="form-control " name="minimum_purchases[]" placeholder="{{_i('Minimum purchases')}}" required="">';
            html += '<span class="input-group-addon input-group-addon-small" id="basic-addon5"><i class="ti ti-money"></i></span>';
            html += '<button type="button" class="btn btn-tiffany btn-sm mr-3 ">{{_i('SR')}}</button>';
            html += '</div> </div> </div>';

            //<!--------------------------- delete condition --------------------->
            html += '<div class="form-group row  text-center"> <div class="col-sm-12">';
            html += '<button type="button" class="btn btn-danger " onclick="delete_section_condition(this)" ><i class="fa fa-times"></i> {{_i('Delete Condition')}}</button>';
            html += '</div> </div>';

            html += '</div> ';

            $('.'+section_condition_add).prepend(html);
           // $('.city_id').selectpicker('refresh');
            $(".js-example-basic-multiple").select2();
            $(".js-example-basic-multiple").select2({
                placeholder: "Select City",
                allowClear: true
            });

        });

        function delete_section_condition(obj) {
            $(obj).closest('.single_section_condition').remove();
        }

        function delete_saved_section_condition(obj,option_id) {

            console.log(option_id);
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
                success: function (response) {
                    $(obj).closest('.single_section_condition').remove();
                    $('.modal.modal_create').modal('hide');

                    Swal.fire({
                        //position: 'top-end',
                        icon: 'success',
                        title: '{{_i("Deleted Successfully")}}',
                        showConfirmButton: false,
                        timer: 5000
                    });

                }
            });
        }



        function get_cities(obj) {

            var cityId = $(obj).closest('.single_section_condition').find('.city_id');

            var countryId = $('.country_id').val();
            //var countryId = $(this).children("option:selected").val();
            //alert(countryId)

            cityId.attr("name", "city_id["+countryId+"][]");
            $.ajax({
                url: '{{ url('admin/get_cities') }}',
                method: "get",
                data: {
                    country_id: countryId,
                },
                success: function (response) {
                    cityId.empty();

                    var html = '';
                    cityId.append('<option selected value="all">{{_i('All Cities')}}</option>');
                    $.each(response , function (key , row) {
                        html += '<option  value=" '+row.id+' ">'+row.title+'</option>';
                        //$('.city_id').append('<option  value=" '+row.id+' ">'+row.title+'</option>');

                    });
                    $(".js-example-basic-multiple").select2();
                    cityId.append(html);


                }
            });
        }





        function get_citiesOld() {

            var countryId = $('.country_id').val();
            $.ajax({
                url: '{{ url('admin/get_cities') }}',
                method: "get",
                data: {
                    country_id: countryId,
                },
                success: function (response) {
                    //$(".city_id").html(response).selectpicker('refresh');
                    $('.city_id').empty();
                    // $('.selectpicker').selectpicker();
                    // $('.picker').selectpicker('refresh');
                    //$('.city_id').selectpicker('refresh');
                    //$('.city_id').addClass("selectpicker").selectpicker('refresh');

                    // $('.city_id').addClass("selectpicker");
                    var html = '';
                    $('.city_id').append('<option selected value="all">{{_i('All Cities')}}</option>');
                    $.each(response , function (key , row) {
                        html += '<option  value=" '+row.id+' ">'+row.title+'</option>';
                        //$('.city_id').append('<option  value=" '+row.id+' ">'+row.title+'</option>');

                    });
                    $('.city_id').append(html);
                    $('.city_id').selectpicker('refresh');

                    // $('.city_id').addClass('selectpicker');
                    // $('.city_id').attr('data-live-search', 'true');
                    // $('.city_id').selectpicker('refresh');
                    // $('.selectpicker').selectpicker('refresh');




                    // $('.city_id').selectpicker('refresh');
                    // $('.selectpicker').selectpicker('render');
                    // $('.selectpicker').selectpicker('val', ['Mustard','Relish']);
                    // $('.selectpicker').addClass('col-lg-12').selectpicker('setStyle');



                    //var html = '';
                    //$.each(response , function (key , row) {
                    //html += '<option  value=" '+row.id+' ">'+row.title+'</option>';
                    //$('.city_id').append('<option  value=" '+row.id+' ">'+row.title+'</option>');
                    // $(".city_id")
                    //     .html('<option  value=" '+row.id+' ">'+row.title+'</option>')
                    //     .selectpicker('refresh');
                    //});
                    //$(".city_id").html(html)
                    //.selectpicker('refresh');

                    //$('.city_id').selectpicker('refresh');
                    // $('.picker').selectpicker('refresh');
                }
            });
        }
    </script>

@endpush
