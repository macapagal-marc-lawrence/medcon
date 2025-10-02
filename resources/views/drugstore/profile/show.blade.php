<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('drugstore.css')
</head>

<body>
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
            @include('drugstore.header')
            <!-- header area end -->
            <!-- page title area start -->
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left">Profile</h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="{{ route('drugstore.dashboard') }}">Home</a></li>
                                <li><span>Profile</span></li>
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
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Drugstore Information</h4>
                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <form action="{{ route('drugstore.profile.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- Store Name -->
                                            <div class="form-group">
                                                <label>Store Name</label>
                                                <input type="text" class="form-control" name="storename" 
                                                    value="{{ old('storename', $drugstore->storename) }}" required>
                                                @error('storename')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <!-- License Number -->
                                            <div class="form-group">
                                                <label>License Number</label>
                                                <input type="text" class="form-control" name="licenseno" 
                                                    value="{{ old('licenseno', $drugstore->licenseno) }}" required>
                                                @error('licenseno')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <!-- BIR Number -->
                                            <div class="form-group">
                                                <label>BIR Number</label>
                                                <input type="text" class="form-control" name="bir_number" 
                                                    value="{{ old('bir_number', $drugstore->bir_number) }}">
                                                @error('bir_number')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- Store Address -->
                                            <div class="form-group">
                                                <label>Store Address</label>
                                                <textarea class="form-control" name="storeaddress" rows="3" required>{{ old('storeaddress', $drugstore->storeaddress) }}</textarea>
                                                @error('storeaddress')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <!-- Operating Days -->
                                            <div class="form-group">
                                                <label>Operating Days</label>
                                                <input type="text" class="form-control" name="operatingdays" 
                                                    value="{{ old('operatingdays', $drugstore->operatingdays) }}" required>
                                                @error('operatingdays')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>


                                    </div>



                                    <div class="form-group mt-4">
                                        <button type="submit" class="btn btn-primary">Update Profile</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
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

    <!-- jquery latest version -->
    @include('drugstore.script')
</body>

</html>
