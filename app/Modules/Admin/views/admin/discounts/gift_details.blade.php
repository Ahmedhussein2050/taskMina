@extends('admin.layout.index',[
'title' => _i('Discount Transaction Details'),
'subtitle' => _i('Transaction Details'),
'activePageName' => _i('Transaction Details') ,
'activePageUrl' => route('admin.discount.trans',$id),
'additionalPageName' => _i('Discount'),
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
        <div class="   col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-text">{{ _i('Title') }} : {{ $discount->title }}</h6>
                    <h6 class="card-text">{{ _i('Type') }} : {{ $discount->type }}</h6>

                    <h6 class="card-text">{{ _i('Discount') }}
                        :{{ $discount->value }}{{ $discount->calc_type == 'perc' ? '%' : '' }}</h6>

                    <h6 class="card-text"> {{ _i('Valid From') }} : {{ $discount->start_date }}</h6>
                    <h6 class="card-text"> {{ _i('To') }} : {{ $discount->end_date }}</h6>

                </div>
            </div>
        </div>
        <div class="  col-md-6 ">
            <div class="card">
                <div class="card-body">

                    <h6 class="card-text"> {{ _i('Date') }} : {{ $transactions->created_at }} </h6>
                    <h6 class="card-text"> {{ _i('Status') }} : {{ $transactions->status }} </h6>
                    <h6 class="card-text"> {{ _i('Type') }} : {{ $transactions->type }} </h6>
                    <h6 class="card-text"> {{ _i('Amount') }} : {{ $transactions->total }} </h6>
                    <h6 class="card-text"> {{ _i('Order No.') }} : {{ $transactions->order_id }}</h6>
                    <h6 class="card-text"> {{ _i('Transaction No.') }} : {{ $transactions->id }} </h6>

                </div>
            </div>

        </div>
        <div class="card col-md-12 ">

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
                                    {{ $item->product->singleProductDetails() != null ? $item->product->singleProductDetails()->title : '' }}
                                </th>
                                <th class="text-center">{{ $item->count }}</th>
                                <th class="text-center">{{ $item->product->price }}</th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


        @if ($bank)
            <div class="card  col-md-12">
                <h5 class="mt-2">{{ _i('Bank Details') }} :</h5>
                <div class="card-body">
                    <h6>{{ $bank->title }} </h6>
                    <h6>{{ $bank->holder_name }} </h6>
                    <img src="{{ asset($bank->logo) }}" alt="" style="width: 110px;">
                </div>
            </div>

        @endif

        @if ($payment)
            <div class="card  col-md-12">
                <h5 class="mt-2">{{ _i('Payment Details') }} :</h5>
                <div class="card-body">
                    <h6>{{ _i('Name') }} : {{ $payment->name }} </h6>
                    <h6>{{ _i('Company') }} : {{ $payment->company }} </h6>

                    <img src="{{ asset($payment->image) }}" alt="" style="width: 110px;">


                </div>
            </div>

        @endif

    @endsection
