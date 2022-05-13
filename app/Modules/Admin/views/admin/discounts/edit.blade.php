@php

$disabled = $Discount->allow_edit == '1' ? '' : 'disabled';

$type = 'free';
if ($Discount->type == 'private' || $Discount->type == 'general') {
    $type = $Discount->type;
}

$title = '';
switch ($type) {
    case 'free':
        # code...
        $title = _i('Edit Gift Discount Code');
        break;
    case 'private':
        # code...
        $title = _i('Edit Private Discount Code');
        break;
    # code...
    case 'general':
        $title = _i('Edit General Discount Code');
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

        <div class="row">
            <div class="col-lg-12">
                <!-- tab header start -->
                @if ($type == 'free' || $type == 'general')
                    <div class="tab-header">
                        <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#personal"
                                    role="tab">{{ _i('Details') }}</a>
                                <div class="slide"></div>
                            </li>
                            {{-- <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#binfo" role="tab">{{ _i('Members') }}</a>
                                <div class="slide"></div>
                            </li> --}}
                        </ul>
                    </div>
                @endif
                <!-- tab header end -->
                <!-- tab content start -->
                <div class="tab-content">
                    <!-- tab panel personal start -->
                    <div class="tab-pane active" id="personal" role="tabpanel">
                        <!-- personal card start -->
                        <div class="card">

                            <div class="card-block">

                                <form method='post' action='{{ route('discounts.update', $Discount->id) }}'
                                    class='form-group' data-parsley-validate="">
                                    @csrf
                                    @if ($Discount->type == 'private')
                                        @include("admin.discounts.edit.private")
                                    @elseif ($Discount->type == 'free')
                                        @include("admin.discounts.edit.gift")
                                    @elseif ($Discount->type == 'general')
                                        @include("admin.discounts.edit.general")
                                    @endif
                                </form>
                            </div>
                            <!-- end of card-block -->
                        </div>

                        <!-- personal card end-->
                    </div>
                    <!-- tab pane personal end -->
                    <!-- tab pane info start -->
                    {{-- <div class="tab-pane" id="binfo" role="tabpanel">
                        <!-- info card start -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-header-text">{{ _i('Users') }}</h5>
                            </div>
                            <div class="card-block">
                                @include("admin.discounts.forms.member",["Discount_id"=> $Discount->id])
                            </div>
                        </div>

                        <!-- info card end -->
                    </div> --}}
                    <!-- tab pane info end -->


                </div>
                <!-- tab content end -->
            </div>
        </div>
    </div>
    <!-- Page-body end -->


@endsection
@push('js')
    <script type="text/javascript">
        $(function() {
            $('.myselect').select2();

            $("input[name='date_from']").val("{{ date('Y-m-d\TH:i', strtotime($Discount->start_date)) }}");

            $("input[name='date_to']").val("{{ date('Y-m-d\TH:i', strtotime($Discount->end_date)) }}");

        });
    </script>

    @include('admin.layout.message')


@endpush
