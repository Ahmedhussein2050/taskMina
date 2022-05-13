<aside class="account-sidebar-menu">
      <ul class="aside-menu list-unstyled">
        <li class=" @if (Request::segment(1) == 'myProfile') active @endif"><a href="{{ route('user.profile') }}"><i
                    class="fa fa-user-o"></i> {{ _i('My Account') }}</a>
        </li>
        <li class="@if (Request::segment(1) == 'myFavourite') active @endif"><a href="{{ route('user.favourite') }}"><i
                    class="fa fa-heart-o"></i> {{ _i('Wishlist') }}</a></li>
        <li class=" @if (Request::segment(1) == 'myOrders' || Request::segment(1) == 'order') active @endif"><a href="{{ route('user.orders') }}"><i
                    class="fa fa-file-text-o"></i> {{ _i('Orders') }}</a></li>
        <li class=" @if (Request::segment(1) == 'myBalance') active @endif"><a href="{{ route('user.balance') }}"><i
                    class="fas fa-wallet"></i> {{ _i('My Wallet') }}</a></li>
        <li class="dropdown-divider"></li>
        <li><a href="{{ route('logout') }}"><i class="fa fa-sign-out"></i> {{ _i('Logout') }}</a></li>

    </ul>
</aside>
