@extends('admin.layout.index',[
'title' => _i('One Free Details'),
'subtitle' => _i('One Free Details'),
'activePageName' => _i('One Free Details') ,
'activePageUrl' => route('admin.offer.trans',$id),
'additionalPageName' => _i('Offer'),
'additionalPageUrl' => route('admin.offer.index')
])
@section('content')
    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if (Session::has($msg))
                <p class="alert alert-{{ $msg }}">{{ Session::get($msg) }}</p>
            @endif
        @endforeach
    </div>
    <div class="row">
        <div class="card   col-5">
            <div class="card-body">
                <h4>{{ $offer_category->title }}</h4>
                <a class="card-link">{{ $offers->title }}</a>
                <br>
                <a class="card-link ">{{ $offers->code ?? '' }}</a>
                <a class="card-subtitle  ">{{ $offers->bonus . '' . $offers->type }}</a>

                <p class="card-text"> {{ _i('Valid From') }} : {{ $offers->start_date }}</p>
                <p class="card-text"> {{ _i('To') }} : {{ $offers->end_date }}</p>

            </div>
        </div>
        <div class="card  ml-1   col-6 ">
            <div class="card-body">

                <h6 class="card-text"> {{ _i('Date') }} : {{ $transOffer->created_at }} </h6>
                <h6 class="card-text"> {{ _i('Status') }} : {{ $transOffer->status }} </h6>
                <h6 class="card-text"> {{ _i('Type') }} : {{ $transOffer->type }}  </h6>
                <h6 class="card-text"> {{ _i('Amount') }} : {{ $transOffer->total }} </h6>
                <h6 class="card-text"> {{ _i('Order No.') }} : {{ $transOffer->order_id }}</h6>
                <h6 class="card-text"> {{ _i('Transaction No.') }} : {{ $transOffer->id }} </h6>

            </div>

        </div>
        <div class="card col-11  ">

            <h5 class="mt-2">{{ _i('Order Details') }} :</h5>
            <div class="dt-responsive table-responsive ">
                <table id="slider_table" class="table table-bordered table-striped dataTable ">
                    <thead>
                        <tr role="row">
                            <th class=""> {{ _i('Title') }}</th>
                            <th class="text-center"> {{ _i('Count') }}</th>
                            <th class="text-center"> {{ _i('Price') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $item)
                            <tr>
                                <th>
                                    <img src="{{ asset($item->photo) }}" style=" width: 50px; "
                                        class="img-responsive img-rounded  " />
                                    {{ $item->title }}
                                </th>
                                <th class="text-center">{{ $item->count }}</th>
                                <th class="text-center">{{ $item->price }}</th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
