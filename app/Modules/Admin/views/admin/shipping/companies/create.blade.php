@extends('admin.layout.index',
[
'title' => _i('Shipping'),
'subtitle' => _i('New shipping company'),
'activePageName' => _i('Shipping'),
'activePageUrl' => route('shipping.index'),
'additionalPageName' => _i('Settings'),
'additionalPageUrl' => route('settings.index') ,
])
@push('css')
    <style>
        .modal-header {
            background-color: #5cd5c4;
            border-color: #5cd5c4;
            color: #fff;
        }

    </style>
@endpush
@section('content')
    <div class="page-body">
        <form class="save_shipping_company" method="POST" action="{{ url('admin/save_shipping_company') }}"
            enctype="multipart/form-data" data-parsley-validate="">
            @csrf
            <input type="hidden" name="free_shipping" value="0">
            <div class="row">
                <div class="col-sm-4 ">
                    @include("admin.shipping.companies.comapny")
                </div>
                <!------------------------------------- companies ----------------------------->
                <div class="col-sm-8 ">

                    <div class="section_shipping_price_add">
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6">
                        <button class="btn btn-primary btn-block save ">{{ _i('Save') }}</button>

                    </div>
                    <div class="col-md-6">
                        <a class="btn btn-primary btn-block add_shipping_price ">{{ _i('Add Option') }}</a>

                    </div>
                </div>


            </div>
        </form>
    </div>

    @push('js')
        <script type="text/javascript">
            $(function() {
                $(".js-example-basic-multiple").select2();
            });



        </script>
        <!--<script src="{{ asset('masterAdmin/assets/pages/advance-elements/select2-custom.js') }}"></script>-->
    @endpush
@endsection
