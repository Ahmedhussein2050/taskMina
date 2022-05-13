<div class="review-section-wrapper">
    <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="review-sidebar-wrapper">
                <div class="bg-white rounded10 text-center p-3">
                    <div class="overall-rating">
                        <div class="text-gray font-weight-simiBold fz18 py-3">{{ _i('Reviews Avg') }}
                        </div>
                        <div class="total-avg">
                            {{ number_format($product->comments->where('published', 1)->avg('stars'), 2) }}
                        </div>
                        <div class="rating purple">
                            <i
                                class="fa fa-star {{ $product->comments->where('published', 1)->avg('stars') < 1 ? 'empty' : '' }}"></i>
                            <i
                                class="fa fa-star {{ $product->comments->where('published', 1)->avg('stars') < 2 ? 'empty' : '' }}"></i>
                            <i
                                class="fa fa-star {{ $product->comments->where('published', 1)->avg('stars') < 3 ? 'empty' : '' }}"></i>
                            <i
                                class="fa fa-star {{ $product->comments->where('published', 1)->avg('stars') < 4 ? 'empty' : '' }}"></i>
                            <i
                                class="fa fa-star {{ $product->comments->where('published', 1)->avg('stars') < 5 ? 'empty' : '' }}"></i>
                        </div>
                        <div class="rating-progress">
                            <div class="single-progress">
                                <span class="step-number">1</span>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: {{ App\Bll\Utility::getRatingPercent(
                                            $product->comments->where('published', 1)->where('stars', 1)->count(),
                                            $product->comments->where('published', 1)->count(),
                                        ) }}%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span
                                    class="step-rate">{{ App\Bll\Utility::getRatingPercent(
                                        $product->comments->where('published', 1)->where('stars', 1)->count(),
                                        $product->comments->where('published', 1)->count(),
                                    ) }}</span>
                            </div>
                            <div class="single-progress">
                                <span class="step-number">2</span>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: {{ App\Bll\Utility::getRatingPercent(
                                            $product->comments->where('published', 1)->where('stars', 2)->count(),
                                            $product->comments->where('published', 1)->count(),
                                        ) }}%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span
                                    class="step-rate">{{ App\Bll\Utility::getRatingPercent(
                                        $product->comments->where('published', 1)->where('stars', 2)->count(),
                                        $product->comments->where('published', 1)->count(),
                                    ) }}</span>
                            </div>
                            <div class="single-progress">
                                <span class="step-number">3</span>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: {{ App\Bll\Utility::getRatingPercent(
                                            $product->comments->where('published', 1)->where('stars', 3)->count(),
                                            $product->comments->where('published', 1)->count(),
                                        ) }}%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span
                                    class="step-rate">{{ App\Bll\Utility::getRatingPercent(
                                        $product->comments->where('published', 1)->where('stars', 3)->count(),
                                        $product->comments->where('published', 1)->count(),
                                    ) }}</span>
                            </div>
                            <div class="single-progress">
                                <span class="step-number">4</span>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: {{ App\Bll\Utility::getRatingPercent(
                                            $product->comments->where('published', 1)->where('stars', 4)->count(),
                                            $product->comments->where('published', 1)->count(),
                                        ) }}%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span
                                    class="step-rate">{{ App\Bll\Utility::getRatingPercent(
                                        $product->comments->where('published', 1)->where('stars', 4)->count(),
                                        $product->comments->where('published', 1)->count(),
                                    ) }}</span>
                            </div>
                            <div class="single-progress">
                                <span class="step-number">5</span>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: {{ App\Bll\Utility::getRatingPercent(
                                            $product->comments->where('published', 1)->where('stars', 5)->count(),
                                            $product->comments->where('published', 1)->count(),
                                        ) }}%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span
                                    class="step-rate">{{ App\Bll\Utility::getRatingPercent(
                                        $product->comments->where('published', 1)->where('stars', 5)->count(),
                                        $product->comments->where('published', 1)->count(),
                                    ) }}</span>
                            </div>
                        </div>
                    </div>
                    @if (auth()->check() == true)
                        <a href="" id="reviewPanelTrigger"
                            class="btn btn-color1  py-2 mt-3">{{ _i('Add review') }}</a>
                    @endif
                </div>
                <aside id="reviewPanel">
                    <div class="color-purple fw-bold fz18 border-bottom pb-3">Add review</div>
                    <form method='post' action='{{ route('send_product_review', $product->id) }}'
                        id='send_product_review'>
                        @csrf
                        <div class="rate-product">
                            <span class="d-block text-lightgray fz14 fw-bold my-3">{{ _i('Rate product') }}</span>
                            <div class="add-rating">
                                <input type="radio" class="rating-input" id="5_star" id="5_star" name="stars"
                                    value="5"><label for="5_star" class="rating-star"></label>
                                <input type="radio" class="rating-input" id="4_star" id="4_star" name="stars"
                                    value="4"><label for="4_star" class="rating-star"></label>
                                <input type="radio" class="rating-input" id="3_star" name="stars" value="3"><label
                                    for="3_star" class="rating-star"></label>
                                <input type="radio" class="rating-input" id="2_star" name="stars" value="2"><label
                                    for="2_star" class="rating-star"></label>
                                <input type="radio" class="rating-input" id="1_star" name="stars" value="1"><label
                                    for="1_star" class="rating-star"></label>
                            </div>
                        </div>

                        <div class="write-review">
                            <span class="d-block text-lightgray fz14 fw-bold my-3">{{ _i('Your comments') }}</span>
                            <textarea name="comment" cols="30" rows="5" class="form-control border-0"></textarea>
                        </div>


                        <input type="submit" class="btn btn-color1 w-100 mt-5" value="{{ _i('send') }}">


                    </form>
                </aside>
            </div>
        </div>
        <div class="col-lg-8 col-md-6">
            @if ($product->comments->where('published', 1)->isNotEmpty())


                <div class="reviews-wrapper">
                    <b class="overlay"></b>
                    @foreach ($product->comments->where('published', 1) as $comment)
                        <div class="single-user-review ">
                            <div class="d-flex">
                                <div class="user-name text-gray fw-bold me-2">
                                    {{ $comment->user ? $comment->user->name : '' }}e</div>
                                <div class="rating ">
                                    <i class="fa fa-star {{ $comment->stars < 1 ? 'empty' : '' }}"></i>
                                    <i class="fa fa-star {{ $comment->stars < 2 ? 'empty' : '' }}"></i>
                                    <i class="fa fa-star {{ $comment->stars < 3 ? 'empty' : '' }}"></i>
                                    <i class="fa fa-star {{ $comment->stars < 4 ? 'empty' : '' }}"></i>
                                    <i class="fa fa-star {{ $comment->stars < 5 ? 'empty' : '' }}"></i>
                                </div>
                            </div>
                            <div class="user-review">
                                {{ $comment->body }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

</div>
