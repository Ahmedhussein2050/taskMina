@extends('layout.index')

@section('main')
    <nav aria-label="breadcrumb" class="py-3">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home', app()->getLocale()) }}">{{ _i('Home') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ _i('Forgot password') }}</li>
            </ol>
        </div>
    </nav>

    <section class="forms-page-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="p-3 rounded25 shadow">

                        <!-- COPY FROM HERE TO ASIDE NAV -->
                        <div class="wrapper">
                            <header class="p-3  border-bottom d-flex justify-content-between">
                                <span class="fz20 font-weight-bold text-color1">{{ _i('Forgot password') }}</span>
                                <span class="fz25 font-weight-bold text-color1 "><i class="fa fa-user"></i></span>
                            </header>

                            <div class="inner-items nice_scroll">
                                <form method='post' name="form" action='{{ route('forgot') }}'
                                    id='forget-password-form' data-validate="parsley">
                                    @csrf
                                    <div class="form-group">
                                        <label>{{ _i('Email') }}</label>
                                        <input class="form-control" name='email' id='email' parsley-type="email"
                                            data-parsley-type="email" data-parsley-required="true">
                                    </div>

                                    <footer class="fixed-footer-buttons">
                                        <button type="submit"
                                            class="btn btn-color1 mt-3 py-2 w-100">{{ _i('Submit') }}</button>
                                    </footer>
                                </form>
                            </div>
                        </div>
                        <!-- END OF COPYING HERE -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script>
    <script src="{{ asset('custom/parsley.min.js') }}"></script>


    <script type="text/javascript">
        $('#forget-password-form').parsley();
        $(document).ready(function() {
            $('#forget-password-form').on('submit', function(e) {
                e.preventDefault();
                var url = $(this).attr('action');
                $(this).parsley().validate();
                if ($(this).parsley().isValid()) {
                    // alert('dgd');
                    $.ajax({
                        url: url,
                        method: "post",
                        "_token": "{{ csrf_token() }}",
                        data: new FormData(this),
                        dataType: 'json',
                        cache: false,
                        contentType: false,
                        processData: false,
                        error: function(response) {
                            var errors = '';
                            console.log(response.responseJSON.errors);
                            $.each(response.responseJSON.errors, function(index, value) {
                                errors = errors + value + "<br>";
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                html: errors,
                            })
                        },
                        success: function(response) {
                            if (response == 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: '{{ _i('A reset link has been sent to your email address.') }}',
                                    timer: 3000
                                })
                            }
                            if (response == 'error') {
                                Swal.fire({
                                    icon: 'error',
                                    title: '{{ _i('Email Not Found.') }}',
                                    timer: 3000
                                })
                            }
                        },
                    });
                } else {}
            });
        });
    </script>
@endpush
