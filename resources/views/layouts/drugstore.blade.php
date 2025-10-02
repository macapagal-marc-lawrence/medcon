<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('drugstore.css')
</head>
<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="loader"></div>
    </div>

    <div class="page-container">
        <!-- Sidebar Menu -->
        @include('drugstore.sidebar')

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header-area">
                <div class="row align-items-center">
                    <!-- Menu Toggle -->
                    <div class="col-sm-6 clearfix">
                        <div class="nav-btn pull-left">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                    <!-- Profile Info -->
                    <div class="col-sm-6 clearfix">
                        <div class="user-profile pull-right">
                            <img class="avatar user-thumb" src="{{ asset('admin/assets/images/author/avatar.png') }}" alt="avatar">
                            <h4 class="user-name dropdown-toggle" data-toggle="dropdown">{{ Auth::user()->name }} <i class="fa fa-angle-down"></i></h4>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">Settings</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); this.closest('form').submit();">
                                        Log Out
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Title -->
            @if (isset($header))
                <div class="page-title-area">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <div class="breadcrumbs-area clearfix">
                                {{ $header }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Content Area -->
            <div class="main-content-inner">
                @yield('content')
            </div>
        </div>

        <!-- Footer -->
        <footer>
            <div class="footer-area">
                <p>© {{ date('Y') }} MediConnect. All rights reserved.</p>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('admin/assets/js/vendor/jquery-2.2.4.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery.slicknav.min.js') }}"></script>

    <!-- Others Scripts -->
    <script src="{{ asset('admin/assets/js/plugins.js') }}"></script>
    <script src="{{ asset('admin/assets/js/scripts.js') }}"></script>

    <!-- Stack Scripts -->
    @stack('scripts')
</body>
</html>