
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark sticky-top">
            <div class="container-fluid">
                <div class="navbar-header">
                <a class="navbar-brand" href="{{ url('/') }}">gameCommerce</a>
                </div>
                <ul class="nav navbar-nav">
                <div class="UpperOption">
                   <li class="nav-item">

                   <a class="fa fa-shopping-cart" aria-hidden="true" onclick=viewcart() }}>
                    <span class="fa fa-comment"></span>
                        <span class="num">99+</span>

                      </a>

                   </li>
                  <!-- Authentication Links -->
                  @guest
                  <li class="nav-item">
                      <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                  </li>
                  @if (Route::has('register'))
                      <li class="nav-item">
                          <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                      </li>
                  @endif
              @else
                  <li class="nav-item dropdown">
                      <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                          {{ Auth::user()->name }}
                      </a>

                      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="{{ route('Home Controller') }}">Dashboard</a>
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
                    </div>
                </ul>
            </div>
        </nav>