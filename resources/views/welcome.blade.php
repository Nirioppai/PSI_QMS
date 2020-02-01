@extends('layouts.app')
@section('title')
<title>PSI Queue | Welcome!</title>
@endsection

@section('main_content')
    <!-- Header -->
    <div class="header bg-gradient-yellow  py-7 py-lg-5">
      <div class="container">
        <div class="header-body text-center mb-8">
          <div class="row justify-content-center">
            <div class="col-lg-5 col-md-6 mt-5">
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
    <div class="container mt--9    pb-5">
      <!-- Table -->
      <div class="row justify-content-center mb--4">

        <div class="col-lg-4 col-md-7 ">
        
          {!! Form::open(['url' => '/Welcome/Submit', 'class' => 'bg-white text-center border border-light p-5 ', 'method' => 'POST']) !!}
            @csrf
            <img src="{{asset('../assets/img/brand/xsLogo.png')}}" class=" text-left mt--4" alt="...">
            <p class="h2 mt-2 text-left">Create account</p>

            <div class="md-form mt--1">
                <input id="Name" name="Name"  class="form-control{{ $errors->has('Name') ? ' is-invalid' : '' }}" value="{{ old('Name') }}" required autofocus placeholder="Name" type="text">

                                @if ($errors->has('Name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('Name') }}</strong>
                                    </span>
                                @endif
                <label for="materialLoginFormName"><i class="ni ni-circle-08"></i> <small>Name</small></label>
            </div>

            <div class="md-form mt--1">
                <input  id="Username" name="Username" class="form-control{{ $errors->has('Username') ? ' is-invalid' : '' }}" value="{{ old('Username') }}" required placeholder="Username" type="text">

                @if ($errors->has('Username'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('Username') }}</strong>
                    </span>
                @endif
                <label for="materialLoginFormUsername"><i class="fas fa-id-card-alt"></i> <small>Username</small></label>
            </div>

            <div class="md-form mt--1">

                <input id="Password" name="Password" class="form-control{{ $errors->has('Password') ? ' is-invalid' : '' }}" required placeholder="Password" type="password">

                @if ($errors->has('Password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('Password') }}</strong>
                    </span>
                @endif
                <label for="materialLoginFormPassword"><i class="ni ni-lock-circle-open"></i> <small>Password</small></label>
            </div>

            <div class="md-form mt--1">
                 <input id="Password-confirm" type="password" class="form-control" name="Password_confirmation" required>
                <label for="materialLoginFormConfirmPassword"><i class="fas fa-lock"></i> <small>Confirm Password</small></label>
            </div>

            <div class="text-center">
            <button type="submit" class="btn btn-sm btn-outline-primary btn-block mb--3">
                {{ __('Register') }}
            </button>
            </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
@endsection
