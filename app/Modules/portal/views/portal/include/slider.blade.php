@if ($sliders->isNotEmpty())
    <section class="sections-nav-slider">
        <div class="container">
            <div class="main-slider">
                <div class="main-slider-trigger">
                    @foreach ($sliders as $slider)
                        <div class="item"><img src="{{ asset($slider->image) }}" alt=""></div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif
