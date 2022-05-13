@php
if (!isset($div_response)) {
    $div_response = '.category-products';
}
if (!isset($hidden)) {
    $hidden = '';
}
//  dd($arr);
@endphp

<div class="col-md-3">
    <div class="products-filters">
        <div class="text-color1 fw-bold fz18 mb-3" data-toggle="collapse" data-target="#filter-form{{ $hidden }}">
            {{ _i('Filter by') }}</div>
        {{-- <div class="text-color1 fw-bold fz18 mb-3">Filter by</div> --}}
        <form method='get' id='filter-form{{ $hidden }}' class=" ">


            @csrf
            <input type="hidden" name="hidden" value="{{ $hidden }}" />

            <div class="single-filter">
                <div class="text-gray fw-bold fz16 mb-2">{{ _i('Search word') }}</div>
                <div class="search-categories">
                    <input type='search' name="search" placeholder="{{ _i('Search word') }}" class="form-control"
                        value='{{ request()->get('search') }}'>
                </div>
            </div>


            <div class="single-filter">
                <div class="title text-gray fw-bold fz16 mb-2 collapsed" data-bs-toggle="collapse" href="#priceFilter">
                    {{ _i('price') }}</div>
                <div class="price-filter collapse" id="priceFilter">
                    {{-- <div id="price_rangee"></div> --}}
                    <div class="col-sm-12 d-flex justify-content-center mb-3">
                        <div id="slider-range" class="price-filter-range" style="width: 100%" name="rangeInput"></div>
                    </div>
                    <div class="d-flex gap-3 mt-3">
                        <input type="number" class="form-control" name="min_price" id="min-price{{ $hidden }}"
                            placeholder="{{ _i('MIN') }}" min=0 max="4900" oninput="validity.valid||(value='0');">
                        <input type="number" class="form-control" name="max_price" id="max-price{{ $hidden }}"
                            placeholder="{{ _i('MAX') }}" min=0 max="5000"
                            oninput="validity.valid||(value='5000');">
                    </div>
                </div>
            </div>

            <div class="single-filter">
                @if ($arr['brands'] || count($arr['brands']) > 0)
                    <div class="title text-gray fw-bold fz16 mb-2 collapsed" data-bs-toggle="collapse"
                        href="#brandFilter">{{ _i('Brands') }}</div>
                    <div class="cat-filter collapse" id="brandFilter">
                        @foreach ($arr['brands'] as $brand)
                             @if ($brand && $brand->translation)
                                <div class="form-check">
                                    <input type="checkbox" name='brand[{{ $brand->id }}]'
                                        class="form-check-input filter-brand" id="brandCheck{{ $brand->id }}"
                                        value="{{ $brand->id }}">
                                    <label class="form-check-label" for="brandCheck{{ $brand->id }}">
                                        <img src="{{ asset($brand->image) }}" class="img-fluid brand" loading="lazy">
                                        {{ isset($brand->translation) ? $brand->translation->name : '' }}
                                    </label>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="single-filter ">
                @if (count($arr['categories']) > 0)
                    <div class="title text-gray fw-bold fz16 mb-2 collapsed" data-bs-toggle="collapse"
                        href="#catFilter">{{ _i('Category') }}</div>
                    <div class="cat-filter collapse" id="catFilter">
                        @foreach ($arr['categories'] as $category)
                            @if ($category)
                                <div class="form-check">
                                    <input type="checkbox" name='category[]' class="form-check-input"
                                        id="catCheck{{ $category->category_id }}"
                                        value="{{ $category->category_id }}">
                                    <label class="form-check-label" for="catCheck{{ $category->category_id }}">
                                        {{ $category->title }}
                                    </label>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="single-filter">
                @if (count($arr['classification']) > 0)
                    <div class="title text-gray fw-bold fz16 mb-2 collapsed" data-bs-toggle="collapse"
                        href="#classFilter">{{ _i('Classification') }}</div>
                    <div class="cat-filter collapse" id="classFilter">
                        @foreach ($arr['classification'] as $class)
                            @if ($class && $class->data)
                                <div class="form-check">
                                    <input type="checkbox" name='classification[]' class="form-check-input"
                                        id="classCheck{{ $class->id }}" value="{{ $class->id }}">
                                    <label class="form-check-label" for="classCheck{{ $class->id }}">
                                        {{ $class->data ? $class->data->title : '' }}
                                    </label>
                                </div>
                            @endif
                        @endforeach

                    </div>
                @endif
            </div>
            <div class="single-filter ">
                <div class="title text-gray fw-bold fz16 mb-2 collapsed" data-bs-toggle="collapse" href="#rateFilter">
                    {{ _i('Rate') }}</div>
                <div class="cat-filter collapse" id="rateFilter">
                    @for ($i = 5; $i >= 1; $i--)
                        <div class="form-check">

                            <input type="checkbox" name='rate[]' class="form-check-input" id="rateCheck "
                                value="{{ $i }}">
                            <label class="form-check-label" for="rateCheck ">
                                @for ($b = 1; $b <= $i; $b++)
                                    <i class="fa fa-star text-warning" aria-hidden="true"></i>
                                @endfor
                            </label>
                        </div>
                    @endfor
                </div>
            </div>

            <input type="hidden" name="page" class='filter-form-page{{ $hidden }}' value=1>
            <input type="hidden" name="sort" id="sort" value="">
        </form>
    </div>
