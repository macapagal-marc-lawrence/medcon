<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-600 rounded-full text-white mb-4">
                    <i class="fas fa-pills text-2xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-800">Create Your Account</h1>
                <p class="text-gray-600 mt-2">Join MedCon today</p>
            </div>
        </x-slot>

        <x-validation-errors class="mb-4" />

        <style>
            [x-cloak] { display: none !important; }
            
            /* Enhanced styling from HTML design */
            .gradient-bg {
                background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
            }
            .card-shadow {
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            }
            
            .btn-primary {
                background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
                transition: all 0.3s ease;
            }
            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(59, 130, 246, 0.4);
            }
            .input-focus:focus {
                border-color: #3b82f6;
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
            }
            
            /* Form sections styling */
            .form-section {
                background-color: #f8fafc;
                border-radius: 12px;
                padding: 1.5rem;
                margin-bottom: 1.5rem;
                border-left: 4px solid #3b82f6;
            }
            
            .form-section-title {
                font-weight: 600;
                color: #1e293b;
                margin-bottom: 1rem;
                font-size: 1.125rem;
                display: flex;
                align-items: center;
            }
            
            .input-group {
                margin-bottom: 1.25rem;
            }
            
            .location-button {
                transition: all 0.2s ease;
                    transform: translateY(-1px);
    background-color: #6883dcff; /* darker blue */
    box-shadow: 0 4px 8px rgba(37,99,235,0.3);
    color: #ffffff !important; /* keep text visible */
            }
            
            .location-button:hover {
    transform: translateY(-1px);
    background-color: #1e40af; /* darker blue */
    box-shadow: 0 4px 8px rgba(37,99,235,0.3);
    color: #ffffff !important; /* keep text visible */
}

            
            .user-type-selector {
                display: flex;
                gap: 1rem;
                margin-top: 0.5rem;
            }
            
            .user-type-option {
                flex: 1;
                padding: 1rem;
                border: 2px solid #e2e8f0;
                border-radius: 8px;
                text-align: center;
                cursor: pointer;
                transition: all 0.2s ease;
            }
            
            .user-type-option:hover {
                border-color: #cbd5e1;
                background-color: #f8fafc;
            }
            
            .user-type-option.selected {
                border-color: #3b82f6;
                background-color: #eff6ff;
            }
            
            .info-text {
                color: #64748b;
                font-size: 0.875rem;
                margin-top: 0.25rem;
                display: flex;
                align-items: center;
            }
            
            .required-field::after {
                content: "*";
                color: #ef4444;
                margin-left: 4px;
            }
            
            .modal-overlay {
                background-color: rgba(0, 0, 0, 0.5);
                backdrop-filter: blur(4px);
            }

/* ✅ FINAL Polished & Compact Subscription Modal */
.subscription-modal {
    background: #fff;
    border-radius: 14px;
    max-width: 900px;
    width: 94%;
    overflow: hidden;
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.08);
    padding: 0 2rem;
}

