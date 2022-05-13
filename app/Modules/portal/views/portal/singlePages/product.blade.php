@extends('layout.index')
@php
$po = '';
if ($product->product_details->where('lang_id', App\Bll\Lang::getSelectedLangId())->first() != null) {
    $po = $product->product_details->where('lang_id', App\Bll\Lang::getSelectedLangId())->first()->title;
} elseif ($product->product_details->first()) {
    $po = $product->product_details->first()->title;
} else {
}
$discount = $product->discounts($product);
@endphp
@section('title', $po)
@section('main')
    {{-- {{ $product->discounts($product) }} --}}
    <nav aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb py-4">
                <li class="breadcrumb-item"><a href="/">{{ _i('home') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $po }}
                </li>
            </ol>
        </div>
    </nav>
    <section class="single-product-page-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-5  col-md-6">
                    <div class="product-image bg-white">
                        <div class="slider-for">

                            @foreach ($images as $key => $image)
                                <img src="{{ asset($image) }}" alt="" class="img-fluid">
                            @endforeach
                        </div>
                        <div class="slider-nav">
                            @foreach ($images as $key => $image)
                                <img src="{{ asset($image) }}" alt="" class="img-fluid">
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-7  col-md-6">
                    <div class="single-product-info fw-bold">
                        <div class="availability">
                            <span class="text-green">
                                @if ($product->stock != null)
                                    {{ $product->stock }} {{ _i('Avialable in stock') }}
                                @endif
                                {{-- {{ $product->status == 'available' ? _i('Avialable in stock') : _i('Not Avialable Now') }} --}}
                            </span>
                        </div>

                        <div class="item-title"><a
                                href="">{{ $product->product_details->where('lang_id', App\Bll\Lang::getSelectedLangId())->first() ? $product->product_details->where('lang_id', App\Bll\Lang::getSelectedLangId())->first()->title : $product->product_details->first()->title }}</a>
                        </div>
                        <div class="item-description">
                            {{ $product->product_details->where('lang_id', App\Bll\Lang::getSelectedLangId())->first() ? $product->product_details->where('lang_id', App\Bll\Lang::getSelectedLangId())->first()->info : $product->product_details->first()->info }}
                            {{-- <a href="#option1" class="btn-read-more">Read More</a> --}}
                        </div>

                        <div class="prices-wrapper">
                            <span class="fz14 text-muted font-weight-normal">{{ _i('Total Price') }}</span>
                            <div class="product-prices justify-content-start mb-3 mt-0 gap-4 flex-wrap">
                                @if ($discount != null)
                                    @if ($discount->calc_type == 'perc')
                                        <div class="regular-price">
                                            {{ $product->getPriceWithTax($product->price) - ($product->getPriceWithTax($product->price) * $discount->value) / 100 }}
                                            {{ _i('SAR') }}</div>
                                    @else
                                        <div class="regular-price">
                                            {{ $product->getPriceWithTax($product->price) - $discount->value }}
                                            {{ _i('SAR') }}</div>
                                    @endif

                                    <del>{{ $product->getPriceWithTax($product->price) }}
                                        {{ _i('SAR') }}</del>
                                @else
                                    <div class="d-block product-price">{{ $product->getPriceWithTax($product->price) }}
                                        {{ _i('SAR') }}</div>
                                @endif

                                <!-- use regular-price class for price without discount -->
                                <!-- <div class="regular-price">270.00 KD</div>-->

                                {{-- <div class="item-quantity border">
                                    <div class="input-group">
                                        <input type="button" value="-" class="button-minus" data-field="quantity">
                                        <input type="number" step="1" max="" value="1" name="quantity"
                                            class="quantity-field">
                                        <input type="button" value="+" class="button-plus" data-field="quantity">
                                    </div>
                                </div> --}}
                            </div>
                            <div class="buttons ">
                                @if (auth()->check())
                                    <a href="" class="add-to-cart  add-to-cartt" data-id="{{ $product->id }}"
                                        data-price="{{ $product->getPriceWithTax($product->price) }}">{{ _i('Add to cart') }}</a>
                                    <a href="" class="add-to-fav addToFav"
                                        data-url="{{ route('favorite.create', $product->id) }}"><i
                                            class="fa fa-heart-o"></i></a>
                                @else
                                    <a href="{{ route('home_login') }}"
                                        class="add-to-cart">{{ _i('Add to cart') }}</a>
                                    <a href="{{ route('home_login') }}" class="add-to-fav"
                                        data-url="{{ route('favorite.create', $product->id) }}"><i
                                            class="fa fa-heart-o"></i></a>
                                @endif


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white  px-3 mt-4">
                <div class="product-navs">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" id="option1-tab" data-bs-toggle="tab" href="#option1" role="tab"
                                aria-controls="option1" aria-selected="true">{{ _i('Description') }}</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="option2-tab" data-bs-toggle="tab" href="#option2" role="tab"
                                aria-controls="option2" aria-selected="false">{{ _i('Additional Info') }}</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="option3-tab" data-bs-toggle="tab" href="#option3" role="tab"
                                aria-controls="option3" aria-selected="false">{{ _i('Video') }}</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="option4-tab" data-bs-toggle="tab" href="#option4" role="tab"
                                aria-controls="option4" aria-selected="false">{{ _i('Reviews') }}</a>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="option1" role="tabpanel" aria-labelledby="option1-tab">
                    {{ $product->product_details->where('lang_id', App\Bll\Lang::getSelectedLangId())->first() ? $product->product_details->where('lang_id', App\Bll\Lang::getSelectedLangId())->first()->description : $product->product_details->first()->description }}
                </div>
                <div class="tab-pane fade" id="option2" role="tabpanel" aria-labelledby="option2-tab">
                    @if ($product->Attributes->isNotEmpty())
                        <ul class="list-unstyled product-specs-list">
                            @foreach ($product->Attributes as $attr)
                                @if ($attr && $attr->attributeData && $attr->attrOptionData)
                                    <li>
                                        <span>{{ $attr->attributeData ? $attr->attributeData->title : '' }}</span>{{ $attr->attrOptionData ? $attr->attrOptionData->title : '' }}
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="tab-pane fade" id="option3" role="tabpanel" aria-labelledby="option3-tab">
                    @include('portal.include.video')
                </div>
                <div class="tab-pane fade" id="option4" role="tabpanel" aria-labelledby="option4-tab">
                    @include('portal.include.comments')
                </div>
            </div>
            <div class=" px-3 mt-4">
                <?php
                $related = $product->related;
                if ($related) {
                    $products_SKUs = explode(',', $related);
                    $products = \App\Modules\Admin\Models\Products\products::query()
                        ->whereIn('sku', $products_SKUs)
                        ->get();
                }
                ?>
                @if (isset($products))
                    <div class="row">
                        <h3>
                            {{ _i('Related Products') }}
                        </h3>
                    </div>
                    <div class="row">

                        @foreach ($products as $product)
                            <div class="col-md-3 mx-2 single-product">

                                @php
                                    foreach ($product->imagee($product) as $img) {
                                        $path = preg_replace("/\.[^.]+$/", '', basename($img));
                                        if ($path == $product->sku) {
                                            $im = $img ?? null;
                                        }
                                    }
                                @endphp

                                <a href="{{ route('home_product.show', $product->id) }}" class="product-img"><img
                                        src="{{ asset($im ?? '') }}" alt="" class="img-fluid"></a>
                                <div class="product-title">
                                    <a href="{{ route('home_product.show', $product->id) }}">
                                        @if ($product->product_details != null)
                                            {{ $product->product_details->where('lang_id', App\Bll\Lang::getSelectedLangId())->first() ? $product->product_details->where('lang_id', App\Bll\Lang::getSelectedLangId())->first()->title : $product->product_details->first()->title }}
                                        @endif
                                    </a>
                                </div>
                                <div class="fixed-button-options">
                                    <div class="product-prices">
                                        <div class="regular-price">{{ $product->getPriceWithTax($product->price) }}
                                            {{ _i('SAR') }}</div>

                                    </div>
                                    <div class="buttons">
                                        @if (auth()->check())
                                            <a href="" class="add-to-cart  add-to-cartt" data-id="{{ $product->id }}"
                                                data-price="{{ $product->getPriceWithTax($product->price) }}">{{ _i('Add to cart') }}</a>
                                            <a href="" data-url="{{ route('favorite.create', $product->id) }}"
                                                class="add-to-fav addToFav"><i class="fa fa-heart-o"></i></a>
                                        @else
                                            <a href="{{ route('home_login') }}"
                                                class="add-to-cart">{{ _i('Add to cart') }}</a>
                                            <a href="{{ route('home_login') }}"
                                                data-url="{{ route('favorite.create', $product->id) }}"
                                                class="add-to-fav "><i class="fa fa-heart-o"></i></a>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script>
        $(document).on('submit', '#send_product_review', function(e) {
            e.preventDefault();
            var review_url = $(this).attr('action');
            $.ajax({
                url: review_url,
                method: "post",
                "_token": "{{ csrf_token() }}",
                data: new FormData($('#send_product_review')[0]),
                cache: false,
                contentType: false,
                processData: false,
                error: function(response) {
                    var errors = '';
                    $.each(response.responseJSON.errors, function(i, item) {
                        errors = errors + item + "<br>";
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            html: errors,
                        })
                    });
                },
                success: function(response) {
                    if (response == 'success') {

                        Swal.fire({
                            icon: 'success',
                            title: 'Thank You, Your Review Has Been Submitted',
                            // html: errors,
                        })
                        //$("#reviewPanel").removeClass("show");
                    }
                },
            });
        })
    </script>
@endpush
