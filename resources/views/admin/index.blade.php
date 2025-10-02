<!doctype html>
<html class="no-js" lang="en">

<head>
    @include('admin.css')
</head>

<body>
    <div id="preloader">
        <div class="loader"></div>
    </div>

    <div class="page-container">
        @include('admin.sidebar')

        <div class="main-content">
            @include('admin.header')

            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left">Dashboard</h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="{{ route('home') }}">Home</a></li>
                                <li><span>Admin Dashboard</span></li>
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
                                <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                                    @csrf
                                </form>
                                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Log Out') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="main-content-inner">
                <div class="row">
                    <!-- Summary Cards -->
                    <div class="col-lg-12">
                        <div class="row">
                            <!-- Total Users Card -->
                            <div class="col-md-4 mt-5 mb-3">
                                <div class="card">
                                    <div class="seo-fact sbg1">
                                        <div class="p-4 d-flex justify-content-between align-items-center">
                                            <div class="seofct-icon">
                                                <i class="fa fa-users"></i>
                                                Total Users
                                            </div>
                                            <h2>{{ $totalUsers ?? 'N/A' }}</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Total Drugstores Card -->
                            <div class="col-md-4 mt-md-5 mb-3">
                                <div class="card">
                                    <div class="seo-fact sbg2">
                                        <div class="p-4 d-flex justify-content-between align-items-center">
                                            <div class="seofct-icon">
                                                <i class="fa fa-medkit"></i>
                                                Total Drugstores
                                            </div>
                                            <h2>{{ $totalDrugstores ?? 'N/A' }}</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Total Orders Card -->
                            <div class="col-md-4 mt-md-5 mb-3">
                                <div class="card">
                                    <div class="seo-fact sbg4">
                                        <div class="p-4 d-flex justify-content-between align-items-center">
                                            <div class="seofct-icon">
                                                <i class="fa fa-shopping-cart"></i>
                                                Total Orders
                                            </div>
                                            <h2>{{ $totalOrders ?? 'N/A' }}</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Users Table -->
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Recent Users</h4>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Username</th>
                                                <th>Email</th>
                                                <th>Type</th>
                                                <th>Registered</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($recentUsers ?? [] as $user)
                                            <tr>
                                                <td>{{ $user->username }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ ucfirst($user->usertype) }}</td>
                                                <td>{{ $user->created_at->format('M d, Y') }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No recent users</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Drugstores Table -->
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Recent Drugstores</h4>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Store Name</th>
                                                <th>Address</th>
                                                <th>License No.</th>
                                                <th>Operating Days</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($recentDrugstores ?? [] as $store)
                                            <tr>
                                                <td>{{ $store->storename }}</td>
                                                <td>{{ $store->storeaddress }}</td>
                                                <td>{{ $store->licenseno }}</td>
                                                <td>{{ $store->operatingdays }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No recent drugstores</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Orders Table -->
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Recent Orders</h4>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Customer</th>
                                                <th>Drugstore</th>
                                                <th>Total Amount</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($recentOrders ?? [] as $order)
                                            <tr>
                                                <td>#{{ $order->id }}</td>
                                                <td>{{ $order->customer->user->username }}</td>
                                                <td>{{ $order->store->storename }}</td>
                                                <td>₱{{ number_format($order->total_amount, 2) }}</td>
                                                <td>
                                                    <span class="badge badge-{{ $order->status === 'completed' ? 'success' : ($order->status === 'pending' ? 'warning' : 'info') }}">
                                                        {{ ucfirst($order->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No recent orders</td>
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
            <!-- End Main Content -->
        </div>

        <footer>
            @include('admin.footer')
        </footer>
    </div>

    @include('admin.script')

    <script>
        $(document).ready(function () {
            $('#dataTable2').DataTable();
        });
    </script>

    <script>
document.addEventListener("DOMContentLoaded", function() {
    // Replace with your OpenWeatherMap API key
    const apiKey = "YOUR_API_KEY_HERE";
    const city = "Pampanga,PH";
    const url = `https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${apiKey}&units=metric`;

    fetch(url)
        .then(response => response.json())
        .then data => {
            // Weather icon
            const iconCode = data.weather[0].icon;
            const iconUrl = `https://openweathermap.org/img/wn/${iconCode}@2x.png`;
            document.getElementById("weather-icon").innerHTML = `<img src="${iconUrl}" alt="Weather icon" style="width:60px;height:60px;">`;

            // Temperature
            document.getElementById("weather-temp").textContent = Math.round(data.main.temp) + "°C";

            // Description
            document.getElementById("weather-desc").textContent = data.weather[0].description.replace(/\b\w/g, l => l.toUpperCase());

            // Location
            document.getElementById("weather-location").textContent = data.name + ", PH";

            // Humidity
            document.getElementById("weather-humidity").innerHTML = `<i class="fa fa-tint"></i> ${data.main.humidity}% Humidity`;

            // Wind
            document.getElementById("weather-wind").innerHTML = `<i class="fa fa-flag"></i> ${data.wind.speed} km/h Wind`;
        })
        .catch(() => {
            document.getElementById("weather-widget").innerHTML = "<div style='color:red;'>Unable to load weather data.</div>";
        });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
(function() {
    // Example data, replace with dynamic values from your backend if needed
    const months = [
        "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
    ];
    const userCounts = [
        120, 135, 150, 170, 200, 220, 250, 270, 300, 320, 350, 400 // Example values
    ];

    // Wait until the DOM is fully loaded
    window.addEventListener('load', function() {
        var ctx = document.getElementById('monthlyUsersChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Users',
                        data: userCounts,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: '#36a2eb',
                        borderWidth: 2,
                        pointBackgroundColor: '#36a2eb',
                        pointRadius: 4,
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { color: '#222' }
                        },
                        x: {
                            ticks: { color: '#222' }
                        }
                    }
                }
            });
        }
    });
})();
</script>
        
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
(function() {
    // Example data, replace with dynamic values from your backend if needed
    const months = [
        "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
    ];
    const userCounts = [
        120, 135, 150, 170, 200, 220, 250, 270, 300, 320, 350, 400 // Example values
    ];

    // Wait until the DOM is fully loaded
    window.addEventListener('load', function() {
        var ctx = document.getElementById('monthlyDrugstoresChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Drugstores',
                        data: userCounts,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: '#36a2eb',
                        borderWidth: 2,
                        pointBackgroundColor: '#36a2eb',
                        pointRadius: 4,
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { color: '#222' }
                        },
                        x: {
                            ticks: { color: '#222' }
                        }
                    }
                }
            });
        }
    });
})();
</script>

