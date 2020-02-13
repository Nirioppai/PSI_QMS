<!DOCTYPE html>
<html>

<head>

  @yield('title')

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Favicon -->
  <link href="{{ asset('/assets/img/brand/icon.png') }}" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- Icons -->
  <link href="{{ asset('assets/vendor/nucleo/css/nucleo.css') }}" rel="stylesheet">
  <script src="https://kit.fontawesome.com/76c4804a71.js"></script>
  <link href="{{ asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
  <!-- Argon CSS -->
  <link type="text/css" href="{{ asset('assets/css/argon.css?v=1.0.0') }}" rel="stylesheet">
  <!-- jquery -->
  <script type = "text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body class="bg-default">
  <div class="main-content">
  <!-- Main content -->

    <!-- Top navbar -->
    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
      <div class="container-fluid">
        <!-- Brand -->
          <a href="/">
            <img src="{{ asset('assets/img/brand/PSI_Resized_White.png') }}">
          </a>

          <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                @yield('link')
              </li>
            </ul>

            <ul class="navbar-nav align-items-center d-none d-md-flex">
              <li class="nav-item dropdown">
                <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <div class="media align-items-center">
                    <span class="avatar avatar-sm rounded-circle">
                      <img alt="Image placeholder" src="{{ asset('assets/img/theme/window_admin.png') }}">
                    </span>
                    <div class="media-body ml-2 d-none d-lg-block">
                      <span class="mb-0 text-sm  font-weight-bold">Window Administrator</span>
                    </div>
                  </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                  <div class=" dropdown-header noti-title">
                    <h6 class="text-overflow m-0">Welcome, EnrollmentS2W2!</h6>
                  </div>
                  <a href="#" class="dropdown-item">
                    <i class="ni ni-single-02"></i>
                    <span>My profile</span>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="{{ route('logout') }}" class="dropdown-item">
                    <i class="ni ni-user-run"></i>
                    <span>Logout</span>
                  </a>
                </div>
              </li>
            </ul>
        </div>
        <!-- User -->
      </div>
    </nav>
    <!-- Navbar End -->

    <!-- Header -->
    <div class="header bg-gradient-primary py-7 py-lg-6">
      <div class="container">
        <div class="header-body text-center mb-8">
        </div>
      </div>
      <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </div>


    <div class="container mt--9 pb-5">
    <!-- Page content -->
    @yield('main_content')

    <!-- Main Content End -->
    </div>
  </div>
  <!-- Footer -->
  <footer class="py-3">
    <div class="container">
      <div class="row align-items-center justify-content-xl-between">
        <div class="col-xl-6">
          <div class="copyright text-center text-xl-left text-muted">
            &copy; 2019 <a href="#" class="font-weight-bold ml-1 text-muted" target="_blank">『 Philippine Softwares Inc. 』</a>
          </div>
        </div>
        <div class="col-xl-6">
          <ul class="nav nav-footer justify-content-center justify-content-xl-end">
            <li class="nav-item">
              <a href="#" class="nav-link text-muted" target="_blank">About</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="{{ asset('assets/vendor/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <!-- Argon JS -->
  <script src="{{ asset('assets/js/argon.js?v=1.0.0') }}"></script>
</body>

</html>
