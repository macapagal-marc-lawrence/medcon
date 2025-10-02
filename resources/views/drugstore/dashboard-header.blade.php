    <div class="header-area bg-white shadow-sm">
                <div class="row align-items-center">
                    <!-- Search and Quick Actions -->
                    <div class="col-md-6 col-sm-8 clearfix">
                        <div class="nav-btn pull-left d-lg-none">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                    <!-- Notifications and Profile -->
                    <div class="col-md-6 col-sm-4 clearfix">
                        <ul class="notification-area pull-right">
                            <!-- Low Stock Alert -->
                            <li class="dropdown">
                                <i class="fa fa-exclamation-triangle text-warning dropdown-toggle" data-toggle="dropdown">
                                    <span class="badge badge-warning">{{ $lowStockCount }}</span>
                                </i>
                                <div class="dropdown-menu notification-menu">
                                    <div class="notification-header">
                                        <h6 class="mb-0">Stock Alerts</h6>
                                    </div>
                                    <div class="notification-list">
                                        @forelse($lowStockMedicines as $medicine)
                                            <a href="{{ route('drugstore.view') }}" class="dropdown-item">
                                                <div class="d-flex align-items-center">
                                                    <i class="fa fa-exclamation-circle text-warning mr-2"></i>
                                                    <div>
                                                        <p class="mb-0">Low stock: {{ $medicine->medicine_name }}</p>
                                                        <small class="text-muted">{{ $medicine->quantity }} units remaining</small>
                                                    </div>
                                                </div>
                                            </a>
                                        @empty
                                            <div class="dropdown-item">
                                                <p class="text-muted mb-0">No low stock alerts</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </li>
                            <!-- Orders Notification -->
                            <li class="dropdown">
                                <i class="fa fa-shopping-bag text-primary dropdown-toggle" data-toggle="dropdown">
                                    <span class="badge badge-primary">{{ $pendingOrders }}</span>
                                </i>
                                <div class="dropdown-menu notification-menu">
                                    <div class="notification-header">
                                        <h6 class="mb-0">New Orders</h6>
                                    </div>
                                    <div class="notification-list">
                                        @forelse($recentOrders as $order)
                                            <a href="#pending-orders-section" class="dropdown-item">
                                                <div class="d-flex align-items-center">
                                                    <i class="fa fa-file-text-o text-primary mr-2"></i>
                                                    <div>
                                                        <p class="mb-0">Order #{{ $order->id }}</p>
                                                        <small class="text-muted">{{ $order->created_at->diffForHumans() }}</small>
                                                    </div>
                                                </div>
                                            </a>
                                        @empty
                                            <div class="dropdown-item">
                                                <p class="text-muted mb-0">No new orders</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
