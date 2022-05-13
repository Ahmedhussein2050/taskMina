@extends('layout.index')
@section('title', _i('My Favourites'))

@section('main')

    <div class="inner-page-wrapper">
        <section class="my-account-page my-5">
            <div class="container">
                <div class="">
                    @include('portal.user.account.partial')
                </div>
                <div class="products-wrapper-grid my-3">
                    @forelse ($products as $product)
                        @php
                            if ($product->imagee($product) != null) {
                                $image = $product->imagee($product)[0];
                            } 
                        @endphp
                        <div class="single-product added-to-favourite delete_div_{{ $product->id }}">
                            <a href="{{ route('home_product.show', $product->id) }}" class="img-fluid"><img
                                    src="{{ asset($image ?? '') }}" alt="" class="img-fluid"></a>
                            <div class="product-title">
                                <a href="{{ route('home_product.show', $product->id) }}">
                                    @if ($product->detailes == null)
                                        {{ $product->product_details ? $product->product_details->first()->title : '' }}
                                    @else
                                        {{ $product->detailes ? $product->detailes->title : '' }}
                                    @endif
                                </a>
                            </div>
                            <div class="fixed-button-options">
                                <div class="product-prices">
                                    <div class="regular-price">{{ $product->getPriceWithTax($product->price) }}
                                        {{ _i('SAR') }}</div>

                                </div>
                                <div class="buttons">
                                    <a href="" class="add-to-cart add-to-cartt" data-id="{{ $product->id }}"
                                        data-price="{{ $product->getPriceWithTax($product->price) }}">{{ _i('Add to cart') }}</a>
                                    <a href="" data-id="{{ $product->id }}"
                                        data-url="{{ route('favorite.create', $product->id) }}"
                                        class="delete-favourite add-to-fav"><i class="fa fa-heart-o"></i></a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center">{{ _i('You dont have favourite products') }}</div>
                    @endforelse
                </div>
            </div>
        </section>
    </div>

@endsection
@push('js')
    <script>
        $(document).on('click', '.delete-favourite', function(e) {
            e.preventDefault();
            var _url = $(this).attr('data-url');
            var id = $(this).attr('data-id');
            var $this = $(this);
            $.ajax({
                url: _url,
                type: 'get',
                data: {
                    id: id
                },
                success: function(response) {
                    if (response.status == 'success') {
                        $this.parents('.delete_div_' + id).remove();
                        $this.parent('div').removeClass('active');
                        $this.removeClass('delete-fav').addClass(
                            'add-product-to-favorite');

                        Swal.fire({
                            icon: 'success',
                            title: 'removed  Successfully',
                        })
                    }
                },
            });
        })
    </script>
@endpush
