@extends('layout.index')
@section('title', _i('Category'))

@section('main')
    <nav aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb py-4">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ _i('home') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $category->dataa ? $category->dataa->title : '' }}</li>
            </ol>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            @if ($category->products->isNotEmpty())
                 @include('portal.filter.filter')
                <div class="col-md-9">
                    <section class="sub-sections mb-3">
                        <div class="container">
                            <div class="section-title mb-3">{{ _i('Brands') }}</div>
                            <div class="row">
                                @if ($category->getBrands($category->products)->isNotEmpty())
                                    @foreach ($category->getBrands($category->products) as $cals)
                                        <div class="col-lg-3 col-md-4 col-6 mb-4">
                                            <div class="single-section-item">
                                                <a href="{{ route('brand', $cals->brand_id) }}">
                                                    <div class="item-icon">
                                                        <img src="{{ asset('portal/images/All categories.svg') }}"
                                                            alt="العدسات" class="img-fluid" loading="lazy">
                                                    </div>
                                                    <h3 class="item-title">
                                                        {{ $cals ? $cals->name : '' }}
                                                    </h3>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </section>
                    <section class="products-section py-4 my-3">
                        <div class="container">
                            <div class="section-title mb-3"> {{ $category->dataa ? $category->dataa->title : '' }}
                                : <span id="span_found">{{ $arr['products']->total() }}</span>
                            </div>

                            <div class="products-wrapper-grid category-products">

                                @if (!empty($arr['products']->count()))
                                    @include('portal.filter.product_item', [
                                        'products' => $arr['products'],
                                    ])
                                @endif

                            </div>
                            @if ($arr['products']->hasPages())
                                <div class="row">
                                    <div class='col-md-12 text-center'>
                                        <button class='btn btn-primary  load-more-products mt-2' type='button'
                                            data-page="1">{{ _i('Load More') }}</button>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </section>
                </div>
            @else
                <div class="text-center">{{ _i('Sorry, There are no products for this category') }}</div>
            @endif

        </div>
    </div>
@endsection
