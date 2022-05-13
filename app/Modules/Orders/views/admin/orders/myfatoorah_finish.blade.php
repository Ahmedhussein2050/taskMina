@extends('admin.AdminLayout.index')
@section('title')
    {{_i('Myfatoorah Finish')}}
@endsection

@section('page_header_name')
    {{_i('Myfatoorah Finish')}}
@endsection

@push('css')
    <style>
        .register-form .form-control {
            margin: 0;
        }
    </style>
@endpush

@section('content')

    <nav aria-label="breadcrumb" class="breadcrumb-wrapper">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{_i('/')}}">{{_i('Home')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{_i('Success Payment')}}</li>
            </ol>
        </div>
    </nav>

    <section class="register-form common-wrapper ">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="center">
                        <a href=""><img src="{{ asset('perpal/images/order-accepted.png') }}" alt="" class="img-fluid"></a>
                        <div class="welcome-head-2">{{ _i('Congratulations .. the payment is accepted') }}</div>
                      
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection


