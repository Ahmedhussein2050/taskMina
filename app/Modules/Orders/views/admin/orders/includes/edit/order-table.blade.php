<table border="0" cellspacing="0" cellpadding="0" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" width="100%">
    <thead>
        <tr>
            <th class="">{{ _i('Product Name') }}</th>
            <th class="">{{ _i('Price') }}</th>
            <th class="">{{ _i('Quantity') }}</th>
            <th class="">{{ _i('VAT') }}</th>
            <th class="">{{ _i('VAT Value') }}</th>
            <th class="">{{ _i('Total') }}</th>
        </tr>
    </thead>
    <tbody>
        @php
        $total_vat = 0;
        $total_prices = 0;
        @endphp
        @foreach ($order->orderProducts as $product)
        @php
        $total_vat += $product->vatVal;
        $total_prices += (float)$product->price - (float)$product->vatVal;
        @endphp
        @if($product->product)
        <tr>
            <td class="">

                <img src='@if ($product->product->thumbnail) {{ asset($product->product->thumbnail) }}@elseif($product->product->product_photos->first()) {{ asset($product->product->product_photos->first()->photo) }} @endif' alt='' class="img-fluid" style="width: 80px">
                <a class="text-primary" target="_blank" {{--                       href="{{ route('home_product.show', [app()->getLocale(), $product->product_id]) }}"--}} href="#">
                    {{ $product->product->product_details->where('lang_id', \App\Bll\Lang::getSelectedLangId())->first()->title? : $product->product->product_details->first()['title']}}
                </a>
                @php

                $options = $order->options->where('product_id', $product->product_id);

                @endphp
                @if ($options->count() > 0)
                <table style="width:100%">
                    <tr>
                        <th>
                            {{ _i('Feature') }}
                        </th>
                        <th>
                            {{ _i('Value') }}
                        </th>
                        <th>
                        </th>
                        <th>
                            {{ _i('Price') }}
                        </th>
                    </tr>
                    @foreach ($options as $option)
                    @php
                    $feature = \DB::select('SELECT features_data.* FROM features_data join feature_options on features_data.feature_id = feature_options.feature_id where feature_options.id=' . $option->feature_option_id . ' ');

                    @endphp

                    <tr>
                        <td>{{ $feature[0]->title }}</td>
                        <td>
                            @if ($option->Data->name != null)
                            {{ $option->Data ? $option->Data->name : '' }}
                            @else
                            {{ $option->Data ? $option->Data->title : '' }}
                            @endif
                        </td>
                        <td style="background-color:{{ $option->Data->title }};">
                        </td>
                        <td>{{ $option->price }}</td>


                    </tr>
                    @endforeach
                </table>
                @endif

            </td>
            <td class="">
                {{ (float)$product->price - (float)$product->vatVal }} {{ $order->currency }}
            </td>
            <td class="qty">{{ $product->count }}</td>
            <td class="qty">{{ $product->vat }}%</td>
            <td class="qty">{{ $product->vatVal }} {{ $order->currency }}</td>
            <td class="total">
                {{ $product->price }} {{ $order->currency }}
            </td>
        </tr>
        @endif
        @endforeach
    </tbody>
</table>
<div class="text-center" style="background: #6f30a0; color: #fff;">{{ _i('Payment Details') }}
</div>

<table class="table table-striped" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    <tbody>
        <tr>
            <th scope="col">
                {{ _i('SUBTOTAL') }}
            </th>
            <td scope="col">
                {{ $total_prices }}
                {{ $order->currency }}
            </td>

        </tr>
        <tr>
            <th scope="row">{{ _i('VAT') }}</th>
            <td> {{ $total_vat }}
                {{ $order->currency }}
            </td>

        </tr>
        <tr>
            <th scope="row">{{ _i('Shipping Cost') }}</th>
            <td> {{ $order->shipping_cost }}
                {{ $order->currency }}
            </td>

        </tr>
        @if ($order->transaction != null)
        @if ($order->transaction->offers->count() > 0)
        <tr>
            <th scope="row">{{ _i('Offers Total') }}

            </th>
            <td>

                - {{ $order->transaction->offers->sum('value') }}
                {{ $order->currency }}
            </td>

        </tr>
        @endif
        @if ($order->transaction->offers->whereNotNull('code')->count() > 0)
        <tr>
            <th scope="row">
                {{ _i('Voucher Code') }}
            </th>
            <td> - {{ $order->transaction->offers->whereNotNull('code')->sum('value') }}
                {{ $order->currency }}
            </td>

        </tr>
        @endif
{{--        @if ($order->transaction->discounts->count() > 0)--}}
{{--        <tr>--}}
{{--            <th scope="row">--}}
{{--                {{ _i('Discount Code') }}--}}
{{--            </th>--}}
{{--            <td>--}}
{{--                {{ $order->transaction->discounts->sum('value') }}--}}

{{--                {{ $order->currency }}--}}
{{--            </td>--}}

{{--        </tr>--}}
{{--        @endif--}}
        @endif
        <tr class="text-color1 font-weight-bold fz18">
            <th scope="row"> {{ _i('GRAND TOTAL') }}
            </th>
            <td> {{ $order->total }}
                {{ $order->currency }}
            </td>

        </tr>
    </tbody>
</table>
