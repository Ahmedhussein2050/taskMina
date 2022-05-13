@extends('layout.index')
@section('title', _i('My orders'))

@section('main')

    <div class="inner-page-wrapper">
        <section class="my-orders-page my-5">
            <div class="container">
                <div class="white-wrapper">
                    @include('portal.user.account.partial')
                </div>

                <div class="user-panel-wrapper my-3">
                    <div class="white-wrapper">
                        @if ($orders->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-striped align-baseline">
                                    <thead>
                                        <tr class="text-center">
                                            <th>{{ _i('ID') }}</th>
                                            <th>{{ _i('Date') }}</th>
                                            <th>{{ _i('Status') }}</th>
                                            <th>{{ _i('Pay method') }}</th>
                                            <th>{{ _i('Quantity') }}</th>
                                            <th>{{ _i('Total') }}</th>
                                            <th>{{ _i('Options') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td>{{ $order->ordernumber }}</td>
                                                <td>{{ $order->created_at }}</td>
                                                <td>{{ $order->status }}</td>
                                                <td>Tabs</td>
                                                <td>{{ $order->products->count() }}</td>
                                                <td>{{ $order->total + $order->shipping_cost}} {{ _i('SAR') }}</td>
                                                <td class="">
                                                    <a href="{{ route('order_details', $order->id) }}"
                                                        data-bs-toggle="tooltip" title="Invoice" class="btn btn-color1 "><i
                                                            class="fas fa-file-invoice"></i>
                                                    </a>
                                                    @if ($order->status == 'wait')
                                                        <span>{{ _i('Return') }}</span>
                                                        <a href="" data-bs-target="#return_modal" data-bs-toggle="modal"
                                                            data-id="{{ $order->id }}"
                                                            class="btn text-color1 returnorder"><i
                                                                class="fas fa-undo"></i></a>
                                                    @elseif ($order->status == 'refund')
                                                        <span>{{ _i('Returning') }}</span>
                                                        <a href="" class="btn disabled text-color2"><i
                                                                class="fas fa-exchange-alt"></i></a>
                                                    @elseif ($order->status == 'complete_refund')
                                                        <span>{{ _i('Returned') }}</span>
                                                        <a href="" class="btn disabled text-success"><i
                                                                class="fas fa-check-double"></i></a>
                                                    @endif

                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <h3 class="text-center">{{ _i('You dont have Orders') }}</h3>

                        @endif
                    </div>
                </div>
                <div class="modal fade bootstrap-modal" id="return_modal" tabindex="-1">
                    <div class="modal-dialog " role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">
                                    {{ _i('Request order returning') }}</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body pt-0">
                                <form id="return-order-form" method="post">
                                    @csrf
                                    <textarea name="description" id="description" class="form-control mt-3" cols="30" rows="10"
                                        placeholder="Reason of returning .."></textarea>
                                    <input type="hidden" name="order_id" id="order_id" value="">
                                </form>
                            </div>
                            <div class="modal-footer pt-0 border-0">
                                <button type="button" class="btn btn-color2"
                                    data-bs-dismiss="modal">{{ _i('Close') }}</button>
                                <button type="submit" class="btn btn-color1"
                                    form="return-order-form">{{ _i('Send Request') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


@endsection
@push('js')
    <script>
        $(document).on('click', '.returnorder', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            $('#order_id').val(id);
        })
        $(document).on('submit', '#return-order-form', function(e) {
            e.preventDefault();
            var review_url = "{{ route('order.return') }}";
            $.ajax({
                url: review_url,
                method: "post",
                "_token": "{{ csrf_token() }}",
                data: new FormData($('#return-order-form')[0]),
                cache: false,
                contentType: false,
                processData: false,
                error: function(response) {
                    var errors = '';
                    $.each(response.responseJSON.errors, function(i, item) {
                        errors = errors + item + "<br>";
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            html: errors,
                        })
                    });
                },
                success: function(response) {
                    if (response == 'success') {

                        Swal.fire({
                            icon: 'success',
                            title: 'Your request has been send',
                        })
                        $("#return_modal").modal('hide');
                    }
                },
            });
        })
    </script>
@endpush
