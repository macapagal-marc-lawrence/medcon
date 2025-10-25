<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('drugstore.css')
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
    <div class="page-container">
        <!-- sidebar menu area start -->
      @include('drugstore.sidebar')
        <!-- sidebar menu area end -->
        <!-- main content area start -->
        <div class="main-content">
            <!-- header area start -->
        @include('drugstore.dashboard-header')
            <!-- header area end -->
            <!-- page title area start -->
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left">Dashboard</h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="index.html">Home</a></li>
                                <li><span>Dashboard</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6 clearfix">
                      <div class="user-profile pull-right">
                        <img class="avatar user-thumb" src="{{ asset('admin/assets/images/author/avatar.png') }}" alt="avatar">
                        <h4 class="user-name dropdown-toggle" data-toggle="dropdown">
                            {{ Auth::user()->username }} <i class="fa fa-angle-down"></i>
                        </h4>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('drugstore.profile') }}">
                                <i class="fa fa-user mr-2"></i> Profile
                            </a>
                            <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                                @csrf
                            </form>
                            <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out mr-2"></i> {{ __('Log Out') }}
                            </a>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
            <!-- page title area end -->
            <div class="main-content-inner">
                @if(!empty($debugInfo))
    <div class="alert alert-info" style="position: sticky; top: 0; z-index: 999;">
        <strong>Debug:</strong>
        storeId={{ $debugInfo['storeId'] }},
        prescriptions(total)={{ $debugInfo['prescTotal'] }},
        onPage={{ $debugInfo['pageCount'] }}
    </div>
