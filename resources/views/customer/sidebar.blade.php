  <div class="sidebar-menu">
            <div class="sidebar-header">
                <div class="logo">
                    <a href="{{ route('home') }}"><img src="admin/assets/images/icon/logo.png" alt="MedCon"></a>
                </div>
            </div>
            <div class="main-menu">
                <div class="menu-inner">
                    <nav>
                        <ul class="metismenu" id="menu">
                            <li class="active">
                                <a href="{{ route('home') }}"><i class="ti-dashboard"></i><span>Dashboard</span></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" aria-expanded="true">
                                    <i class="fa fa-medkit"></i>
                                    <span>Medicines</span>
                                </a>
                                <ul class="collapse">
                                    <li><a href="{{ route('drugstore.view') }}">All Medicines</a></li>
                                    <li><a href="{{ route('drugstore.create') }}">Add Medicine</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0)" aria-expanded="true">
                                    <i class="fa fa-shopping-cart"></i>
                                    <span>Orders</span>
                                </a>
                                <ul class="collapse">
                                    <li><a href="#">All Orders</a></li>
                                    <li><a href="#">Pending</a></li>
                                    <li><a href="#">Completed</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0)" aria-expanded="true">
                                    <i class="fa fa-file-text-o"></i>
                                    <span>Prescriptions</span>
                                </a>
                                <ul class="collapse">
                                    <li><a href="#">All Prescriptions</a></li>
                                    <li><a href="#">Pending Review</a></li>
                                    <li><a href="#">Approved</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="{{ route('admin.view') }}">
                                    <i class="fa fa-users"></i>
                                    <span>Customers</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" aria-expanded="true">
                                    <i class="fa fa-bar-chart"></i>
                                    <span>Reports</span>
                                </a>
                                <ul class="collapse">
                                    <li><a href="#">Sales Report</a></li>
                                    <li><a href="#">Inventory Report</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-user"></i>
                                    <span>Profile</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-cog"></i>
                                    <span>Settings</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>