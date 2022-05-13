@push('css')
    <!-- Treeview css -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin_dashboard/bower_components/jstree/css/style.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin_dashboard/assets/pages/treeview/treeview.css') }}">
@endpush

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
                        <input type="text" required name="title[{{ $item['code'] }}]"  value="{!! $offer->title->{$item->code} !!}" class='form-control ' required>

                    </div>
                </div>

                {{--<div class="form-group row">--}}
                    {{--<label class="col-sm-2 col-form-label"> {{ _i('Description') }}--}}
                    {{--</label>--}}

                    {{--<div class="col-sm-10">--}}
                        {{--<textarea name="description[{{ $item['code'] }}]" class='form-control'> </textarea>--}}
                    {{--</div>--}}
                {{--</div>--}}
            </div>
        @endforeach

    </div>

</div>

<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Start Date') }} </label>
    <div class="col-sm-4">
        <input name="start_date" value="{{date('Y-m-d\TH:i',strtotime($offer->start_date))}}" required type="datetime-local" class="form-control">
    </div>
    <div class="col-sm-1">
        {{ _i('End Date') }}
    </div>
    <div class="col-sm-4">

        <input name="end_date" value="{{date('Y-m-d\TH:i',strtotime($offer->end_date))}}" required type="datetime-local" class="form-control">
    </div>
</div>

<input type="hidden" name="type" value="extra">

<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Allowing Using Times') }}:
    </label>
    <div class="col-sm-4">
        <input type="range" value="{{$offer->offer_limit}}" name="using_times" min="0" max="200"
            oninput="$(this).next().html($(this).val())">
        <span>{{$offer->offer_limit}}</span>
    </div>

    <label for="title" class="col-sm-2 col-form-label"> {{ _i('User Limit') }} :
    </label>
    <div class="col-sm-4">
        <input type="range" value="{{$offer->user_times}}" name="user_times" min="0" max="50" oninput="$(this).next().html($(this).val())">
        <span>{{$offer->user_times}}</span>
    </div>
</div>

<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Bonus') }} <span style="color: #F00;">*</span></label>
    <div class="col-sm-6">
        <input type="number" name="bonusValue" class='form-control' value='{{ $offer->bonus }}' required>
    </div>
    <label><input type="radio" {{ $offer->calc_type == 'perc' ? 'checked' : '' }} name="bonus"
                  value="perc"  > %</label>
    <label> <input type="radio" {{ $offer->calc_type == 'net' ? 'checked' : '' }} name="bonus" value="net">
        {{ get_default_currency()->code }}</label>
</div>


<div class="form-group row">
    <label class="col-sm-2 col-form-label"> {{ _i('Bank') }} <span style="color: #F00;">*</span> </label>

    <div class="col-sm-10">
        <div class="row">
            @foreach($banks as $bank)
			<div class="col-md-3">
				<div class="checkbox-fade fade-in-primary">
					<label>
						<input type="checkbox" name="bank_id[]" class="bank_id" value="{{$bank->id}}" @foreach($offer_offline as $item){{ $bank->id == $item->bank_id ? 'checked' : '' }} @endforeach data-bv-field="member">
						<span class="cr">
							<i class="cr-icon icofont icofont-ui-check txt-primary"></i>
						</span> <span>{{ $bank->title }}</span>
					</label>
				</div>
			</div>
            @endforeach
        </div>
    </div>
</div>
<div class="form-group row">

    <label class="col-sm-2 col-form-label"> {{ _i('Payments') }} <span style="color: #F00;">*</span></label>
    <div class="col-sm-10">
        <div class="row">
            @foreach($payment_gates as $payment)

				<div class="col-md-3">
                    <div class="checkbox-fade fade-in-primary">
                        <label>
							<input type="checkbox" name="payment_id[]" class="payment_id" value="{{$payment->id}}" @foreach($offer_online as $item){{ $payment->id == $item->method_id ? 'checked' : '' }} @endforeach data-bv-field="member">
                            <span class="cr">
                                <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                            </span> <span>{{ $payment->name }}</span>
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>


<hr />

<div class="form-group row apply" style="display: block" id="div_items">
    <label class="col-sm-2">{{ _i('Apply offer to') }}</label>
    <div class="col-sm-10">
        <div class="form-radio">
            <div class="radio radiofill radio-primary radio-inline">
                <label>
                    <input type="radio" name="Products" class="Products" {{ count($Offer_products) > 0 ? 'checked' : '' }} value="0" data-bv-field="member">
                    <i class="helper"></i>{{ _i('All Products') }}
                </label>
            </div>
            <div class="radio radiofill radio-primary radio-inline">
                <label>
                    <input type="radio" name="Products" class="Products" {{ count($Offer_products) > 0 ? 'checked' : '' }} value="1" data-bv-field="member">
                    <i class="helper"></i>{{ _i('Selected Products') }}
                </label>
            </div>
        </div>
        <span class="messages"></span>
    </div>
</div>
@include("admin.offer.edit.selectApplyProduct")

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
                allowValidate(false);


            }
        });
    </script>
@endpush
