<nav class="navbar header-navbar pcoded-header" header-theme="theme4">
    <div class="navbar-wrapper">
        <div class="navbar-logo">

            <a class="mobile-menu" id="mobile-collapse" href="#!">
                <i class="ti-menu"></i>
            </a>
            <a href="{{ url('/') }}">
                <img class="img-fluid img-responsive" style="width: 160px;height: 50px" src="{{asset('images/MASH.png')}}"
                     alt="Logo"/>
            </a>
            <a class="mobile-options">
                <i class="ti-more"></i>
            </a>
        </div>
        <div class="navbar-container container-fluid">
            <div>
                <ul class="nav-left">
                    <li>
                        <div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a>
                        </div>
                    </li>
                    <li>
                        <a href="#!" onclick="javascript:toggleFullScreen()">
                            <i class="ti-fullscreen"></i>
                        </a>
                    </li>
                </ul>
                <ul class="nav-right">
                    <li class="header-notification lng-dropdown">
                        <?php
                        use Xinax\LaravelGettext\Facades\LaravelGettext;$languages = App\Models\Language::where('code', '!=', LaravelGettext::getLocale())->get();
                        ?>
                        <a href="#" id="dropdown-active-item">
                            <i class="ti-world"></i> {{_i('Language')}}
                            <?php
                            $selected_lang = \App\Models\Language::where('code', LaravelGettext::getLocale())->first();
                            if ($selected_lang == null) {
                                $selected_lang = \App\Models\Language::first();
                            }

                            //                            $admin = Auth()->user();

                            ?>

                            <img src="{{ asset('images/' . $selected_lang['flag']) }}" alt="">
                            {{ _i($selected_lang['title']) }}
                        </a>
                        <ul class="show-notification">
                            @foreach ($languages as $lang)
                                <li>
                                    <a href="{{ url('/admin/lang/' . $lang['code']) }}" data-lng="en">
                                        <img src="{{ asset('images/' . $lang['flag']) }}"
                                             style="max-width:25px; max-height:25px; !important;" alt="">
                                        {{ _i($lang['title']) }}
                                    </a>
                                </li>
                            @endforeach

                        </ul>
                    </li>
                    {{--                    <li class="header-notification">--}}
                    {{--                        <a href="#!">--}}
                    {{--                            <i class="ti-bell"></i>--}}
                    {{--                            <span class="badge"> {{ $adminNotifications->count() }}</span>--}}
                    {{--                        </a>--}}
                    {{--                        <ul class="show-notification">--}}
                    {{--                            <li>--}}
                    {{--                                <h6>{{ _i('Notifications') }}</h6>--}}
                    {{--                                <label class="label label-danger">{{ _i('New') }}</label>--}}
                    {{--                            </li>--}}
                    {{--                            @foreach ( $adminNotifications->paginate(5) as $item)--}}
                    {{--                                <li style="">--}}
                    {{--                                    <div class="media">--}}
                    {{--                                         <img class="d-flex align-self-center" src="assets/images/user.png" alt="Generic placeholder image">--}}
                    {{--                                        <div class="media-body">--}}
                    {{--                                             <h5 class="notification-user">John Doe</h5>--}}
                    {{--                                            <p class="notification-msg">--}}
                    {{--												@php--}}
                    {{--													$key = isset($item->data['order_url']) ? 'order_url' : 'url';--}}

                    {{--												@endphp--}}
                    {{--												<a class="mark-as-read" data-id="{{ $item->id }}" target="_blank"--}}
                    {{--												   href=" {{ isset($item->data[$key]) ? $item->data[$key] : '' }} ">--}}
                    {{--													@if (isset($item->data['name']))--}}
                    {{--														@if (@isset($item->data['name'][get_lang_code()]))--}}
                    {{--															 {{ $item->data['name'][get_lang_code()] }}--}}
                    {{--														@endif--}}
                    {{--													@endif--}}
                    {{--                                                </a>--}}
                    {{--                             </p>--}}
                    {{--                            <span class="notification-time">{{ $item->created_at->diffForHumans() }}</span>--}}
                    {{--            </div>--}}
                    {{--        </div>--}}

                    {{--        </li>--}}


                    {{--        @endforeach--}}


                    {{--        <li>--}}
                    {{--            <div class="media">--}}

                    {{--                <div class="media-body">--}}
                    {{--                    <h5 class="notification-user"><a href='{{ route('notificationAll.index') . '?type=notAll' }}'--}}
                    {{--                            class="read-more" style="">{{ _i('...ReadMore') }}</a></h5>--}}

                    {{--                </div>--}}
                    {{--            </div>--}}

                    {{--        </li>--}}

                    {{--        </ul>--}}
                    {{--        </li>--}}
                    <li class="user-profile header-notification">
                        <a href="#!">
                            @php
                                $user = auth()->guard('admin')->user();
                            @endphp
                            @if ($user->first()->image))
                            <img src="{{ asset('/uploads/users/' . $user->first()->id . '/' . $user->first()->image) }}"
                                 alt="User-Profile-Image">
                            @else
                                <img src="{{ asset('admin_dashboard/assets/images/user.png') }}"
                                     alt="User-Profile-Image">
                            @endif
                            {{ auth()->guard('admin')->user()->name }}
                            <i class="ti-angle-down"></i>
                        </a>
                        <ul class="show-notification profile-notification">
                            <li>
                                <a href="{{ route('admin.editProfile', auth()->guard("admin")->user()->id) }}">
                                    <i class="ti-user"></i> {{ _i('Edit Profile') }}
                                </a>
                            </li>
                            {{--                @can('Settings')--}}
                            <li>
                                <a href="{{ url('admin/settings') }}">
                                    <i class="ti-settings"></i> {{ _i('Settings') }}
                                </a>
                            </li>
                            {{--                @endcan--}}
                            <li>
                                <a href="{{ url('admin/logout') }}">
                                    <i class="ti-layout-sidebar-left"></i>
                                    {{ _i('Logout') }}
                                </a>
                            </li>

                        </ul>
                    </li>


                </ul>
            </div>
        </div>
    </div>
</nav>
