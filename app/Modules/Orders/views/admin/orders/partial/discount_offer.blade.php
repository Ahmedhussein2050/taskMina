@php
$transaction = App\Modules\Orders\Models\Transaction::where('order_id', $order->id)->first();
if ($transaction != null) {
    $transaction_offer = App\Modules\Orders\Models\OffersAndDiscounts\TransactionOffer::with('offer')
        ->where('transaction_id', $transaction->id)
        ->get();
}

@endphp
@if (isset($transaction_offer))
    @foreach ($transaction_offer as $offer)
        @php
            $json = json_decode($offer->offer, true);
        @endphp
        <div class="col-md-4">

            <div class="card user">
                <div class="card-header">
                    <h5>{{ _i('Discount Offer') }}</h5>
                </div>

                <div class="card-footer userIcon ">
                    <div class="card-block-big text-center">
                        <p><span>{{ _i('Discount') }} : </span> {{ $json['title'][getLangCode()] }}</p>
                        @if ($json['description'])
                            <p><span>{{ _i('Description') }} : </span>{{ $json['description'][getLangCode()] }}</p>
                        @else
                            <p><span>{{ _i('Description') }} : </span></p>
                        @endif
                        <p><span>{{ _i('Starting From') }} : </span>{{ $offer->offer->start_date }}</p>
                        <p><span>{{ _i('To') }} : </span>{{ $offer->offer->end_date }}</p>
                    </div>
                </div>


            </div>
        </div>
    @endforeach
@endif
