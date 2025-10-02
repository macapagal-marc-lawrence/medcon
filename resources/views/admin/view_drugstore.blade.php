<!doctype html>
<html class="no-js" lang="en">
<head>
    @include('admin.css')
    <style>
        .card {
            border: none;
            box-shadow: 0 0 20px rgba(0,0,0,0.08);
            border-radius: 12px;
        }
        .card-header {
            background: transparent;
            border-bottom: 1px solid #eee;
            padding: 20px;
        }
        .table th {
            border-top: none;
            font-weight: 600;
            padding: 15px;
            color: #555;
        }
        .table td {
            padding: 15px;
            vertical-align: middle;
        }
        .btn-group .btn {
            margin: 0 2px;
            border-radius: 6px !important;
        }
        .badge {
            padding: 8px 12px;
            border-radius: 6px;
            font-weight: 500;
        }
    </style>
</head>

<body>
    <div id="preloader">
        <div class="loader"></div>
    </div>

    <div class="page-container">
        @include('admin.sidebar')

        <div class="main-content">
            <!-- header area start -->
            <div class="header-area">
                <div class="row align-items-center">
                    <div class="col-md-6 col-sm-8 clearfix">
                        <div class="nav-btn pull-left">
                            <span></span>
                            <span></span>
                            <span></span>
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
            <!-- header area end -->

            <div class="main-content-inner">
                <!-- Drugstores Table Card -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="header-title mb-0">Registered Drugstores</h4>
                                <p class="text-muted mb-0 mt-1">Manage and monitor all registered drugstores</p>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Store Name</th>
                                                <th>Address</th>
                                                <th>License No.</th>
                                                <th>Operating Days</th>
                                                <th>Medicines</th>
                                                <th class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($drugstores as $store)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="store-icon me-3">
                                                            <i class="fa fa-store fa-2x text-primary"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0">{{ $store->storename }}</h6>
                                                            <small class="text-muted">ID: #{{ $store->id }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $store->storeaddress }}</td>
                                                <td>{{ $store->licenseno }}</td>
                                                <td>{{ $store->operatingdays }}</td>
                                                <td>
                                                    @if($store->medicines->count() > 0)
                                                        <button class="btn btn-link text-info p-0" 
                                                                type="button" 
                                                                data-bs-toggle="collapse" 
                                                                data-bs-target="#medicines-{{ $store->id }}" 
                                                                aria-expanded="false">
                                                            <i class="fa fa-pills me-1"></i>
                                                            {{ $store->medicines->count() }} Items
                                                        </button>
                                                    @else
                                                        <span class="text-muted">
                                                            <i class="fa fa-pills me-1"></i> No medicines
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="text-end">
                                                    <button type="button" 
                                                            class="btn btn-sm btn-danger" 
                                                            onclick="confirmDelete({{ $store->id }})"
                                                            title="Delete">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @if($store->medicines->count() > 0)
                                            <tr>
                                                <td colspan="6" class="p-0">
                                                    <div class="collapse" id="medicines-{{ $store->id }}">
                                                        <div class="table-responsive">
                                                            <table class="table table-sm mb-0" style="background: #f8f9fa;">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Medicine Name</th>
                                                                        <th>Generic Name</th>
                                                                        <th>Price</th>
                                                                        <th>Stock</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($store->medicines as $medicine)
                                                                    <tr>
                                                                        <td>{{ $medicine->medicine_name }}</td>
                                                                        <td>{{ $medicine->generic_name }}</td>
                                                                        <td>₱{{ number_format($medicine->medicine_price, 2) }}</td>
                                                                        <td>{{ $medicine->quantity }} units</td>
                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endif
                                            @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-5">
                                                    <img src="{{ asset('admin/assets/images/icon/drugstore-empty.png') }}" 
                                                         alt="No Drugstores" 
                                                         style="width: 120px; opacity: 0.6; margin-bottom: 15px;">
                                                    <h5 class="text-muted mb-2">No Drugstores Found</h5>
                                                    <p class="text-muted mb-3">Start by adding your first drugstore</p>
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                
                                <!-- Pagination -->
                                <div class="mt-4">
                                    {{ $drugstores->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer>
            @include('admin.footer')
        </footer>
    </div>

    @include('admin.script')
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize all collapse elements
        document.addEventListener('DOMContentLoaded', function() {
            var collapseElements = document.querySelectorAll('[data-bs-toggle="collapse"]');
            collapseElements.forEach(function(element) {
                element.addEventListener('click', function(e) {
                    e.preventDefault();
                    var target = document.querySelector(this.getAttribute('data-bs-target'));
                    if (target) {
                        var bsCollapse = bootstrap.Collapse.getInstance(target) || new bootstrap.Collapse(target);
                        if (target.classList.contains('show')) {
                            bsCollapse.hide();
                        } else {
                            bsCollapse.show();
                        }
                    }
                });
            });
        });

        function confirmDelete(storeId) {
            if (confirm('Are you sure you want to delete this drugstore?')) {
                fetch(`/admin/delete-drugstore/${storeId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        alert('Error deleting drugstore: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting drugstore');
                });
            }
        }
    </script>
</body>
</html>