@endif

                <!-- Quick Stats -->
                <div class="row mt-5">
                    <!-- Total Medicines -->
                    <div class="col-md-3 col-sm-6">
                        <div class="card bg-primary text-white mb-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">Total Medicines</h6>
                                        <h2 class="mb-0">{{ $totalMedicines ?? 0 }}</h2>
                                    </div>
                                    <div class="icon-shape rounded-circle bg-white text-primary p-3">
                                        <i class="fa fa-medkit fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="{{ route('drugstore.view') }}">View Details</a>
                                <div class="small text-white"><i class="fa fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>

                    <!-- Low Stock Alert -->
                    <div class="col-md-3 col-sm-6">
                        <div class="card bg-warning text-white mb-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">Low Stock Items</h6>
                                        <h2 class="mb-0">{{ $lowStockCount ?? 0 }}</h2>
                                    </div>
                                    <div class="icon-shape rounded-circle bg-white text-warning p-3">
                                        <i class="fa fa-exclamation-triangle fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="#">View Details</a>
                                <div class="small text-white"><i class="fa fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Orders -->
                    <div class="col-md-3 col-sm-6">
                        <div class="card bg-success text-white mb-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">Pending Orders</h6>
                                        <h2 class="mb-0">{{ $pendingOrders ?? 0 }}</h2>
                                    </div>
                                    <div class="icon-shape rounded-circle bg-white text-success p-3">
                                        <i class="fa fa-shopping-cart fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="#">View Details</a>
                                <div class="small text-white"><i class="fa fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>

                    <!-- Today's Revenue -->
                    <div class="col-md-3 col-sm-6">
                        <div class="card bg-info text-white mb-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">Total Sales</h6>
                                        <h2 class="mb-0" id="totalSales">₱{{ number_format($todayRevenue ?? 0, 2) }}</h2>
                                    </div>
                                    <div class="icon-shape rounded-circle bg-white text-info p-3">
                                        <i class="fa fa-money fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="#">View Details</a>
                                <div class="small text-white"><i class="fa fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Inventory Alerts -->
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-header bg-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Inventory Alerts</h5>
                                    <a href="#" class="btn btn-sm btn-primary">View All</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Medicine</th>
                                                <th>Current Stock</th>
                                                <th>Status</th>
                                                <th>Expiration</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($lowStockMedicines ?? [] as $medicine)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if($medicine->medicine_img)
                                                            <img src="{{ asset('storage/' . $medicine->medicine_img) }}" 
                                                                alt="{{ $medicine->medicine_name }}" 
                                                                class="rounded-circle mr-2"
                                                                style="width: 40px; height: 40px; object-fit: cover;">
                                                        @else
                                                            <div class="rounded-circle bg-light mr-2 d-flex align-items-center justify-content-center" 
                                                                style="width: 40px; height: 40px;">
                                                                <i class="fa fa-medkit text-muted"></i>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <h6 class="mb-0">{{ $medicine->medicine_name }}</h6>
                                                            <small class="text-muted">{{ $medicine->generic_name }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge badge-pill badge-warning">
                                                        {{ $medicine->quantity }} units
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($medicine->quantity == 0)
                                                        <span class="badge badge-danger">Out of Stock</span>
                                                    @else
                                                        <span class="badge badge-warning">Low Stock</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        $expirationDate = \Carbon\Carbon::parse($medicine->expiration_date);
                                                        $daysUntilExpiration = now()->diffInDays($expirationDate, false);
                                                    @endphp
                                                    
                                                    @if($daysUntilExpiration < 0)
                                                        <span class="badge badge-danger">Expired</span>
                                                    @elseif($daysUntilExpiration <= 30)
                                                        <span class="badge badge-warning">
                                                            Expires in {{ (int)$daysUntilExpiration }} days
                                                        </span>
                                                    @else
                                                        <span class="badge badge-success">
                                                            {{ $expirationDate->format('M d, Y') }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('drugstore.editMedicine', $medicine->id) }}" 
                                                        class="btn btn-sm btn-outline-primary">
                                                        Update Stock
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<!-- Submitted Prescriptions -->
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header bg-white">
        <div class="d-flex align-items-center">
          <h5 class="mb-0">Submitted Prescriptions</h5>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Description / Note</th>
                <th>Status</th>
                <th>Date Sent</th>
                <th>File</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse(($recentPrescriptions ?? collect()) as $pres)


                <tr>
                  <td>#{{ $pres->id }}</td>
                  <td>{{ $pres->customer->user->username ?? 'N/A' }}</td>
                  <td>{{ $pres->description ?? '—' }}</td>
                  <td>
                    @if($pres->status == 'approved')
                      <span class="badge badge-success">Approved</span>
                    @elseif($pres->status == 'rejected')
                      <span class="badge badge-danger">Rejected</span>
                    @else
                      <span class="badge badge-secondary">Pending</span>
                    @endif
                  </td>
                  <td>{{ $pres->created_at->format('M d, Y h:i A') }}</td>
                  <td>
                    <a href="{{ asset('storage/'.$pres->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                      <i class="fa fa-file"></i> View
                    </a>
                  </td>
                  <td>
                    @if($pres->status === 'pending')
                      <div class="btn-group">
                        <button type="button" 
                                class="btn btn-success btn-sm approve-prescription" 
                                data-prescription-id="{{ $pres->id }}">
                          <i class="fa fa-check"></i> Approve
                        </button>
                        <button type="button" 
                                class="btn btn-danger btn-sm reject-prescription" 
                                data-prescription-id="{{ $pres->id }}">
                          <i class="fa fa-times"></i> Reject
                        </button>
                      </div>
                    @elseif($pres->status === 'approved')
                      <span class="text-success">
                        <i class="fa fa-check-circle"></i> Approved
                      </span>
                    @elseif($pres->status === 'rejected')
                      <span class="text-danger">
                        <i class="fa fa-times-circle"></i> Rejected
                      </span>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7" class="text-center">No prescriptions found</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

     {{-- Pagination --}}
@if(!empty($recentPrescriptions) && 
    $recentPrescriptions instanceof \Illuminate\Pagination\LengthAwarePaginator && 
    $recentPrescriptions->hasPages())
    <div class="d-flex justify-content-center mt-3">
        {!! $recentPrescriptions->links('pagination::bootstrap-4') !!}
    </div>
@endif

      </div>
    </div>
  </div>
