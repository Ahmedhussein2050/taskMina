@extends('admin.layout.index',[
	'title' => _i('Contacts'),
	'subtitle' => _i('Contacts'),
	'activePageName' => _i('Contacts'),
	'activePageUrl' => '',
	'additionalPageUrl' => '' ,
	'additionalPageName' => '',
] )

@section('content')

    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has($msg))
                <p class="alert alert-{{ $msg }}">{{ Session::get($msg) }}</p>
            @endif
        @endforeach
    </div>


    <!-- Page-header start -->
    <!-- Page-header end -->
    <!-- Page-body start -->
    <div class="page-body">
        <!-- Blog-card start -->
        <div class="card blog-page" id="blog">
            <div class="card-block">
                @include('admin.layout.message')
                {!! $dataTable->table([
                    'class'=> 'table table-bordered table-striped table-responsive text-center'
                ],true) !!}

        </div>
    </div>
    </div>

    @push('js')
        {!! $dataTable->scripts() !!}
    @endpush
    <style>
        .table{
            display: table !important;
        }
    </style>
@endsection
