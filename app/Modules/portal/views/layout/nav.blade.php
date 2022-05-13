<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
        <a class="navbar-brand d-block d-lg-none" href="#"><img src="images/logo.png" class="img-fluid" alt=""></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main_nav"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="main_nav">
             <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        {{ _i('categories') }} </a>
                    <ul class="dropdown-menu">
                        @foreach (App\Bll\Utility::mainNav() as $key => $valuee)

                            @if ($valuee->products->isNotEmpty())
                                @php
                                    $brands = $valuee->getBrands($valuee->products);

                                @endphp
                                <li><a class="dropdown-item"
                                        href="{{ route('category', $valuee->id) }}">{{ $valuee->dataa->title ?? '' }}
                                    </a>
                                    <ul class="submenu dropdown-menu">
                                        @if (isset($brands))
                                            @foreach ($brands as $brand)
                                                @php
                                                    $class = $brand->brand->getclassifications($brand->brand_id) ?? '';
                                                @endphp
                                                @if (isset($brand))
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('brand', $brand->brand_id) }}">
                                                            {{ $brand->name }} </a>
                                                        @if (isset($class))
                                                            <ul class="submenu dropdown-menu">
                                                                @foreach ($class as $classf)
                                                                    @if ($classf->data != null)
                                                                        <li><a class="dropdown-item"
                                                                                href="{{ route('classification', $classf->id) }}">{{ $classf->data ? $classf->data->title : '' }}</a>
                                                                        </li>
                                                                    @endif
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @endif
                                            @endforeach
                                        @endif
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>

                <li class="nav-item"><a class="nav-link" href="{{ route('page.get', 1) }}">
                        {{ _i('About') }} </a></li>

                <li class="nav-item"><a class="nav-link" href="{{ route('contact_us.get') }}">
                        {{ _i('Contact Us') }} </a></li>

            </ul>
        </div> <!-- navbar-collapse.// -->
    </div> <!-- container-fluid.// -->
</nav>
