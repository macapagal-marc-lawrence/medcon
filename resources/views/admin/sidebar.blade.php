<div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo">
            <a href="{{ route('home') }}">
                <img src="{{ asset('assets/img/logreglogowhite.png') }}" alt="logo" />
            </a>
        </div>
    </div>

    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">
                    <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                        <a href="{{ route('home') }}" aria-expanded="true">
                            <i class="ti-dashboard"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>



                    <li>
                        <a href="javascript:void(0)" aria-expanded="false">
                            <i class="ti-shopping-cart"></i>
                            <span>Drugstores</span>
                        </a>
                        <ul class="collapse">
                            <li><a href="{{ route('admin.drugstore.create') }}">Create Drugstore</a></li>
                            <li><a href="{{ route('admin.drugstore.view') }}">View Drugstores</a></li>
                        </ul>
                    </li>


                </ul>
            </nav>
        </div>
    </div>
</div>