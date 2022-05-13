@extends('admin.layout.index',
[
'title' => _i('Show Order'),
'subtitle' => _i('Show Order'),
'activePageName' => _i('Show Order'),
'activePageUrl' => '',
'additionalPageName' => _i('Orders'),
'additionalPageUrl' => route('admin.orders.index')
])

@section('content')
    @push('css')
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
        <style>
            .dropdown-menu {
                z-index: 9999;
            }

        </style>
    @endpush
@section('content')

    <div class="row order-column">

        <div class="order-table col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ _i('Discount') }}</h3>
                    <div class="heading-elements">
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="card-body">

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ _i('Title') }}</th>
                                <th>{{ _i('created at') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="productRowOne">
                                <td>{{ $transaction_offer->id }}</td>
                                <td>	</td>
                                <td>{{ $transaction_offer->created_at }}</td>
                            </tr>

                        </tbody>
                </div>
            </div>
        </div>
    </div>





@endsection
