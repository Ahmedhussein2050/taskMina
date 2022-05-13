

<div class="row">


    @foreach ($Offer_Free_product as $item)
        <div class="col-3  dataFree_{{ $item['id']}}">

                <input type="hidden" name="productFree_id[]" value="{{ $item['product_id'] }}">

            <div class="card rounded-card user-card">
                <div class="card-block">
                    <div class="img-hover">
                        @if ($item['photo'] != null)
                            <img class="img-fluid img-circle" style="max-height: 70px;"
                                src="{{ URL::asset($item['photo'])}}" alt="round-img">
                        @else
                            <img class="img-fluid img-circle"
                                src="{{ URL::asset('admin_dashboard/assets/images/user.png') }}" alt="round-img">
                        @endif

                    </div>
                    <div class="user-content">
                        <h4 class="">{{ $item['title'] }}</h4>
                        <h4 class="">{{ $item['cateName'] }}</h4>
                        <div>
                            <button
                                class='btn btn-primary btn-outline-primary waves-effect waves-light m-r-15 btn-delete '
                                data-id="{{ $item['id'] }}"
                                data-url='{{ route('admin.offer.delete', $item['id']) }}'
                                data-type="ProductFree"><i
                                    class='fa fa-trash'></i> </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endforeach



</div>