<script>
(function() {
    // Example data for design only
    const designData = [12, 19, 7, 15, 10, 14, 9, 13, 8, 11, 6, 10];

    // Impressions/Reach (sbg3) - maximize graph, no dots, no tooltips
    var ctx3 = document.getElementById('seolinechart3');
    if (ctx3) {
        new Chart(ctx3, {
            type: 'line',
            data: {
                labels: Array(12).fill(''),
                datasets: [{
                    data: designData,
                    backgroundColor: 'rgba(255,255,255,0.15)',
                    borderColor: '#fff',
                    borderWidth: 2,
                    pointRadius: 0, // No dots
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: { enabled: false }
                },
                scales: {
                    y: { display: false },
                    x: { display: false }
                }
            }
        });
    }

    // New Users/Impressions (sbg4) - maximize graph, no dots, no tooltips
    var ctx4 = document.getElementById('seolinechart4');
    if (ctx4) {
        new Chart(ctx4, {
            type: 'line',
            data: {
                labels: Array(12).fill(''),
                datasets: [{
                    data: designData.slice().reverse(),
                    backgroundColor: 'rgba(255,255,255,0.15)',
                    borderColor: '#fff',
                    borderWidth: 2,
                    pointRadius: 0, // No dots
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: { enabled: false }
                },
                scales: {
                    y: { display: false },
                    x: { display: false }
                }
            }
        });
    }
})();
</script>
        
</body>

</html>
