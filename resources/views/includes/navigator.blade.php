<nav class="main-nav colm-10 fixed-top">
    <div class="container">
        <div class="navbar-logo colm-15 tablet-3 mobile-5">
            <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ url('/') }}/images/icons/main-icon.png"></a>
        </div>

        <div class="navbar-menu">
            <ul class="menu-container">
                <li class="menu-item search-container">
                    <input type="text" name="searched" class="textfield">
                    <input type="submit" value="Search">
                </li>
                @if(Auth::user() == '')
                @else
                <li class="menu-item cart-container">
                    <img src="{{ url('/') }}/images/icons/cart.png" onclick=viewcart()>
                    <!-- <a class="fa fa-shopping-cart" aria-hidden="true" onclick=viewcart() }}>
                        <span class="fa fa-comment"></span><span class="num">99+</span>
                    </a> -->
                </li>
                @endif
                
                <ul class="menu-item dropdown account-container">
                    <a href="#" class="dropdown">Account
                    <!-- @if(Auth::user() == '')
                    Account
                    @else
                    {{ Auth::user()->name }}
                    @endif -->
                    </a>
                    <!-- Authentication Links -->
                    <ul class="dropdown-container">
                        @guest
                        <li class="menu-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="menu-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="menu-item">
                            <a class="dropdown-item" href="{{ route('User Controller') }}">Dashboard</a>
                        </li>
                        <li class="menu-item">
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                            
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                        @endguest
                    </ul>
                </ul>
            </ul>
            <ul class="menu-container mobile">
                <li class="menu-item search-container">
                    <input type="text" name="searched" class="textfield">
                    <input type="submit" value="Search">
                </li>
                @if(Auth::user() == '')
                @else
                <li class="menu-item cart-container">
                    <img src="{{ url('/') }}/images/icons/cart.png" onclick=viewcart()>
                    <!-- <a class="fa fa-shopping-cart" aria-hidden="true" onclick=viewcart() }}>
                        <span class="fa fa-comment"></span><span class="num">99+</span>
                    </a> -->
                </li>
                @endif
                
                <ul class="menu-item dropdown account-container">
                    <a href="#" class="dropdown">Account
                    <!-- @if(Auth::user() == '')
                    Account
                    @else
                    {{ Auth::user()->name }}
                    @endif -->
                    </a>
                    <!-- Authentication Links -->
                    <ul class="dropdown-container">
                        @guest
                        <li class="menu-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="menu-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="menu-item">
                            <a class="dropdown-item" href="{{ route('User Controller') }}">Dashboard</a>
                        </li>
                        <li class="menu-item">
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                            
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                        @endguest
                    </ul>
                </ul>
            </ul>
        </div>
    </div>
</nav>