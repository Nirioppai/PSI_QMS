@extends('layouts.app')

@section('title')
        <title> PSI Queue | Flashboards </title>
@endsection

@section('main_content')

  <!-- Header -->
    <div class="header bg-gradient-yellow py-7 py-lg-6">
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
    <!-- Top navbar -->
    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
      <div class="container-fluid">
        <!-- Brand -->
          <a href="/flashboard/home">
            <img src="{{ asset('assets/img/brand/xsLogo.png') }}">
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
                      <span class="mb-0 text-sm text-dark font-weight-bold">Flashboard Administrator</span>
                    </div>
                  </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                  <div class=" dropdown-header noti-title">
                    <h6 class="text-overflow m-0">Welcome, EnrollmentS2!</h6>
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
        <div class="card">
            <div class="card-header">
                <h2>Flashboard</h2>
            </div>
            <div class="card-body">
                <div class="container" id = 'data'>
                  <!-- Live search container -->
                </div>
            </div>
            <div class="card-footer">

            </div>
        </div>
</div>
<!-- Live search script -->
<script type = "text/javascript">
  var auto_refresh = setInterval(function(){
  $('#data').load('<?php echo url('/flashboard/data'); ?>');
}, 1000);
  </script>
@endsection
