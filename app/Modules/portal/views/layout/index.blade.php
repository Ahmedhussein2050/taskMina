<!DOCTYPE html>
@php
$setting = App\Bll\Site::getSettings();
$settings = App\Setting::first();
$lang = App\Bll\Lang::getSelectedLangId();
$lang = session('locale');
// dd(LaravelGettext::getLocale());
@endphp
<html lang="{{ $lang }}" dir="{{ $lang == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@yield('title') - {{ $setting->title ?? '' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@400;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>

    @if (LaravelGettext::getLocale() == 'ar')
        <link href="{{ asset('portal/css/bootstrap.rtl.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('portal/css/bootstrap.rtl.min.css') }}">
        <link rel="stylesheet" type="text/css"
            href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
        <link href=" {{ asset('portal/css/rtl.css') }}" rel="stylesheet">
    @else
        <link href="{{ asset('portal/css/bootstrap.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('portal/css/jquery-ui.css') }}">
        <link href="{{ asset('portal/css/en.css') }}" rel="stylesheet">
    @endif

</head>

<body>

    @include('layout.header')
    @yield('main')
    @include('layout.footer')

    <!-- / Pre-Loader -->
    <!-- Return to Top -->
    <a href="javascript:" id="return-to-top"><i class="fas fa-chevron-up"></i></a>

    <script src="{{ asset('portal/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('portal/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://kit.fontawesome.com/e5696f83c8.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.8/jquery.slimscroll.min.js"></script>
    <script src="{{ asset('portal/js/jquery-ui.min.js') }}"></script>
    @if (LaravelGettext::getLocale() == 'ar')
        <script src="{{ asset('portal/js/custom-rtl.js') }}"></script>
    @else
        <script src="{{ asset('portal/js/custom-en.js') }}"></script>
    @endif
    <script>
        $(function() {
            $("#results").autocomplete({
                appendTo: $("#results").parent(),
                source: "{{ route('auto_search') }}",
                'open': function(e, ui) {
                    $(".ui-autocomplete").append(
                        '<li><div style="text-align:center"><a href="javascript:$(\'#frm_search\').submit()">{{ _i('More') }}</a></div></li>'
                    );
                },
            }).autocomplete("instance")._renderItem = function(ul, item) {
                var float = "float:{{ $lang == 'ar' ? 'right' : 'left' }}";
                var item = $('<div class="image"><a href="' + item.url +
                    '"><img width="50px" height="50px" style="' + float + '" src="' + item.image + '">' +
                    item.title + '</a></div>')
                return $("<li>").append(item).appendTo(ul);
            };
        });
        $('body').on('click', '.add-to-cartt', function(e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            console.log(id)
            var price = $(this).attr('data-price');
            var url = "{{ route('cart.single.add', '/id') }}";
            url = url.replace('/id', id)
            console.log(url)
            $.ajax({
                url: url,
                method: "post",
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id,
                    price: price,
                },
                success: function(response) {
                    console.log(response)
                    if (response.fail == false) {

                        Swal.fire({
                            icon: 'success',
                            title: response.message,
                        })

                        $('.cart-wrapper .cartcount').html('')
                        $('.cart-wrapper .cartcount').html(response.product)
                        

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: response.message,
                        })

                    }
                }
            });
        });
        $(document).on('click', '.addToFav', function(e) {
            e.preventDefault();
            var _url = $(this).attr('data-url');
            var id = $(this).attr('data-id');
            var $this = $(this);
            $.ajax({
                url: _url,
                method: "get",
                data: {},
                success: function(response) {
                    $this.parent('div').addClass('active');
                    if (response.status == 'success') {

                        Swal.fire({
                            icon: 'success',
                            title: response.message,
                        })
                    } else if (response.status == 'failed') {
                        Swal.fire({
                            icon: 'error',
                            title: response.message,
                        })
                    }
                },
            });
        })
    </script>
    @stack('js')
    @if ($settings->chat_mode == 1)
        {!! $settings->chat_code !!}
    @endif
</body>

</html>
