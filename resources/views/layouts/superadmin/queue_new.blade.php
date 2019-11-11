@extends('layouts.dashboard')

@section('title')
<title>PSI Queue | New Queue</title>
@endsection

@section('main_content')


<div class="container">
  @if(!count($StationAdmins))
  <div class="row justify-content-center align-items-center">
    <div class="col-sm-8">
    <a href="/superadmin/accounts/new">
      <div class="alert  alert-warning alert-dismissible fade show" role="alert">
            <span class="badge badge-pill badge-warning text-white">Warning</span> &nbsp;&nbsp;&nbsp;You have no Station Administrators. Click here to make one now.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        </a>
    </div>
  </div>
  @endif

  @if($Status == "true")
  <div class="row justify-content-center align-items-center toast-alert" id="myDiv">
    <div class="col-sm-8">
    <a href="/superadmin/accounts/new">
      <div class="alert  alert-success alert-dismissible fade show" role="alert">
            <span class="badge badge-pill badge-success">Success</span> &nbsp;&nbsp;&nbsp;You have successfully created a queue.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        </a>
    </div>
  </div>
  @endif

@if(count($StationAdmins))
  <div class="row justify-content-center align-items-center">
    <div class="col-lg-5">
    	<div class="card bg-secondary shadow-lg border-0">
           <div class="card-header bg-transparent">
            	<h3 class="mb-0">Start up the Queue with Basic Details.</h3>
            </div>
            {!! Form::open(['url' => '/superadmin/queue/new/submit_1']) !!}
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
							         <span class="input-group-text"><i class="far fa-edit"></i></span>
							      </div>
							      <input id="queue_name" placeholder="Queue Name" type="text" class="form-control{{ $errors->has('queue_name') ? ' is-invalid' : '' }}" name="queue_name" value="{{ old('queue_name') }}" required autofocus>

							      @if ($errors->has('queue_name'))
							      <span class="invalid-feedback text-center" role="alert">
							         <strong><i class="fas fa-exclamation-triangle text-red"></i> {{ $errors->first('queue_name') }}</strong>
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
							         <span class="input-group-text"><i class="fas fa-layer-group"></i></span>
							      </div>
							      <input id="number_of_stations" placeholder="Number of Stations" type="text" class="form-control{{ $errors->has('number_of_stations') ? ' is-invalid' : '' }}" name="number_of_stations" value="{{ old('number_of_stations') }}" required autofocus>

							      @if ($errors->has('number_of_stations'))
							      <span class="invalid-feedback text-center" role="alert">
							         <strong><i class="fas fa-exclamation-triangle text-red"></i> {{ $errors->first('number_of_stations') }}</strong>
							      </span>
							   @endif
							   </div>
							</div>
    					</div>
  					</div>

  					<div class="row">
			    		<div class="col-sm text-left">
			    			<button type="submit" class="btn btn-primary"><i class="fas fa-arrow-alt-circle-right"></i> Submit</button>
    					</div>
  					</div>
  					{!! Form::close() !!}
				</div>
	        </div>
     	</div>
    </div>
  </div>
  @endif
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
