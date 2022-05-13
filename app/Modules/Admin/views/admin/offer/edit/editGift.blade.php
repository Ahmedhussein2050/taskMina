@push('css')
    <!-- Treeview css -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin_dashboard/bower_components/jstree/css/style.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin_dashboard/assets/pages/treeview/treeview.css') }}">
@endpush
<input type="hidden" name="type" value="oneFree">
<div class="col-lg-12 col-xl-12">
    <ul class="nav nav-tabs  tabs" role="tablist">
        @foreach ($langs as $item)
            <li class="nav-item">
                <a class="nav-link @if ($loop->first) active @endif"
                    data-toggle="tab" href="#home{{ $item->id }}" role="tab">{{ $item->title }}</a>
            </li>
        @endforeach
    </ul>
    <!-- Tab panes -->
    <div class="tab-content tabs card-block">
        @foreach ($langs as $item)
            <div class="tab-pane @if ($loop->first) active @endif"
                id="home{{ $item->id }}" role="tabpanel">
                <div class="form-group row">

                    <label for="title" class="col-sm-2 col-form-label"> {{ _i('title') }}
                    </label>

                    <div class="col-sm-10">
                        <input type="text" {{ $disabled }} required name="title[{{ $item['code'] }}]"
                            {{ $disabled }} value="@php
                                if (!empty($offer->title->{$item->code})) {
                                    echo $offer->title->{$item->code};
                                }
                            @endphp" class='form-control '>

                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"> {{ _i('Description') }}
                    </label>

                    <div class="col-sm-10">
                        <textarea name="description[{{ $item['code'] }}]" {{ $disabled }}
                            class='form-control'>@php
                                if (!empty($offer->description->{$item->code})) {
                                    echo $offer->description->{$item->code};
                                }
                            @endphp</textarea>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

</div>
<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Start Date') }} </label>
    <div class="col-sm-4">
        <input name="start_date" value="{{ date('Y-m-d\TH:i', strtotime($offer->start_date)) }}" required
            type="datetime-local" class="form-control">
    </div>
    <div class="col-sm-1">
        {{ _i('End Date') }}
    </div>
    <div class="col-sm-4">

        <input name="end_date" {{ $disabled }} value="{{ date('Y-m-d\TH:i', strtotime($offer->end_date)) }}"
            required type="datetime-local" class="form-control">
    </div>
</div>

<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Allowing Using Times') }}
    </label>
    <div class="col-sm-4">
        <input type="range" {{ $disabled }} value="{{ $offer->offer_limit }}" name="using_times" min="0"
            max="200" oninput="$(this).next().html($(this).val())">
        <span>{{ $offer->offer_limit }}</span>
    </div>

    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Allowing User Times') }}
    </label>
    <div class="col-sm-4">
        <input type="range" {{ $disabled }} value="{{ $offer->user_times }}" name="user_times" min="0" max="50"
            oninput="$(this).next().html($(this).val())">
        <span>{{ $offer->user_times }}</span>
    </div>
</div>

<div class="form-inline row">
    <label class="col-sm-2 col-form-label"> {{ _i('Buy') }} <span style="color: #F00;">*</span> </label>
    <div class="col-sm-4">
        <input class="form-control" {{ $disabled }} name="buyProducts" type="number" min="1"
            value="{{ $offers->buy_products_num }}" required> {{ _i('Product(s)') }}

    </div>
    <label class="col-sm-2 col-form-label"> {{ _i('Take') }} <span style="color: #F00;">*</span></label>
    <div class="col-sm-4">
        <input class="form-control" {{ $disabled }} name="freeProducts" type="number" min="1"
            value="{{ $offers->free_products_num }}" required> {{ _i('Free') }}

    </div>
</div>

<br>
<div class="form-group row">
    <label class="col-sm-2 col-form-label"> {{ _i('Select Condition') }} :
    </label>
    <div class="col-sm-4">
        <select name="condetion" class="form-control" id="condetion" {{ $disabled }}>
            <option value="cart"  @if ($offer->minimum_cart() != null) selected @endif>{{ _i('Based on cart minimum price') }}
            </option>
            <option value="items" @if ($offer->minimum_cart() == null) selected @endif>{{ _i('Based on selected items') }}
            </option>

        </select>
    </div>