</div>

                <!-- Recent Pending Orders -->
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-header bg-white">
                                <div class="d-flex align-items-center">
                                    <h5 class="mb-0">Recent Orders</h5>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Customer</th>
                                                <th>Items</th>
                                                <th>Total Amount</th>
                                                <th>Pickup Date</th>
                                                <th>Pickup Deadline</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($recentOrders as $order)
                                                <tr>
                                                    <td>#{{ $order->id }}</td>
                                                    <td>{{ $order->customer->user->username }}</td>
                                                    <td>
                                                        <div class="medicines-list">
                                                            @foreach($order->items as $item)
                                                                <div class="medicine-item">
                                                                    <span class="medicine-name">{{ $item->medicine->medicine_name }}</span>
                                                                    <span class="medicine-qty">({{ $item->quantity }})</span>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                    <td>₱{{ number_format($order->total_amount, 2) }}</td>
                                                    <td>{{ $order->scheduled_pickup_date->format('M d, Y h:i A') }}</td>
                                                    <td>{{ $order->pickup_deadline->format('M d, Y h:i A') }}</td>
                                                    <td>
                                                        @if($order->status === 'pending')
                                                            <div class="btn-group">
                                                                <button type="button" 
                                                                        class="btn btn-success btn-sm approve-order" 
                                                                        data-order-id="{{ $order->id }}">
                                                                    <i class="fa fa-check"></i> Approve
                                                                </button>
                                                                <button type="button" 
                                                                        class="btn btn-danger btn-sm reject-order" 
                                                                        data-order-id="{{ $order->id }}">
                                                                    <i class="fa fa-times"></i> Reject
                                                                </button>
                                                            </div>
                                                        @elseif($order->status === 'approved')
                                                            <span class="text-success">
                                                                <i class="fa fa-check-circle"></i> Approved
                                                            </span>
                                                        @elseif($order->status === 'rejected')
                                                            <span class="text-danger">
                                                                <i class="fa fa-times-circle"></i> Rejected
                                                            </span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">No pending orders found</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-3">
                                    <div class="text-muted mb-2">
                                        Total Pending Orders: {{ $pendingOrders }}
                                    </div>
                                    @if($recentOrders instanceof \Illuminate\Pagination\LengthAwarePaginator && $recentOrders->hasPages())
                                    <div class="d-flex justify-content-center">
                                        {!! $recentOrders->links('pagination::bootstrap-4') !!}
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sales Analytics -->
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-header bg-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Sales Analytics</h5>
                                </div>
                            </div>
                            <div class="card-body">
                                <div style="height: 400px;">
                                    <canvas id="salesChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    var salesChart;

                    function updateChart(data) {
                        var dates = [];
                        var totals = [];
                        
                        if (data && data.length > 0) {
                            dates = data.map(function(item) {
                                return new Date(item.date).toLocaleDateString('en-US', { 
                                    month: 'short', 
                                    day: 'numeric' 
                                });
                            });
                            totals = data.map(function(item) {
                                return Number(item.total);
                            });
                        } else {
                            // If no data, show last 7 days with zero values
                            for (var i = 6; i >= 0; i--) {
                                var date = new Date();
                                date.setDate(date.getDate() - i);
                                dates.push(date.toLocaleDateString('en-US', { 
                                    month: 'short', 
                                    day: 'numeric' 
                                }));
                                totals.push(0);
                            }
                        }

                        if (salesChart) {
                            salesChart.data.labels = dates;
                            salesChart.data.datasets[0].data = totals;
                            salesChart.update();
                        }
                    }

                    function updateTotalSales() {
                        $.ajax({
                            url: '{{ route("drugstore.getTotalSales") }}',
                            type: 'GET',
                            success: function(response) {
                                if (response.success) {
                                    $('#totalSales').text('₱' + parseFloat(response.total).toLocaleString(undefined, {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    }));
                                }
                            },
                            error: function(xhr) {
                                console.error('Error fetching total sales:', xhr);
                            }
                        });
                    }

                    function fetchSalesData() {
                        $.ajax({
                            url: '{{ route("drugstore.getSalesData") }}',
                            type: 'GET',
                            success: function(response) {
                                if (response.success) {
                                    updateChart(response.data);
                                    updateTotalSales(); // Update total sales when chart updates
                                }
                            },
                            error: function(xhr) {
                                console.error('Error fetching sales data:', xhr);
                            }
                        });
                    }

                    // Initialize the chart and start auto-refresh
                    document.addEventListener('DOMContentLoaded', function() {
                        var ctx = document.getElementById('salesChart').getContext('2d');
                        
                        var gradientFill = ctx.createLinearGradient(0, 0, 0, 400);
                        gradientFill.addColorStop(0, 'rgba(54, 162, 235, 0.3)');
                        gradientFill.addColorStop(1, 'rgba(54, 162, 235, 0)');
                        
                        // Initialize with empty data
                        var initialDates = [];
                        var initialTotals = [];
                        
                        // Show last 7 days with zero values initially
                        for (var i = 6; i >= 0; i--) {
                            var date = new Date();
                            date.setDate(date.getDate() - i);
                            initialDates.push(date.toLocaleDateString('en-US', { 
                                month: 'short', 
                                day: 'numeric' 
                            }));
                            initialTotals.push(0);
                        }
                        
                        // Create the chart
                        salesChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: initialDates,
                                datasets: [{
                                    label: 'Daily Sales',
                                    data: initialTotals,
                                    fill: true,
                                    backgroundColor: gradientFill,
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 3,
                                    pointBackgroundColor: '#ffffff',
                                    pointBorderColor: 'rgba(54, 162, 235, 1)',
                                    pointBorderWidth: 2,
                                    pointRadius: 6,
                                    pointHoverRadius: 8,
                                    tension: 0.4
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        grid: {
                                            drawBorder: false,
                                            color: 'rgba(200, 200, 200, 0.2)'
                                        },
                                        ticks: {
                                            font: {
                                                size: 12
                                            },
                                            callback: function(value) {
                                                return '₱' + value.toLocaleString();
                                            }
                                        }
                                    },
                                    x: {
                                        grid: {
                                            display: false
                                        },
                                        ticks: {
                                            font: {
                                                size: 12
                                            }
                                        }
                                    }
                                },
                                plugins: {
                                    legend: {
                                        display: false
                                    },
                                    tooltip: {
                                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                        titleFont: {
                                            size: 13
                                        },
                                        bodyFont: {
                                            size: 13
                                        },
                                        padding: 12,
                                        displayColors: false,
                                        callbacks: {
                                            label: function(context) {
                                                return '₱' + context.parsed.y.toLocaleString();
                                            }
                                        }
                                    }
                                },
                                interaction: {
                                    intersect: false,
                                    mode: 'index'
                                }
                            }
                        });

                        // Load initial data
                        fetchSalesData();
                        
                        // Auto-refresh every 30 seconds
                        setInterval(fetchSalesData, 30000);
                    });
                </script>

                <style>
                    .icon-shape {
                        display: inline-flex;
                        align-items: center;
                        justify-content: center;
                        text-align: center;
                        vertical-align: middle;
                    }
                    
                    .card-footer {
                        background-color: rgba(0, 0, 0, 0.1);
                    }
                    
                    .stretched-link::after {
                        position: absolute;
                        top: 0;
                        right: 0;
                        bottom: 0;
                        left: 0;
                        z-index: 1;
                        content: "";
                    }
                    
                    .badge {
                        padding: 0.5em 0.75em;
                    }
                    
                    .table td {
                        vertical-align: middle;
                    }

                    .medicines-list {
                        max-height: 100px;
                        overflow-y: auto;
                    }

                    .medicine-item {
                        padding: 2px 0;
                        font-size: 0.9rem;
                    }

                    .medicine-name {
                        font-weight: 500;
                    }

                    .medicine-qty {
                        color: #666;
                        margin-left: 4px;
                    }
                </style>
            </div>
        </div>
        <!-- main content area end -->
        <!-- footer area start-->
        <footer>
          @include('drugstore.footer')
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
    <!-- jquery latest version -->
   @include('drugstore.script')
    
    <!-- Order Management Scripts -->
    <script>
        $(document).ready(function() {
            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();

            // Handle order approval
            $('.approve-order').click(function() {
                const orderId = $(this).data('order-id');
                if (confirm('Are you sure you want to approve this order?')) {
                    $.ajax({
                        url: `/orders/${orderId}/approve`,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                // Update both the chart and total sales
                                fetchSalesData();
                                updateTotalSales();
                                // Reload the orders table
                                location.reload();
                            } else {
                                alert('Error: ' + response.message);
                            }
                        },
                        error: function(xhr) {
                            alert('Error: ' + xhr.responseJSON.message);
                        }
                    });
                }
            });

            // Handle order rejection
            $('.reject-order').click(function() {
                const orderId = $(this).data('order-id');
                if (confirm('Are you sure you want to reject this order?')) {
                    $.ajax({
                        url: `/orders/${orderId}/reject`,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                // Update both the chart and total sales
                                fetchSalesData();
                                updateTotalSales();
                                // Reload the orders table
                                location.reload();
                            } else {
                                alert('Error: ' + response.message);
                            }
                        },
                        error: function(xhr) {
                            alert('Error: ' + xhr.responseJSON.message);
                        }
                    });
                }
            });
        });

        // Prescription approval / rejection
$('.approve-prescription').click(function() {
  const id = $(this).data('prescription-id');
  if (confirm('Approve this prescription?')) {
    $.post(`/prescriptions/${id}/approve`, {_token: '{{ csrf_token() }}'})
      .done(() => location.reload())
      .fail(xhr => alert('Error: ' + xhr.responseJSON.message));
  }
});

$('.reject-prescription').click(function() {
  const id = $(this).data('prescription-id');
  if (confirm('Reject this prescription?')) {
    $.post(`/prescriptions/${id}/reject`, {_token: '{{ csrf_token() }}'})
      .done(() => location.reload())
      .fail(xhr => alert('Error: ' + xhr.responseJSON.message));
  }
});

    </script>
</body>

</html>