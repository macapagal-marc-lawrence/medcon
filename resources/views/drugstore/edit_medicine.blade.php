<!doctype html>
<html class="no-js" lang="en">

<head>
    @include('drugstore.css')
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
                                <form id="logout-form" method="POST" action="{{ route('logout') }}"
                                    style="display: none;">
                                    @csrf
                                </form>
                                <a class="dropdown-item" href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Log Out') }}
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
                            <h4 class="header-title">Medicine Information</h4>
                            <form action="{{ route('drugstore.updateMedicine', $medicine->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" value="{{ $medicine->id }}">

                                <div class="form-group">
                                    <label for="medicine_name" class="col-form-label">Medicine Name</label>
                                    <input class="form-control" type="text" name="medicine_name" id="medicine_name"
                                        value="{{ old('medicine_name', $medicine->medicine_name) }}" required>
                                    @error('medicine_name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="form-group">
                                    <label for="generic_name" class="col-form-label">Generic Name</label>
                                    <input class="form-control" type="text" name="generic_name" id="generic_name"
                                        value="{{ old('generic_name', $medicine->generic_name) }}" required>
                                    @error('generic_name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="form-group">
                                    <label for="description" class="col-form-label">Description</label>
                                    <textarea class="form-control" name="description" id="description"
                                        rows="2">{{ old('description', $medicine->description) }}</textarea>
                                    @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="form-group">
                                    <label for="medicine_price" class="col-form-label">Price</label>
                                    <input class="form-control" type="number" step="0.01" name="medicine_price"
                                        id="medicine_price"
                                        value="{{ old('medicine_price', $medicine->medicine_price) }}" required>
                                    @error('medicine_price') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="form-group">
                                    <label for="quantity" class="col-form-label">Quantity</label>
                                    <input class="form-control" type="number" name="quantity" id="quantity"
                                        value="{{ old('quantity', $medicine->quantity) }}" required>
                                    @error('quantity') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="form-group">
                                    <label for="manufactured_date" class="col-form-label">Manufactured Date</label>
                                    <input class="form-control" type="date" name="manufactured_date"
                                        id="manufactured_date"
                                        value="{{ old('manufactured_date', $medicine->manufactured_date) }}" required>
                                    @error('manufactured_date') <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="expiration_date" class="col-form-label">Expiration Date</label>
                                    <input class="form-control" type="date" name="expiration_date" id="expiration_date"
                                        value="{{ old('expiration_date', $medicine->expiration_date) }}" required>
                                    @error('expiration_date') <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="medicine_img" class="col-form-label">Medicine Image</label>
                                    @if($medicine->medicine_img)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $medicine->medicine_img) }}"
                                                alt="Medicine Image" width="80">
                                        </div>
                                    @endif
                                    <input class="form-control" type="file" name="medicine_img" id="medicine_img"
                                        accept="image/*">
                                    @error('medicine_img') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="form-group mt-4">
                                    <button class="btn btn-primary" type="submit">Update Medicine</button>
                                    <a href="{{ route('drugstore.view') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
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

    @include('drugstore.script')

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6'
            });
        @endif

        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Failed',
                text: '{{ $errors->first() }}',
                confirmButtonColor: '#d33'
            });
        @endif
    </script>

</body>

</html>