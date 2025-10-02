<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('drugstore.css')
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
</head>

<body>
    <div id="preloader">
        <div class="loader"></div>
    </div>

    <div class="page-container">
        @include('drugstore.sidebar')

        <div class="main-content">
            @include('drugstore.header')

            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left">Dashboard</h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="{{ route('home') }}">Home</a></li>
                                <li><span>Drugstore Dashboard</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6 clearfix">
                        <div class="user-profile pull-right">
                            <img class="avatar user-thumb" src="{{ asset('admin/assets/images/author/avatar.png') }}"
                                alt="avatar">
                            <h4 class="user-name dropdown-toggle" data-toggle="dropdown">
                                {{ Auth::user()->username }} <i class="fa fa-angle-down"></i>
                            </h4>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('drugstore.profile') }}">
                                    <i class="fa fa-user mr-2"></i> Profile
                                </a>
                                <form id="logout-form" method="POST" action="{{ route('logout') }}"
                                    style="display: none;">
                                    @csrf
                                </form>
                                <a class="dropdown-item" href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out mr-2"></i> {{ __('Log Out') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="main-content-inner">
                <div class="col-12 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Medicine List</h4>
                            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                                <h5 class="mb-0">Medicine Inventory</h5>
                                <a href="{{ route('drugstore.create') }}" class="btn btn-primary">
                                    <i class="fa fa-plus-circle"></i> Add New Medicine
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="dataTable2" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th style="width: 60px">Image</th>
                                                <th>Medicine Details</th>
                                                <th>Stock Info</th>
                                                <th>Dates</th>
                                                <th style="width: 120px">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($medicines as $medicine)
                                                <tr>
                                                    <td>
                                                        <div class="medicine-img-wrapper">
                                                            @if($medicine->medicine_img)
                                                                <img src="{{ asset('storage/' . $medicine->medicine_img) }}"
                                                                    alt="{{ $medicine->medicine_name }}" 
                                                                    class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                                            @else
                                                                <div class="no-image-placeholder">
                                                                    <i class="fa fa-medkit text-muted"></i>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <h6 class="mb-1">{{ $medicine->medicine_name }}</h6>
                                                        <div class="small text-muted mb-1">Generic: {{ $medicine->generic_name }}</div>
                                                        <div class="small text-muted">{{ Str::limit($medicine->description, 100) }}</div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column">
                                                            <div class="mb-1">
                                                                <span class="badge badge-primary">₱{{ number_format($medicine->medicine_price, 2) }}</span>
                                                            </div>
                                                            <div>
                                                                @if($medicine->quantity > 20)
                                                                    <span class="badge badge-success">In Stock: {{ $medicine->quantity }}</span>
                                                                @elseif($medicine->quantity > 0)
                                                                    <span class="badge badge-warning">Low Stock: {{ $medicine->quantity }}</span>
                                                                @else
                                                                    <span class="badge badge-danger">Out of Stock</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="small">
                                                            <div class="mb-1">
                                                                <i class="fa fa-calendar-plus-o text-success"></i>
                                                                Mfg: {{ \Carbon\Carbon::parse($medicine->manufactured_date)->format('M d, Y') }}
                                                            </div>
                                                            <div>
                                                                <i class="fa fa-calendar-times-o text-danger"></i>
                                                                Exp: {{ \Carbon\Carbon::parse($medicine->expiration_date)->format('M d, Y') }}
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="{{ route('drugstore.editMedicine', $medicine->id) }}"
                                                                class="btn btn-sm btn-outline-primary" title="Edit">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <button type="button" 
                                                                class="btn btn-sm btn-outline-danger delete-medicine" 
                                                                data-id="{{ $medicine->id }}"
                                                                data-name="{{ $medicine->medicine_name }}"
                                                                title="Delete">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <style>
                                .no-image-placeholder {
                                    width: 50px;
                                    height: 50px;
                                    background: #f8f9fa;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    border-radius: 4px;
                                }
                                .no-image-placeholder i {
                                    font-size: 24px;
                                }
                                .table td {
                                    vertical-align: middle;
                                }
                                .badge {
                                    padding: 5px 10px;
                                }
                                /* DataTables Search styling */
                                .dataTables_wrapper .dataTables_filter {
                                    float: right;
                                    margin-bottom: 20px;
                                }
                                .dataTables_wrapper .dataTables_filter input {
                                    border: 1px solid #e0e0e0;
                                    border-radius: 4px;
                                    padding: 8px 12px;
                                    margin-left: 8px;
                                    width: 250px;
                                    transition: all 0.3s ease;
                                }
                                .dataTables_wrapper .dataTables_filter input:focus {
                                    border-color: #4e73df;
                                    outline: none;
                                    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
                                }
                                .dataTables_wrapper .dataTables_length {
                                    float: left;
                                    margin-bottom: 20px;
                                }
                                .dataTables_wrapper .dataTables_length select {
                                    border: 1px solid #e0e0e0;
                                    border-radius: 4px;
                                    padding: 6px 12px;
                                    margin: 0 4px;
                                }
                                .dataTables_wrapper .dataTables_info {
                                    padding-top: 15px;
                                    font-size: 0.875rem;
                                    color: #6c757d;
                                }
                                .dataTables_wrapper .dataTables_paginate {
                                    padding-top: 15px;
                                }
                                .dataTables_wrapper .dataTables_paginate .paginate_button {
                                    padding: 5px 12px;
                                    margin: 0 2px;
                                    border: 1px solid #e0e0e0;
                                    border-radius: 4px;
                                    background: #fff;
                                }
                                .dataTables_wrapper .dataTables_paginate .paginate_button.current {
                                    background: #4e73df;
                                    color: #fff !important;
                                    border-color: #4e73df;
                                }
                                .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
                                    background: #eaecf4;
                                    border-color: #e0e0e0;
                                }
                            </style>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Main Content -->
        </div>

        <footer>
            @include('drugstore.footer')
        </footer>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    
    @include('drugstore.script')

    <!-- DataTables JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            // Wait a bit for DOM to be ready
            setTimeout(function() {
                try {
                    // Initialize DataTable
                    var table = $('#dataTable2').DataTable({
                        paging: true,
                        pageLength: 10,
                        ordering: true,
                        info: true,
                        searching: true,
                        lengthChange: true,
                        dom: '<"top"lf>rt<"bottom"ip><"clear">',
                        language: {
                            search: "_INPUT_",
                            searchPlaceholder: "Search medicines..."
                        }
                    });
                    console.log('DataTable initialized successfully');
                } catch (error) {
                    console.error('Error initializing DataTable:', error);
                }
            }, 100);

            // Handle medicine deletion with event delegation
            $(document).on('click', '.delete-medicine', function(e) {
                e.preventDefault();
                console.log('Delete button clicked');
                
                const button = $(this);
                const id = button.data('id');
                const name = button.data('name');
                
                console.log('Medicine ID:', id);
                console.log('Medicine Name:', name);

                Swal.fire({
                    title: 'Delete Medicine',
                    text: 'Are you sure you want to delete ' + name + '?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        console.log('Deletion confirmed');
                        
                        // Get the CSRF token from the meta tag
                        const token = $('meta[name="csrf-token"]').attr('content');
                        
                        $.ajax({
                            url: '/delete-medicine/' + id,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': token
                            },
                            success: function(response) {
                                console.log('Delete response:', response);
                                if (response.success) {
                                    Swal.fire({
                                        title: 'Deleted!',
                                        text: name + ' has been deleted successfully.',
                                        icon: 'success'
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        response.message || 'Failed to delete medicine.',
                                        'error'
                                    );
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Delete error:', error);
                                console.error('Status:', status);
                                console.error('Response:', xhr.responseText);
                                
                                Swal.fire(
                                    'Error!',
                                    'Something went wrong while deleting the medicine.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>