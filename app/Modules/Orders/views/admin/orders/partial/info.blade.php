<div class="orderList">
    <div class="card ship">
        <div class="  row">
            <div class="col-sm-2">
                <span class="order-top-line">
                    {{ _i('Order No') }}
                </span>
                <div class="order-second-line">
                    {{ $number }}
                </div>
            </div>
            <div class="col-sm-2">
                <span class="order-top-line">
                    {{ _i('Transaction no') }}
                </span>
                @if ($order->transaction != null)
                    <div class="order-second-line">
                        <a href="{{ url('admin/orders/online/' . $order->transaction->id . '/show') }}">
                            {{ $order->transaction->id }}</a>
                    </div>
                @else
                    <div class="order-second-line">
                        {{ _i('Not Found') }}
                    </div>
                @endif
            </div>
            <div class="col-sm-2">
                <span class="order-top-line">
                    {{ _i('Date') }}
                </span>
                <div class="order-second-line">
                    {{ $order->created_at->format('d/m/Y') }}
                </div>
            </div>
            <div class="col-sm-2">
                <span class="order-top-line">
                    {{ _i('Order Status') }}
                </span>
                <div class="order-second-line">
                    {{-- @dd($text); --}}
                    <button class="btn btn-success btn-sm" data-toggle="modal" id='btn_status'
                        data-target="#exampleModal">{{ _i($text) }}</button>
                </div>
            </div>
            <div class="col-sm-2">
                <span class="order-top-line">
                    {{ _i('Print Order') }}
                </span>
                <div class="order-second-line">
                    <a href="{{ route('print_order', $order->id) }}"
                        class="btn waves-effect waves-light btn-success show text-center btn-sm"><i
                            class="ti-printer"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
