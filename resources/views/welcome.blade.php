@extends('layouts.app')
@section('title')
<title>PSI Queue | Welcome!</title>
@endsection

@section('main_content')
<nav class="navbar navbar-top navbar-horizontal navbar-expand-md navbar-dark">
      <div class="container px-4">
        <a  href="/home">
        <img src="../assets/img/brand/psiWhite.png">
        </a>
      </div>
    </nav>
    <!-- Navbar End -->
    <!-- Header -->
    <div class="header bg-gradient-primary py-7 py-lg-5">
      <div class="container">
        <div class="header-body text-center mb-8">
          <div class="row justify-content-center">
            <div class="col-lg-5 col-md-6">
              <h1 class="text-white">Registration</h1>
              <p class="text-lead text-light">Welcome! Sign up an account on this Queueing System.</p>
            </div>
          </div>
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
        <div class="col-lg-5 col-md-8">
          <div class="card bg-secondary shadow border-0">
            <div class="card-body px-lg-5 py-lg-5">
              {!! Form::open(['url' => '/Welcome/Submit']) !!}
                @csrf
                <div class="form-group">
                  <div class="input-group input-group-alternative mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-circle-08"></i></span>
                    </div>
                    <input id="Name" name="Name"  class="form-control{{ $errors->has('Name') ? ' is-invalid' : '' }}" value="{{ old('Name') }}" required autofocus placeholder="Name" type="text">
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-alternative mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-id-card-alt"></i></span>
                    </div>
                    <input  id="Username" name="Username" class="form-control{{ $errors->has('Username') ? ' is-invalid' : '' }}" value="{{ old('Username') }}" required placeholder="Username" type="text">
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                    </div>
                    <input id="Password" name="Password" class="form-control{{ $errors->has('Password') ? ' is-invalid' : '' }}" required placeholder="Password" type="password">
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    </div>
                    <input id="Password_Confirm" name="Password_Confirm" class="form-control{{ $errors->has('Password_Confirm') ? ' is-invalid' : '' }}" required placeholder="Password Confirmation {{ $errors->has('Password_Confirm') ? 'does not match.' : '' }}" type="password">
                  </div>
                </div>
                <div class="text-center">
                  {{Form::submit('Create Account', ['class' => 'btn btn-primary'])}}
                </div>
              {!! Form::close() !!}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
