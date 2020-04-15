@extends('layouts.app')

@section('title')
<title>PSI Queue | Login</title>
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

    <!-- Page content -->
    <div class="container mt--9 pb-5">
      <!-- Table -->
      <div class="row justify-content-center">

        <div class="col-lg-4 col-md-7 ">
        
           <form method="POST" class="bg-white text-center border border-light p-5" action="{{ route('login') }}">
            @csrf
            <img src="{{asset('../assets/img/brand/xsLogo.png')}}" class=" text-left mt--4" alt="...">
            <p class="h2 mt-2 text-left">Enter credentials</p>

            <div class="md-form mt--1">

                <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus>

                @if ($errors->has('username'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('username') }}</strong>
                    </span>
                @endif
                <label for="materialLoginFormUsername"><i class="fas fa-id-card-alt"></i> <small>Username</small></label>
            </div>

            <div class="md-form mt--1">
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
                <label for="materialLoginFormPassword"><i class="ni ni-lock-circle-open"></i> <small>Password</small></label>
            </div>

            <div class="text-center">
            <button type="submit" class="btn btn-md btn-outline-primary mb--3">
                {{ __('Sign in') }}
            </button>
            </div>
          </form>
        </div>


      </div>
    </div>
  </div>
@endsection
