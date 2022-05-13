@extends('admin.layout.index',
[
'title' => _i('Shipping'),
'subtitle' => _i('Edit Shipping Company'),
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
        <form class="save_shipping_company" method="POST"
            action="{{ url('admin/update_shipping_company/' . $company->id) }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="free_shipping" value="0">
            <div class="row">
                <div class="col-sm-4 ">
                    @include("admin.shipping.companies.comapny")
                </div>
                <div class="col-sm-8 ">

                    <div class=" section_shipping_price_add ">
                        @php
                            $options = App\Modules\Orders\Models\Shipping\Shipping_option::where('company_id', $company->id)->get();
                        @endphp
                        @include(" admin.shipping.companies.edit_options")
                    </div>

                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary save btn-block">{{ _i('Save') }}</button>
                </div>
                @include("admin.shipping.companies.btn.add_option")

            </div>

        </form>
    </div>
    {{-- <a href="#top" id="back-to-top" style="display: inline;"><i class="fa fa-plus"></i></a> --}}
    <!------------------------------------- companies ----------------------------->
    @push('js')
        <script type="text/javascript">
            number_of_iteration = parseInt('{{ count($options) }}');

            console.log(number_of_iteration);
            $(function() {
                $(".js-example-basic-multiple").select2();
            });
        </script>
        <!--<script src="{{ asset('masterAdmin/assets/pages/advance-elements/select2-custom.js') }}"></script>-->
    @endpush
@endsection
