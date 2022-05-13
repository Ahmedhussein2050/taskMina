<header>

    <div class="top-nav">
        <div class="container">
            <div class="menu-wrapper py-3 d-md-flex justify-content-between align-items-center flex-wrap">

                <div class="h-box logo">
                    <a href="{{ route('home') }}"><img src="{{ asset('portal/images/logo.png') }}" alt=""
                            class="img-fluid "> </a>
                </div>
                <div class="h-box top-search">

                    <form id="frm_search" class="search-form" method='get' action='{{ route('search') }}'>
                        @csrf
                        <input type="text" id="results" placeholder="search about anything" class="form-control">
                        <button type="submit" class="btn btn-link"><i class="fa fa-search"></i></button>
                    </form>
                </div>
                <div class="h-box header-contacts">
                    <ul class="list-inline">
                        <li class="list-inline-item"><i class="fa fa-map-marker"></i> {{ $setting->address }}
                        </li>
                        <li class="list-inline-item"><i class="fa fa-phone"></i> {{ $setting->phone1 }}</li>
                        <li class="list-inline-item"><i class="fa fa-envelope"></i> {{ $setting->email }} </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="main-menu">
        <div class="container">
            <div class="row">

                <div class="col-lg-9  d-lg-flex   align-items-center">
                    @include('layout.nav')
                </div>

                <div class="col-lg-3  d-flex justify-content-center justify-content-lg-end align-items-center gap-4">
                    <div class="lange-links dropdown">
                        <a class="" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fa fa-globe">{{ App\Bll\Lang::get_language_title() }}</i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            @foreach (App\Bll\Lang::anotherLang() as $lang)
                                <li><a class="dropdown-item" href="{{ route('switch.lang', $lang->code) }}">
                                        {{ $lang->title }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="user-links dropdown">
                        <a class="" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fa fa-user"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            @if (Auth::check())
                                <li><a class="dropdown-item" href="{{ route('user.profile') }}">
                                        {{ _i('My Account') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('logout') }}">{{ _i('Logout') }}</a>
                                </li>
                            @else
                                <li><a class="dropdown-item" href="{{ route('login') }}">
                                        {{ _i('Login') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('register.index') }}">
                                        {{ _i('Register') }}</a></li>
                            @endif



                        </ul>
                    </div>
                    @include('layout.notification')
                    @include('layout.cart')
                    @if (auth()->check())
                        <div class="wishlist"><a href="{{ route('user.favourite') }}" id="wishlist"><i
                                    class="fa fa-heart-o"></i></a></div>
                    @endif

                </div>
            </div>

        </div>
    </div>

</header>
