<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  @yield('title')
  <!-- Favicon -->
  <link href="{{ asset('/assets/img/brand/icon.png') }}" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- Icons -->
  <link href="{{ asset('/assets/vendor/nucleo/css/nucleo.css') }}" rel="stylesheet">
  <link href="{{ asset('/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
  <!-- Argon CSS -->
  <link type="text/css" href="{{ asset('/assets/css/flip.css') }}" rel="stylesheet">
  <link type="text/css" href="{{ asset('/assets/css/argon.css?v=1.0.0') }}" rel="stylesheet">
</head>

<body>
  <!-- Sidenav -->
  <nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
      <!-- Toggler -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Brand -->
      <a class="navbar-brand pt-0" href="/superadmin/home">
        <img src="{{ asset('/assets/img/brand/PSI_Resized_Black.png') }}" class="navbar-brand-img" alt="...">
      </a>
      <!-- User -->
      <ul class="nav align-items-center d-md-none">
        <li class="nav-item dropdown">
          <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="media align-items-center">
              <span class="avatar avatar-sm rounded-circle">
                <img alt="Image placeholder" src="../assets/img/theme/station_admin.png">
              </span>
            </div>
          </a>
          <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
            <div class=" dropdown-header noti-title">
              <h6 class="text-overflow m-0">Welcome!</h6>
            </div>
            <a href="../examples/profile.html" class="dropdown-item">
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
      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <!-- Collapse header -->
        <div class="navbar-collapse-header d-md-none">
          <div class="row">
            <div class="col-6 collapse-brand">
              <a href="/superadmin/home">
                <img src="{{ asset('/assets/img/brand/PSI_Resized_Black.png') }}">
              </a>
            </div>
            <div class="col-6 collapse-close">
              <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                <span></span>
                <span></span>
              </button>
            </div>
          </div>
        </div>
        <!-- Navigation -->
        <h6 class="navbar-heading text-muted">Navigation</h6>
           <!-- Navigation -->
           <ul class="navbar-nav">
              <li class="nav-item">
                 <a class="nav-link text-dark" href="/superadmin/home">
                 <i class="fas fa-tachometer-alt text-blue"></i> Dashboard
                 </a>
              </li>
           </ul>
           <hr class="my-0">
           <h6 class="navbar-heading text-muted">Stations</h6>
           <!-- Queues -->
           <ul class="navbar-nav">
              <li class="nav-item">
                 <a class="nav-link text-dark" href="/superadmin/queues">
                 <i class="fas fa-pen-square text-blue"></i> Station Management
                 </a>
              </li>
           </ul>
            <hr class="my-0">
           <h6 class="navbar-heading text-muted">People</h6>
           <!-- People -->
           <ul class="navbar-nav">
              <li class="nav-item">
                 <a class="nav-link text-dark" href="/superadmin/accounts">
                 <i class="fas fa-user-circle text-blue"></i> Window Administrators
                 </a>
              </li>
           </ul>
           <hr class="my-0">
           <h6 class="navbar-heading text-muted">Logs</h6>
           <!-- Logs -->
           <ul class="navbar-nav">
              <li class="nav-item">
                 <a class="nav-link text-dark" href="/superadmin/archives">
                 <i class="fas fa-clipboard text-blue"></i> Archive
                 </a>
              </li>
           </ul>
      </div>
    </div>
  </nav>
  <!-- Main content -->
  <div class="main-content">
    <!-- Top navbar -->
    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
      <div class="container-fluid">
        <!-- Breadcrumb -->
        <div class="collapse navbar-collapse">
           <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
              <li class="nav-item">
                 <a class="nav-link" href="/about"><small>About</small></a>
              </li>
           </ul>
        </div>
        <!-- User -->
        <ul class="navbar-nav align-items-center d-none d-md-flex">
          <li class="nav-item dropdown">
            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="media align-items-center">
                <span class="avatar avatar-sm rounded-circle">
                  <img alt="Image placeholder" src="{{ asset('assets/img/theme/station_admin.png') }}">
                </span>
                <div class="media-body ml-2 d-none d-lg-block">
                  <span class="mb-0 text-sm  font-weight-bold">Station Admin</span>
                </div>
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
              <div class=" dropdown-header noti-title">
                <h6 class="text-overflow m-0">Welcome!</h6>
              </div>
              <a href="../examples/profile.html" class="dropdown-item">
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
    </nav>
    <!-- Header -->
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <div class="row">
            <div class="col-xl-3 col-lg-6">
  <!-- We can put Cards here -->
            </div>
            <div class="col-xl-3 col-lg-6">
  <!-- We can put Cards here -->
            </div>
            <div class="col-xl-3 col-lg-6">
  <!-- We can put Cards here -->
            </div>
            <div class="col-xl-3 col-lg-6">
  <!-- We can put Cards here -->
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--7">
      <div class="row">

        @yield('main_content')
        @include('toast::messages-jquery')

      </div>
      <div class="row mt-5">
        <div class="col-xl-8 mb-5 mb-xl-0">


        </div>
        <div class="col-xl-4">


        </div>
      </div>
      <!-- Footer -->
      <footer class="footer">
        <div class="row align-items-center justify-content-xl-between">
          <div class="col-xl-6">
            <div class="copyright text-center text-xl-left text-muted">
              &copy; 2019 <a href="https://www.facebook.com/Philippine-Softwares-Inc-101678331227061/" class="font-weight-bold ml-1" target="_blank">Philippine Softwares Inc.</a>
            </div>
          </div>
          <div class="col-xl-6">
            <ul class="nav nav-footer justify-content-center justify-content-xl-end">
              <li class="nav-item">
                <a href="#" class="nav-link" target="_blank">About</a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link" target="_blank">Contact us</a>
              </li>
            </ul>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="{{ asset('/assets/vendor/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <!-- Optional JS -->
  <script src="{{ asset('/assets/vendor/chart.js/dist/Chart.min.js') }}"></script>
  <script src="{{ asset('/assets/vendor/chart.js/dist/Chart.extension.js') }}"></script>
  <!-- Argon JS -->
  <script src="{{ asset('/assets/js/argon.js?v=1.0.0') }}"></script>
</body>

</html>
