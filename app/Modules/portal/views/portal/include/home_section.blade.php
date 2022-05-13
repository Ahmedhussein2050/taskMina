 @foreach ($sections as $section)
    @if ($loop->index == 1)
        @if (isset($category) && count($category->products) > 0)
            <section class="store-sections mt-5">
                <div class="container">

                    <div class="five_items_carousel">
                        @if ($category->products != null)
                            @php
                                $items = count($category->products) >= 5 ? $category->products->random(5) : $category->products;
                            @endphp
                            {{-- @foreach ($items as $product)
                                @include('web.' . get_default_template() . '.' . 'includes.product_item')
                            @endforeach --}}
                        @endif
                    </div>
                </div>
            </section>
        @endif
    @endif
    @if ($section->type == 'best_selling_products' || ($section->type == 'latest_products' && $section->products()->isNotEmpty()))
        <section class="products-section py-4 my-3">
            <div class="container">
                <div class="section-title mb-3">
                    @if ($section->is_title_displayed == 1)
                        {{ $section->translation ? $section->translation->title : '' }}
                    @endif
                </div>
                <div class="products-slider">
                    {{-- @if ($section->products() != null) --}}
                     @foreach ($section->products()->where('stock', '>', 0) as $product)
                        @include('portal.products.productItem', [
                            'product' => $product,
                        ])
                    @endforeach

                </div>
            </div>
        </section>
    @elseif($section->type == 'random_products' && $section->products()->isNotEmpty())
        @if ($section->products() != null)
            <section class="products-section py-4 my-3">
                <div class="container">
                    <div class="section-title mb-3">
                        @if ($section->is_title_displayed == 1)
                            {{ $section->translation ? $section->translation->title : '' }}
                        @endif
                    </div>
                    <div class="products-slider">

                        @foreach ($section->products()->where('stock', '>', 0) as $product)
                            @include('portal.products.productItem', [
                                'product' => $product,
                            ])
                        @endforeach

                    </div>
                </div>
            </section>
        @endif
    @elseif($section->type == 'banner' && $section->banners->isNotEmpty())
        <section class="adv">
            <div class="container">
                @foreach ($section->banners as $banner)
                    <div class="single-wide-ad">
                        <a href="{{ $banner->link }}"><img src="{{ asset($banner->image) }}" alt=""
                                class="img-fluid w-100"></a>
                    </div>
                @endforeach
            </div>
        </section>
    @elseif($section->type == 'banner2')
        @if ($section->translation)
            <section class="adv two-ads-row mt-4">
                <div class="container">
                    @if ($section->is_title_displayed == '1')
                        {{ $section->translation ? $section->translation->title : '' }}
                    @endif
                    <div class="row">
                        @foreach ($section->banners as $banner)
                            <div class="col-md-6">
                                <div class="single-wide-ad">
                                    <a href=""><img src="{{ asset($banner->image) }}" alt=""
                                            class="img-fluid w-100"></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    @endif
@endforeach
