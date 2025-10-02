 <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>MediConnect</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="/assets/img/logo.png">
    <link rel="stylesheet" href="admin/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="admin/assets/css/themify-icons.css">
    <link rel="stylesheet" href="admin/assets/css/metisMenu.css">
    <link rel="stylesheet" href="admin/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="admin/assets/css/slicknav.min.css">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="admin/assets/css/typography.css">
    <link rel="stylesheet" href="admin/assets/css/default-css.css">
    <link rel="stylesheet" href="admin/assets/css/styles.css">
    <link rel="stylesheet" href="admin/assets/css/responsive.css">
    <!-- Custom CSS for customer layout -->
    <style>
        /* Search Results Styling */
        .search-container {
            position: relative;
        }
        .search-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            max-height: 400px;
            overflow-y: auto;
            margin-top: 0.5rem;
        }
        .search-result-item {
            padding: 1rem;
            border-bottom: 1px solid #eee;
            cursor: pointer;
            transition: background-color 0.2s;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .search-result-item:last-child {
            border-bottom: none;
        }
        .search-result-item:hover {
            background-color: #f8f9fa;
        }
        .search-result-item img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 0.25rem;
        }
        .search-result-info {
            flex: 1;
        }
        .search-result-name {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        .search-result-generic {
            font-size: 0.875rem;
            color: #6c757d;
            margin-bottom: 0.25rem;
        }
        .search-result-store {
            font-size: 0.75rem;
            color: #0d6efd;
        }
        .search-result-price {
            font-weight: 600;
            color: #198754;
        }
        .no-results {
            padding: 1rem;
            text-align: center;
            color: #6c757d;
        }
        /* Reset sidebar spacing */
        .page-container {
            padding-left: 0 !important;
            transition: none !important;
        }
        .main-content {
            margin-left: 0 !important;
            width: 100% !important;
        }
        /* Header styling */
        .navbar {
            padding: 1rem 0;
            border-bottom: 1px solid #eee;
        }
        .navbar-brand img {
            max-height: 40px;
            width: auto;
        }
        /* Navigation spacing */
        .navbar-nav {
            gap: 1.5rem;
        }
        .navbar-nav .nav-link {
            color: #666;
            padding: 0;
        }
        .navbar-nav .nav-link.active {
            color: #333;
        }
        /* Content spacing */
        .container-fluid {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }
        @media (max-width: 768px) {
            .navbar {
                padding: 0.75rem 0;
            }
            .container-fluid {
                padding-left: 1rem;
                padding-right: 1rem;
            }
            .navbar-nav {
                gap: 0.5rem;
                padding: 0.25rem 0.5rem;
                margin-left: 0.25rem;
            }
            .navbar-collapse {
                padding: 0.25rem 0;
            }
            .nav-link {
                padding-left: 0.25rem !important;
            }
        }
    </style>
    <!-- modernizr css -->
    <script src="admin/assets/js/vendor/modernizr-2.8.3.min.js"></script>