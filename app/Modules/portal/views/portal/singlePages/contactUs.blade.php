@extends('layout.index')
@section('title', _i('Brands'))

@section('main')
    <nav aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb py-4">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ _i('home') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ _i('Contact Us') }}
                </li>
            </ol>
        </div>
    </nav>
    <section class="inner-page-overlay-header d-flex  text-center align-items-center "
        style="background-image: url('portal/images/contact-head-img.png');">
        <div class="container">
            <div class="header-content">
                <div class="head-title wow fadeInDown fz30 font-weight-bold text-white mb-4">
                    {{ _i('We always strive to listen to our customers') }}</div>
                <a href="#contactBox"
                    class="btn btn-white-outlined font-weight-simiBold wow fadeInUp">{{ _i('Contact us') }}</a>
            </div>
        </div>
    </section>
    <section class="contact-us-wrapper">
        <div class="map-wrapper google-maps h-100 ">
            {{-- <iframe
                src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d13673.308668104753!2d31.36559835!3d31.044990449999997!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2seg!4v1595240864534!5m2!1sen!2seg"
                width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false"
                tabindex="0"></iframe> --}}
            {!! $settings->location_code !!}
        </div>
        <div class="container">
            <div class="contact-box " id="contactBox">
                <div class="wrapper p-4">
                    <div class="title fz25 font-weight-bold mb-4">{{ _i('Get in Touch With') }}</div>
                    <ul class="list-inline footer-nav contact-info-list">
                        <li><i class="fa fa-map-marker"></i>{!! $settings->address !!}</li>
                        <li><i class="fa fa-phone"></i> {!! $settings->phone1 !!}</li>
                        <li><i class="fa fa-whatsapp"></i> {!! $settings->whats_app !!}</li>
                        <li><i class="fa fa-envelope"></i> {!! $settings->email !!}</li>
                    </ul>

                    <div class="unreal-form" id="unrealForm">
                        <textarea cols="30" rows="4" class="form-control" placeholder="Write Your Message Here" readonly></textarea>
                        <div class="email-input">
                            <input type="text" class="form-control" placeholder="E-mail" readonly>
                            <i class="fa fa-send"></i>
                        </div>
                    </div>



                    <div class="real-form" id="realForm">
                        <button id="closeForm" class="d-sm-none d-block">&times;</button>
                        <form id="contact_formm" method="post" action="">
                            @csrf
                            <input type="text" class="form-control" name="name" placeholder="{{ _i('Your Name') }}">

                            @if ($errors->has('name'))
                                <span class="text-danger invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                            <input type="text" class="form-control" name="email" placeholder="{{ _i('Email') }}">

                            @if ($errors->has('email'))
                                <span class="text-danger invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                            <textarea cols="30" rows="10" name="message" class="form-control"
                                placeholder="{{ _i('Write Your Message Here') }}"></textarea>
                            @if ($errors->has('message'))
                                <span class="text-danger invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('message') }}</strong>
                                </span>
                            @endif
                            <button type="submit" id="test" class="btn btn-white">{{ _i('send') }}</button>
                        </form>
                    </div>

                    <div class="text-center mt-auto">
                        <ul class="list-inline footer-social">
                            @if (isset($settings))
                                @if ($settings->facebook_url != '')
                                    <li class="list-inline-item"><a href="{{ $settings->facebook_url }}"><i
                                                class="fa fa-facebook"></i></a></li>
                                @endif
                                @if ($settings->twitter_url != '')
                                    <li class="list-inline-item"><a href="{{ $settings->twitter_url }}"><i
                                                class="fa fa-twitter"></i></a></li>
                                @endif
                                @if ($settings->instagram_url != '')
                                    <li class="list-inline-item"><a href="{{ $settings->instagram_url }}"><i
                                                class="fa fa-instagram"></i></a></li>
                                @endif
                                @if ($settings->youtube_url != '')
                                    <li class="list-inline-item"><a href="{{ $settings->youtube_url }}"><i
                                                class="fa fa-youtube"></i></a></li>
                                @endif

                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script>
        $(document).on('submit', '#contact_formm', function(e) {
            e.preventDefault();
            var url = "{{ route('contact_us.submit') }}";

            $.ajax({
                url: url,
                method: "post",
                "_token": "{{ csrf_token() }}",
                data: new FormData($('#contact_formm')[0]),
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response == 'sucsses') {
                        Swal.fire({
                            icon: 'success',
                            title: "{{ _i('Your request send successfully') }}",
                        })
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: "error",
                        })
                    }

                }
            });
        });
    </script>
@endpush
