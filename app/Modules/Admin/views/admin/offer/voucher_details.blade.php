@extends('admin.layout.index',[
'title' => _i('Offer Transaction Details'),
'subtitle' => _i('Transaction Details'),
'activePageName' => _i('Transaction Details') ,
'activePageUrl' => route('admin.offer.trans',$id),
'additionalPageName' => _i('Offer'),
'additionalPageUrl' => url()->previous()
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
                <h6>{{ $offers->title->{getLangCode()} }}</h6>
                <h6 class="card-link">
					{{ $offer_category->title }}</h6>

                <h6 class="card-link ">{{ $offers->code ?? '' }}</h6>
                <h6 class="card-subtitle  ">{{ $offers->bonus . '' . $offers->type }}</h6>

                <h6 class="card-text"> {{ _i('Valid From') }} : {{ $offers->start_date }}</h6>
                <h6 class="card-text"> {{ _i('To') }} : {{ $offers->end_date }}</h6>
				<h6 class="card-text"> {{ ($offers->description!=null)? $offers->description->{getLangCode()} : "" }}</h6>

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
                                    <img src="{{ asset($item->product->mainPhoto()) }}" style=" width: 50px; "
                                        class="img-responsive img-rounded  " />
                                    {{ ($item->product->singleProductDetails()->title )}}
                                </th>
                                <th class="text-center">{{ $item->count }}</th>
                                <th class="text-center">{{ $item->product->price }}</th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

<div class="row">
   @if ($bank)
		<div class="card col-11">
			<h5 class="mt-2">{{ _i('Bank Details') }} :</h5>
            <div class="card-body">
                 <h6 >{{ $bank->title }} </h6>
                 <h6 >{{ $bank->holder_name }} </h6>
				 <img src="{{ asset($bank->logo) }}"  alt="" style="width: 110px;">
            </div>
        </div>

	@endif

	@if ($payment!=null)
		<div class="card  col-11">
			<h5 class="mt-2">{{ _i('Payment Details') }} :</h5>
            <div class="card-body">
                 <h6  >{{$payment->name }} </h6>
                 <h6  >{{ $payment->company }} </h6>
                <img src="{{ asset($payment->image) }}"  alt="" style="width: 110px;">


            </div>
        </div>

	@endif
</div>
@endsection
