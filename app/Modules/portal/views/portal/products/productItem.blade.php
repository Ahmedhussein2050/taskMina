<div class="single-product">

    @php
        foreach ($product->imagee($product) as $img) {
            $path = preg_replace("/\.[^.]+$/", '', basename($img));
            if ($path == $product->sku) {
                $im = $img ?? null;
            }
        }
    @endphp

    <a href="{{ route('home_product.show', $product->id) }}" class="product-img"><img src="{{ asset($im ?? '') }}"
            alt="" class="img-fluid"></a>
    <div class="product-title">
        <a href="{{ route('home_product.show', $product->id) }}">
            @if ($product->product_details != null)
                {{ $product->product_details->where('lang_id', App\Bll\Lang::getSelectedLangId())->first() ? $product->product_details->where('lang_id', App\Bll\Lang::getSelectedLangId())->first()->title : $product->product_details->first()->title }}
            @endif
        </a>
    </div>
    <div class="fixed-button-options">
        <div class="product-prices">
            {{-- @dd($product ) --}}
            @if ($product->discounts($product) != null)
                <del>{{ $product->getPriceWithTax($product->price) }} {{ _i('SAR') }}</del>

                 @if ($product->discounts($product)->calc_type == 'perc')
                    <div class="sale-price">
                        {{ $product->getPriceWithTax($product->price) - ($product->getPriceWithTax($product->price) * $product->discounts($product)->value) / 100 }}
                        {{ _i('SAR') }}</div>
                @else
                    <div class="sale-price">
                        {{ $product->getPriceWithTax($product->price) - $product->discounts($product)->value }}
                        {{ _i('SAR') }}</div>
                @endif
            @else
                <div class="regular-price">{{ $product->getPriceWithTax($product->price) }} {{ _i('SAR') }}
                </div>
            @endif

        </div>
        <div class="buttons">
            @if (auth()->check())
                <a href="" class="add-to-cart  add-to-cartt" data-id="{{ $product->id }}"
                    data-price="{{ $product->getPriceWithTax($product->price) }}">{{ _i('Add to cart') }}</a>
                <a href="" data-url="{{ route('favorite.create', $product->id) }}" class="add-to-fav addToFav"><i
                        class="fa fa-heart-o"></i></a>
            @else
                <a href="{{ route('home_login') }}" class="add-to-cart">{{ _i('Add to cart') }}</a>
                <a href="{{ route('home_login') }}" data-url="{{ route('favorite.create', $product->id) }}"
                    class="add-to-fav "><i class="fa fa-heart-o"></i></a>
            @endif

        </div>
    </div>
</div>
