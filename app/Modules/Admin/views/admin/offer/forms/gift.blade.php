@push('css')
    <!-- Treeview css -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin_dashboard/bower_components/jstree/css/style.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin_dashboard/assets/pages/treeview/treeview.css') }}">
@endpush

@php
	$title =old('title');
	$desc =old('description');

@endphp
<div class="col-lg-12 col-xl-12">
    <ul class="nav nav-tabs  tabs" role="tablist">
        @foreach ($langs as $item)
            <li class="nav-item">
                <a class="nav-link @if ($loop->first) active @endif"
                    data-toggle="tab" href="#home{{ $item->id }}"  role="tab">{{ $item->title }}</a>
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
                        <input type="text" required value="{{(isset($title))? $title[$item->code] : ''}}" name="title[{{ $item['code'] }}]"   class='form-control '>

                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"> {{ _i('Description') }}
                    </label>

                    <div class="col-sm-10">
                        <textarea name="description[{{ $item['code'] }}]" class='form-control'>{{(isset($desc))? $desc[$item->code] : ''}}</textarea>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

</div>

<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Start Date') }} </label>
    <div class="col-sm-4">
        <input name="start_date" value="{{old('start_date')}}" required type="datetime-local" class="form-control">
    </div>
    <div class="col-sm-1">
        {{ _i('End Date') }}
    </div>
    <div class="col-sm-4">

        <input name="end_date" value="{{old('end_date')}}" required type="datetime-local" class="form-control">
    </div>
</div>

<input type="hidden" name="type" value="oneFree">

<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Allowing Using Times') }} :
    </label>
    <div class="col-sm-4">
        <input type="range" value="{{ old('using_times') }}" name="using_times" min="0" max="200"
            oninput="$(this).next().html($(this).val())">
        <span>100</span>
    </div>

    <label for="title" class="col-sm-2 col-form-label"> {{ _i('User Limit') }} :
    </label>
    <div class="col-sm-4">
        <input type="range" value="{{( old('user_times') !==null) ?  old('user_times') : 1 }}" name="user_times" min="0" max="50" oninput="$(this).next().html($(this).val())">
        <span>1</span>
    </div>
</div>

<div class="form-inline row">
    <label class="col-sm-2 col-form-label"> {{ _i('Buy') }} <span style="color: #F00;">*</span> </label>
    <div class="col-sm-4">
        <input class="form-control" name="buyProducts" type="number" value="{{ old('buyProducts') }}" min="1" required> {{ _i('Product(s)') }}

    </div>
    <label class="col-sm-2 col-form-label"> {{ _i('Take') }} <span style="color: #F00;">*</span></label>
    <div class="col-sm-4">
        <input class="form-control" name="freeProducts" type="number" value="{{ old('freeProducts') }}" min="1" required> {{ _i('Free') }}

    </div>
</div>
<p>
</p>
<div class="form-group row">
    <label class="col-sm-2 col-form-label"> {{ _i('Select Condition') }} :
    </label>
    <div class="col-sm-4">
        <select name="condetion" class="form-control" id="condetion">

            <option value="cart">{{ _i('Based on cart minimum price') }}
            </option>
             <option value="items"  {{ (old("condetion") == 'items' ? "selected":"") }}>{{ _i('Based on selected items') }}
            </option>

        </select>
    </div>


</div>
<hr />

<div class="form-inline row " id="div_cart">
    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Min Cart Total') }}
        <span style="color: #F00;">*</span></label>
    <div class="col-sm-4">
		<div class="input-group">
        <input type="number" name="min" class='form-control' min="1" id="input_min" required="" value="{{ old('min') }}">
		<span class="input-group-addon" id="basic-addon3">
			{{ get_default_currency()->code }}

		</span>
		</div>
    </div>


    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Max Free') }} <span
            style="color: #F00;">*</span></label>
    <div class="col-sm-4">
		<div class="input-group">
        <input type="number" name="max" min="1" class='form-control' required="" value="{{ old('max') }}" id="input_max">
		<span class="input-group-addon" id="basic-addon3">
			{{ get_default_currency()->code }}

		</span>
		</div>
    </div>
    <div class="col-sm-1">
    </div>



</div>

<div class="form-group row apply" style="display: none" id="div_items">
    <label class="col-sm-2">{{ _i('Apply offer to') }}</label>
    <div class="col-sm-10">
        <div class="form-radio">
            <div class="radio radiofill radio-primary radio-inline">
                <label>
                    <input type="radio" name="Products" class="Products" checked value="0" data-bv-field="member">
                    <i class="helper"></i>{{ _i('All Products') }}
                </label>
            </div>
            <div class="radio radiofill radio-primary radio-inline">
                <label>
                    <input type="radio" name="Products" class="Products" value="1" data-bv-field="member">
                    <i class="helper"></i>{{ _i('Selected Products') }}
                </label>
            </div>
        </div>
        <span class="messages"></span>
    </div>
</div>
@include("admin.offer.forms.selectProduct")

<div class="form-group row free"  >
    <label class="col-sm-2">{{ _i('Free Products From') }}</label>
    <div class="col-sm-10">
        <div class="form-radio">
            <div class="radio radiofill radio-primary radio-inline">
                <label>
                    <input type="radio" name="FreeProducts" id="free0" class="FreeProducts" checked value="0"
                        data-bv-field="member">
                    <i class="helper"></i>{{ _i('All Products') }}
                </label>
            </div>
            <div class="radio radiofill radio-primary radio-inline">
                <label>
                    <input type="radio" name="FreeProducts" id="free1" class="FreeProducts" value="1" {{ old('FreeProducts') == "1" ? 'checked' : '' }} data-bv-field="member">
                    <i class="helper"></i>{{ _i('Selected Products') }}
                </label>
            </div>
        </div>
        <span class="messages"></span>
    </div>
</div>

@include("admin.offer.forms.selectProductFree")


<div class="form-group row">
    <div class="col-sm-12 text-right">
        <input class="btn btn-primary btn-block" type="submit" value="{{ _i('Save') }}">
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
        $(document).ready(function() {
            const condetion = '{{ old('condetion') }}';

            if(condetion == 'items') {
                $("#div_cart").hide();
                $("#div_items").show();
				$("#div_free").show();
                $("#show-product").hide();
                $("#show-product2").hide();
                $("#free0").prop("checked", true);
                $("#free1").prop("checked", false);
                allowValidate(false);
            }
            if(condetion == 'cart') {
                $("#div_cart").show();
                $("#div_items").hide();
				$("#div_free").hide();
                $("#show-products").hide();
                $("#show-product2").hide();
                allowValidate(true);
            }
        });

        $('#condetion').on('change', function() {
            var link_type = $(this).val();

            if (link_type == 'cart') {
                $("#div_cart").show();
                $("#div_items").hide();
				$("#div_free").hide();
                $("#show-products").hide();
                $("#show-product2").hide();
                allowValidate(true);

            } else {
                $("#div_cart").hide();
                $("#div_items").show();
				$("#div_free").show();
                $("#show-product").hide();
                $("#show-product2").hide();
                $("#free0").prop("checked", true);
                $("#free1").prop("checked", false);
                allowValidate(false);


            }
        });
    </script> 
@endpush
