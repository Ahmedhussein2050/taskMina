
@include('.admin.orders.account.css')
<!DOCTYPE html>
<html>

<head>
    <title>{{ _i('Invoice #') }} {{ $order->ordernumber }}</title>
</head>

<body>

    {{-- @dd($order->created_at, $order->total, $order->tax_cost) --}}

    <div>
        <div style="min-width: 600px">
            <header>
                <div class="row">
                    <div class="col">
                        <img width="100px"
                            src="{{ \App\Bll\Utility::zatca($order->created_at, $order->total, $order->tax_cost) }}" />
                    </div>
                    <div class="col company-details">
                        <a target="_blank" href="{{ route('home', app()->getLocale()) }}">
                            <img src="{{ asset('') }}" data-holder-rendered="true" />

                        </a>

                        <div style="background: #6f30a0; color: #fff;">
                            {{ _i('Invoice Number') }} : {{ $order->id }}
                        </div>
                        <div style="background: #6f30a0; color: #fff;">
                            {{ _i('Shipment Number') }} : #0000
                        </div>
                        <div style="background: #6f30a0; color: #fff;">
                            {{ _i('Tax Number') }} : 302180841300003
                        </div>
                    </div>
                </div>

            </header>
            <div class="text-center">البائع (Mashora)</div>
        </div>
    </div>

    @include('.admin.orders.account.main')


    @if (request()->is('*/account/print/*') || request()->is('*/orders/*'))
        <script type="text/javascript">
            window.onload = function() {
                window.print();
            }
        </script>
    @endif
</body>

</html>
