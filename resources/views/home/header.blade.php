<div class="branding d-flex align-items-center">
  <div class="container position-relative d-flex align-items-center justify-content-between">
    
    <!-- Logo + Site Name -->
    <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto">
      <img src="{{ asset('assets/img/logo.png') }}" alt="MediConnect Logo" width="50" height="50">
      <h1 class="sitename ms-2 mb-0">MediConnect</h1>
    </a>

    <!-- Desktop Navigation -->
    <nav id="navmenu" class="navmenu d-none d-xl-block">
      <ul class="d-flex gap-4 mb-0">
        <li><a href="#home" class="active">Home</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="#services">Services</a></li>
        <li><a href="#developers">Developers</a></li>
      </ul>
    </nav>

    <!-- Auth Buttons -->
    @if (Route::has('login'))
    <div class="auth-buttons d-flex align-items-center gap-3">
      @auth
        <!-- Logged in user menu -->
        <div class="dropdown">
          <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle me-2"></i>
            {{ Auth::user()->username }}
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li>
              <h6 class="dropdown-header">
                <i class="bi bi-person me-2"></i>
                {{ Auth::user()->username }}
                <br>
                <small class="text-muted">{{ Auth::user()->email }}</small>
              </h6>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <a class="dropdown-item" href="{{ route('dashboard') }}">
                <i class="bi bi-speedometer2 me-2"></i>
                Dashboard
              </a>
            </li>
            @if(Auth::user()->usertype === 'customer')
              <li>
                <a class="dropdown-item" href="{{ route('customer.profile') }}">
                  <i class="bi bi-person me-2"></i>
                  Profile
                </a>
              </li>
            @endif
            <li><hr class="dropdown-divider"></li>
            <li>
              <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="dropdown-item text-danger">
                  <i class="bi bi-box-arrow-right me-2"></i>
                  Logout
                </button>
              </form>
            </li>
          </ul>
        </div>
      @else
        <a class="cta-btn btn btn-primary" href="{{ route('login') }}">Login</a>
        @if (Route::has('register'))
          <a class="cta-btn btn btn-outline-primary" href="{{ route('register') }}">Register</a>
        @endif
      @endauth
    </div>
    @endif

    <!-- Mobile Menu Toggle -->
    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
  </div>
</div>
