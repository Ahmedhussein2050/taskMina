

<div class="row">


    @foreach ($result as $item)

        <div class="col-3 @if($ProductOffer == 'ProductOffer') data_{{ $item['id'] }} @else  dataFree_{{ $item['id'] }} @endif">
            @if($ProductOffer == 'ProductOffer')
            <input type="hidden" name="product_id[]" value="{{ $item['id'] }}">
            @endif
            @if($ProductOffer == 'ProductFree')
                <input type="hidden" name="productFree_id[]" value="{{ $item['id'] }}">
            @endif
            <div class="card rounded-card user-card">
                <div class="card-block">
                    <div class="img-hover">
						<img class="img-fluid img-circle" style="max-height: 70px;"
						src="{{ URL::asset($item->mainPhoto())}}" alt="round-img">

                    </div>
                    <div class="user-content">

                        <h4 class="">{{ $item->singleProductDetails()!=null ? $item->singleProductDetails()->title : "" }}</h4>
                        {{-- <h4 class="">{{ $item['cateName'] }}</h4> --}}
                        <div>
                            <button
                                class='btn btn-primary btn-outline-primary waves-effect waves-light m-r-15 btn-delete '
                                data-id="{{ $item['id'] }}"
                                data-url='{{ route('admin.offer.delete', $item['id']) }}'
                                data-type="@if($ProductOffer =='ProductOffer') ProductOffer @else ProductFree @endif"><i
                                    class='fa fa-trash'></i> </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
</div>
