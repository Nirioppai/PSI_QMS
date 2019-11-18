@extends('layouts.superadminDashboard') xx

@section('title')
<title>PSI Queue | New Account</title>
@endsection

@section('main_content')
<div class="container">
	@if($Status == "true")
	<div class="row justify-content-center align-items-center toast-alert" id="myDiv">
		<div class="col-sm-8">
		<a href="/superadmin/accounts/new">
			<div class="alert  alert-success alert-dismissible fade show" role="alert">
						<span class="badge badge-pill badge-success">Success</span> &nbsp;&nbsp;&nbsp;You have successfully created an account.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
						</button>
				</div>
				</a>
		</div>
	</div>
	@endif

	<div class="row justify-content-center align-items-center">

		<div class="col-lg-7">
	    	<div class="card bg-secondary shadow-lg border-0">
	           <div class="card-header bg-transparent">
	            	<h3 class="mb-0">Register an account for this Queue Management System.</h3>
	            </div>
	            {!! Form::open(['url' => '/superadmin/accounts/new/submit']) !!}
	            @csrf
		        <div class="card-body px-md-5 py-lg-4">
		        	<div class="container">
						<div class="row">
				    		<div class="col-sm">
				    			<div class="form-group mb-3">
								   <div class="text-muted">
								   </div>
								   <div class="input-group input-group-alternative">
								      <div class="input-group-prepend">
								         <span class="input-group-text"><i class="fas fa-id-card-alt"></i></span>
								      </div>
								      <input id="name" placeholder="Name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

								      @if ($errors->has('name'))
								      <span class="invalid-feedback text-center" role="alert">
								         <strong><i class="fas fa-exclamation-triangle text-red"></i> {{ $errors->first('name') }}</strong>
								      </span>
								   @endif
								   </div>
								</div>
	    					</div>
	  					</div>

	  					<div class="row">
				    		<div class="col-sm">
				    			<div class="form-group mb-3">
								   <div class="text-muted">
								   </div>
								   <div class="input-group input-group-alternative">
								      <div class="input-group-prepend">
								         <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
								      </div>
								      <input id="username" placeholder="Username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus>

								      @if ($errors->has('username'))
								      <span class="invalid-feedback text-center" role="alert">
								         <strong><i class="fas fa-exclamation-triangle text-red"></i> {{ $errors->first('username') }}</strong>
								      </span>
								   @endif
								   </div>
								</div>
	    					</div>
	  					</div>

	  					<div class="row">
				    		<div class="col-sm">
				    			<div class="form-group mb-3">
								   <div class="text-muted">
								   </div>
								   <div class="input-group input-group-alternative">
								      <div class="input-group-prepend">
								         <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
								      </div>
								      <input id="password" placeholder="Password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{ old('password') }}" required autofocus>

								      @if ($errors->has('password'))
								      <span class="invalid-feedback text-center" role="alert">
								         <strong><i class="fas fa-exclamation-triangle text-red"></i> {{ $errors->first('password') }}</strong>
								      </span>
								   @endif
								   </div>
								</div>
	    					</div>
	  					</div>

	  					<div class="row">
				    		<div class="col-sm">
				    			<div class="form-group">
	                                <div class="input-group input-group-alternative">
	                                    <div class="input-group-prepend">
	                                    	<span class="input-group-text"><i class="fas fa-lock"></i></span>
	                                    </div>
	                                    <input id="password-confirm" placeholder="Confirm Password" type="password" class="form-control" name="password_confirmation" required>
	                                </div>
	                            </div>
	    					</div>
	  					</div>

	  					<div class="row">
				    		<div class="col-sm">
				    			<div class="form-group">
	                                <div class="input-group input-group-alternative">
		                                <div class="input-group-prepend">
		                                    <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
		                                </div>
	                                    <select class="form-control" placeholder="Account Type" name="account_type">
		                                    <option value="Super Admin">Super Admin</option>
		                                    <option value="Queue Admin">Queue Admin</option>
		                                    <option value="Station Admin">Station Admin</option>
	                                    </select>
	                                </div>
	                            </div>
	    					</div>
	  					</div>

	  					<div class="row">
				    		<div class="col-sm text-center">
				    			{{Form::submit('Create Account', ['class' => 'btn btn-primary'])}}
	    					</div>
	  					</div>
	  					{!! Form::close() !!}
					</div>
		        </div>
	     	</div>
	    </div>

	</div>


</div>
@endsection

<script
  src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous"></script>

<script type="text/javascript">
$(document).ready(function() {
   window.setTimeout("fadeMyDiv();", 3000); //call fade in 3 seconds
 }
)

function fadeMyDiv() {
   $("#myDiv").fadeOut('slow');
}

</script>
