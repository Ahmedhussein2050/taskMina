@extends('admin.layout.index',
[
    'title' => _i('Offers'),
    'subtitle' => _i('Offers'),
    'activePageName' => _i('Offers'),
    'activePageUrl' => route('abandoned_carts.index'),
    'additionalPageName' => '',
    'additionalPageUrl' => '' ,
])

@section('content')
    <!-- Page-body start -->
    <div class="page-body">
        <!-- Blog-card start -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5> {{ _i('Offers List') }} </h5>
                        <div class="card-header-right">
                            <i class="icofont icofont-rounded-down"></i>
                            <i class="icofont icofont-refresh"></i>
                            <i class="icofont icofont-close-circled"></i>
                        </div>
                    </div>
                    <div class="card-block">

                        <div class="dt-responsive table-responsive text-center">
                            @include('admin.layout.message')
                            {!! $dataTable->table([
                                'class'=> 'table table-bordered table-striped  text-center'
                            ],true) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('js')
        {!! $dataTable->scripts() !!}
    @endpush
@endsection