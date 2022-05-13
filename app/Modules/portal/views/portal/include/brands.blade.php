<section class="sponsors  py-4 my-3">
    <div class="container">

        <div class="section-title mb-3">{{ _i('Brands') }}</div>
        <div class="sponsors-slider">
            @foreach ($brands as $brand)
                <div class="single-sponsor"><a href="{{ route('brand',$brand->id) }}"><img src="{{ asset($brand->image) }}" alt="" class="img-fluid"></a></div>
            @endforeach
        </div>
    </div>
</section>
