@extends('layouts.app')

@section('title')
<title>PSI Queue | Login</title>
@endsection

@section('main_content')
<nav class="navbar navbar-top navbar-horizontal navbar-expand-md navbar-dark">
      <div class="container px-4">
        <a href="/">
          <img src="../assets/img/brand/PSI_Resized_White.png">
        </a>
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

    <!-- Page content -->
    <div class="container mt--9 pb-5">
      <!-- Table -->
      <div class="row justify-content-center">
        <div class="col-lg-4 col-md-8">
          <div class="card bg-secondary shadow border-0">
            <div class="card-body px-lg-5 py-sm-3 ">
              <br>
              <br>
              <br>
              <div class="text-center text-muted mb-4">
                 <small>Sign in with your Admin Credentials.</small>
              </div>
              <form method="POST" action="{{ route('login') }}">
                 @csrf
                 <div class="form-group mb-3">
                    <div class="input-group input-group-alternative">
                       <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-id-card-alt"></i></span>
                       </div>
                       <input id="username" type="text" placeholder="Admin ID" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus>
                    </div>
                 </div>

                 <div class="form-group">
                    <div class="input-group input-group-alternative">
                       <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-lock"></i></span>
                       </div>
                       <input placeholder="{{ $errors->has('password') ? ' Invalid ' : '' }}Password{{ $errors->has('password') ? '. ' : '' }}" id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                    </div>
                 </div>

                 <div class="text-center">
                    <button type="submit" class="btn btn-outline-primary  my-4">
                    {{ __('Sign in') }}
                    </button>
                 </div>
                 
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
