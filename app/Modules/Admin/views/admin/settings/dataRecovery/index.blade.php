@extends('admin.layout.index',
[
    'title' => _i('Data Recovery'),
    'subtitle' => _i('Data Recovery'),
    'activePageName' => _i('Data Recovery'),
    'activePageUrl' => route('dataRecovery.index'),
    'additionalPageName' =>  _i('Settings'),
    'additionalPageUrl' => route('settings.index')
])

@push('css')
    <style>
        .blog-page {
            margin: 43px;
            height: 200px;
        }
        h3 i {
            font-size: 45px !important;
        }
        .counter-card-1 [class*="card-"] div > i,
        .counter-card-2 [class*="card-"] div > i,
        .counter-card-3 [class*="card-"] div > i {
            font-size: 30px;
            color: #1abc9c !important;
        }
    </style>
@endpush

@section('content')
    <div class="page-body">
        <div class="row">
            <div class="col-md-12 col-xl-4">
                <div class="card counter-card-1">
                    <div class="card-block-big d-flex justify-content-between">
                        <div>
                            <h3><a href="{{ route('dataRecovery.products') }}"
                                   class="text-primary">{{_i('Products') }}</a></h3>
                            <p>{{ _i('Products deleted during the past 30 days') }}</p>
                            <div class="progress ">
                                <div class="progress-bar progress-bar-striped progress-xs progress-bar-pink"
                                     role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0"
                                     aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div>
                            <i class="ti-view-list"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-xl-4">
                <div class="card counter-card-1">
                    <div class="card-block-big d-flex justify-content-between">
                        <div>
                            <h3><a href="{{ route('dataRecovery.orders') }}"
                                   class="text-primary">{{_i('Orders') }}</a></h3>
                            <p>{{ _i('Orders deleted during the past 30 days') }}</p>
                            <div class="progress ">
                                <div class="progress-bar progress-bar-striped progress-xs progress-bar-pink"
                                     role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0"
                                     aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div>
                            <i class="ti-shopping-cart"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </div>
    {{--Store settings--}}

@endsection

