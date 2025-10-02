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
            <div class="header-area">
                <div class="row align-items-center">
                    <div class="col-md-6 col-sm-8 clearfix">
                        <div class="nav-btn pull-left">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left">Create Drugstore</h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="{{ route('home') }}">Home</a></li>
                                <li><span>Create Drugstore</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6 clearfix">
                        <div class="user-profile pull-right">
                            <img class="avatar user-thumb" src="{{ asset('admin/assets/images/author/avatar.png') }}" alt="avatar">
                            <h4 class="user-name dropdown-toggle" data-toggle="dropdown">{{ Auth::user()->username }} <i class="fa fa-angle-down"></i></h4>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a>
                            </div>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="main-content-inner">
                <div class="row">
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title mb-4">Create New Drugstore</h4>
                                
                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form action="{{ route('admin.drugstore.store') }}" method="POST">
                                    @csrf
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="username">Username</label>
                                                <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="password" class="form-control" id="password" name="password" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password_confirmation">Confirm Password</label>
                                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="storename">Store Name</label>
                                                <input type="text" class="form-control" id="storename" name="storename" value="{{ old('storename') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="licenseno">License No.</label>
                                                <input type="text" class="form-control" id="licenseno" name="licenseno" value="{{ old('licenseno') }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="bir_number">BIR Number (TIN)</label>
                                                <input type="text" class="form-control" id="bir_number" name="bir_number" value="{{ old('bir_number') }}" placeholder="XXX-XXX-XXX-XXX" required>
                                                <small class="form-text text-muted">12-digit TIN</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="operatingdays">Operating Days/Hours</label>
                                                <input type="text" class="form-control" id="operatingdays" name="operatingdays" value="{{ old('operatingdays') }}" placeholder="Mon-Fri: 9:00 AM - 6:00 PM" required>
                                                <small class="form-text text-muted">Days: Opening - Closing Time</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="storeaddress">Store Address</label>
                                        <div class="input-group">
                                            <textarea class="form-control" id="storeaddress" name="storeaddress" rows="2" required>{{ old('storeaddress') }}</textarea>
                                            <div class="input-group-append">
                                                <button type="button" onclick="getCurrentLocation()" class="btn btn-info">
                                                    <i class="fa fa-map-marker"></i> Current Location
                                                </button>
                                            </div>
                                        </div>
                                        <!-- Hidden fields for coordinates -->
                                        <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}">
                                        <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}">
                                        <div id="map" class="mt-2" style="height: 300px; width: 100%; display: none;"></div>
                                    </div>

                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-primary">Create Drugstore</button>
                                        <a href="{{ route('home') }}" class="btn btn-secondary">Cancel</a>
                                    </div>

                                    <!-- Add Google Maps JavaScript -->
                                    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAUXAVO-jgzu0AwNfawYdtWep3cbHFoHZ0&libraries=places"></script>
                                    <script>
                                        let map;
                                        let marker;

                                        function getCurrentLocation() {
                                            if (navigator.geolocation) {
                                                navigator.geolocation.getCurrentPosition(
                                                    (position) => {
                                                        const lat = position.coords.latitude;
                                                        const lng = position.coords.longitude;
                                                        
                                                        // Set hidden fields
                                                        document.getElementById('latitude').value = lat;
                                                        document.getElementById('longitude').value = lng;
                                                        
                                                        // Show map
                                                        const mapDiv = document.getElementById('map');
                                                        mapDiv.style.display = 'block';
                                                        
                                                        // Initialize map if not already initialized
                                                        if (!map) {
                                                            map = new google.maps.Map(mapDiv, {
                                                                center: { lat, lng },
                                                                zoom: 15
                                                            });
                                                            
                                                            // Add marker
                                                            marker = new google.maps.Marker({
                                                                position: { lat, lng },
                                                                map: map,
                                                                draggable: true
                                                            });

                                                            // Update coordinates when marker is dragged
                                                            google.maps.event.addListener(marker, 'dragend', function() {
                                                                const pos = marker.getPosition();
                                                                document.getElementById('latitude').value = pos.lat();
                                                                document.getElementById('longitude').value = pos.lng();
                                                                getAddressFromCoordinates(pos.lat(), pos.lng());
                                                            });
                                                        } else {
                                                            // Update existing marker position
                                                            marker.setPosition({ lat, lng });
                                                            map.setCenter({ lat, lng });
                                                        }

                                                        // Get address from coordinates
                                                        getAddressFromCoordinates(lat, lng);
                                                    },
                                                    (error) => {
                                                        alert("Error getting location: " + error.message);
                                                    }
                                                );
                                            } else {
                                                alert("Geolocation is not supported by this browser.");
                                            }
                                        }

                                        function getAddressFromCoordinates(lat, lng) {
                                            const geocoder = new google.maps.Geocoder();
                                            geocoder.geocode(
                                                { location: { lat, lng } },
                                                (results, status) => {
                                                    if (status === "OK") {
                                                        if (results[0]) {
                                                            document.getElementById('storeaddress').value = results[0].formatted_address;
                                                        }
                                                    }
                                                }
                                            );
                                        }
                                    </script>
                                </form>
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
</body>

</html>