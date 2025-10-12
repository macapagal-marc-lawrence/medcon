<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('customer.css')
    <!-- Bootstrap Dependencies -->
       <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
    <!-- page container area start -->
    <div class="page-container px-0">
        <!-- main content area start -->
        <div class="main-content w-100 ml-0">
            <!-- header area start -->
        @include('customer.header')
            <!-- header area end -->
            <!-- page title area start -->
                        <div class="page-header bg-white shadow-sm">
                <div class="container-fluid py-4">
                    <div class="row g-3 align-items-center">
                        <div class="col-12 col-md">
                            <div class="d-flex flex-column flex-md-row align-items-md-center bg-white p-4 rounded-3 shadow-sm">
                                <div class="me-md-4">
                                    <h1 class="h3 mb-2 text-primary fw-bold d-flex align-items-center gap-2">
                                        <i class="fas fa-hand-wave"></i>
                                        Welcome Back, {{ Auth::user()->name }}!
                                    </h1>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb mb-0 bg-transparent p-0">
                                            <li class="breadcrumb-item">
                                                <a href="{{ route('home') }}" class="text-decoration-none d-flex align-items-center gap-1">
                                                    <i class="fas fa-home text-primary"></i>
                                                    <span>Home</span>
                                                </a>
                                            </li>
                                            <li class="breadcrumb-item active fw-medium">My Dashboard</li>
                                        </ol>
                                    </nav>
                                </div>
                                <!-- Search - Mobile Only -->
                                <div class="d-block d-md-none mt-2">
                                    <div class="search-container">
                                        <input type="search" 
                                               class="form-control search-medicine" 
                                               placeholder="Search medicines..."
                                               autocomplete="off">
                                        <div class="search-results d-none"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-auto">
                            <div class="d-flex align-items-center justify-content-end gap-4 py-2">
                                <!-- Search - Desktop Only -->
                                <div class="search-container d-none d-md-block">
                                    <input type="search" 
                                           class="form-control form-control-lg search-medicine" 
                                           placeholder="Search medicines..." 
                                           style="width: 300px; height: 45px;"
                                           autocomplete="off">
                                    <div class="search-results d-none"></div>
                                </div>

                                <!-- Notifications -->
                                <div class="dropdown">
                                    <button class="btn btn-light position-relative rounded-pill p-2 px-3" 
                                            type="button" 
                                            data-bs-toggle="dropdown">
                                        <i class="fa fa-bell fa-lg"></i>
                                        @if($notifications->count() > 0)
                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                {{ $notifications->count() }}
                                            </span>
                                        @endif
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="min-width: 280px;">
                                        <div class="p-2">
                                            <h6 class="mb-0">Notifications</h6>
                                        </div>
                                        <hr class="dropdown-divider my-0">
                                        
                                        @forelse($notifications as $notification)
                                            <a class="dropdown-item py-2" href="#">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        @if($notification->status === 'approved')
                                                            <i class="fa fa-check-circle text-success fa-lg"></i>
                                                        @else
                                                            <i class="fa fa-times-circle text-danger fa-lg"></i>
                                                        @endif
                                                    </div>
                                                    <div class="flex-grow-1 ms-2">
                                                        <p class="mb-0">Order #{{ $notification->id }} has been {{ strtoupper($notification->status) }}</p>
                                                        <small class="text-muted">{{ $notification->updated_at->diffForHumans() }}</small>
                                                    </div>
                                                </div>
                                            </a>
                                        @empty
                                            <div class="dropdown-item text-center text-muted py-3">
                                                No new notifications
                                            </div>
                                        @endforelse
                                        

                                    </div>
                                </div>

                                <!-- User Menu -->
                                <div class="dropdown ms-3">
                                    <button class="btn btn-light d-flex align-items-center rounded-pill p-2" 
                                            type="button" 
                                            data-bs-toggle="dropdown" 
                                            aria-expanded="false">
                                        <img class="avatar user-thumb rounded-circle me-2" 
                                             src="{{ Auth::user()->customer->avatar ? asset('storage/' . Auth::user()->customer->avatar) : asset('admin/assets/images/author/avatar.png') }}" 
                                             alt="avatar"
                                             style="width: 32px; height: 32px; object-fit: cover;">
                                        <i class="fa fa-angle-down ms-1 me-1"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="min-width: 280px;">
                                        <li>
                                            <div class="px-4 py-3">
                                                <div class="d-flex align-items-center">
                                                    <img class="rounded-circle me-3" 
                                                         src="{{ Auth::user()->customer->avatar ? asset('storage/' . Auth::user()->customer->avatar) : asset('admin/assets/images/author/avatar.png') }}"
                                                         alt="avatar"
                                                         style="width: 40px; height: 40px; object-fit: cover;">
                                                    <div>
                                                        <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                                                        <small class="text-muted">{{ Auth::user()->email }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item py-2" href="{{ route('customer.profile') }}">
                                                <i class="fa fa-user me-2 text-muted"></i> Profile
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}" class="px-4 py-2">
                                                @csrf
                                                <button type="submit" class="btn btn-danger w-100">
                                                    <i class="fa fa-sign-out me-2"></i> Log Out
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- page title area end -->
            <div class="main-content-inner">
                <!-- sales report area start -->
                                <style>
                    .dashboard-card {
                        border: none;
                        border-radius: 15px;
                        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
                        height: 100%;
                        transition: all 0.3s ease;
                    }

                    .dashboard-card:hover {
                        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
                    }

                    .card-header-title {
                        font-size: 1.25rem;
                        font-weight: 600;
                        color: #333;
                        display: flex;
                        align-items: center;
                        gap: 8px;
                        margin: 0;
                    }

                    .item-card {
                        background: #f8f9fa;
                        border: 1px solid rgba(0, 0, 0, 0.05);
                        border-radius: 12px;
                        padding: 1rem;
                        margin-bottom: 1rem;
                        transition: all 0.3s ease;
                    }

                    .item-card:hover {
                        background: white;
                        transform: translateY(-2px);
                        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
                    }

                    .item-icon {
                        width: 45px;
                        height: 45px;
                        background: rgba(33, 150, 243, 0.1);
                        border-radius: 10px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    }

                    .badge-modern {
                        background: linear-gradient(45deg, #2196F3, #1976D2);
                        border-radius: 20px;
                        padding: 0.5rem 1rem;
                        color: white;
                        font-weight: 500;
                        font-size: 0.875rem;
                    }

                    .empty-state {
                        text-align: center;
                        padding: 3rem 2rem;
                        background: #f8f9fa;
                        border-radius: 15px;
                    }

                    .empty-state-icon {
                        width: 80px;
                        height: 80px;
                        background: rgba(33, 150, 243, 0.1);
                        border-radius: 50%;
                        display: inline-flex;
                        align-items: center;
                        justify-content: center;
                        margin-bottom: 1.5rem;
                    }
                </style>

                <div class="customer-dashboard-area mt-5 mb-5">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card dashboard-card">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h4 class="card-header-title">
                                            <i class="fas fa-file-medical text-primary"></i>
                                            My Prescriptions
                                        </h4>
                                    </div>

                                    @php
                                        $prescriptions = auth()->user()->customer->prescriptions()->latest()->take(3)->get();
                                    @endphp

                                    @forelse($prescriptions as $prescription)
                                        <div class="item-card">
                                            <div class="d-flex gap-3">
                                                <div class="item-icon">
                                                    <i class="fas fa-file-medical text-primary"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                                        <div>
                                                            <h6 class="mb-1 fw-bold">Prescription #{{ $prescription->id }}</h6>
                                                            <p class="text-muted small mb-2">
                                                                {{ $prescription->created_at->format('M d, Y h:i A') }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <p class="mb-0 text-muted">{{ Str::limit($prescription->notes, 100) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="empty-state">
                                            <div class="empty-state-icon">
                                                <i class="fas fa-file-medical text-primary fa-2x"></i>
                                            </div>
                                            <h5 class="fw-bold mb-2">No Prescriptions Yet</h5>
                                            <p class="text-muted mb-0">Click the button above to add your first prescription</p>
                                        </div>
                                    @endforelse

                                
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card dashboard-card">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h4 class="card-header-title">
                                            <i class="fas fa-shopping-cart text-primary"></i>
                                            Shopping Cart
                                        </h4>
                                        @if(!empty($cartItems) && count($cartItems) > 0)
                                            <span class="badge-modern">
                                                {{ count($cartItems) }} items
                                            </span>
                                        @endif
                                    </div>
                                    
                                                                        <div class="active-orders">
                                        @if(empty($cartItems) || count($cartItems) === 0)
                                            <div class="empty-state">
                                                <div class="empty-state-icon">
                                                    <i class="fas fa-shopping-cart text-primary fa-2x"></i>
                                                </div>
                                                <h5 class="fw-bold mb-2">Your Cart is Empty</h5>
                                                <p class="text-muted mb-4">Looks like you haven't added any medicines to your cart yet.</p>
                                                <a href="#available-drugstores" class="btn btn-primary rounded-pill px-4">
                                                    <i class="fas fa-pills me-2"></i>Browse Medicines
                                                </a>
                                            </div>
                                        @else
                                            <div class="cart-items">
                                                @php $totalAmount = 0; @endphp
                                                @foreach($cartItems as $item)
                                                    @php 
                                                        $itemTotal = $item['medicine']->medicine_price * $item['quantity'];
                                                        $totalAmount += $itemTotal;
                                                    @endphp
                                                    <div class="cart-item mb-3 p-3 border rounded-3 bg-light">
                                                        <div class="row align-items-center">
                                                            <!-- Medicine Info -->
                                                            <div class="col-md-6">
                                                                <div class="d-flex align-items-center">
                                                                    @if($item['medicine']->medicine_img)
                                                                        <img src="{{ asset('storage/' . $item['medicine']->medicine_img) }}"
                                                                             alt="{{ $item['medicine']->medicine_name }}"
                                                                             class="rounded-3 me-3"
                                                                             style="width: 60px; height: 60px; object-fit: cover;">
                                                                    @else
                                                                        <img src="{{ asset('admin/assets/images/icon/medicine.png') }}"
                                                                             alt="No Image"
                                                                             class="rounded-3 me-3"
                                                                             style="width: 60px; height: 60px; object-fit: cover; opacity: 0.6;">
                                                                    @endif
                                                                    <div>
                                                                        <h6 class="mb-1">{{ $item['medicine']->medicine_name }}</h6>
                                                                        <p class="text-muted mb-0">{{ $item['medicine']->generic_name }}</p>
                                                                        <small class="text-primary">{{ $item['store']->storename }}</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- Price -->
                                                            <div class="col-md-2">
                                                                <div class="text-md-center">
                                                                    <p class="mb-0 text-muted small">Price</p>
                                                                    <p class="mb-0 fw-medium">₱{{ number_format($item['medicine']->medicine_price, 2) }}</p>
                                    </div>
                                    </div>
                                                            
                                                            <!-- Quantity -->
                                                            <div class="col-md-2">
                                                                <div class="text-md-center">
                                                                    <p class="mb-2 text-muted small">Quantity</p>
                                                                    <form method="POST" action="{{ route('cart.update') }}" class="d-inline">
                                                                        @csrf
                                                                        <input type="hidden" name="medicine_id" value="{{ $item['medicine']->id }}">
                                                                        <div class="input-group input-group-sm" style="width: 100px;">
                                                                            <button type="submit" name="quantity" value="{{ max(1, $item['quantity'] - 1) }}" 
                                                                                    class="btn btn-outline-primary btn-sm">-</button>
                                                                            <input type="text" 
                                                                                   class="form-control form-control-sm text-center border-primary" 
                                                                                   value="{{ $item['quantity'] }}" 
                                                                                   readonly>
                                                                            <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}" 
                                                                                    class="btn btn-outline-primary btn-sm"
                                                                                    {{ $item['quantity'] >= $item['medicine']->quantity ? 'disabled' : '' }}>+</button>
                                </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- Total & Actions -->
                                                            <div class="col-md-2">
                                                                <div class="text-md-end">
                                                                    <p class="mb-2 text-muted small">Total</p>
                                                                    <p class="mb-0 fw-bold">₱{{ number_format($itemTotal, 2) }}</p>
                                                                    <form method="POST" action="{{ route('cart.remove') }}" class="d-inline mt-2">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <input type="hidden" name="medicine_id" value="{{ $item['medicine']->id }}">
                                                                        <button type="submit" class="btn btn-sm btn-link text-danger p-0" 
                                                                                onclick="return confirm('Remove this item from cart?')">
                                                                            <i class="fa fa-trash-alt"></i> Remove
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach

                                                @if(count($cartItems) > 0)
                                                    <!-- Cart Summary -->
                                                    <div class="d-flex justify-content-end align-items-center mt-4">
                                                        <div class="me-4">
                                                            <span class="text-muted me-2">Total:</span>
                                                            <span class="fw-bold text-primary fs-5">₱{{ number_format($totalAmount, 2) }}</span>
                                                        </div>
                                                        <button class="btn btn-primary" data-toggle="modal" data-target="#checkoutModal">
                                                            <i class="fa fa-shopping-cart me-2"></i>Checkout
                                                        </button>
                                                    </div>
                                                @endif
                                                    
                                                    <!-- Checkout Modal -->
                                                    <div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="checkoutModalLabel">Checkout</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="order-summary">
                                                                        <div class="alert alert-info mb-4">
                                                                            <i class="fa fa-info-circle me-2"></i>
                                                                            This is a reservation for over-the-counter pickup. Please select your preferred pickup date and proceed to the pharmacy to complete your purchase.
                                                                        </div>
                                                                        
                                                                        <!-- Pickup Date Selection -->
                                                                        <div class="mb-4">
                                                                            <h5 class="mb-3">Select Pickup Date</h5>
                                                                            <div class="form-group">
                                                                                <select class="form-select" id="pickupDate" required>
                                                                                    <option value="">Choose pickup date...</option>
                                                                                    <option value="today">Today (Before closing time)</option>
                                                                                    <option value="tomorrow">Tomorrow</option>
                                                                                </select>
                                                                                <div class="form-text text-danger">
                                                                                    * Reservation will be automatically voided if not picked up by the end of the selected day
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="table-responsive">
                                                                            <table class="table table-bordered">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>Item</th>
                                                                                        <th>Quantity</th>
                                                                                        <th class="text-end">Price</th>
                                                                                        <th class="text-end">Total</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    @foreach($cartItems as $item)
                                                                                        <tr>
                                                                                            <td>
                                                                                                <div class="d-flex align-items-center">
                                                                                                    <div class="me-2">
                                                                                                        @if($item['medicine']->medicine_img)
                                                                                                            <img src="{{ asset('storage/' . $item['medicine']->medicine_img) }}"
                                                                                                                 alt="{{ $item['medicine']->medicine_name }}"
                                                                                                                 class="rounded"
                                                                                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                                                                                        @else
                                                                                                            <img src="{{ asset('admin/assets/images/icon/medicine.png') }}"
                                                                                                                 alt="No Image"
                                                                                                                 class="rounded"
                                                                                                                 style="width: 40px; height: 40px; object-fit: cover; opacity: 0.6;">
                                                                                                        @endif
                                                                                                    </div>
                                                                                                    <div>
                                                                                                        <div class="fw-bold">{{ $item['medicine']->medicine_name }}</div>
                                                                                                        <small class="text-muted">{{ $item['store']->storename }}</small>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </td>
                                                                                            <td>{{ $item['quantity'] }}</td>
                                                                                            <td class="text-end">₱{{ number_format($item['medicine']->medicine_price, 2) }}</td>
                                                                                            <td class="text-end">₱{{ number_format($item['medicine']->medicine_price * $item['quantity'], 2) }}</td>
                                                                                        </tr>
                                                                                    @endforeach
                                                                                    <tr>
                                                                                        <td colspan="3" class="text-end fw-bold">Total Amount:</td>
                                                                                        <td class="text-end fw-bold">₱{{ number_format($totalAmount, 2) }}</td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                                                                        <button type="button" class="btn btn-primary" id="placeOrderBtn">
                                                        <i class="fa fa-check me-2"></i>Place Order
                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Order Confirmation Modal -->
                                                    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true" data-bs-backdrop="static">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-success text-white">
                                                                    <h5 class="modal-title" id="confirmationModalLabel">
                                                                        <i class="fa fa-check-circle me-2"></i>
                                                                        Orders Reserved Successfully
                                                                    </h5>
                                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body p-4" id="confirmationModalBody">
                                                                    <!-- Content will be dynamically inserted here -->
                                                                </div>
                                                                <div class="modal-footer justify-content-center">
                                                                    <button type="button" class="btn btn-primary" onclick="window.location.reload()">
                                                                        <i class="fa fa-check me-2"></i>Done
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- sales report area end -->

                <!-- Order History Section -->
                <div id ="recent-orders" class="row mt-5 mb-5">
                    <div class="col-12">
                        <div class="card dashboard-card">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h4 class="card-header-title">
                                        <i class="fas fa-history text-primary"></i>
                                        Order History
                                    </h4>
                                </div>
                                <div class="order-history-table">
                                    <div class="table-responsive">
                                                                                <table class="table table-hover align-middle">
                                            <thead>
                                                <tr class="bg-light">
                                                    <th class="py-3 ps-4" style="color: #666; font-weight: 600; font-size: 0.9rem;">ORDER #</th>
                                                    <th class="py-3" style="color: #666; font-weight: 600; font-size: 0.9rem;">DATE</th>
                                                    <th class="py-3" style="color: #666; font-weight: 600; font-size: 0.9rem;">PRODUCT DETAILS</th>
                                                    <th class="py-3" style="color: #666; font-weight: 600; font-size: 0.9rem;">TOTAL</th>
                                                    <th class="py-3 pe-4" style="color: #666; font-weight: 600; font-size: 0.9rem;">STATUS</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $ordersData = app(\App\Http\Controllers\Customer\OrderController::class)->getOrderHistory();
                                                    $orders = $ordersData;
                                                @endphp
                                                @forelse($orders as $order)
                                                <tr>
                                                    <td>
                                                        <strong>#{{ $order->id }}</strong>
                                                    </td>
                                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                                    <td>
                                                        @foreach($order->items as $item)
                                                            <div class="d-flex align-items-center mb-2">
                                                                <div class="product-img me-3">
                                                                    @if($item->medicine->medicine_img)
                                                                        <img src="{{ asset('storage/' . $item->medicine->medicine_img) }}"
                                                                             alt="{{ $item->medicine->medicine_name }}"
                                                                             class="rounded"
                                                                             style="width: 40px; height: 40px; object-fit: cover;">
                                                                    @else
                                                                        <img src="{{ asset('admin/assets/images/icon/medicine.png') }}"
                                                                             alt="No Image"
                                                                             class="rounded"
                                                                             style="width: 40px; height: 40px; object-fit: cover; opacity: 0.6;">
                                                                    @endif
                                                                </div>
                                                                <div class="product-info">
                                                                    <p class="mb-0 fw-medium">{{ $item->medicine->medicine_name }}</p>
                                                                    <small class="text-muted">Qty: {{ $item->quantity }}</small>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </td>
                                                    <td>₱{{ number_format($order->total_amount, 2) }}</td>
                                                    <td>
                                                        @php
                                                            $statusColors = [
                                                                'pending' => 'warning',
                                                                'processing' => 'info',
                                                                'completed' => 'success',
                                                                'cancelled' => 'danger'
                                                            ];
                                                            $statusColor = $statusColors[$order->status] ?? 'secondary';
                                                        @endphp
                                                        <span class="badge bg-{{ $statusColor }}">
                                                            {{ ucfirst($order->status) }}
                                                        </span>
                                                    </td>
                                            </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="6" class="text-center py-5">
                                                        <img src="{{ asset('images/no-orders.svg') }}" alt="No Orders" style="width: 120px; margin-bottom: 20px;">
                                                        <h5>No Orders Yet</h5>
                                                        <p class="text-muted">Start shopping to see your orders here</p>
                                                </td>
                                            </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- Pagination -->
                                    <div class="d-flex justify-content-center mt-4">
                                        {{ $ordersData->onEachSide(2)->links() }}
                                    </div>
                                    <div class="text-center mt-2 text-muted">
                                        Showing {{ $ordersData->firstItem() ?? 0 }} to {{ $ordersData->lastItem() ?? 0 }} of {{ $ordersData->total() }} orders
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- market value area end -->

                <!-- Available Drugstores Section start -->
                <div id="available-drugstores" class="mt-5">
                    <div class="mb-4">
                        <h4 class="header-title">Available Drugstores</h4>
                    </div>
                    <div class="container-fluid">
                        <!-- Modern CSS for cards -->
                        <style>
                            .drugstore-card {
                                transition: all 0.3s ease;
                                border: none;
                                border-radius: 15px;
                                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                                overflow: hidden;
                            }
                            
                            .drugstore-card:hover {
                                transform: translateY(-5px);
                                box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
                            }

                            .drugstore-header {
                                background: linear-gradient(45deg, #2196F3, #1976D2);
                                padding: 20px;
                                color: white;
                                border-radius: 15px 15px 0 0;
                            }

                            .drugstore-content {
                                padding: 20px;
                            }

                            .info-badge {
                                padding: 8px 12px;
                                border-radius: 20px;
                                font-weight: 500;
                                font-size: 0.9rem;
                                display: inline-flex;
                                align-items: center;
                                gap: 6px;
                            }

                            .info-row {
                                display: flex;
                                align-items: center;
                                gap: 8px;
                                margin-bottom: 12px;
                                color: #666;
                            }

                            .view-medicines-btn {
                                width: 100%;
                                padding: 12px;
                                border-radius: 10px;
                                transition: all 0.3s ease;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                gap: 8px;
                                background: linear-gradient(45deg, #2196F3, #1976D2);
                                border: none;
                                color: white;
                                font-weight: 500;
                            }

                            .view-medicines-btn:hover {
                                background: linear-gradient(45deg, #1976D2, #1565C0);
                                transform: translateY(-2px);
                            }
                        </style>

                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                            @forelse($drugstores ?? [] as $drugstore)
                                <div class="col">
                                    <div class="card h-100 drugstore-card">
                                        <div class="drugstore-header">
                                            <h5 class="mb-2">{{ $drugstore->storename }}</h5>
                                            <small class="d-block text-white-50">License No: {{ $drugstore->licenseno }}</small>
                                        </div>
                                        <div class="drugstore-content">
                                            @php
                                                $medicineCount = $drugstore->medicines->count();
                                                $availableMedicines = $drugstore->medicines->where('quantity', '>', 0)->count();
                                            @endphp
                                            
                                            @if($availableMedicines > 0)
                                                <div class="info-badge bg-success-subtle text-success mb-3">
                                                    <i class="fas fa-pills"></i>
                                                    <span>{{ $availableMedicines }} Medicines Available</span>
                                                </div>
                                            @else
                                                <div class="info-badge bg-warning-subtle text-warning mb-3">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    <span>No Medicines in Stock</span>
                                                </div>
                                            @endif

                                            <div class="info-row">
                                                <i class="fa fa-map-marker-alt text-danger"></i>
                                                <span class="text-truncate">{{ $drugstore->storeaddress }}</span>
                                            </div>
                                            <div class="info-row">
                                                <i class="fa fa-clock text-primary"></i>
                                                <span>{{ $drugstore->operatingdays }}</span>
                                            </div>
                                            <button type="button" 
                                                    class="view-medicines-btn mt-3" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#drugstoreModal{{ $drugstore->id }}">
                                                <i class="fa fa-pills"></i>
                                                <span>View Medicines</span>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Modern Modal Styles -->
                                    <style>
                                        .modern-modal .modal-content {
                                            border: none;
                                            border-radius: 20px;
                                            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                                        }

                                        .modern-modal .modal-header {
                                            background: linear-gradient(45deg, #2196F3, #1976D2);
                                            color: white;
                                            border-radius: 20px 20px 0 0;
                                            padding: 20px;
                                            border: none;
                                        }

                                        .modern-modal .modal-title {
                                            font-size: 1.4rem;
                                            font-weight: 600;
                                        }

                                        .modern-modal .btn-close {
                                            background-color: white;
                                            opacity: 0.8;
                                            transition: all 0.3s ease;
                                        }

                                        .modern-modal .btn-close:hover {
                                            opacity: 1;
                                            transform: rotate(90deg);
                                        }

                                        .modern-search {
                                            background: #f8f9fa;
                                            border-radius: 15px;
                                            padding: 8px;
                                            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
                                        }

                                        .modern-search .input-group-text {
                                            background: transparent;
                                            border: none;
                                            color: #2196F3;
                                        }

                                        .modern-search .form-control {
                                            border: none;
                                            background: transparent;
                                            padding: 12px;
                                            font-size: 1rem;
                                        }

                                        .modern-search .form-control:focus {
                                            box-shadow: none;
                                        }

                                        .modern-table {
                                            border-radius: 15px;
                                            overflow: hidden;
                                            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
                                        }

                                        .modern-table thead {
                                            background: #f8f9fa;
                                        }

                                        .modern-table th {
                                            font-weight: 600;
                                            color: #2196F3;
                                            text-transform: uppercase;
                                            font-size: 0.85rem;
                                            letter-spacing: 0.5px;
                                            padding: 1rem 1.5rem;
                                        }

                                        .modern-table td {
                                            padding: 1rem 1.5rem;
                                            vertical-align: middle;
                                        }

                                        .modern-table tbody tr {
                                            transition: all 0.3s ease;
                                        }

                                        .modern-table tbody tr:hover {
                                            background-color: #f8f9fa;
                                            transform: scale(1.01);
                                        }

                                        .stock-badge {
                                            padding: 6px 12px;
                                            border-radius: 20px;
                                            font-size: 0.85rem;
                                            font-weight: 500;
                                        }

                                        .add-to-cart-btn {
                                            padding: 8px 16px;
                                            border-radius: 10px;
                                            background: linear-gradient(45deg, #2196F3, #1976D2);
                                            border: none;
                                            color: white;
                                            font-weight: 500;
                                            transition: all 0.3s ease;
                                            display: inline-flex;
                                            align-items: center;
                                            gap: 8px;
                                        }

                                        .add-to-cart-btn:hover {
                                            background: linear-gradient(45deg, #1976D2, #1565C0);
                                            transform: translateY(-2px);
                                        }

                                        .price-tag {
                                            font-weight: 600;
                                            color: #2196F3;
                                            font-size: 1.1rem;
                                        }
                                    </style>

                                    <!-- Medicines Modal -->
                                    <div class="modal fade" id="drugstoreModal{{ $drugstore->id }}" tabindex="-1" aria-labelledby="drugstoreModalLabel{{ $drugstore->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-xl modal-dialog-centered modern-modal" style="max-width: 1000px;">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="drugstoreModalLabel{{ $drugstore->id }}">
                                                        <i class="fa fa-pills me-2"></i>
                                                        {{ $drugstore->storename }} - Available Medicines
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body p-4">
                                                    <!-- Search Box -->
                                                    <div class="mb-4">
                                                        <div class="modern-search">
                                                            <div class="input-group">
                                                                <span class="input-group-text">
                                                                    <i class="fas fa-search"></i>
                                                                </span>
                                                                <input type="text" 
                                                                    class="form-control medicine-search" 
                                                                    placeholder="Search medicines by name, description..." 
                                                                    data-drugstore-id="{{ $drugstore->id }}"
                                                                    onkeyup="searchMedicines(this)">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table table-hover align-middle mb-0" 
                                                            id="medicineTable{{ $drugstore->id }}" 
                                                            style="max-width: 95%; margin: 0 auto;">
                                                            <thead class="bg-light">
                                                                <tr>
                                                                    <th class="py-3">Medicine</th>
                                                                    <th class="py-3">Description</th>
                                                                    <th class="py-3">Manufacturing & Expiry</th>
                                                                    <th class="py-3">Price</th>
                                                                    <th class="py-3">Stock</th>
                                                                    <th class="py-3 text-end">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse($drugstore->medicines->where('quantity', '>', 0) as $medicine)
                                                                    <tr>
                                                                        <td>
                                                                            <div class="d-flex align-items-center">
                                                                                @if($medicine->medicine_img)
                                                                                    <img src="{{ asset('storage/' . $medicine->medicine_img) }}"
                                                                                         alt="{{ $medicine->medicine_name }}"
                                                                                         class="rounded me-3"
                                                                                         style="width: 48px; height: 48px; object-fit: cover;">
                                                                                @else
                                                                                    <img src="{{ asset('admin/assets/images/icon/medicine.png') }}"
                                                                                         alt="No Image"
                                                                                         class="rounded me-3"
                                                                                         style="width: 48px; height: 48px; object-fit: cover; opacity: 0.6;">
                                                                                @endif
                                                                                <div>
                                                                                    <div class="fw-bold">{{ $medicine->medicine_name }}</div>
                                                                                    <small class="text-muted">{{ $medicine->generic_name }}</small>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <p class="mb-0 text-muted small">{{ $medicine->description }}</p>
                                                                        </td>
                                                                        <td>
                                                                            <div class="small">
                                                                                <div class="mb-1">
                                                                                    <span class="text-muted">Mfg:</span> 
                                                                                    {{ \Carbon\Carbon::parse($medicine->manufactured_date)->format('M d, Y') }}
                                                                                </div>
                                                                                <div>
                                                                                    @php
                                                                                        $expDate = \Carbon\Carbon::parse($medicine->expiration_date);
                                                                                        $today = \Carbon\Carbon::now();
                                                                                        $daysUntilExpiry = $today->diffInDays($expDate, false);
                                                                                    @endphp
                                                                                    <span class="text-muted">Exp: </span>
                                                                                    {{ $expDate->format('M d, Y') }}
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="fw-bold text-primary">₱{{ number_format($medicine->medicine_price, 2) }}</div>
                                                                        </td>
                                                                        <td>
                                                                            <span class="badge bg-success">{{ $medicine->quantity }} in stock</span>
                                                                        </td>
                                                                        <td class="text-end">
                                                                            <form method="POST" action="{{ route('cart.add') }}" class="d-inline">
                                                                                @csrf
                                                                                <input type="hidden" name="medicine_id" value="{{ $medicine->id }}">
                                                                                <input type="hidden" name="store_id" value="{{ $drugstore->id }}">
                                                                                <input type="hidden" name="quantity" value="1">
                                                                                <button type="submit" class="btn btn-primary">
                                                                                    <i class="fa fa-cart-plus me-2"></i>Add to Cart
                                                                                </button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="4" class="text-center py-4">
                                                                            <img src="{{ asset('admin/assets/images/icon/medicine.png') }}"
                                                                                 alt="No Medicines"
                                                                                 class="mb-3"
                                                                                 style="width: 64px; opacity: 0.6;">
                                                                            <h6 class="text-muted">No Medicines Available</h6>
                                                                        </td>
                                                                    </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="text-center py-5">
                                        <img src="{{ asset('admin/assets/images/icon/pharmacy.png') }}" 
                                             alt="No Drugstores" 
                                             class="mb-3"
                                             style="width: 64px; opacity: 0.6;">
                                        <h4 class="mb-2">No Drugstores Available</h4>
                                        <p class="text-muted">Please check back later for available drugstores</p>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                <!-- Available Drugstores Section end -->

                <!-- Google Maps Section start -->
                <div id="drugstore-location" class="mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-4">Drugstore Locations</h4>
                            <div id="drugstoreMap" style="height: 400px; width: 100%; border-radius: 10px;"></div>
                        </div>
                    </div>
                </div>
                <!-- Google Maps Section end -->

                <!-- row area start-->
            </div>
        </div>
        <!-- main content area end -->
        <!-- footer area start-->
        <footer class="mt-0">
          @include('customer.footer')
        </footer>
        <!-- footer area end-->
    </div>
    <!-- page container area end -->
    <!-- offset area start -->
    <div class="offset-area">
        <div class="offset-close"><i class="ti-close"></i></div>
        <ul class="nav offset-menu-tab">
            <li><a class="active" data-toggle="tab" href="#activity">Activity</a></li>
            <li><a data-toggle="tab" href="#settings">Settings</a></li>
        </ul>
        <div class="offset-content tab-content">
            <div id="activity" class="tab-pane fade in show active">
                <div class="recent-activity">
                    <div class="timeline-task">
                        <div class="icon bg1">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <div class="tm-title">
                            <h4>Rashed sent you an email</h4>
                            <span class="time"><i class="ti-time"></i>09:35</span>
                        </div>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse distinctio itaque at.
                        </p>
                    </div>
                    <div class="timeline-task">
                        <div class="icon bg2">
                            <i class="fa fa-check"></i>
                        </div>
                        <div class="tm-title">
                            <h4>Added</h4>
                            <span class="time"><i class="ti-time"></i>7 Minutes Ago</span>
                        </div>
                        <p>Lorem ipsum dolor sit amet consectetur.
                        </p>
                    </div>
                    <div class="timeline-task">
                        <div class="icon bg2">
                            <i class="fa fa-exclamation-triangle"></i>
                        </div>
                        <div class="tm-title">
                            <h4>You missed you Password!</h4>
                            <span class="time"><i class="ti-time"></i>09:20 Am</span>
                        </div>
                    </div>
                    <div class="timeline-task">
                        <div class="icon bg3">
                            <i class="fa fa-bomb"></i>
                        </div>
                        <div class="tm-title">
                            <h4>Member waiting for you Attention</h4>
                            <span class="time"><i class="ti-time"></i>09:35</span>
                        </div>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse distinctio itaque at.
                        </p>
                    </div>
                    <div class="timeline-task">
                        <div class="icon bg3">
                            <i class="ti-signal"></i>
                        </div>
                        <div class="tm-title">
                            <h4>You Added Kaji Patha few minutes ago</h4>
                            <span class="time"><i class="ti-time"></i>01 minutes ago</span>
                        </div>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse distinctio itaque at.
                        </p>
                    </div>
                    <div class="timeline-task">
                        <div class="icon bg1">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <div class="tm-title">
                            <h4>Ratul Hamba sent you an email</h4>
                            <span class="time"><i class="ti-time"></i>09:35</span>
                        </div>
                        <p>Hello sir , where are you, i am egerly waiting for you.
                        </p>
                    </div>
                    <div class="timeline-task">
                        <div class="icon bg2">
                            <i class="fa fa-exclamation-triangle"></i>
                        </div>
                        <div class="tm-title">
                            <h4>Rashed sent you an email</h4>
                            <span class="time"><i class="ti-time"></i>09:35</span>
                        </div>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse distinctio itaque at.
                        </p>
                    </div>
                    <div class="timeline-task">
                        <div class="icon bg2">
                            <i class="fa fa-exclamation-triangle"></i>
                        </div>
                        <div class="tm-title">
                            <h4>Rashed sent you an email</h4>
                            <span class="time"><i class="ti-time"></i>09:35</span>
                        </div>
                    </div>
                    <div class="timeline-task">
                        <div class="icon bg3">
                            <i class="fa fa-bomb"></i>
                        </div>
                        <div class="tm-title">
                            <h4>Rashed sent you an email</h4>
                            <span class="time"><i class="ti-time"></i>09:35</span>
                        </div>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse distinctio itaque at.
                        </p>
                    </div>
                    <div class="timeline-task">
                        <div class="icon bg3">
                            <i class="ti-signal"></i>
                        </div>
                        <div class="tm-title">
                            <h4>Rashed sent you an email</h4>
                            <span class="time"><i class="ti-time"></i>09:35</span>
                        </div>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse distinctio itaque at.
                        </p>
                    </div>
                </div>
            </div>
            <div id="settings" class="tab-pane fade">
                <div class="offset-settings">
                    <h4>General Settings</h4>
                    <div class="settings-list">
                        <div class="s-settings">
                            <div class="s-sw-title">
                                <h5>Notifications</h5>
                                <div class="s-swtich">
                                    <input type="checkbox" id="switch1" />
                                    <label for="switch1">Toggle</label>
                                </div>
                            </div>
                            <p>Keep it 'On' When you want to get all the notification.</p>
                        </div>
                        <div class="s-settings">
                            <div class="s-sw-title">
                                <h5>Show recent activity</h5>
                                <div class="s-swtich">
                                    <input type="checkbox" id="switch2" />
                                    <label for="switch2">Toggle</label>
                                </div>
                            </div>
                            <p>The for attribute is necessary to bind our custom checkbox with the input.</p>
                        </div>
                        <div class="s-settings">
                            <div class="s-sw-title">
                                <h5>Show your emails</h5>
                                <div class="s-swtich">
                                    <input type="checkbox" id="switch3" />
                                    <label for="switch3">Toggle</label>
                                </div>
                            </div>
                            <p>Show email so that easily find you.</p>
                        </div>
                        <div class="s-settings">
                            <div class="s-sw-title">
                                <h5>Show Task statistics</h5>
                                <div class="s-swtich">
                                    <input type="checkbox" id="switch4" />
                                    <label for="switch4">Toggle</label>
                                </div>
                            </div>
                            <p>The for attribute is necessary to bind our custom checkbox with the input.</p>
                        </div>
                        <div class="s-settings">
                            <div class="s-sw-title">
                                <h5>Notifications</h5>
                                <div class="s-swtich">
                                    <input type="checkbox" id="switch5" />
                                    <label for="switch5">Toggle</label>
                                </div>
                            </div>
                            <p>Use checkboxes when looking for yes or no answers.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- offset area end -->

    <!-- Modern Prescription Modal Styles -->
    <style>
        .modern-modal .modal-content {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .modern-modal .modal-header {
            background: linear-gradient(45deg, #2196F3, #1976D2);
            color: white;
            border-radius: 20px 20px 0 0;
            padding: 1.5rem;
            border: none;
        }

        .modern-modal .modal-title {
            font-size: 1.4rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .modern-modal .btn-close {
            background-color: white;
            opacity: 0.8;
            transition: all 0.3s ease;
        }

        .modern-modal .btn-close:hover {
            opacity: 1;
            transform: rotate(90deg);
        }

        .modern-modal .modal-body {
            padding: 2rem;
        }

        .modern-textarea {
            border: 2px solid #e0e0e0;
            border-radius: 15px;
            padding: 1rem;
            transition: all 0.3s ease;
            font-size: 1rem;
            resize: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
        }

        .modern-textarea:focus {
            border-color: #2196F3;
            box-shadow: 0 0 0 4px rgba(33, 150, 243, 0.1);
        }

        .modern-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.75rem;
            font-size: 1.1rem;
        }

        .modern-helper {
            color: #666;
            font-size: 0.9rem;
            margin-top: 0.75rem;
            padding: 0.75rem;
            background: #f8f9fa;
            border-radius: 10px;
            border-left: 4px solid #2196F3;
        }

        .modern-submit {
            background: linear-gradient(45deg, #2196F3, #1976D2);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 10px;
            color: white;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .modern-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(33, 150, 243, 0.3);
        }

        .modern-cancel {
            background: #f8f9fa;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 10px;
            color: #666;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .modern-cancel:hover {
            background: #e9ecef;
            transform: translateY(-2px);
        }
    </style>

    <!-- Add Prescription Modal -->
    <div class="modal fade" id="addPrescriptionModal" tabindex="-1" aria-labelledby="addPrescriptionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modern-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPrescriptionModalLabel">
                        <i class="fas fa-file-medical"></i>
                        Add Prescription
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="prescriptionForm">
                        <div class="mb-4">
                            <label for="prescriptionDetails" class="modern-label">Prescription Details</label>
                            <textarea class="form-control modern-textarea" id="prescriptionDetails" rows="5" 
                                    placeholder="Enter your prescription details here..." required></textarea>
                            <div class="modern-helper">
                                <i class="fas fa-info-circle me-2"></i>
                                Please enter your prescription details clearly and accurately.
                                Include medicine names, dosage, and any specific instructions.
                            </div>
                        </div>
                        <!-- AI Analysis Results -->
                        <div id="aiAnalysisSection" class="mt-4 d-none">
                            <div class="modern-label d-flex align-items-center gap-2 mb-3">
                                <i class="fas fa-robot text-primary"></i>
                                AI Analysis
                            </div>
                            <div class="modern-analysis-box p-4 rounded-3" style="background: rgba(33, 150, 243, 0.05); border: 1px solid rgba(33, 150, 243, 0.1);">
                                <div id="aiAnalysisSpinner" class="text-center py-3">
                                    <div class="spinner-grow text-primary" style="width: 2rem; height: 2rem;" role="status">
                                        <span class="visually-hidden">Analyzing...</span>
                                    </div>
                                    <div class="mt-3 text-primary fw-500">Analyzing your prescription...</div>
                                </div>
                                <div id="aiAnalysisResult" class="d-none">
                                    <!-- AI analysis will be inserted here -->
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0 gap-2 p-4">
                    <button type="button" class="modern-cancel" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>
                        Cancel
                    </button>
                    <button type="button" class="modern-submit" onclick="submitPrescription()">
                        <i class="fas fa-paper-plane me-2"></i>
                        Submit Prescription
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- jquery latest version -->
   @include('customer.script')

   <!-- Prescription Submit Script -->
   <script>
        let isAnalyzing = false;

        async function analyzePrescription(details) {
            const aiSection = document.getElementById('aiAnalysisSection');
            const aiSpinner = document.getElementById('aiAnalysisSpinner');
            const aiResult = document.getElementById('aiAnalysisResult');
            
            aiSection.classList.remove('d-none');
            aiSpinner.classList.remove('d-none');
            aiResult.classList.add('d-none');
            
            try {
                const response = await fetch('/chat/analyze-prescription', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ prescription: details })
                });

                const data = await response.json();
                
                if (data.success) {
                    aiSpinner.classList.add('d-none');
                    aiResult.classList.remove('d-none');
                    aiResult.innerHTML = `
                        <div class="analysis-content">
                            ${data.analysis.replace(/\n/g, '<br>')}
                        </div>
                    `;
                    return data.analysis;
                } else {
                    throw new Error(data.message);
                }
            } catch (error) {
                aiSpinner.classList.add('d-none');
                aiResult.classList.remove('d-none');
                aiResult.innerHTML = `
                    <div class="text-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        Error analyzing prescription. Please proceed with submission.
                    </div>
                `;
                console.error('AI Analysis Error:', error);
                return null;
            }
        }

        async function submitPrescription() {
            const details = document.getElementById('prescriptionDetails').value;
            if (!details.trim()) {
                alert('Please enter prescription details');
                return;
            }

            // Get the submit button
            const submitBtn = document.querySelector('#addPrescriptionModal .btn-primary');
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin me-2"></i>Processing...';

            try {
                // First, analyze the prescription if not already analyzing
                if (!isAnalyzing) {
                    isAnalyzing = true;
                    const analysis = await analyzePrescription(details);
                    isAnalyzing = false;
                }

                // Get CSRF token
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Send to server
                const response = await fetch('/prescriptions', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        notes: details
                    })
                });

                const data = await response.json();
                
                if (data.success) {
                    // Show success message
                    alert('Prescription submitted successfully!');
                    // Close modal and reset form
                    $('#addPrescriptionModal').modal('hide');
                    document.getElementById('prescriptionForm').reset();
                } else {
                    throw new Error(data.message || 'Error submitting prescription');
                }
            } catch (error) {
                console.error('Error:', error);
                alert(error.message || 'Error submitting prescription. Please try again.');
            } finally {
                // Reset button state
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            }
        }

        // Add event listener for prescription details input
        document.addEventListener('DOMContentLoaded', function() {
            const prescriptionDetails = document.getElementById('prescriptionDetails');
            let typingTimer;
            const doneTypingInterval = 1000; // 1 second

            prescriptionDetails.addEventListener('input', function() {
                clearTimeout(typingTimer);
                if (this.value) {
                    typingTimer = setTimeout(() => {
                        if (!isAnalyzing) {
                            analyzePrescription(this.value);
                        }
                    }, doneTypingInterval);
                }
            });
        });
   </script>
   
   <!-- Checkout Processing Script -->
   <script>
        function generateOrderReference() {
            const timestamp = new Date().getTime().toString().slice(-6);
            const random = Math.floor(Math.random() * 10000).toString().padStart(4, '0');
            return `MED-${timestamp}-${random}`;
        }

        function formatDateTime(date) {
            const options = { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                hour12: true
            };
            return date.toLocaleDateString('en-US', options);
        }

        function showConfirmationModal(referenceNumber) {
            try {
                // Update modal content
                $('#referenceNumber').text(referenceNumber);
                $('#orderDateTime').text(formatDateTime(new Date()));
                
                // Hide checkout modal and show confirmation
                $('#checkoutModal').modal('hide');
                setTimeout(() => {
                    $('#confirmationModal').modal('show');
                }, 500);
            } catch (e) {
                console.error('Error showing confirmation:', e);
                alert('Error generating confirmation. Please try again.');
            }
        }

        function validateStock() {
            const items = {!! json_encode($cartItems ?? []) !!};
            let isValid = true;
            let errorMessage = '';

            items.forEach(item => {
                if (item.quantity > item.medicine.quantity) {
                    isValid = false;
                    errorMessage += `\n- ${item.medicine.medicine_name}: Only ${item.medicine.quantity} available`;
                }
            });

            return { isValid, errorMessage };
        }

        function processCheckout() {
            try {
                // Validate stock first
                const stockValidation = validateStock();
                if (!stockValidation.isValid) {
                    alert('Some items are out of stock:' + stockValidation.errorMessage);
                    return;
                }

                // Get the submit button
                const submitBtn = document.querySelector('#checkoutModal button[type="button"].btn-primary');
                if (!submitBtn) {
                    throw new Error('Submit button not found');
                }

                // Store original button text and disable button
                const originalBtnText = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin me-2"></i>Processing...';
                
                // Get CSRF token
                const tokenElement = document.querySelector('meta[name="csrf-token"]');
                if (!tokenElement) {
                    throw new Error('CSRF token not found');
                }
                const token = tokenElement.getAttribute('content');
                
                // Group items by store
                const itemsByStore = {};
                const items = {!! json_encode($cartItems ?? []) !!};
                
                items.forEach(item => {
                    const storeId = item.store.id;
                    if (!itemsByStore[storeId]) {
                        itemsByStore[storeId] = {
                            items: [],
                            total_amount: 0,
                            store_name: item.store.storename
                        };
                    }
                    itemsByStore[storeId].items.push(item);
                    itemsByStore[storeId].total_amount += item.medicine.medicine_price * item.quantity;
                });

                                // Get pickup date
                                const pickupSelect = document.getElementById('pickupDate');
                                if (!pickupSelect.value) {
                                    alert('Please select a pickup date');
                                    submitBtn.disabled = false;
                                    submitBtn.innerHTML = originalBtnText;
                                    return;
                                }

                                // Calculate pickup date
                                const today = new Date();
                                let pickupDate;
                                if (pickupSelect.value === 'today') {
                                    pickupDate = today;
                                } else if (pickupSelect.value === 'tomorrow') {
                                    pickupDate = new Date(today);
                                    pickupDate.setDate(pickupDate.getDate() + 1);
                                }

                                // Prepare orders data - one order per store
                                const ordersData = Object.entries(itemsByStore).map(([storeId, data]) => ({
                                    customer_id: {{ auth()->id() }},
                                    store_id: parseInt(storeId),
                                    total_amount: data.total_amount,
                                    items: data.items,
                                    store_name: data.store_name
                                }));

                                // Add pickup date to request body
                                const requestBody = {
                                    orders: ordersData,
                                    pickup_date: pickupDate.toISOString()
                                };

                // Send orders to server
                fetch('{{ route("orders.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(requestBody)
                })
                .then(async response => {
                    const data = await response.json();
                    if (!response.ok) {
                        throw new Error(data.message || 'Error creating orders');
                    }
                    return data;
                })
                .then(data => {
                    if (data.success) {
                        // Show confirmation for multiple orders
                        const ordersList = data.orders.map(order => 
                            `<div class="order-item mb-3 p-3 bg-light rounded">
                                                                                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                                                    <div>
                                                                                        <strong>Order #${order.id}</strong>
                                                                                        <div class="text-muted">${order.store_name}</div>
                                                                                        <div class="mt-2 d-flex align-items-center text-info">
                                                                                            <i class="fa fa-calendar-alt me-2"></i>
                                                                                            <span>Pickup: ${pickupSelect.value === 'today' ? 'Today (Before closing time)' : 'Tomorrow'}</span>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="text-end">
                                                                                        <div class="text-success fw-bold">₱${order.total_amount.toFixed(2)}</div>
                                                                                    </div>
                                                                                </div>
                            </div>`
                        ).join('');

                        // Calculate grand total
                        const grandTotal = data.orders.reduce((sum, order) => sum + order.total_amount, 0);

                        // Update modal content
                        document.querySelector('#confirmationModalBody').innerHTML = `
                            <div class="text-center mb-4">
                                <div class="mb-3">
                                    <i class="fa fa-shopping-bag text-success fa-3x"></i>
                                </div>
                                <h4 class="text-success mb-4">Thank you for your reservation!</h4>
                                                                <div class="alert alert-warning">
                                                                    <i class="fa fa-info-circle me-2"></i>
                                                                    Please take a screenshot of this confirmation and present it at each pharmacy counter during your scheduled pickup time.
                                                                </div>
                                                                <div class="alert alert-info">
                                                                    <i class="fa fa-clock me-2"></i>
                                                                    Your reservation will be automatically voided if not picked up by the end of your scheduled pickup day.
                                                                </div>
                            </div>
                            <div class="orders-list">
                                <h5 class="mb-3">Your Orders:</h5>
                                ${ordersList}
                                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                                    <h5 class="mb-0">Grand Total:</h5>
                                    <h4 class="mb-0 text-success">₱${grandTotal.toFixed(2)}</h4>
                                </div>
                            </div>
                        `;

                        // Force close the checkout modal and clean up
                        const checkoutModal = document.getElementById('checkoutModal');
                        checkoutModal.style.display = 'none';
                        checkoutModal.classList.remove('show');
                        document.body.classList.remove('modal-open');
                        const backdrops = document.getElementsByClassName('modal-backdrop');
                        while(backdrops.length > 0) {
                            backdrops[0].parentNode.removeChild(backdrops[0]);
                        }

                        // Then update confirmation modal content and show it after cleanup
                        setTimeout(() => {
                            document.querySelector('#confirmationModalBody').innerHTML = `
                                <div class="text-center mb-4">
                                    <div class="mb-3">
                                        <i class="fa fa-shopping-bag text-success fa-3x"></i>
                                    </div>
                                    <h4 class="text-success mb-4">Thank you for your reservation!</h4>
                                    <div class="alert alert-warning">
                                        <i class="fa fa-info-circle me-2"></i>
                                        Please take a screenshot of this confirmation and present it at each pharmacy counter during your scheduled pickup time.
                                    </div>
                                    <div class="alert alert-info">
                                        <i class="fa fa-clock me-2"></i>
                                        Your reservation will be automatically voided if not picked up by the end of your scheduled pickup day.
                                    </div>
                                </div>
                                <div class="orders-list">
                                    <h5 class="mb-3">Your Orders:</h5>
                                    ${ordersList}
                                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                                        <h5 class="mb-0">Grand Total:</h5>
                                        <h4 class="mb-0 text-success">₱${grandTotal.toFixed(2)}</h4>
                                    </div>
                                </div>
                            `;
                            $('#confirmationModal').modal('show');
                        }, 500);
                    } else {
                        throw new Error(data.message || 'Error creating orders');
                    }
                })
                .catch(error => {
                    console.error('Checkout error:', error);
                    alert(error.message || 'Error processing checkout. Please try again.');
                    // Restore button state
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                });
            } catch (e) {
                console.error('Checkout error:', e);
                alert(e.message || 'Error processing checkout. Please try again.');
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText || 'Place Order';
                }
            }
        }

        // Initialize modals and event handlers
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize modals with Bootstrap 5
            const checkoutModalEl = document.getElementById('checkoutModal');
            const confirmationModalEl = document.getElementById('confirmationModal');
            
            // Set modal options
            const modalOptions = {
                backdrop: 'static',
                keyboard: false
            };
            
            // Create modal instances
            const checkoutModal = new bootstrap.Modal(checkoutModalEl, modalOptions);
            const confirmationModal = new bootstrap.Modal(confirmationModalEl, modalOptions);

            // Add click handler for place order button
            const placeOrderBtn = document.getElementById('placeOrderBtn');
            if (placeOrderBtn) {
                placeOrderBtn.addEventListener('click', processCheckout);
            }
        });
   </script>

   <!-- Cart Update Script -->
   <script>
        function updateQuantity(medicineId, newQuantity) {
            // Get CSRF token
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Disable buttons during update
            const buttons = document.querySelectorAll('button');
            buttons.forEach(btn => btn.disabled = true);
            
            // Send request
            fetch('{{ route("cart.update") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    medicine_id: medicineId,
                    quantity: newQuantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update quantity display without page refresh
                    const quantityInput = document.querySelector(`button[onclick*="${medicineId}"]`).parentElement.querySelector('input');
                    quantityInput.value = newQuantity;
                    
                    // Update total price (you'll need to add this functionality)
                    // For now, we'll reload the page
                    window.location.reload();
                } else {
                    alert(data.message || 'Error updating quantity');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating quantity. Please try again.');
            })
            .finally(() => {
                // Re-enable buttons
                buttons.forEach(btn => btn.disabled = false);
            });
        }
   </script>
   
   <!-- Add to Cart Script -->
   <script>
        function handleAddToCart(event, form) {
            event.preventDefault();
            
            // Disable button and show loading state
            const button = form.querySelector('.add-to-cart-btn');
            const btnText = button.querySelector('.btn-text');
            const originalText = btnText.textContent;
            button.disabled = true;
            btnText.textContent = 'Adding...';

            // Submit form
            fetch(form.action, {
                method: 'POST',
                body: new FormData(form)
            })
            .then(response => response.text())
            .then(() => {
                // Show success state
                btnText.textContent = 'Added ✓';
                setTimeout(() => {
                    // Refresh page to update cart
                    window.location.reload();
                }, 1000);
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error adding to cart. Please try again.');
                button.disabled = false;
                btnText.textContent = originalText;
            });
        }
   
   <!-- Smooth Scrolling Script -->
   <script>
       document.addEventListener('DOMContentLoaded', function() {
           // Get all navigation links
           const navLinks = document.querySelectorAll('a[href^="#"]');
           
           // Add click event listener to each link
           navLinks.forEach(link => {
               link.addEventListener('click', function(e) {
                   e.preventDefault();
                   
                   // Get the target element
                   const targetId = this.getAttribute('href');
                   const targetElement = document.querySelector(targetId);
                   
                   if (targetElement) {
                       // Add offset for fixed header
                       const headerOffset = 80;
                       const elementPosition = targetElement.getBoundingClientRect().top;
                       const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                       
                       // Smooth scroll to target
                       window.scrollTo({
                           top: offsetPosition,
                           behavior: 'smooth'
                       });
                       
                       // Update active state in navigation
                       navLinks.forEach(link => link.classList.remove('active'));
                       this.classList.add('active');
                   }
               });
           });
           
           // Add scroll spy to update active state
           window.addEventListener('scroll', function() {
               let current = '';
               const sections = document.querySelectorAll('div[id]');
               
               sections.forEach(section => {
                   const sectionTop = section.offsetTop;
                   if (window.pageYOffset >= sectionTop - 100) {
                       current = section.getAttribute('id');
                   }
               });
               
               navLinks.forEach(link => {
                   link.classList.remove('active');
                   if (link.getAttribute('href') === `#${current}`) {
                       link.classList.add('active');
                   }
               });
           });
       });
   </script>

   <!-- Dynamic Search Script -->
   <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInputs = document.querySelectorAll('.search-medicine');
            let debounceTimer;

            searchInputs.forEach(searchInput => {
                const searchResults = searchInput.nextElementSibling;

                // Handle input event with debounce
                searchInput.addEventListener('input', function() {
                    const query = this.value.trim();
                    
                    // Clear previous timer
                    clearTimeout(debounceTimer);

                    if (query.length < 2) {
                        searchResults.classList.add('d-none');
                        searchResults.innerHTML = '';
                        return;
                    }

                    // Set new timer
                    debounceTimer = setTimeout(() => {
                        performSearch(query, searchResults);
                    }, 300);
                });

                // Close results when clicking outside
                document.addEventListener('click', function(e) {
                    if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                        searchResults.classList.add('d-none');
                    }
                });

                // Show results when focusing on input
                searchInput.addEventListener('focus', function() {
                    if (this.value.trim().length >= 2) {
                        searchResults.classList.remove('d-none');
                    }
                });
            });

            function performSearch(query, resultsContainer) {
                fetch(`/search-medicines?query=${encodeURIComponent(query)}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        const resultsHtml = data.map(medicine => `
                            <div class="search-result-item" onclick="showDrugstoreModal(${medicine.drugstore.id})">
                                <img src="${medicine.image}" alt="${medicine.medicine_name}">
                                <div class="search-result-info">
                                    <div class="search-result-name">${medicine.medicine_name}</div>
                                    <div class="search-result-generic">${medicine.generic_name}</div>
                                    <div class="search-result-store">
                                        <i class="fa fa-store me-1"></i>${medicine.drugstore.name}
                                    </div>
                                </div>
                                <div class="search-result-price">₱${typeof medicine.medicine_price === 'number' ? medicine.medicine_price.toFixed(2) : medicine.medicine_price}</div>
                            </div>
                        `).join('');

                        resultsContainer.innerHTML = resultsHtml;
                        resultsContainer.classList.remove('d-none');
                    } else {
                        resultsContainer.innerHTML = `
                            <div class="no-results">
                                <i class="fa fa-search me-2"></i>No medicines found
                            </div>
                        `;
                        resultsContainer.classList.remove('d-none');
                    }
                })
                .catch(error => {
                    console.error('Search error:', error);
                    resultsContainer.innerHTML = `
                        <div class="no-results text-danger">
                            <i class="fa fa-exclamation-circle me-2"></i>Error searching medicines
                        </div>
                    `;
                    resultsContainer.classList.remove('d-none');
                });
            }

            function showDrugstoreModal(drugstoreId) {
                // Find and open the drugstore modal
                const modalId = `drugstoreModal${drugstoreId}`;
                const modal = document.getElementById(modalId);
                if (modal) {
                    $(modal).modal('show');
                }
            }
        });
   </script>

       <!-- Search Medicines Function -->
    <script>
        function searchMedicines(input) {
            const drugstoreId = input.getAttribute('data-drugstore-id');
            const searchValue = input.value.toLowerCase();
            const table = document.getElementById('medicineTable' + drugstoreId);
            const rows = table.getElementsByTagName('tr');

            // Skip header row
            for (let i = 1; i < rows.length; i++) {
                const row = rows[i];
                const medicineName = row.getElementsByTagName('td')[0]?.textContent.toLowerCase() || '';
                const description = row.getElementsByTagName('td')[1]?.textContent.toLowerCase() || '';
                
                if (medicineName.includes(searchValue) || description.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        }
    </script>

    <!-- Google Maps Script -->
    <script>
        let map;
        let geocoder;
        let markers = [];
        let activeInfoWindow = null;
        let bounds;
        let userLocation = null;

        // Function to calculate distance between two points
        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371; // Radius of the earth in km
            const dLat = deg2rad(lat2 - lat1);
            const dLon = deg2rad(lon2 - lon1);
            const a = 
                Math.sin(dLat/2) * Math.sin(dLat/2) +
                Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
                Math.sin(dLon/2) * Math.sin(dLon/2); 
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
            const distance = R * c; // Distance in km
            return distance.toFixed(2);
        }

        function deg2rad(deg) {
            return deg * (Math.PI/180);
        }

        // Function to get user's current location
        let userMarker = null;  // Variable to store user's location marker

        function getUserLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        userLocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        
                        // Remove existing user marker if it exists
                        if (userMarker) {
                            userMarker.setMap(null);
                        }

                        // Add new marker for user's location
                        userMarker = new google.maps.Marker({
                            position: userLocation,
                            map: map,
                            title: 'Your Location',
                            icon: {
                                url: 'https://maps.google.com/mapfiles/ms/icons/blue-dot.png', // Blue marker for user
                                scaledSize: new google.maps.Size(32, 32)
                            },
                            animation: google.maps.Animation.DROP,
                            zIndex: 999 // Ensure user marker stays on top
                        });

                        // Add info window for user marker
                        const userInfoWindow = new google.maps.InfoWindow({
                            content: '<div style="padding: 8px;"><strong>Your Current Location</strong></div>'
                        });

                        userMarker.addListener('click', () => {
                            if (activeInfoWindow) {
                                activeInfoWindow.close();
                            }
                            userInfoWindow.open(map, userMarker);
                            activeInfoWindow = userInfoWindow;
                        });

                        // Extend bounds to include user location
                        bounds.extend(userLocation);
                        map.fitBounds(bounds);

                        // Update distances for all markers
                        updateDistances();
                    },
                    (error) => {
                        console.error("Error getting location:", error);
                        alert("Please enable location services to see your position on the map.");
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 5000,
                        maximumAge: 0
                    }
                );
            }
        }

        function initMap() {
            // Default center (Philippines)
            const defaultCenter = { lat: 12.8797, lng: 121.7740 };

            // Create the map
            map = new google.maps.Map(document.getElementById("drugstoreMap"), {
                zoom: 6,
                center: defaultCenter,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                mapTypeControl: true,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                    position: google.maps.ControlPosition.TOP_RIGHT
                },
                zoomControl: true,
                zoomControlOptions: {
                    position: google.maps.ControlPosition.RIGHT_CENTER
                },
                scaleControl: true,
                streetViewControl: true,
                streetViewControlOptions: {
                    position: google.maps.ControlPosition.RIGHT_BOTTOM
                },
                fullscreenControl: true
            });

            // Initialize geocoder and bounds
            geocoder = new google.maps.Geocoder();
            bounds = new google.maps.LatLngBounds();

            // Get user's location and update distances
            getUserLocation();

            @foreach($drugstores ?? [] as $drugstore)
                @if($drugstore->latitude && $drugstore->longitude)
                    const position = new google.maps.LatLng(
                        {{ $drugstore->latitude }}, 
                        {{ $drugstore->longitude }}
                    );
                @else
                    geocoder.geocode(
                        { address: "{{ $drugstore->storeaddress }}, Philippines" },
                        function(results, status) {
                            if (status === "OK" && results[0]) {
                                const position = results[0].geometry.location;
                @endif
                            
                            // Create marker
                            const marker = new google.maps.Marker({
                                map: map,
                                position: position,
                                title: "{{ $drugstore->storename }}",
                                animation: google.maps.Animation.DROP,
                                icon: {
                                    url: 'https://maps.google.com/mapfiles/ms/icons/red-dot.png'
                                }
                            });

                            markers.push(marker);
                            bounds.extend(position);

                            // Function to update distances for all markers
                            function updateDistances() {
                                if (!userLocation) return;
                                
                                markers.forEach(marker => {
                                    const position = marker.getPosition();
                                    const distance = calculateDistance(
                                        userLocation.lat,
                                        userLocation.lng,
                                        position.lat(),
                                        position.lng()
                                    );
                                    
                                    // Update info window content with distance
                                    const infoWindow = marker.infoWindow;
                                    if (infoWindow) {
                                        const content = infoWindow.getContent();
                                        const distanceHtml = `<p class="distance-info">Distance: ${distance} km</p>`;
                                        if (!content.includes('distance-info')) {
                                            infoWindow.setContent(content + distanceHtml);
                                        }
                                    }
                                });
                            }

                            // Calculate distance if user location is available
                            let distanceText = '';
                            if (navigator.geolocation) {
                                navigator.geolocation.getCurrentPosition(
                                    (userPosition) => {
                                        const userLat = userPosition.coords.latitude;
                                        const userLng = userPosition.coords.longitude;
                                        const storeLat = position.lat();
                                        const storeLng = position.lng();
                                        
                                        // Calculate distance using Haversine formula
                                        const R = 6371; // Radius of the earth in km
                                        const dLat = (storeLat - userLat) * Math.PI / 180;
                                        const dLon = (storeLng - userLng) * Math.PI / 180;
                                        const a = 
                                            Math.sin(dLat/2) * Math.sin(dLat/2) +
                                            Math.cos(userLat * Math.PI / 180) * Math.cos(storeLat * Math.PI / 180) * 
                                            Math.sin(dLon/2) * Math.sin(dLon/2); 
                                        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
                                        const distance = (R * c).toFixed(2);
                                        distanceText = `<p style="margin: 8px 0; color: #28a745; font-size: 14px;"><i class="fa fa-route"></i> ${distance} km away</p>`;
                                    }
                                );
                            }

                            // Create info window content
                            const contentString = `
                                <div class="card" style="border: none; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                    <div class="card-body" style="padding: 15px;">
                                        <h5 class="card-title" style="font-size: 18px; font-weight: 600; margin-bottom: 10px;">{{ $drugstore->storename }}</h5>
                                        <div class="card-text">
                                            <p style="margin: 0 0 8px; color: #666;">
                                                <i class="fa fa-map-marker-alt text-danger"></i> {{ $drugstore->storeaddress }}
                                            </p>
                                            ${distanceText}
                                            <p style="margin: 8px 0 0; color: #666;">
                                                <i class="fa fa-clock text-primary"></i> {{ $drugstore->operatingdays }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                    </p>
                                    <p style="margin: 0; color: #666; font-size: 0.9em;">
                                        <i class="fa fa-clock text-primary"></i> {{ $drugstore->operatingdays }}
                                    </p>
                                </div>
                            `;

                            // Create info window
                            const infowindow = new google.maps.InfoWindow({
                                content: contentString,
                                maxWidth: 300
                            });

                            // Update info window with distance when opened
                            marker.addListener('click', () => {
                                if (navigator.geolocation) {
                                    navigator.geolocation.getCurrentPosition(
                                        (userPosition) => {
                                            const userLat = userPosition.coords.latitude;
                                            const userLng = userPosition.coords.longitude;
                                            const storeLat = position.lat();
                                            const storeLng = position.lng();
                                            
                                            // Calculate distance using Haversine formula
                                            const R = 6371; // Radius of the earth in km
                                            const dLat = (storeLat - userLat) * Math.PI / 180;
                                            const dLon = (storeLng - userLng) * Math.PI / 180;
                                            const a = 
                                                Math.sin(dLat/2) * Math.sin(dLat/2) +
                                                Math.cos(userLat * Math.PI / 180) * Math.cos(storeLat * Math.PI / 180) * 
                                                Math.sin(dLon/2) * Math.sin(dLon/2); 
                                            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
                                            const distance = (R * c).toFixed(2);

                                            // Update info window content with distance
                                            const updatedContent = `
                                                <div class="card" style="border: none; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                                    <div class="card-body" style="padding: 15px;">
                                                        <h5 class="card-title" style="font-size: 18px; font-weight: 600; margin-bottom: 10px;">{{ $drugstore->storename }}</h5>
                                                        <div class="card-text">
                                                            <p style="margin: 0 0 8px; color: #666;">
                                                                <i class="fa fa-map-marker-alt text-danger"></i> {{ $drugstore->storeaddress }}
                                                            </p>
                                                            <p style="margin: 8px 0; color: #28a745; font-size: 14px;">
                                                                <i class="fa fa-route"></i> ${distance} km away
                                                            </p>
                                                            <p style="margin: 8px 0 0; color: #666;">
                                                                <i class="fa fa-clock text-primary"></i> {{ $drugstore->operatingdays }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            `;
                                            infowindow.setContent(updatedContent);
                                            infowindow.open(map, marker);
                                        },
                                        (error) => {
                                            console.error("Error getting location:", error);
                                            infowindow.open(map, marker);
                                        }
                                    );
                                } else {
                                    infowindow.open(map, marker);
                                }
                            });

                            // Close previously opened info window when clicking a new marker
                            marker.addListener("click", () => {
                                if (activeInfoWindow) {
                                    activeInfoWindow.close();
                                }
                                activeInfoWindow = infowindow;
                                infowindow.open(map, marker);
                                activeInfoWindow = infowindow;
                            });

                            // Fit map to bounds after adding marker
                            @if(!$drugstore->latitude || !$drugstore->longitude)
                                if (markers.length === 1) {
                                    map.setCenter(position);
                                    map.setZoom(15);
                                } else {
                                    map.fitBounds(bounds);
                                }
                            }
                        }
                    );
                @else
                    if (markers.length === 1) {
                        map.setCenter(position);
                        map.setZoom(15);
                    } else {
                        map.fitBounds(bounds);
                    }
                @endif
            @endforeach

            // Add click listener to map to close active info window
            map.addListener("click", function() {
                if (activeInfoWindow) {
                    activeInfoWindow.close();
                }
            });
        }
   </script>
   <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAUXAVO-jgzu0AwNfawYdtWep3cbHFoHZ0&callback=initMap">
   </script>
</body>

</html>

