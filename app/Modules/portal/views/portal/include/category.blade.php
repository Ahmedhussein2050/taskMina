<section class="sections-slider py-5">
    <div class="container">
        <div class="section-title mb-3">{{ _i('categories') }}</div>
        <div class="products-slider">
            @foreach ($categories as $category)
                @if ($category->dataa != null)
                    <div class="single-section-item">
                        <a href="{{ route('category', $category->id) }}">
                            <div class="item-icon">
                                <img src="{{ asset($category->icon) }}g" alt="" class="img-fluid" loading="lazy">
                            </div>
                            <h3 class="item-title">
                                {{ $category->dataa->title }}
                            </h3>
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</section>
