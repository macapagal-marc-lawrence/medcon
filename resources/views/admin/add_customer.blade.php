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
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Add Customer</h4>
                <form action="{{ route('admin.store') }}" method="POST">
                    @csrf

                    <h5 class="mb-3">User Information</h5>

                    <div class="form-group">
                        <label for="username" class="col-form-label">Username</label>
                        <input class="form-control" type="text" name="username" id="username" value="{{ old('username') }}" required>
                        @error('username') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-form-label">Email</label>
                        <input class="form-control" type="email" name="email" id="email" value="{{ old('email') }}" required>
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <input type="hidden" name="usertype" value="customer">

                    <div class="form-group">
                        <label for="password" class="col-form-label">Password</label>
                        <input class="form-control" type="password" name="password" id="password" required>
                        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <hr class="my-4">

                    <h5 class="mb-3">Customer Information</h5>

                    <div class="form-group">
                        <label for="firstname" class="col-form-label">First Name</label>
                        <input class="form-control" type="text" name="firstname" id="firstname" value="{{ old('firstname') }}" required>
                        @error('firstname') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label for="middlename" class="col-form-label">Middle Name</label>
                        <input class="form-control" type="text" name="middlename" id="middlename" value="{{ old('middlename') }}">
                    </div>

                    <div class="form-group">
                        <label for="lastname" class="col-form-label">Last Name</label>
                        <input class="form-control" type="text" name="lastname" id="lastname" value="{{ old('lastname') }}" required>
                        @error('lastname') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label for="birthdate" class="col-form-label">Birthdate</label>
                        <input class="form-control" type="date" name="birthdate" id="birthdate" value="{{ old('birthdate') }}" required>
                        @error('birthdate') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label for="age" class="col-form-label">Age </label>
                        <input class="form-control" type="text" id="age" name="age" readonly value="{{ old('age') }}">
                    </div>

                    <div class="form-group">
                        <label for="sex" class="col-form-label">Sex</label>
                        <select name="sex" class="form-control" required>
                            <option value="">-- Select Sex --</option>
                            <option value="male" {{ old('sex') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('sex') == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('sex') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label for="address" class="col-form-label">Address</label>
                        <textarea class="form-control" name="address" id="address" rows="2" required>{{ old('address') }}</textarea>
                        @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group mt-4">
                        <button class="btn btn-primary" type="submit">Create Customer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('birthdate').addEventListener('change', function () {
        const birthdate = new Date(this.value);
        const today = new Date();
        let age = today.getFullYear() - birthdate.getFullYear();
        const m = today.getMonth() - birthdate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthdate.getDate())) {
            age--;
        }
        document.getElementById('age').value = age;
    });
</script>

            <!-- End Main Content -->
        </div>

        <footer>
            @include('admin.footer')
        </footer>
    </div>

    @include('admin.script')

    <!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            $('#dataTable2').DataTable();
        });
    </script>

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
            title: 'Error',
            html: '{!! implode("<br>", $errors->all()) !!}',
            confirmButtonColor: '#d33'
        });
    @endif
</script>
</body>
</html>
