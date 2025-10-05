<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('customer.css')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="page-container px-0">
        <div class="main-content w-100 ml-0">
            @include('customer.header')
            
            <div class="page-header bg-white shadow-sm">
                <div class="container-fluid py-4">
                    <div class="row g-3 align-items-center">
                        <div class="col-12 col-md">
                            <div class="d-flex flex-column flex-md-row align-items-md-center bg-white p-4 rounded-3 shadow-sm">
                                <div class="me-md-4">
                                    <h1 class="h3 mb-2 text-primary fw-bold d-flex align-items-center gap-2">
                                        <i class="fas fa-chart-line"></i>
                                        Sales Reports
                                    </h1>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb mb-0 bg-transparent p-0">
                                            <li class="breadcrumb-item">
                                                <a href="{{ route('landing') }}" class="text-decoration-none d-flex align-items-center gap-1">
                                                    <i class="fas fa-home text-primary"></i>
                                                    <span>Home</span>
                                                </a>
                                            </li>
                                            <li class="breadcrumb-item active fw-medium">Sales Reports</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="main-content-inner">
                <div class="row g-4">
                    <!-- Statistics Cards -->
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <div class="text-primary mb-2">
                                    <i class="fas fa-shopping-bag fa-2x"></i>
                                </div>
                                <h3 class="mb-1">{{ $totalOrders }}</h3>
                                <p class="text-muted mb-0">Total Orders</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <div class="text-success mb-2">
                                    <i class="fas fa-peso-sign fa-2x"></i>
                                </div>
                                <h3 class="mb-1">₱{{ number_format($totalSpent, 2) }}</h3>
                                <p class="text-muted mb-0">Total Spent</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <div class="text-warning mb-2">
                                    <i class="fas fa-clock fa-2x"></i>
                                </div>
                                <h3 class="mb-1">{{ $pendingOrders }}</h3>
                                <p class="text-muted mb-0">Pending Orders</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <div class="text-info mb-2">
                                    <i class="fas fa-check-circle fa-2x"></i>
                                </div>
                                <h3 class="mb-1">{{ $completedOrders }}</h3>
                                <p class="text-muted mb-0">Completed Orders</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Orders Table -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Order History</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Order #</th>
                                                <th>Date</th>
                                                <th>Store</th>
                                                <th>Items</th>
                                                <th>Total</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($orders as $order)
                                                <tr>
                                                    <td><strong>#{{ $order->id }}</strong></td>
                                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                                    <td>{{ $order->store->storename ?? 'N/A' }}</td>
                                                    <td>{{ $order->items->count() }} items</td>
                                                    <td>₱{{ number_format($order->total_amount, 2) }}</td>
                                                    <td>
                                                        <span class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'pending' ? 'warning' : 'secondary') }}">
                                                            {{ ucfirst($order->status) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center py-4">
                                                        <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                                                        <h5>No Orders Yet</h5>
                                                        <p class="text-muted">Start shopping to see your orders here</p>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('customer.script')
</body>
</html>