</div>
@once
    @push('js')
        <script>
            function changeMe(id) {

                $('#div_' + id).toggle();
            }

            function ajaxFilter(div_response, hidden) {
                $('.filter-form-page{{ $hidden }}').val(1);
                $('.load-more-products{{ $hidden }}').show();
                $.ajax({
                    url: "",
                    method: "post",
                    "_token": "{{ csrf_token() }}",
                    data: new FormData($('#filter-form' + hidden)[0]),
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $(div_response).html(response);
                    },
                });
            }
            const priceRange = document.getElementById('price_rangee');

            noUiSlider.create(priceRange, {
                start: [0, 100],
                connect: true,
                //direction: 'rtl', //Enable this for RTL version
                range: {
                    'min': 0,
                    'max': 400
                }
            });
        </script>
    @endpush
@endonce

@push('js')
    <script>
        var filter_url = $('.filter-url').val();

        $(document).on('click', '.load-more-products{{ $hidden }}', function() {

            var $this = $(this);
            var page = $('.filter-form-page{{ $hidden }}').val();

            var next_page = parseInt(page) + 1;
            var data_pre = $(this).attr('data-pre');
            $('.filter-form-page{{ $hidden }}').val(next_page);
            $.ajax({
                url: filter_url,
                method: "post",
                "_token": "{{ csrf_token() }}",
                data: new FormData($('#filter-form{{ $hidden }}')[0]),
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response)
                    if (response == '') {
                        $this.hide();
                    }
                    $('{{ $div_response }}').append(response);
                    if (data_pre == next_page) {
                        $this.hide();
                    }
                },
            });
        });

        $(document).on('change', '#filter-form{{ $hidden }} :input', function() {
            //  alert("{{ $div_response }}" + " #filter-form{{ $hidden }}");
            ajaxFilter("{{ $div_response }}", "{{ $hidden }}");
        })

        $(function() {
            $("#min-price{{ $hidden }},#max-price{{ $hidden }}").on('change', function() {
                var min_price_range = parseInt($("#min-price{{ $hidden }}").val());
                var max_price_range = parseInt($("#max-price{{ $hidden }}").val());
                if (min_price_range > max_price_range) {
                    $('#max-price{{ $hidden }}').val(min_price_range);
                }

                $("#slider-range").slider({
                    values: [min_price_range, max_price_range]
                });


            });
            $("#min-price{{ $hidden }},#max-price{{ $hidden }}").on("paste keyup", function() {
                var min_price_range = parseInt($("#min-price{{ $hidden }}").val());

                var max_price_range = parseInt($("#max-price{{ $hidden }}").val());

                if (min_price_range == max_price_range) {

                    max_price_range = min_price_range + 100;

                    $("#min-price{{ $hidden }}").val(min_price_range);
                    $("#max-price{{ $hidden }}").val(max_price_range);
                }

                $("#slider-range").slider({
                    values: [min_price_range, max_price_range]
                });

            });
            $(function() {
                $("#slider-range").slider({
                    range: true,
                    orientation: "horizontal",
                    min: 0,
                    max: {{ \App\Bll\Utility::getMaxPrice() }},
                    values: [0, {{ \App\Bll\Utility::getMaxPrice() }}],
                    step: 50,

                    slide: function(event, ui) {
                        if (ui.values[0] == ui.values[1]) {
                            return false;
                        }


                        $("#min-price{{ $hidden }}").val(ui.values[0]);
                        $("#max-price{{ $hidden }}").val(ui.values[1]);
                    }

                });

                $("#min-price{{ $hidden }}").val($("#slider-range").slider("values", 0));
                $("#max-price{{ $hidden }}").val($("#slider-range").slider("values", 1));

            });

            $("#slider-range").click(function() {

                var min_price = $('#min-price{{ $hidden }}').val();
                var max_price = $('#max-price{{ $hidden }}').val();

                $("#searchResults").text("Here List of products will be shown which are cost between " +
                    min_price + " " + "and" + " " + max_price + ".");
            });

            $("#slider-range").mouseup(function() {

                ajaxFilter("{{ $div_response }}", "{{ $hidden }}");
            });




        });
    </script>
@endpush
