@extends('layout.index')
@section('title', _i('Thank you'))

@section('main')
    <section class="thank-you-page-wrapper my-5">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">

                    <div class="text-center text-color2">
                        <h5><strong class="fz30 lh-lg text-green">{{ _i('Thank you') }}</strong> <br>
                            .. {{ _i('You can redirecte to home page now') }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
