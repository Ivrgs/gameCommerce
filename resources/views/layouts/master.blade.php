<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('includes.header')

    <body>

    <nav class="main-nav">
            <div class="container">
                <div class="navbar-logo">
                    <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ url('/') }}/images/icons/main-icon.png"></a>
                </div>

                <div class="navbar-menu">
                    <ul class="menu-container">
                        <li class="menu-item">
                                <a class="fa fa-shopping-cart" aria-hidden="true" onclick=viewcart() }}><span class="fa fa-comment"></span><span class="num">99+</span></a>
                        </li>
                        <!-- Authentication Links -->
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
                        <li class="menu-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('User Controller') }}">Dashboard</a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        
            @yield('shopcontents')
            @yield('content')
        @include('includes.footer')
        @include('includes.modal')
     
    </body>
{{--AJAX Modal --}}
@include('includes.ajax')

    <script type="text/javascript" src="{{URL::to('/')}}/js/popper.min.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/js/app.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/js/custom.js"></script>
</html>
