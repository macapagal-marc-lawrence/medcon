<div class="sidebar-menu bg-white">
    <div class="sidebar-header bg-primary">
        <div class="logo">
            <a href="{{ route('home') }}" class="d-flex align-items-center justify-content-center">
                <img src="{{ asset('assets/img/logreglogowhite.png') }}" alt="MediConnect" class="img-fluid" style="max-height: 40px;" />
            </a>
        </div>
    </div>

    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">
                    <!-- Dashboard -->
                    <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                        <a href="{{ route('home') }}" class="d-flex align-items-center">
                            <i class="fa fa-dashboard text-primary"></i>
                            <span class="ml-2">Dashboard</span>
                        </a>
                    </li>

                    <!-- Inventory Management -->
                    <li>
                        <a href="javascript:void(0)" class="d-flex align-items-center">
                            <i class="fa fa-medkit text-success"></i>
                            <span class="ml-2">Inventory</span>
                        </a>
                        <ul class="collapse">
                            <li>
                                <a href="{{ route('drugstore.create') }}" class="d-flex align-items-center">
                                    <i class="fa fa-plus-circle text-success"></i>
                                    <span class="ml-2">Add Medicine</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('drugstore.view') }}" class="d-flex align-items-center">
                                    <i class="fa fa-list text-primary"></i>
                                    <span class="ml-2">View Medicines</span>
                                </a>
                            </li>
                        </ul>
                    </li>






                </ul>
            </nav>
        </div>
    </div>
</div>