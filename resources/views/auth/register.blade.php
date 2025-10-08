<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-label for="name" value="{{ __('Username') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autofocus />
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" 
                         class="block mt-1 w-full @error('email') border-red-500 @enderror" 
                         type="email" 
                         name="email" 
                         :value="old('email')" 
                         required 
                         autocomplete="email"
                         pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                         title="Please enter a valid email address" />
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">We'll send a verification link to this email address.</p>
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
            </div>

            <!-- User Type Selector -->
            <div class="mt-4" x-data="{ usertype: '{{ old('usertype') }}' }">
                <x-label for="usertype" value="User Type" />
                <select name="usertype" id="usertype" class="block w-full mt-1" x-model="usertype" required>
                    <option value="">Select user type</option>
                    <option value="drugstore">Drugstore</option>
                    <option value="customer">Customer</option>
                </select>

                <!-- Drugstore Fields -->
                <div x-show="usertype === 'drugstore'" class="mt-4 space-y-4">
                    <div>
                        <x-label for="storename" value="Store Name" />
                        <x-input type="text" name="storename" class="block w-full mt-1" />
                    </div>
                    <div>
                        <x-label for="storeaddress" value="Store Address" />
                        <div class="flex space-x-2">
                            <x-input type="text" id="storeaddress" name="storeaddress" class="block w-full mt-1" />
                            <button type="button" onclick="getCurrentLocation()" class="mt-1 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                <i class="fa fa-map-marker"></i> Current Location
                            </button>
                        </div>
                        <!-- Hidden fields for coordinates -->
                        <input type="hidden" id="latitude" name="latitude">
                        <input type="hidden" id="longitude" name="longitude">
                        <div id="map" class="mt-2" style="height: 200px; width: 100%; display: none;"></div>
                    </div>
                    <div>
                        <x-label for="licenseno" value="License No." />
                        <x-input type="number" name="licenseno" class="block w-full mt-1" />
                    </div>
                    <div>
                        <x-label for="bir_number" value="BIR Number (TIN)" />
                        <x-input type="number" name="bir_number" class="block w-full mt-1" placeholder="XXX-XXX-XXX-XXX" />
                        <p class="mt-1 text-sm text-gray-500">Enter your 12-digit Tax Identification Number (TIN)</p>
                    </div>
                    <div>
                        <x-label for="operatingdayshrs" value="Operating Days/Hours" />
                        <x-input type="text" name="operatingdays" class="block w-full mt-1" placeholder="e.g., Mon-Fri: 9:00 AM - 6:00 PM" />
                        <p class="mt-1 text-sm text-gray-500">Format: Days: Opening Time - Closing Time</p>
                    </div>
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

                <!-- Customer Fields -->
                <div x-show="usertype === 'customer'" class="mt-4 space-y-4">
                    <div>
                        <x-label for="firstname" value="First Name" />
                        <x-input type="text" name="firstname" class="block w-full mt-1" />
                    </div>
                    <div>
                        <x-label for="middlename" value="Middle Name" />
                        <x-input type="text" name="middlename" class="block w-full mt-1" />
                    </div>
                    <div>
                        <x-label for="lastname" value="Last Name" />
                        <x-input type="text" name="lastname" class="block w-full mt-1" />
                    </div>
                    <div>
                        <x-label for="age" value="Age" />
                        <x-input type="number" name="age" class="block w-full mt-1" />
                    </div>
                    <div>
                        <x-label for="birthdate" value="Birthdate" />
                        <x-input type="date" name="birthdate" class="block w-full mt-1" />
                    </div>
                    <div>
                        <x-label for="sex" value="Sex" />
                        <select name="sex" class="block w-full mt-1">
                            <option value="">Select</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div>
                        <x-label for="address" value="Address" />
                        <div class="flex space-x-2">
                            <x-input type="text" id="customerAddress" name="address" class="block w-full mt-1" />
                            <button type="button" onclick="getCustomerLocation()" class="mt-1 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                <i class="fa fa-map-marker"></i> Current Location
                            </button>
                        </div>
                        <!-- Hidden fields for coordinates -->
                        <input type="hidden" id="customerLatitude" name="latitude">
                        <input type="hidden" id="customerLongitude" name="longitude">
                        <div id="customerMap" class="mt-2" style="height: 200px; width: 100%; display: none;"></div>
                    </div>
                </div>
            </div>

            <!-- Add Customer Location JavaScript -->
            <script>
                let customerMap;
                let customerMarker;

                function getCustomerLocation() {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(
                            (position) => {
                                const lat = position.coords.latitude;
                                const lng = position.coords.longitude;
                                
                                // Set hidden fields
                                document.getElementById('customerLatitude').value = lat;
                                document.getElementById('customerLongitude').value = lng;
                                
                                // Show map
                                const mapDiv = document.getElementById('customerMap');
                                mapDiv.style.display = 'block';
                                
                                // Initialize map if not already initialized
                                if (!customerMap) {
                                    customerMap = new google.maps.Map(mapDiv, {
                                        center: { lat, lng },
                                        zoom: 15
                                    });
                                    
                                    // Add marker
                                    customerMarker = new google.maps.Marker({
                                        position: { lat, lng },
                                        map: customerMap,
                                        draggable: true
                                    });

                                    // Update coordinates when marker is dragged
                                    google.maps.event.addListener(customerMarker, 'dragend', function() {
                                        const pos = customerMarker.getPosition();
                                        document.getElementById('customerLatitude').value = pos.lat();
                                        document.getElementById('customerLongitude').value = pos.lng();
                                        getCustomerAddressFromCoordinates(pos.lat(), pos.lng());
                                    });
                                } else {
                                    // Update existing marker position
                                    customerMarker.setPosition({ lat, lng });
                                    customerMap.setCenter({ lat, lng });
                                }

                                // Get address from coordinates
                                getCustomerAddressFromCoordinates(lat, lng);
                            },
                            (error) => {
                                alert("Error getting location: " + error.message);
                            }
                        );
                    } else {
                        alert("Geolocation is not supported by this browser.");
                    }
                }

                function getCustomerAddressFromCoordinates(lat, lng) {
                    const geocoder = new google.maps.Geocoder();
                    geocoder.geocode(
                        { location: { lat, lng } },
                        (results, status) => {
                            if (status === "OK") {
                                if (results[0]) {
                                    document.getElementById('customerAddress').value = results[0].formatted_address;
                                }
                            }
                        }
                    );
                }
            </script>

            <!-- Email Validation Script -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const emailInput = document.getElementById('email');
                    const emailError = document.createElement('div');
                    emailError.className = 'mt-1 text-sm text-red-600';
                    emailError.style.display = 'none';
                    emailInput.parentNode.appendChild(emailError);

                    // Real-time email validation
                    emailInput.addEventListener('input', function() {
                        const email = this.value.trim();
                        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                        
                        if (email === '') {
                            emailError.style.display = 'none';
                            this.classList.remove('border-red-500');
                            return;
                        }
                        
                        if (!emailRegex.test(email)) {
                            emailError.textContent = 'Please enter a valid email address (e.g., user@example.com)';
                            emailError.style.display = 'block';
                            this.classList.add('border-red-500');
                        } else {
                            emailError.style.display = 'none';
                            this.classList.remove('border-red-500');
                        }
                    });

                    // Check email availability on blur
                    emailInput.addEventListener('blur', function() {
                        const email = this.value.trim();
                        if (email && emailInput.classList.contains('border-red-500') === false) {
                            // You can add AJAX call here to check email availability
                            // For now, we'll just show a loading state
                            this.style.borderColor = '#d1d5db';
                        }
                    });
                });
            </script>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    Already registered?
                </a>

                <x-button class="ml-4">
                    Register
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
