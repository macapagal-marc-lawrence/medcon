<!DOCTYPE html>
<html lang="en">

<head>
  @include('home.css')
</head>

<body class="index-page">

  <header id="header" class="header sticky-top">

    @include('home.header')

  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="home" class="hero section light-background">

      <img src="assets/img/hero-bg.jpg" alt="" data-aos="fade-in">

      <div class="container position-relative">

        <!-- Success/Error Messages -->
        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert" data-aos="fade-down" data-aos-delay="50">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @if(session('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert" data-aos="fade-down" data-aos-delay="50">
            <i class="bi bi-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <div class="welcome position-relative" data-aos="fade-down" data-aos-delay="100">
          @if(isset($userData) && $userData)
            <h2>Welcome back, {{ $userData['name'] }}!</h2>
            <p>Ready to manage your {{ $userData['usertype'] === 'customer' ? 'prescriptions and orders' : ($userData['usertype'] === 'drugstore' ? 'inventory and orders' : 'system') }}?</p>
            <div class="mt-4">
              <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg me-3">
                <i class="bi bi-speedometer2 me-2"></i>
                Go to Dashboard
              </a>
              @if($userData['usertype'] === 'customer')
                <a href="{{ route('customer.profile') }}" class="btn btn-outline-primary btn-lg">
                  <i class="bi bi-person me-2"></i>
                  View Profile
                </a>
              @endif
            </div>
          @else
            <h2>Welcome to MediConnect</h2>
            <p>"Smart Prescriptions, Connected Care."</p>
            <div class="mt-4">
              <a href="{{ route('register') }}" class="btn btn-primary btn-lg me-3">Get Started</a>
              <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg">Login</a>
            </div>
          @endif
        </div><!-- End Welcome -->

        <div class="content row gy-4">
          <div class="col-lg-4 d-flex align-items-stretch">
            <div class="why-box" data-aos="zoom-out" data-aos-delay="200">
              <h3>Why Choose MediConnect?</h3>
              <p>
                Never waste time with unavailable meds. Our system connects instantly with nearby pharmacies to confirm
                stock, prioritize faster delivery, or recommend equally effective alternatives—all tailored to your
                needs.
              </p>
              <div class="text-center">
                <a href="#about" class="more-btn"><span>Learn More</span> <i class="bi bi-chevron-right"></i></a>
              </div>
            </div>
          </div><!-- End Why Box -->

          <div class="col-lg-8 d-flex align-items-stretch">
            <div class="d-flex flex-column justify-content-center">
              <div class="row gy-4">

                <div class="col-xl-4 d-flex align-items-stretch">
                  <div class="icon-box" data-aos="zoom-out" data-aos-delay="300">
                    <i class="bi bi-clipboard-data"></i>
                    <h4>AI-Based Prescriptions</h4>
                   
                  </div>
                </div><!-- End Icon Box -->

                <div class="col-xl-4 d-flex align-items-stretch">
                  <div class="icon-box" data-aos="zoom-out" data-aos-delay="400">
                    <i class="bi bi-gem"></i>
                    <h4>Health is Wealth</h4>
                   
                  </div>
                </div><!-- End Icon Box -->

                <div class="col-xl-4 d-flex align-items-stretch">
                  <div class="icon-box" data-aos="zoom-out" data-aos-delay="500">
                    <i class="bi bi-inboxes"></i>
                    <h4>Real-Time Inventory</h4>
                    
                  </div>
                </div><!-- End Icon Box -->

              </div>
            </div>
          </div>
        </div><!-- End  Content-->

      </div>

    </section><!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">

      @include('home.about')

    </section><!-- /About Section -->

    <!-- Stats Section -->
    <section id="stats" class="stats section light-background">

      @include('home.stats')

    </section><!-- /Stats Section -->

    <!-- Services Section -->
    <section id="services" class="services section">

      @include('home.services')

    </section><!-- /Services Section -->

  


    <!-- Developers Section -->
    <section id="developers" class="doctors section">

      @include('home.developers')

    </section><!-- /Developers Section -->

    <!-- Faq Section -->
    <section id="faq" class="faq section light-background">

      @include('home.faq')
    </section><!-- /Faq Section -->

    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials section">

      @include('home.testimonials')

    </section><!-- /Testimonials Section -->

    <!-- Gallery Section -->
    <section id="gallery" class="gallery section">

      @include('home.gallery')

    </section><!-- /Gallery Section -->

    <!-- Contact Section -->
    

  </main>

  <footer id="footer" class="footer light-background">

    @include('home.footer')

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>