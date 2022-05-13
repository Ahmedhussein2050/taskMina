@php
$type = 'free';
if (request()->query('type') == 'private' || request()->query('type') == 'general') {
    $type = request()->query('type');
}
$title = '';
switch ($type) {
    case 'free':
        # code...
        $title = _i('Create Gift Discount Code');
        break;
    case 'private':
        # code...
        $title = _i('Create Private Discount Code');
        break;
    case 'general':
        # code...
        $title = _i('Create General Discount Code');
        break;
    default:
        # code...
        break;
}
@endphp
@extends('admin.layout.index',[
'title' => $title,
'subtitle' =>$title,
'activePageName' => $title,
'activePageUrl' => "#",
'additionalPageUrl' => route('discounts.index',["type"=> $type]) ,
'additionalPageName' => _i('Discounts'),
] )

@section('content')
    <div class="page-body">

        <div class="card">
            <div class="card-block">
                <div class="row m-b-30">
                    <div class="col-lg-12 col-xl-12">

                        <!-- Nav tabs -->

                        <!-- Tab panes -->
                        <form method='post' action='{{ route('discounts.store') }}' class='form-group'
                            data-parsley-validate="">
                            @csrf

                            {{-- @switch($type)
                                @case ('private')
                                    @include("admin.discounts.forms.private")
                                @break
                                @case('free')
                                    @include("admin.discounts.forms.gift")
                                @break
                                @case('general')
                                    @include("admin.discounts.forms.general")
                                @break
                                @default --}}
                                    @include("admin.discounts.forms.general")
                            {{-- @endswitch --}}
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    @include('admin.layout.message')
    <script>
        $('.myselect').select2();
    </script>
@endpush