/* Header */
.subscription-modal .modal-header {
     background: linear-gradient(135deg, #1e3a8a, #1e40af, #111827); /* darker */
    color: #fff;
    text-align: center;
    padding: 1.5rem 1rem 1.25rem;   
     box-shadow: inset 0 -4px 6px rgba(0, 0, 0, 0.2);
}

.subscription-modal .modal-header h2 {
  color: #ffffff;
    text-shadow: 0 1px 4px rgba(0,0,0,0.25);
}

.subscription-modal .modal-header p {
    font-size: 0.95rem;
    color: rgba(255, 255, 255, 0.85);
}

/* Stepper */
.step-indicator {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 1.25rem 0 1.75rem;
}
.step {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #e5e7eb;
    color: #6b7280;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
}
.step.active {
    background: #1d4ed8;
    color: #fff;
}
.step-line {
    width: 55px;
    height: 3px;
    background: #e5e7eb;
    margin: 0 0.75rem;
}
.step-line.active {
    background: #1d4ed8;
}

/* Cards */
.plan-card {
    border: 2px solid #c7d7ff;
    border-radius: 12px;
    background: #f3f6ff;
    padding: 1.5rem 1rem;
    text-align: center;
    transition: all 0.25s ease;
    cursor: pointer;
}
.plan-card:hover {
    border-color: #1d4ed8;
    box-shadow: 0 6px 18px rgba(29,78,216,0.18);
    transform: translateY(-2px);
}
.plan-card.selected {
    border-color: #1d4ed8;
    background: #eaf0ff;
}
.plan-card.popular {
    border-color: #1d4ed8;
    background: #edf3ff;
    position: relative;
}
.popular-badge {
    position: absolute;
    top: -10px;
    left: 50%;
    transform: translateX(-50%);
    background: #1d4ed8;
    color: #fff;
    padding: 5px 15px;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
    box-shadow: 0 2px 6px rgba(29,78,216,0.3);
}

/* Typography */
.plan-name {
    font-size: 1.25rem;
    font-weight: 700;
    color: #0f172a;
}
.plan-price {
    font-size: 1.45rem;
    font-weight: 700;
    color: #1d4ed8;
    margin: 0.5rem 0 1rem;
}
.plan-features {
    list-style: none;
    padding: 0;
    margin: 0.75rem 0 1rem;
}
.plan-features li {
    color: #475569;
    font-size: 0.9rem;
    padding: 0.35rem 0;
    border-bottom: 1px solid #f1f5f9;
}
.plan-features li:last-child {
    border-bottom: none;
}
.plan-badge {
    display: inline-block;
    background: #e0e7ff;
    color: #1e40af;
    font-weight: 600;
    padding: 0.4rem 0.9rem;
    border-radius: 9999px;
    font-size: 0.78rem;
}

/* Buttons */
.modal-buttons {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.75rem 1.25rem;
    background: #f8fafc;
    border-top: 1px solid #e5e7eb;
}
.skip-continue-group {
    display: flex;
    gap: 0.65rem;
}
.btn-outline {
    border: 1px solid #cbd5e1;
    background: #fff;
    color: #1e293b;
    padding: 0.55rem 1.25rem;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.2s ease;
}
.btn-outline:hover {
    background: #f1f5f9;
    border-color: #94a3b8;
}
.btn-continue {
    background: #1d4ed8;
    color: #fff;
    padding: 0.55rem 1.25rem;
    border-radius: 8px;
    font-weight: 500;
    box-shadow: 0 2px 5px rgba(29,78,216,0.3);
    transition: all 0.2s ease;
}
.btn-continue:hover {
    background: #0c2569ff;
    box-shadow: 0 4px 10px rgba(29,78,216,0.4);
}

/* Responsive */
@media (max-width: 768px) {
    .subscription-modal { width: 95%; padding: 0 1.25rem; }
    .modal-buttons { flex-direction: column; gap: 0.75rem; }
    .skip-continue-group { flex-direction: column; width: 100%; }
}

        </style>

        <!-- ✅ Attach Alpine controller to form -->
        <form method="POST" action="{{ route('register') }}" x-data="registerForm()" x-ref="formElement" x-cloak>
            @csrf

            <!-- Hidden input for subscription plan -->
            <input type="hidden" name="subscription_plan" x-model="selectedPlan">

            <!-- Account Information Section -->
            <div class="form-section">
                <h2 class="form-section-title">
                    <i class="fas fa-user-circle mr-2 text-blue-600"></i>
                    Account Information
                </h2>
                
                <div class="input-group">
                    <x-label for="name" value="{{ __('Username') }}" class="required-field" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <x-input id="name" 
                               class="block mt-1 w-full pl-10 pr-3 py-2 rounded-lg input-focus" 
                               type="text" 
                               name="username" 
                               :value="old('username')" 
                               required 
                               autofocus 
                               placeholder="Enter your username"/>
                    </div>
                </div>

                <div class="input-group">
                    <x-label for="email" value="{{ __('Email') }}" class="required-field" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <x-input id="email"
                               class="block mt-1 w-full pl-10 pr-3 py-2 rounded-lg input-focus @error('email') border-red-500 @enderror"
                               type="email"
                               name="email"
                               :value="old('email')"
                               required
                               autocomplete="email"
                               pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                               title="Please enter a valid email address"
                               placeholder="your.email@example.com" />
                    </div>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="info-text">
                        <i class="fas fa-info-circle mr-1 text-blue-500"></i>
                        We'll send a verification link to this email address.
                    </p>
                </div>

                <div class="input-group">
                    <x-label for="password" value="{{ __('Password') }}" class="required-field" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <x-input id="password" 
                               class="block mt-1 w-full pl-10 pr-3 py-2 rounded-lg input-focus" 
                               type="password" 
                               name="password" 
                               required 
                               placeholder="Create a secure password"/>
                    </div>
                </div>

                <div class="input-group">
                    <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" class="required-field" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <x-input id="password_confirmation" 
                               class="block mt-1 w-full pl-10 pr-3 py-2 rounded-lg input-focus" 
                               type="password" 
                               name="password_confirmation" 
                               required 
                               placeholder="Confirm your password"/>
                    </div>
                </div>
            </div>

            <!-- User Type Section -->
            <div class="form-section">
                <h2 class="form-section-title">
                    <i class="fas fa-users mr-2 text-blue-600"></i>
                    User Type
                </h2>
                
                <div class="user-type-selector">
                    <div class="user-type-option" 
                         :class="{ 'selected': usertype === 'drugstore' }"
                         @click="usertype = 'drugstore'">
                        <i class="fas fa-store text-blue-600 text-lg mb-2"></i>
                        <div class="font-medium">Drugstore</div>
                        <div class="text-sm text-gray-500 mt-1">Register as a pharmacy business</div>
                    </div>
                    
                    <div class="user-type-option" 
                         :class="{ 'selected': usertype === 'customer' }"
                         @click="usertype = 'customer'">
                        <i class="fas fa-user text-green-600 text-lg mb-2"></i>
                        <div class="font-medium">Customer</div>
                        <div class="text-sm text-gray-500 mt-1">Register as a regular customer</div>
                    </div>
                </div>
                
                <input type="hidden" name="usertype" x-model="usertype" required>
            </div>

            <!-- Drugstore Fields -->
            <div x-show="usertype === 'drugstore'" class="form-section">
                <h2 class="form-section-title">
                    <i class="fas fa-store mr-2 text-blue-600"></i>
                    Drugstore Information
                </h2>
                
                <div class="input-group">
                    <x-label for="storename" value="Store Name" class="required-field" />
                    <x-input type="text" name="storename" class="block w-full mt-1 rounded-lg input-focus" placeholder="Enter your store name" />
                </div>
                
                <div class="input-group">
                    <x-label for="storeaddress" value="Store Address" class="required-field" />
                    <div class="flex space-x-2">
                        <x-input type="text" id="storeaddress" name="storeaddress" class="block w-full mt-1 rounded-lg input-focus" placeholder="Enter your store address" />
                        <button type="button" onclick="getCurrentLocation()" class="mt-1 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 location-button">
                            <i class="fas fa-map-marker-alt mr-1"></i> Location
                        </button>
                    </div>
                    <input type="hidden" id="latitude" name="latitude">
                    <input type="hidden" id="longitude" name="longitude">
                    <div id="map" class="mt-2" style="height: 200px; width: 100%; display: none;"></div>
                </div>
                
                <div class="input-group">
                    <x-label for="licenseno" value="License No." class="required-field" />
                    <x-input type="number" name="licenseno" class="block w-full mt-1 rounded-lg input-focus" placeholder="Enter license number" />
                </div>
                
                <div class="input-group">
                    <x-label for="bir_number" value="BIR Number (TIN)" class="required-field" />
                    <x-input
                        type="text"
                        name="bir_number"
                        id="bir_number"
                        class="block w-full mt-1 rounded-lg input-focus"
                        placeholder="Enter 12-digit TIN"
                        pattern="\d{12}"
                        maxlength="12"
                        title="Enter 12 numeric digits only"
                        required
                    />
                    <p class="info-text">
                        <i class="fas fa-info-circle mr-1 text-blue-500"></i>
                        Enter your 12-digit Tax Identification Number (numbers only)
                    </p>
                </div>
                
                <div class="input-group">
                    <x-label for="operatingdayshrs" value="Operating Days/Hours" class="required-field" />
                    <x-input type="text" name="operatingdays" class="block w-full mt-1 rounded-lg input-focus" placeholder="e.g., Mon-Fri: 9:00 AM - 6:00 PM" />
                    <p class="info-text">
                        <i class="fas fa-info-circle mr-1 text-blue-500"></i>
                        Format: Days: Opening Time - Closing Time
                    </p>
                </div>
            </div>

            <!-- Customer Fields -->
            <div x-show="usertype === 'customer'" class="form-section">
                <h2 class="form-section-title">
                    <i class="fas fa-user mr-2 text-green-600"></i>
                    Personal Information
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="input-group">
                        <x-label for="firstname" value="First Name" class="required-field" />
                        <x-input type="text" name="firstname" class="block w-full mt-1 rounded-lg input-focus" placeholder="First name" />
                    </div>
                    
                    <div class="input-group">
                        <x-label for="middlename" value="Middle Name" />
                        <x-input type="text" name="middlename" class="block w-full mt-1 rounded-lg input-focus" placeholder="Middle name" />
                    </div>
                </div>
                
                <div class="input-group">
                    <x-label for="lastname" value="Last Name" class="required-field" />
                    <x-input type="text" name="lastname" class="block w-full mt-1 rounded-lg input-focus" placeholder="Last name" />
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="input-group">
                        <x-label for="age" value="Age" class="required-field" />
                        <x-input type="number" name="age" class="block w-full mt-1 rounded-lg input-focus" placeholder="Age" />
                    </div>
                    
                    <div class="input-group">
                        <x-label for="birthdate" value="Birthdate" class="required-field" />
                        <x-input type="date" name="birthdate" class="block w-full mt-1 rounded-lg input-focus" />
                    </div>
                    
                    <div class="input-group">
                        <x-label for="sex" value="Sex" class="required-field" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-venus-mars text-gray-400"></i>
                            </div>
                            <select name="sex" class="block w-full mt-1 pl-10 pr-3 py-2 rounded-lg input-focus">
                                <option value="">Select</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="input-group">
                    <x-label for="address" value="Address" class="required-field" />
                    <div class="flex space-x-2">
                        <x-input type="text" id="customerAddress" name="address" class="block w-full mt-1 rounded-lg input-focus" placeholder="Enter your address" />
                        <button type="button" onclick="getCustomerLocation()" class="mt-1 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 location-button">
                            <i class="fas fa-map-marker-alt mr-1"></i> Location
                        </button>
                    </div>
                    <input type="hidden" id="customerLatitude" name="latitude">
                    <input type="hidden" id="customerLongitude" name="longitude">
                    <div id="customerMap" class="mt-2" style="height: 200px; width: 100%; display: none;"></div>
                </div>
            </div>

            <!-- Enhanced Subscription Modal - EXACT MATCH TO IMAGE -->
            <template x-if="showPlans">
                <div
                    x-show="showPlans"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 flex items-center justify-center modal-overlay z-50 p-4"
                    style="z-index: 9999;"
                >
                    <div class="subscription-modal">
                        <!-- Modal Header -->
                       <div class="modal-header bg-gradient-to-r from-blue-700 via-indigo-800 to-indigo-900 text-white text-center shadow-inner">

                            <h2 class="text-3xl font-bold mb-4">Choose Your Subscription Plan</h2>
                            <p class="text-blue-100 text-lg">Select the plan that best fits your drugstore needs</p>
                        </div>

                        <!-- Step Indicator -->
                        <div class="step-indicator">
                            <div class="step">1</div>
                            <div class="step-line"></div>
                            <div class="step active">2</div>
                        </div>

                        <!-- Plans Grid - EXACT MATCH TO IMAGE -->
                        <div class="px-8 py-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 px-4 md:px-6">

                                <!-- Basic Plan -->
                                <div class="plan-card" 
                                     :class="{ 'selected': selectedPlan === 'basic' }"
                                     @click="selectedPlan = 'basic'">
                                    <h3 class="plan-name">Basic</h3>
                                    <div class="plan-price">₱0 /month</div>
                                    <ul class="plan-features">
                                        <li>Basic listing access</li>
                                        <li>Up to 50 products</li>
                                        <li>Standard visibility</li>
                                    </ul>
                                    <div class="plan-badge">Free Forever</div>
                                </div>

                                <!-- Standard Plan -->
                                <div class="plan-card popular" 
                                     :class="{ 'selected': selectedPlan === 'standard' }"
                                     @click="selectedPlan = 'standard'">
                                    <div class="popular-badge">MOST POPULAR</div>
                                    <h3 class="plan-name">Standard</h3>
                                    <div class="plan-price">₱299 /month</div>
                                    <ul class="plan-features">
                                        <li>Featured listings</li>
                                        <li>Advanced analytics</li>
                                        <li>Up to 500 products</li>
                                        <li>Priority visibility</li>
                                    </ul>
                                    <div class="plan-badge">Save 15% annually</div>
                                </div>

                                <!-- Premium Plan -->
                                <div class="plan-card" 
                                     :class="{ 'selected': selectedPlan === 'premium' }"
                                     @click="selectedPlan = 'premium'">
                                    <h3 class="plan-name">Premium</h3>
                                    <div class="plan-price">₱599 /month</div>
                                    <ul class="plan-features">
                                        <li>Full platform access</li>
                                        <li>Marketing tools</li>
                                        <li>Unlimited products</li>
                                        <li>Premium support</li>
                                        <li>API access</li>
                                    </ul>
                                    <div class="plan-badge">Best Value</div>
                                </div>
                            </div>

                            <!-- Action Buttons - EXACT MATCH TO IMAGE -->
                            <div class="modal-buttons">
                                <button
                                    type="button"
                                    class="btn-outline"
                                    @click="showPlans = false"
                                >
                                    Back
                                </button>
                                <div class="skip-continue-group">
                                    <button
                                        type="button"
                                        class="btn-outline"
                                        @click="skipSubscription"
                                    >
                                        Skip for now
                                    </button>
                                    <button
                                        type="button"
                                        class="btn-continue"
                                        @click="submitForm"
                                    >
                                        Continue
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <!-- Register Button -->
            <div class="flex items-center justify-between mt-6">
                <a class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center transition-colors" href="{{ route('login') }}">
                    <i class="fas fa-arrow-left mr-1"></i> Already registered?
                </a>

                <button
                    type="button"
                    class="btn-primary text-white px-6 py-2 rounded-lg font-medium flex items-center"
                    @click="handleRegisterClick"
                >
                    Continue <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </form>

        <!-- ✅ FIXED Alpine Script -->
        <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('registerForm', () => ({
                usertype: '',
                showPlans: false,
                selectedPlan: 'basic',

                init() {
                    // Initialize if needed
                },

                handleRegisterClick() {
                    // Simple validation - check if required fields are filled
                    const requiredFields = this.$el.querySelectorAll('[required]');
                    let isValid = true;
                    
                    requiredFields.forEach(field => {
                        if (!field.value.trim()) {
                            isValid = false;
                            field.classList.add('border-red-500');
                        } else {
                            field.classList.remove('border-red-500');
                        }
                    });

                    if (!isValid) {
                        alert('Please fill in all required fields');
                        return;
                    }

                    // If drugstore, show modal; else submit directly
                    if (this.usertype === 'drugstore') {
                        this.showPlans = true;
                    } else {
                        this.submitForm();
                    }
                },

                skipSubscription() {
                    this.selectedPlan = 'basic';
                    this.showPlans = false;
                    this.submitForm();
                },

                submitForm() {
                    this.showPlans = false;
                    // Directly submit the form using the form reference
                    this.$refs.formElement.submit();
                },
            }));
        });

        </script>

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
    </x-authentication-card>
</x-guest-layout>