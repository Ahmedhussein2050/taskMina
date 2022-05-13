<footer id="Main">

    <div class="container">

        <div class="footer-content">
            <div class="row">
                <div class="col-lg-4  ">
                    <div class="about-us">
                        <h5 class="fz30">{{ $setting->title }}</h5>
                        <p class="text-white fz16">{{ $setting->description }}</p>
                    </div>
                    <div class="subscribe">
                        <form action="" id="form-subscribe" data-validate="parsley">
                            <input type="email" id="email" class="form-control" placeholder="{{ _i('your email') }}"
                                data-parsley-type="email" required>
                            <input type="submit" id="form-subscribee" class="btn btn-white"
                                value="{{ _i('Subscribe') }}">
                        </form>
                    </div>
                    <ul class="list-inline footer-social text-center">
                        <li class="list-inline-item"><a href="{{ $setting->facebook_url }}"><i class="fa fa-facebook"></i></a></li>
                        <li class="list-inline-item"><a href="{{ $setting->twitter_url }}"><i class="fa fa-twitter"></i></a></li>
                        <li class="list-inline-item"><a href="{{ $setting->instagram_url }}"><i class="fa fa-instagram"></i></a></li>
                        <li class="list-inline-item"><a href="{{ $setting->youtube_url }}"><i class="fa fa-youtube"></i></a></li>
                        <li class="list-inline-item"><a href="tel:{{ $setting->phone1 }}"><i class="fa fa-phone"></i></a></li>
                    </ul>

                </div>
                <div class="col-lg-7 offset-lg-1">
                    <div class="row">
                        @foreach (App\Bll\Utility::footerLink() as $list)
                            <div class="col-md-4  ">
                                @if ($list && $list->getitems)
                                    <h5>{{ $list->data ? $list->data->name : '' }}</h5>
                                    <ul class="list-inline footer-nav">
                                        @foreach ($list->getitems as $item)
                                            <li><a
                                                    href="{{ $item->link }}">{{ $item->data ? $item->data->name : '' }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyrights">
        <div class="container">

            <div class="d-md-flex justify-content-between text-center">
                <p class="cr">All rights recerved &copy;</p>
                <p><a href="http://www.serv5.com" target="_blank"><img src="images/serv5.png" alt=""
                            class="img-fluid">
                        {{ _i('Developed and Designed by Serv5') }} </a></p>
            </div>
        </div>
    </div>

</footer>

<!-- Pre-Loader -->
<div id="loader">
    <div class="lds-ripple mt-3">
        <div></div>
        <div></div>
    </div>
</div>
<!-- / Pre-Loader -->
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).on('submit', '#form-subscribe', function(e) {
            var $this = $(this);
            e.preventDefault();
            var email = $('#email').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('subscribe.store') }}",
                method: "post",
                data: {
                    email: email
                },
                error: function(response) {
                    var errors = '';
                    $.each(response.responseJSON.errors, function(i, item) {
                        errors = errors + item + "<br>";
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            html: errors,
                        })
                    });
                },
                success: function(response) {
                    if (response.status == 'success') {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: "{{ _i('Send Successfully') }}",
                            showConfirmButton: false,
                            timer: 2000
                        });
                        $('#email').val('');
                    } else {
                        $.notify({
                            message: response.message
                        }, {
                            type: 'danger',
                            delay: 5000,
                            animate: {
                                enter: 'animated flipInY',
                                exit: 'animated flipOutX'
                            }
                        });
                    }
                },
            });

        })
    </script>
@endpush
