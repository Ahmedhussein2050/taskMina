@extends('layout.index')
@section('title', _i('Order Details'))

@section('main')

    <div class="inner-page-wrapper">
        <section class="my-orders-page my-5">
            <div class="container">
                <div class="white-wrapper">
                    @include('portal.user.account.partial')
                </div>

                <div class="user-panel-wrapper my-3" id="test">
                    <div class="white-wrapper">
                        <div class="order-details">
                            <ul class="list-inline">
                                <li><strong>{{ _i('Order Number') }} </strong>{{ $order->ordernumber }}</li>
                                <li><strong> {{ _i('Order date') }}</strong>{{ $order->created_at }}</li>
                                <li>
                                    <strong>{{ _i('Payment Method') }}</strong>
                                    Tab
                                </li>
                                <li>
                                    <strong>{{ _i('Payment Status') }}</strong>
                                    {{ $order->status }}
                                </li>
                                <li><strong>{{ _i('Total price') }}</strong> {{ $order->total }} {{ _i('SAR') }}
                                </li>
                                <li>
                                    <strong>{{ _i('Shipping method') }}</strong>
                                    {{-- @dd( $order->shipping_option->company->title) --}}
                                    @if ($order->shipping_option && $order->shipping_option->company && $order->shipping_option->company->titlee != null)
                                        {{ $order->shipping_option->company->titlee->title }}
                                    @endif

                                </li>
                                <li><strong>{{ _i('Client Name') }}</strong> {{ auth()->user()->name }}
                                </li>
                                <li><strong>{{ _i('delivery time') }}</strong>
                                    @if ($order->shipping_option->delay == 0)
                                        {{ $order->shipping_option->hours_delay }} {{ _i('hours') }}
                                    @elseif ($order->shipping_option->hours_delay == 0)
                                        {{ $order->shipping_option->delay }} {{ _i('Days') }}
                                    @else
                                        {{ $order->shipping_option->delay }} Days
                                        : {{ $order->shipping_option->hours_delay }} hours
                                    @endif
                                </li>
                                <li><strong>{{ _i('Email') }}</strong> {{ auth()->user()->email }}</li>
                                <li><strong>{{ _i('Phone') }}</strong> {{ auth()->user()->phone }}
                                </li>

                            </ul>
                        </div>
                        <div class="my-orders-page">
                            <div class="text-color1 fw-bold fz18 p-3"> {{ _i('Order details') }}</div>
                            @php
                                $total = 0;
                            @endphp
                            @forelse ($order->orderProducts as  $product)
                                @php
                                    $total += $product->product->price * $product->count;
                                @endphp
                                <div class="single-order-item">
                                    <div class="single-cart-item d-flex align-items-center shadow-none">
                                        <div class="item-info d-inline-flex align-items-center">
                                            <div class="item-img"><a
                                                    href="{{ route('home_product.show', $product->product->id) }}"><img
                                                        src="{{ asset($product->product->image) }}"
                                                        class="img-fluid" loading="lazy" alt=""></a>
                                            </div>
                                            <div class="item-meta">
                                                <div class="item-title"><a
                                                        href="{{ route('home_product.show', $product->product->id) }}">
                                                        @if ($product->product->product_details != null)
                                                            {{ $product->product->product_details->where('lang_id', App\Bll\Lang::getSelectedLangId())->first()? $product->product->product_details->where('lang_id', App\Bll\Lang::getSelectedLangId())->first()->title: $product->product->product_details->first()->title }}
                                                        @endif
                                                    </a></div>
                                                <div class="item-price"> {{ $product->product->price }}
                                                    {{ _i('SAR') }}</div>
                                            </div>
                                        </div>

                                        <div class="item-quantity">
                                            <div class="rounded-pill bg-color1 text-white p-1 fz14">{{ $product->count }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="info">
                                        <span>{{ _i('tax') }}</span>
                                        <span>{{ App\Bll\Utility::taxOnProduct() }} %</span>
                                    </div>
                                    <div class="info">
                                        <span>{{ _i('Total After Tax') }}</span>
                                        <span>{{ $product->price * $product->count }} {{ _i('SAR') }}</span>
                                    </div>

                                </div>
                            @empty
                            @endforelse


                        </div>

                        <div class="totals fw-bold fz18 table-responsive">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <th>{{ _i('Total order') }}</th>
                                        <td>
                                            {{ $total }} {{ _i('SAR') }}

                                        </td>

                                    </tr>
                                    <tr>
                                        <th>{{ _i('TAX') }}</th>
                                        <td>{{ ($total * App\Bll\Utility::taxOnProduct()) / 100 }}
                                            {{ _i('SAR') }}
                                        </td>

                                    </tr>

                                    <tr>
                                        <th>{{ _i('Shipping Cost') }}</th>
                                        <td> {{ $order->shipping_cost ?? 0 }} {{ _i('SAR') }}

                                        </td>
                                    </tr>

                                    <tr class="text-color1">
                                        <th scope="row">{{ _i('Amount to pay') }}</th>
                                        <td>
                                            @if ($order->shipping_cost != null)
                                                {{ $order->total + $order->shipping_cost }} {{ _i('SAR') }}
                                            @else
                                                {{ $order->total }} {{ _i('SAR') }}
                                            @endif
                                        </td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <a class="btn btn-color1 mt-0 m-2" target="_blank" onclick="printDiv()">
                            <i class="fa fa-print "></i>
                            {{ _i('Print invoice') }}

                        </a>
                    </div>
                </div>

            </div>

        </section>
    </div>




















@endsection
@push('js')
    <script>
        function printDiv() {

            let printElement = document.getElementById("test");
            var printWindow = window.open('', 'PRINT');
            printWindow.document.write(document.documentElement.innerHTML);
            // setTimeout(() => { // Needed for large documents
            printWindow.document.body.style.margin = '0 0';
            printWindow.document.body.innerHTML = printElement.outerHTML;
            printWindow.document.close(); // necessary for IE >= 10
            printWindow.focus(); // necessary for IE >= 10*/
            printWindow.print();
            printWindow.close();
            // }, 1000)
        }
    </script>
@endpush
