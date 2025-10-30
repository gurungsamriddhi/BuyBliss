<nav class="custom-navbar navbar navbar-expand-md navbar-dark bg-dark sticky-top" aria-label="Furni navigation bar">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">BuyBliss<span>.</span></a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni"
            aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsFurni">
            <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
                <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item {{ request()->is('shop*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('shop') }}">Shop</a>
                </li>
                <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About us</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('services') }}">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('blog') }}">Blog</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('contactus') }}">Contact us</a></li>
            </ul>



            <!--<ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
      <li><a class="nav-link" href="#"><img src=""></a></li>
      <li><a class="nav-link" href="cart.html"><img src="images/cart.svg"></a></li>
     </ul>-->
            {{--  ====  AUTH / CART ICONS  ====  --}}
            <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5 d-flex align-items-center gap-3">

                @guest
                    {{-- Register --}}
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="nav-link p-0">
                            <span class="d-flex align-items-center gap-1 text-white">
                                <img src="{{ asset('images/register.svg') }}" alt="Register" class="icon-svg">
                                <span class="d-none d-lg-inline">Register</span>
                            </span>
                        </a>
                    </li>

                    {{-- Login --}}
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link p-0">
                            <span class="d-flex align-items-center gap-1 text-white">
                                <img src="{{ asset('images/login.svg') }}" alt="Login" class="icon-svg">
                                <span class="d-none d-lg-inline">Login</span>
                            </span>
                        </a>
                    </li>
                @else
                    {{-- Logged-in user dropdown --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link p-0 dropdown-toggle d-flex align-items-center gap-1 text-white" href="#"
                            id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('images/user.svg') }}" alt="User" class="icon-svg">
                            <span class="d-none d-lg-inline">{{ Auth::user()->name }}</span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest

                {{-- Cart – already perfect --}}
                <li class="nav-item">
                    <a href="{{ route('cartitems') }}" class="nav-link p-0">
                        <span class="d-flex align-items-center gap-1 text-white">
                            <img src="{{ asset('images/cart.svg') }}" alt="Cart" class="icon-svg">
                            <span class="d-none d-lg-inline">Cart</span>
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
