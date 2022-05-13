@extends('layout.index')
@section('title', _i('My Profile'))

@section('main')
@php
    $phone = explode(auth()->user()->code, auth()->user()->phone);
    $phone[1] = $phone? $phone[1] : auth()->user()->phone
@endphp
    <div class="inner-page-wrapper">
        <section class="my-account-page my-5">
            <div class="container">

                <div class="white-wrapper">
                    @include('portal.user.account.partial')
                    <div class="user-panel-wrapper my-3">
                        <div class="white-wrapper">
                            <div class="info-line">
                                <strong>{{ _i('Username') }}</strong>
                                <span class="info"> {{ auth()->user()->name }}</span>
                            </div>
                            <div class="info-line">
                                <strong>{{ _i('Email') }}</strong>
                                <span class="info">{{ auth()->user()->email }}</span>
                            </div>
                            <div class="info-line">
                                <strong>{{ _i('Phone') }}</strong>
                                <span class="info">{{ $phone[1] }}</span>
                            </div>

                            <button data-bs-toggle="modal" data-bs-target="#account-information"
                                class=" m-3 mt-auto ms-auto btn btn-color1"><i class="fa fa-edit"></i>
                                {{ _i('Edit') }}
                            </button>

                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>

    <div class="modal fade bootstrap-modal" id="account-information" tabindex="-1">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ _i('Edit account information') }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form id="account-information-form" method="post" action="{{ route('edit.user.info') }}">
                        @csrf
                        <div class="form-group">
                            <label for="first-name" class="col-form-label">{{ _i('First name') }}</label>
                            <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">{{ _i('Last Name') }}</label>
                            <input type="text" name="lastname" class="form-control"
                                value="{{ auth()->user()->last_name }}">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">{{ _i('Email') }}</label>
                            <input type="text" name="email" class="form-control" readonly=""
                                value="{{ auth()->user()->email }}">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">{{ _i('Phone') }}</label>
                            <input type="text" name="phone" class="form-control" value="{{ $phone[1]}}">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">{{ _i('Gender') }}</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="flexRadioDefault1"
                                    value="male" @if (auth()->user()->gender == 'male') checked @endif>
                                <label class="form-check-label" for="flexRadioDefault1">
                                    {{ _i('Male') }}
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="flexRadioDefault2"
                                    value="female" @if (auth()->user()->gender == 'female') checked @endif>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    {{ _i('Female') }}
                                </label>
                            </div>

                        </div>


                        <div class="form-group">
                            <label for="message-text" class="col-form-label">{{ _i('New Password') }}</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">{{ _i('Confirm New Password') }}</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>

                    </form>
                </div>
                <div class="modal-footer pt-0 border-0">
                    <button type="button" class="btn btn-color2" data-bs-dismiss="modal">{{ _i('Close') }}</button>
                    <button type="submit" class="btn btn-color1"
                        form="account-information-form">{{ _i('Save') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).on('submit', '#account-information-form', function(e) {
            e.preventDefault();
            var review_url = $(this).attr('action');
            $.ajax({
                url: review_url,
                method: "post",
                "_token": "{{ csrf_token() }}",
                data: new FormData($('#account-information-form')[0]),
                cache: false,
                contentType: false,
                processData: false,
                error: function(response) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        html: response.responseJSON.message,
                    })
                },
                success: function(response) {
                    if (response == 'success') {

                        Swal.fire({
                            icon: 'success',
                            title: 'Updated Successfully',
                        })
                    }
                },
            });
        })
    </script>
@endpush
