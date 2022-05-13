@extends('layout.index')
@section('title', _i('Classification'))

@section('main')
    <nav aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb py-4">
                <li class="breadcrumb-item"><a href="/">{{ _i('home') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $classifications->data ? $classifications->data->title : '' }}</li>
            </ol>
        </div>
    </nav>
    @if ($categories->isNotEmpty())
        <section class="sub-sections mb-3">
            <div class="container">
                <div class="section-title mb-3">{{ _i('Categories') }}</div>
                <div class="row">
                    @foreach ($categories as $cals)
                        @if ($cals->dataa != null)
                            <div class="col-lg-3 col-md-4 col-6 mb-4">
                                <div class="single-section-item">
                                    <a href="{{ route('category', $cals->id) }}">
                                        <div class="item-icon">
                                            <img src="{{ asset($cals->icon) }}" alt="image"
                                                class="img-fluid" loading="lazy">
                                        </div>
                                        <h3 class="item-title">
                                            {{ $cals->dataa ? $cals->dataa->title : '' }}
                                        </h3>
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    @if (!$classifications->products->isEmpty())
        <section class="products-section  pb-5">
            <div class="container">
                <div class="section-title mb-3">{{ _i('Product(s) found related to') }}
                    {{ $classifications->data ? $classifications->data->title : '' }} :
                    {{ $classifications->products->count() }}</div>

                <div class="products-wrapper-grid">
                    @foreach ($classifications->products as $product)
                        @include('portal.products.productItem', [
                            'product' => $product,
                        ])
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
