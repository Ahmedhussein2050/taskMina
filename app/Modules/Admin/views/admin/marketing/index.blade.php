@extends('admin.layout.index',
[
    'title' => _i('Marketing campaigns'),
    'subtitle' => _i('Marketing campaigns'),
    'activePageName' => _i('Marketing campaigns'),
    'activePageUrl' => route('discount_code.index'),
    'additionalPageName' => '',
    'additionalPageUrl' => '' ,
])
@section('content')
    <div class="page-body">
        <div class="row">
			<div class="col-sm-12 mb-3">
				<span class="pull-left">
					<a href='{{ route('campaign.create') }}' class="btn btn-primary create add-permissiont">
						<span><i class="ti-control-forward"></i> {{ _i('Add New Campaign') }}</span>
					</a>
				</span>
			</div>
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5> {{ _i('Campaign List') }} </h5>
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
