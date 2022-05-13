@extends('layout.index')
@section('title', _i('Search'))

@section('main')
    <nav aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb py-4">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ _i('home') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{_i('Search') }}
                </li>
            </ol>
        </div>
    </nav>
    <div class="container">
        <div class="row">
             @if ($arr['products']->isNotEmpty())
                @include('portal.filter.filter')
                <div class="col-md-9">
                    <section class="products-section py-4 my-3">
                        <div class="container">
                            <div class="section-title mb-3"> {{ _i('Avaliable') }}
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
                <div class="text-center">{{ _i('Sorry, There are no products') }}</div>
            @endif

        </div>
    </div>
@endsection