</div>
<div class="form-group row apply" style=" @if ($offer->minimum_cart() != null) display: none @endif " id="div_items">
    <label class="col-sm-2">{{ _i('Apply offer to') }}</label>
    <div class="col-sm-10">
        <div class="form-radio">
            <div class="radio radiofill radio-primary radio-inline">
                <label>
                    <input type="radio" {{ $disabled }} name="Products" class="Products"
                        {{ count($Offer_products) > 0 ? '' : 'checked' }} value="0" data-bv-field="member">
                    <i class="helper"></i>{{ _i('All Products') }}
                </label>
            </div>
            <div class="radio radiofill radio-primary radio-inline">
                <label>
                    <input type="radio" {{ $disabled }} name="Products" class="Products"
                        {{ count($Offer_products) > 0 ? 'checked' : '' }} value="1" data-bv-field="member">
                    <i class="helper"></i>{{ _i('Selected Products') }}
                </label>
            </div>
        </div>
        <span class="messages"></span>
    </div>
</div>



<div class="form-inline row" @if ($offer->minimum_cart() == null) style="display: none" @endif id="div_cart">
    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Min Cart Total') }}
        <span style="color: #F00;">*</span></label>
    <div class="col-sm-4">
        <div class="input-group"><input type="number" name="min" {{ $disabled }} class='form-control'
                value="{{ $offers->min_cart_amount }}" min="1" id="input_min" required="">

            <span class="input-group-addon" id="basic-addon3">
                {{ get_default_currency()->code }}

            </span>
        </div>
    </div>


    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Max Free') }} <span
            style="color: #F00;">*</span></label>
    <div class="col-sm-4">
        <div class="input-group"> <input type="number" name="max" min="1" {{ $disabled }} class='form-control'
                value="{{ $offers->free_products_max_price }}" required="" id="input_max">
            <span class="input-group-addon" id="basic-addon3">
                {{ get_default_currency()->code }}

            </span>
        </div>
    </div>
    <div class="col-sm-1">
    </div>
</div>
@include("admin.offer.edit.selectApplyProduct")

<div class="form-group row free">
    <label class="col-sm-2">{{ _i('Free Products From') }}</label>
    <div class="col-sm-10">
        <div class="form-radio">
            <div class="radio radiofill radio-primary radio-inline">
                <label>
                    <input type="radio" name="FreeProducts" id="free0" {{ $disabled }} class="FreeProducts" checked
                        value="0" data-bv-field="member">
                    <i class="helper"></i>{{ _i('All Products') }}
                </label>
            </div>
            <div class="radio radiofill radio-primary radio-inline">
                <label>
                    <input type="radio" {{ $disabled }} id="free1" name="FreeProducts" class="FreeProducts"
                        value="1" data-bv-field="member">
                    <i class="helper"></i>{{ _i('Selected Products') }}
                </label>
            </div>
        </div>
        <span class="messages"></span>
    </div>
</div>

@include("admin.offer.edit.editFreeProduct")


<div class="form-group row">
    <div class="col-sm-12 text-right">
        <input class="btn btn-primary btn-block mt-2" type="submit" value="{{ _i('Save') }}" {{ $disabled }}>
    </div>
</div>

@push('js')

    <script>
        $(".Products").click(function() {
            var vpp = $(this).val();
            if (vpp == 1) {
                $("#show-products").css("display", "block");
            } else {
                $("#show-products").css("display", "none");
            }
        });


        $(".FreeProducts").click(function() {

            var vpp = $(this).val();
            if (vpp == 1) {
                $("#show-product2").css("display", "block");
            } else {
                $("#show-product2").css("display", "none");
            }
        });

        function allowValidate(bool) {

            //set required attribute on input to false
            if (bool) {
                $('#input_min').attr('required');
                $('#input_max').attr('required');
            } else {
                $('#input_min').removeAttr('required');
                $('#input_max').removeAttr('required');
            }

            //reinitialize parsley
            $("form[data-parsley-validate]").parsley().refresh();
        }
        $('#condetion').on('change', function() {
            var link_type = $(this).val();

            if (link_type == 'cart') {
                $("#div_cart").show();
                $("#div_items").hide();
                $("#div_free").hide();
                $("#show-products").hide();
                $("#show-product2").show();
                allowValidate(true);

            } else {
                $("#div_cart").hide();
                $("#div_items").show();
                $("#div_free").show();
                $("#show-product2").hide();
                $("#free0").prop("checked", true);
                $("#free1").prop("checked", false);
                allowValidate(false);


            }
        });
    </script>
@endpush
