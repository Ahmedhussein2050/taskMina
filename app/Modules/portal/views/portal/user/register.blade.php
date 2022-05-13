@extends('layout.index')

@section('main')
    <section class="forms-page-wrapper my-5">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="p-3 rounded25 shadow">
                        <div class="wrapper">
                            <div class="p-3  mb-3 border-bottom d-flex justify-content-between">
                                <span class="fz20 fw-bold text-color1">{{ _i('Register') }}</span>
                                <span class="fz25 fw-bold text-color1 "><i class="fa fa-user"></i></span>
                            </div>
                            <form method='post' id="register-form">
                                @csrf
                                <div class="form-group">
                                    <label>{{ _i('First name') }}</label>
                                    <input type="text" class="form-control" name="name">
                                </div>
                                <div class="form-group">
                                    <label>{{ _i('Last name') }}</label>
                                    <input type="text" class="form-control" name="lastname">
                                </div>
                                <div class="form-group">
                                    <label>{{ _i('Gender') }}</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="inlineRadio1" name='gender'
                                            value='male'>
                                        <label class="form-check-label" for="inlineRadio1">{{ _i('Male') }}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="inlineRadio2" name='gender'
                                            value='female'>
                                        <label class="form-check-label" for="inlineRadio2">{{ _i('Female') }}</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>{{ _i('Email') }}</label>
                                    <input type="email" class="form-control" name="email">
                                </div>

                                <div class="form-group">
                                    <label>{{ _i('phone') }}</label>
                                    <div class="row">
                                        <div class="col-md-3 col-4">
                                            <select name='country' class='form-control select2 ' required>
                                                <option value=''>{{ _i('Select Your Country') }}</option>
                                                @foreach ($countries as $country)
                                                    @if ($country->data)
                                                        <option value='{{ $country->code }}'>
                                                            {{ $country->data->title ?? '' }}</option>
                                                    @endif
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="col-md-9 col-8">
                                            <input type="text" class="form-control" name="phone" required="">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>{{ _i('Password') }}</label>
                                    <input type="password" class="form-control" name="password">
                                </div>
                                <div class="form-group">
                                    <label>{{ _i('Confirm password') }}</label>
                                    <input type="password" class="form-control" name="password_confirmation">
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" required>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        {{ _i(' I agree to the site policy and terms of use') }}
                                    </label>
                                </div>
                                <footer class="fixed-footer-buttons">
                                    <button id="form_button" type="submit"
                                        class="btn btn-color1 mt-3 py-2 w-100">{{ _i('Register') }}
                                    </button>

                                </footer>
                            </form>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script type="text/javascript">
        $(document).on('submit', '#register-form', function(e) {
            e.preventDefault();

            $('#form_button').html('{{ _i('Waiting...') }}');
            var url = "{{ route('promotor.register') }}";
            $.ajax({
                url: url,
                method: "post",
                data: new FormData(this),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                error: function(response) {
                    $('#form_button').html('{{ _i('Register') }}');
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

                    $('#form_button').html('{{ _i('Register') }}');
                    if (response == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: '{{ _i('Registered Successfully, please verify your email address') }}',
                            timer: 1500
                        })
                    }

                    window.location = "{{ url('/') }}";

                },
            });
        });
    </script>
@endpush
