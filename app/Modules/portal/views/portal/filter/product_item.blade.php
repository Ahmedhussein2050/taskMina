@php
	if (!isset($hidden)) {
    $hidden = '';
}

@endphp
@foreach ($products as $product)

    <div class="products-wrapper-grid ">
        @include('portal.products.productItem')
    </div>
@endforeach
@if ($products->hasPages())
    @if ($products->currentPage() < ((int) ceil($products->total() / $products->perPage())))
        <script>
            $(function() {
                $(".load-more-products{{$hidden}}").show();
            });
        </script>
    @else
        <script>
            $(function() {
                $(".load-more-products{{$hidden}}").hide();
            });
        </script>
    @endif
@else
    <script>
        $(function() {
            $(".load-more-products{{$hidden}}").hide();
        });
    </script>

@endif
<script>
    $(function() {
        $("#span_found{{$hidden}}").text({{ $products->total() }});
    });
</script>
