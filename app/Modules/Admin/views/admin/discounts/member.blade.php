@extends('admin.layout.index',[
'title' => _i("Discount beneficiaries"),
'subtitle' =>_i("Discount beneficiaries"),
'activePageName' => _i("Discount beneficiaries"),
'activePageUrl' => "#",
'additionalPageUrl' => route('discounts.index') ,
'additionalPageName' => _i('Discounts'),
] )

@section('content')

    <div class="page-body">

        <div class="row">
            <div class="col-sm-12">
                <!-- Default Date-Picker card start -->
                <div class="card">


                    <div class="card-header">
                        <h5>{{ _i('Select target beneficiaries') }} </h5>


                    </div>
                    <div class="card-block">
                        @include("admin.discounts.forms.member",["Discount_id"=> $Discount_id])
                    </div>
                </div>

            </div>
        @endsection
