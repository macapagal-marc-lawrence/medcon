<!-- Modern Header Styles -->
<style>
    .modern-header {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.04);
        position: sticky;
        top: 0;
        z-index: 1000;
        padding: 0.75rem 0;
    }

    .modern-nav-link {
        color: #666;
        padding: 0.5rem 1rem !important;
        margin: 0 0.25rem;
        border-radius: 10px;
        transition: all 0.3s ease;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .modern-nav-link:hover, .modern-nav-link.active {
        background: linear-gradient(45deg, #2196F3, #1976D2);
        color: white !important;
        transform: translateY(-2px);
    }

    .modern-nav-link i {
        font-size: 1.1rem;
    }

    .add-prescription-btn {
        background: linear-gradient(45deg, #2196F3, #1976D2);
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .add-prescription-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(33, 150, 243, 0.3);
        background: linear-gradient(45deg, #1976D2, #1565C0);
    }

    .navbar-toggler {
        border: none;
        padding: 0.5rem;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .navbar-toggler:hover {
        background: #f8f9fa;
    }

    @media (max-width: 991.98px) {
        .modern-nav-link {
            padding: 0.75rem 1rem !important;
            margin: 0.25rem 0;
        }
        
        .navbar-collapse {
            background: white;
            padding: 1rem;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            margin-top: 1rem;
        }
    }
</style>

<!-- Modern Header Navigation -->
<nav class="navbar navbar-expand-lg navbar-light modern-header">
    <div class="container">
        <!-- Mobile Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Main Navigation -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link modern-nav-link {{ Request::is('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="fa fa-home"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link modern-nav-link" href="#available-drugstores">
                        <i class="fa fa-store"></i>
                        <span>Browse Drugstores</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link modern-nav-link" href="#drugstore-location">
                        <i class="fa fa-location"></i>
                        <span>Drugstore Locations</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link modern-nav-link" href="#recent-orders">
                        <i class="fa fa-history"></i>
                        <span>Recent Orders</span>
                    </a>
                </li>
            </ul>
            
            <!-- Right-aligned items -->
            <div class="d-flex align-items-center">
                <button type="button" class="btn add-prescription-btn" data-bs-toggle="modal" data-bs-target="#addPrescriptionModal">
                    <i class="fa fa-file-medical"></i>
                    <span>Add Prescription</span>
                </button>
            </div>
        </div>
    </div>
</nav>