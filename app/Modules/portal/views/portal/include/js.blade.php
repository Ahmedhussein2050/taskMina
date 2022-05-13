<script>
    var tax = "{{ $tax }}";
    $('body').on('click', '.increasee', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var discount = $(this).data('discount');
        var beforeDiscount = $(this).data('before');
        //alert(discount)
        var url = "{{ route('cart.increase', '/id') }}";
        url = url.replace('/id', id)
        var me = $(this);
        $.ajax({
            url: url,
            method: "get",
            data: {
                id: id,
            },
            success: function(response) {
                if (response.fail == false) {

                    console.log(parseFloat(response.product))
                    $('.pricee-' + id).empty();
                    var old = me.closest('.pluss').find('.sss').html();
                    me.closest('.pluss').find('.sss').html((response.product).toFixed(2))
                    var neww = parseFloat(response.product) - parseFloat(old);
                    var total2 = $('#productTotal').html();
                    var total222 = $('#productTotal2').val();
                    var total3 = parseFloat(total2) + parseFloat(neww);
                    var total33 = parseFloat(total222) + parseFloat(neww);

                    var dis = $('#discount').html();
                    console.log(dis);
                    console.log(discount);
                    $('#discount').html( (parseFloat(dis) + parseFloat(discount)).toFixed(2));
                    var dis = $('#discount').html();
                    var t = $('#before').html();
                    $('#before').html((parseFloat(t) + parseFloat(beforeDiscount)).toFixed(2))
                    var tn = $('#before').html();
                     console.log(t)
                     $('#tax').html((parseFloat(tn) * parseFloat(tax)).toFixed(2))
                    $('#productTotal').html((parseFloat($('#before').html() )+ parseFloat($('#tax').html()) - parseFloat($('#discount').html())).toFixed(2));
                     $('#productTotal2').val((parseFloat($('#before').html() )+ parseFloat($('#tax').html()) - parseFloat($('#discount').html())).toFixed(2));
                }
            }
        });
    });
    $('body').on('click', '.decreasee', function(e) {
        e.preventDefault();
        var me = $(this);
        var num = me.closest('.pluss').find('#number').val();
        // alert(num)
        if (num == 0) {
            me.closest('.pluss').find('#number').val(1)
        } else {
            var id = $(this).data('id');
            var discount = $(this).data('discount');

            var beforeDiscount = $(this).data('before');

            var url = "{{ route('cart.decrease', '/id') }}";
            url = url.replace('/id', id)
            var me = $(this);
            $.ajax({
                url: url,
                method: "get",
                data: {
                    id: id,

                },
                success: function(response) {
                    console.log(parseFloat(response.product))

                    if (response.fail == false) {


                    $('.pricee-' + id).empty();
                    var old = me.closest('.pluss').find('.sss').html();
                    me.closest('.pluss').find('.sss').html((response.product).toFixed(2))
                    var neww =  parseFloat(old) -  parseFloat(response.product);
                    // var total2 = $('#productTotal').html();
                    // var total222 = $('#productTotal2').val();
                    // var total3 = parseFloat(total2) + parseFloat(neww);
                    // var total33 = parseFloat(total222) + parseFloat(neww);

                    var dis = $('#discount').html();
                    console.log(dis);
                    console.log(discount);
                    $('#discount').html( (parseFloat(dis) - parseFloat(discount)).toFixed(2));



                    var dis = $('#discount').html();
                    var t = $('#before').html();
                    $('#before').html((parseFloat(t) - parseFloat(beforeDiscount)).toFixed(2))
                    var tn = $('#before').html();
                     console.log(t)
                     $('#tax').html((parseFloat(tn) * parseFloat(tax)).toFixed(2))
                    $('#productTotal').html((parseFloat($('#before').html() )+ parseFloat($('#tax').html()) - parseFloat($('#discount').html())).toFixed(2));
                     $('#productTotal2').val((parseFloat($('#before').html() )+ parseFloat($('#tax').html()) - parseFloat($('#discount').html())).toFixed(2));

                    } else {

                    }
                }
            });
        }

    });

    $(document).on('click', '.shopping-cart-delete', function(e) {
        e.preventDefault();
        var id = $(this).data('id');

        var url = "{{ route('cart.destroy', 'id') }}";
        var url = url.replace('id', id)


        $.ajax({
            url: url,
            type: 'GET',
            success: function(res) {
                if (res == 'success') {
                    location.reload();
                }
            }
        })
    })

    $("#country_id").change(function(e) {
        e.preventDefault();
        var country = $("#country_id").val();
        var url = "{{ route('helper.cities', 'id') }}";
        url = url.replace('id', country)
        $.ajax({
            url: url,
            success: function(res) {
                // console.log(res);
                if (country) {
                    if (res) {
                        $("#city_id").empty();
                        $("#city_id").append("<option>select</option>");
                        $.each(res, function(key, value) {
                            if (value.data != null) {
                                $("#city_id").append('<option value="' + value.id +
                                    '">' + value.title + '</option>');
                            }

                        })
                    } else {
                        $("#city_id").empty();

                    }
                }

            }
        })

    })

    function loadByRegions() {
        _val = $("#country_id").val();
        //calcTax(_val);
        $.ajax({
            url: "{{ route('get_available_shipping_methods') }}",
            method: "get",
            data: {
                country_id: $("#country_id").val(),
                city_id: $("select[name='city']").val(),
                region_id: $("select[name='region']").val(),
                price: 0
            },
            success: function(response) {
                $('.shipping-methods-options').html('');
                //
                $.each(response, function(i, item) {

                    let regions = " ";

                    $("#LoadingImage").show()

                    if (item.shipping_company_type == 'free') {
                        $('.shipping-methods-options').append(
                            "<div class='custom-control custom-radio'><input type='radio' id='shipping" +
                            i +
                            "' class='custom-control-input checkout-shipping-method' name='shipping_option' value='" +
                            item.option_id + "' data-cost='" + 0 +
                            "' data-delivery='" + 0 +
                            "'><label class='custom-control-label' for='shipping" + i +
                            "'>" + item.company_title + " - " + item.company_delay + " " +
                            0 + "</label> " + regions +
                            " <span style='color: #bf0707'>{{ _i('Free') }}</span></div> ");
                    } else {
                        $('.shipping-methods-options').append(
                            "<div class='custom-control custom-radio'><input type='radio' id='shipping" +
                            i +
                            "' class='custom-control-input checkout-shipping-method' name='shipping_option' value='" +
                            item.option_id + "' data-cost='" + item.company_cost +
                            "' data-delivery='" + item.company_cash_delivery_commission +
                            "'><label class='custom-control-label' for='shipping" + i +
                            "'>" + item.company_title + " - " + item.company_delay + " " +
                            item.company_cost_text + "</label> " + regions + " </div>");
                    }
                    var e = $('#shipping').html();


                });
                // $(".nice_scroll").getNiceScroll().resize();
                $("#LoadingImage").hide()
                $(".shipping-methods-options").show()
            },
        });

    }

    $(document).on('click', '.custom-control-input', function(e) {
        $('#shipping').html('')
        $('#shipping').html($(this).data('cost'))
        var tot = $('#productTotal2').val()
        console.log(tot)
        console.log($(this).data('cost'))
        $('#productTotal').html(parseFloat(tot) + $(this).data('cost'))

    })
</script>
