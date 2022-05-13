@php
$type = 'free';
if ($discount->type == 'private' || $discount->type == 'general') {
    $type = $discount->type;
}
$title = '';
switch ($type) {
    case 'free':
        # code...
        $title = _i('Gift Discount Code');
        break;
    case 'private':
        # code...
        $title = _i('Private Discount Code');
        break;
    # code...
    case 'general':
        $title = _i('General Discount Code');
        break;
    default:
        # code...
        break;
}
@endphp
@extends('admin.layout.index',[
'title' => _i('Discount Users'),
'subtitle' => $title." "._i('Beneficiaries'),
'activePageName' => _i('Beneficiaries') ,
'activePageUrl' => "#",
'additionalPageName' =>$title." ". _i('Discounts'),
'additionalPageUrl' => route('discounts.index',["type"=> $discount->type])
] )
@section('content')
    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if (Session::has($msg))
                <p class="alert alert-{{ $msg }}">{{ Session::get($msg) }}</p>
            @endif
        @endforeach
    </div>

    <div class="page-body">
        <div class="card blog-page">
            <div class="card-block ">

                <table class=" table table-bordered table-striped table-responsive  " id="order_data" width="100%">
                    <thead>
                        <tr role="row">
                            <th>{{ _i('User Code') }}</th>
                            <th>{{ _i('Member') }}</th>
                            <th>{{ _i('Code') }}</th>
                            <th>{{ _i('Using Time') }}</th>


                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    @push('js')
        <script type="text/javascript">
            $(function() {
                var url = "{{ route('admin.discountUsers.index', 1) }}";
                var id = {{ $discount->id }};
                $('#order_data').DataTable({


                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: url,
                        data: {
                            'id': id
                        }
                    },

                    columns: [{
                            data: 'user_code'
                        },
                        {
                            data: 'members'
                        },
                        {
                            data: 'code'
                        },
                        {
                            data: 'using_time'
                        },


                    ],
                    'drawCallback': function() {}
                });
            });
        </script>
    @endpush
    <style>
        .table {
            display: table !important;
        }

        .row {
            width: 100% !important;
        }

    </style>
@endsection
