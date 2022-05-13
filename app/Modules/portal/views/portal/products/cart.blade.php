@extends('layout.index')
@section('title', _i('Cart'))

@section('main')
    <link href="{{ asset('customGetway/style.css') }}" rel="stylesheet">
    @php
    $total = 0;
    $countDiscount = 0;
    $totalbeforDiscount = 0;
    $tax = App\Bll\Utility::taxOnProduct() / 100;

    @endphp
    @if ($products->isNotEmpty())
        <section class="cart-page-wrapper my-4">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 order-0 order-md-1">
                        <div class="my-cart-items">
                            <div class="section-title mb-2">{{ _i('My Cart') }}</div>
                            <div class="cart-items-wrapper">
                                @forelse ($products as $product)
                                    @php
                                        $po = '';
                                        if ($product->product->product_detail && $product->product->product_details->where('lang_id', App\Bll\Lang::getSelectedLangId())->first() != null) {
                                            $po = $product->product->product_details->where('lang_id', App\Bll\Lang::getSelectedLangId())->first()->title;
                                        } elseif ($product->product->product_details->first()) {
                                            $po = $product->product->product_details->first()->title;
                                        } else {
                                        }
                                        $totalbeforDiscount += $product->getPriceAttribute($product);
                                        $totalbeforDiscountitem = $product->total_price;


                                        $discount = $product->product->discounts($product->product);
                                         if ($discount != null) {
                                            if ($discount->calc_type == 'perc') {
                                                $countDiscount += ($product->getPriceAttribute($product) * $discount->value) / 100;
                                                $totalItem = $product->getPriceAttribute($product) - ($product->getPriceAttribute($product) * $discount->value) / 100;
                                                $DiscountItem = ($product->total_price * $discount->value) / 100;
                                                //dd( $countDiscount);
                                            } else {
                                                $countDiscount += $discount->value;
                                                $DiscountItem = $discount->value;
                                                $totalItem = $product->getPriceAttribute($product) - $discount->value;
                                            }
                                        } else {
                                            $countDiscount += 0;
                                            $totalItem = $product->getPriceAttribute($product);
                                            $DiscountItem = 0;
                                        }

                                    @endphp
                                    <div class="single-cart-item pluss">
                                        <div class="item-thumbnail"><a
                                                href="{{ route('home_product.show', $product->item_id) }}"><img
                                                    src="{{ asset($product->product->image) }}" alt=""
                                                    class="img-fluid"></a>
                                        </div>
                                        <div class="item-title">
                                            <span>{{ $po }}</span>
                                            <a href="{{ route('home_product.show', $product->item_id) }}">
                                                {{-- {{ $product->product->product_details->where('lang_id', App\Bll\Lang::getSelectedLangId())->first() ? $product->product->product_details->where('lang_id', App\Bll\Lang::getSelectedLangId())->first()->description : $product->product->product_details->first()->description }} --}}
                                            </a>
                                        </div>
                                        <div class="item-quantity">
                                            <span>{{ _i('Quantity') }}</span>
                                            <div class="input-group">
                                                <input type="button" min="1" value="-" class="button-minus decreasee"
                                                    data-id=" {{ $product->item_id }}" data-field="quantity" data-discount={{ $DiscountItem }} data-before="{{ $totalbeforDiscountitem }}">
                                                <input type="number" id="number" min="1" step="1" max="" readonly
                                                    value="{{ $product->qty }}" name="quantity"
                                                    class="quantity-field pricee-{{ $product->item_id }}">
                                                <input type="button" min="1" value="+" class="button-plus increasee"
                                                    data-id=" {{ $product->item_id }}" data-field="quantity" data-discount={{ $DiscountItem }} data-before="{{ $totalbeforDiscountitem }}">
                                            </div>
                                        </div>
                                        <div class="item-price">
                                            <span>{{ _i('Price') }}</span>
                                             <div class="regular-price "><span class="sss">{{ $totalItem }}
                                                </span>
                                                {{ _i('SAR') }}
                                            </div>

                                        </div>
                                        <div class="item-remove">
                                            <a href="#" class="btn btn-remove shopping-cart-delete"
                                                data-id="{{ $product->id }}"><i class="fa fa-times"></i></a>
                                        </div>
                                    </div>

                                @empty
                                    {{ _i('Your cart is empty') }}
                                @endforelse


                            </div>
                        </div>

                        <div class="my-3">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <th scope="col">
                                            {{ _i('Total Before Discount') }}</th>
                                        <td scope="col">
                                            <span class="order-total2"
                                                id="before">{{ $totalbeforDiscount  }}</span>
                                            {{ _i('SAR') }}
                                        </td>

                                    </tr>
                                    <tr>
                                        <th scope="row">{{ _i('Tax') }}</th>
                                        <td> <span class="products-tax-txt"
                                                id="tax">{{ round( $totalbeforDiscount  * $tax, 2) }}</span>
                                            {{ _i('SAR') }}</td>

                                    </tr>
                                    <tr>
                                        <th scope="row">{{ _i('Discount') }}</th>
                                        <td> <span class="products-tax-txt" id="discount">{{ $countDiscount }}</span>
                                            {{ _i('SAR') }}</td>

                                    </tr>
                                    <tr>
                                        <th scope="row">{{ _i('Shipping') }}</th>
                                        <td> <span class="shipping-price" id="shipping"></span>
                                            {{ _i('SAR') }}</td>

                                    </tr>

                                    <tr class="text-color1 font-weight-bold fz18">
                                        <th scope="row"> <span
                                                class="text-color1 font-weight-bold fz18">{{ _i('Total') }}</span>
                                        </th>
                                        <td> <span class="order-total-latest " id="productTotal">{{ round(($totalbeforDiscount + ($totalbeforDiscount  * $tax) - $countDiscount),2)  }}</span>
                                            <input type="hidden" id="productTotal2" value="{{round(($totalbeforDiscount + ($totalbeforDiscount  * $tax) - $countDiscount),2)  }}">
                                            {{ _i('SAR') }}
                                        </td>

                                    </tr>
                                </tbody>
                            </table>


                        </div>
                    </div>


                    <div class="col-lg-4 order-1 order-md-0">
                        <div class="info-box shadow">
                            <div class="box-header">{{ _i('Personal Info') }}</div>
                            <div class="box-content">
                                <form class="form-shopping-place" id="form-container" method="post"
                                    action="{{ route('confirm.order') }}">
                                    @csrf
                                    <h5 class="m-pr-title mb-4">{{ _i('Order') }}</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select name="country" id="country_id" class="form-control" required>
                                                <option>{{ _i('Select Country') }}</option>

                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->country_id }}">
                                                        {{ $country->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('country'))
                                                <span class="text-danger">{{ $errors->first('country') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <select name="city" id="city_id" class="form-control"
                                                onchange="loadByRegions()" required>
                                            </select>
                                        </div>

                                        @if ($errors->has('city'))
                                            <span class="text-danger">{{ $errors->first('city') }}</span>
                                        @endif
                                        <div class="col-12 xp-search my-2">
                                            <div class="col-12">
                                                <input type="text" class="form-control" name="region"
                                                    placeholder="{{ _i('Region') }}" required>
                                            </div>
                                        </div>
                                        @if ($errors->has('region'))
                                            <span class="text-danger">{{ $errors->first('region') }}</span>
                                        @endif

                                        <div class="col-12 xp-search my-2">
                                            <div class="col-12">
                                                <input type="text" name="street" class="form-control"
                                                    placeholder="{{ _i('Street') }}">
                                            </div>
                                        </div>
                                        <div class=" radio_selection shipping-options">

                                            <div class="my-3">
                                                <div id="LoadingImage" style="display: block">
                                                    <p>{{ _i('Loading') }}...</p>
                                                </div>
                                                <div class="shipping-methods-options" style="display: none">
                                                </div>
                                                @if ($errors->has('shipping_option'))
                                                    <span
                                                        class="text-danger">{{ $errors->first('shipping_option') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="amount" id="amount" value="{{ $total }}">
                                    <div class="row">

                                        <button id="tap-btn">{{ _i('Submit') }}</button>

                                    </div>

                                </form>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        <div class="text-center"> {{ _i('Your cart is empty') }}</div>
    @endif

@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bluebird/3.3.4/bluebird.min.js"></script>
    <script src="https://secure.gosell.io/js/sdk/tap.min.js"></script>
    <script src="{{ asset('customGetway/custom.js') }}"></script>

    @include('portal.include.js')
@endpush
