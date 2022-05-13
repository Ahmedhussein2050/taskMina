<div class="col-md-4">
    <div class="card user">
        <div class="card-header">
            <h5>{{ _i('Payment Method') }}</h5>
            <button class="btn btn-tiffany f-right" data-toggle="modal" data-target="#payment" type="button"><i
                    class="fa fa-edit"></i>{{ _i('Edit') }}
            </button>
        </div>
        <div class="card-footer userIcon ">
            <div class="card-block-big text-center">
                @if (isset($order) && $order->gettransactions && $order->gettransactions->payment_gateway != null && $order->gettransactions->count() > 0)
                    <p><span>{{ _i('Payment method') }} :
                        </span>{{ App\Modules\Orders\Models\PaymentGate::where('id', $order->gettransactions->payment_gateway)->first()->name }}
                    </p>
                    <p><span>{{ _i('status') }} : </span>{{ $order->gettransactions->status }}</p>
                @endif
            </div>
        </div>
    </div>
</div>

@include('admin.orders.partial.discount_offer')
@include('admin.orders.partial.order_status')

<!--- payment model --->
<div class="modal fade" ref="payment" id="payment" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">{{ _i('payment') }}</h4>
            </div>
            <div class="modal-body">
                <div class="payment_details">
                    <div class="section-title">
                        {{ _i('payment_options') }}
                    </div>
                    <div class="transaction_types">
                        <ul class="list-unstyled">
                            <li>
                                <div hidden>
                                    <label>
                                        <input type="radio" value="bank" data-title="{{ _i('Bank') }}"
                                            class="paymentMethod choose_bank" name="payment">
                                        {{ _i('Pay With Bank') }}
                                        <br />
                                    </label>
                                </div>
                                <div hidden>
                                    <label>
                                        <input type="radio" value="delivery" data-title="{{ _i('Delivery') }}"
                                            class="paymentMethod delivery" name="payment">
                                        {{ _i('Cash on delivery') }}
                                        @if (isset($order) && $order->shipping_option != null)
                                            <span
                                                class="delivery_commission_payment">{{ $order->shipping_option->cash_delivery_commission }}</span>
                                        @endif
                                        <br />
                                    </label>
                                </div>
                                @foreach ($transtransaction_types as $transtransaction_type)
                                    <div>
                                        <label>
                                            <input type="radio"
                                                onclick="getpaymentid('{{ $transtransaction_type->id }}')"
                                                value="{{ $transtransaction_type->id }}"
                                                data-title="{{ $transtransaction_type->name }}"
                                                class="paymentMethod myfatoorah_show" name="payment">
                                            {{ $transtransaction_type->name }}
                                            <br />
                                        </label>
                                    </div>
                                @endforeach
                            </li>
                        </ul>
                        @if (count($banks) > 0)
                            <div class="choose_bank_show mb-4" style="display: none">
                                <select class="form-control bank" id="bank" name="bank" style="height: auto">
                                    <option selected disabled>{{ _i('select') }}</option>
                                    @foreach ($banks as $key => $bank)
                                        <option value="{{ $key }}">{{ $bank }}</option>
                                    @endforeach
                                </select>
                                <div class="bank-details">
                                </div>
                            </div>
                        @else
                            <div class="text-danger">
                                {{ _i('No Banks Available') }}
                            </div>
                        @endif
                        <div class="choose_myfatoorah_show mt-2 mb-4" style="display: none">
                            <div class="online-details">
                                <form action="{{ route('myfatoorah_admin') }}" target="_blank" method="POST"
                                    id="myfatoorah_form">
                                    @csrf
                                    <input type="hidden" name="order" value="{{ $order->id ?? '' }}">
                                    <input type="hidden" name="payment_type" id="payment_type" value="">
                                    <button type="submit" class="btn btn-outline-primary btn-block myfatoorah">
                                        {{ _i('Pay') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="choose_delivery mt-2 mb-4">
                            <form method="post" action="{{ url('admin/orders/update') }}" data-parsley-validate="">
                                @csrf
                                <input type="hidden" name="update_payment" value="1">
                                <input type="hidden" name="order_id" value="{{ $order->id ?? '' }}">
                                <input type="hidden" name='payment_gateway' class='payment-gateway' value=''>
                                <button class="btn btn-tiffany col-md-12" type="submit">{{ _i('Save') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="shipping_cost" class="shipping_cost_input"
                    value="{{ $order->shipping_cost ?? '' }}">
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@push('js')
    <script language="javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function getpaymentid(id) {
            window.paymentId = id;
            $("#payment_type").val(id);
            $('.payment-gateway').val(id);
            if ($("input[type='radio'][name='payment'][value=" + id + "]").data("title").toLowerCase() == "bank") {
                $(".choose_bank_show").show();
            } else
                $(".choose_bank_show").hide();

        }

        $('.bank').on('change', function() {
            var bank_id = $(this).children("option:selected").val();
            $('.bank-details').css('display', 'none');
            if (bank_id != null) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('get-pay-banks') }}",
                    dataType: 'html',
                    data: {
                        bank_id: bank_id,
                        order_id: '<?= $order->id ?>'
                    },
                    success: function(data) {
                        $('.bank-details').css('display', 'block').html(data);
                        $("#frm_bank").parsley();
                    }
                });
            }
        });
    </script>
@endpush
