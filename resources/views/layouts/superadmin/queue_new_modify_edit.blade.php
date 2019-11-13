@extends('layouts.superadminDashboard')

@section('title')
<title>PSI Queue | New Queue</title>
@endsection

@section('main_content')
<div class="container d-flex justify-content-center">
	<div class="col-lg-9">
    	<div class="card bg-secondary shadow-lg border-0">
           <div class="card-header bg-transparent">
            	<h3 class="mb-0">Manage additional information for your stations.</h3>
            </div>
             {!!Form::open(['action' => ['QueueDesigner2Controller@update',$queue_designer1->id], 'method' => 'POST'])!!}
            @csrf
	        <div class="card-body px-md-5 py-lg-4">
	        	<div class="container">
					<div class="row">
				    	<div class="col-sm">
				      		<div class="row">
					    		<div class="col-sm text-muted">
					    			<caption> <small>Basic Details </small></caption>
					    		</div>
			    			</div>

							<div class="row">
					    		<div class="col-sm">
					    			<div class="form-group mb-3">
									   <div class="input-group input-group-alternative">
									      <div class="input-group-prepend">
									         <span class="input-group-text"><i class="far fa-edit"></i></span>
									      </div>
									      <input id="station_name" placeholder="Station Name" type="text" class="form-control{{ $errors->has('station_name') ? ' is-invalid' : '' }}" name="station_name" value="{{ old('station_name') }}" required autofocus>

									    	@if ($errors->has('station_name'))
										      <span class="invalid-feedback text-center" role="alert">
										         <strong><i class="fas fa-exclamation-triangle text-red"></i> {{ $errors->first('station_name') }}</strong>
										      </span>
									   		@endif
									   </div>
									</div>
		    					</div>
		  					</div>

		  					<div class="row">
					    		<div class="col-sm">
					    			<div class="form-group mb-3">
									   <div class="input-group input-group-alternative">
									      <div class="input-group-prepend">
									         <span class="input-group-text"><i class="fas fa-layer-group"></i></span>
									      </div>
									      <input id="number_of_windows" placeholder="Number of Windows" type="text" class="form-control{{ $errors->has('number_of_windows') ? ' is-invalid' : '' }}" name="number_of_windows" value="{{ old('number_of_windows') }}" required autofocus>

									    	@if ($errors->has('number_of_windows'))
										      <span class="invalid-feedback text-center" role="alert">
										         <strong><i class="fas fa-exclamation-triangle text-red"></i> {{ $errors->first('number_of_windows') }}</strong>
										      </span>
									   		@endif
									   </div>
									</div>
		    					</div>
		  					</div>
				    	</div>
				    	<div class="col-sm">
				      		<div class="row">
					    		<div class="col-sm text-muted">
					    			<caption> <small>Additional Options</small></caption>
					    		</div>
					    	</div>

					    	<div class="row">
					    		<div class="col-sm">
					    			<div class="form-group mb-3">
									   <div class="input-group input-group-alternative">
									      <div class="input-group-prepend">
									         <span class="input-group-text"><i class="fas fa-inbox"></i></span>
									      </div>
									      <input id="number_of_kiosks" placeholder="Number of Kiosks" type="text" class="form-control{{ $errors->has('number_of_kiosks') ? ' is-invalid' : '' }}" name="number_of_kiosks" value="{{ old('number_of_kiosks') }}" required autofocus>

									    	@if ($errors->has('number_of_kiosks'))
										      <span class="invalid-feedback text-center" role="alert">
										         <strong><i class="fas fa-exclamation-triangle text-red"></i> {{ $errors->first('number_of_kiosks') }}</strong>
										      </span>
									   		@endif
									   </div>
									</div>
		    					</div>
		  					</div>

					    	<div class="row">
					    		<div class="col-sm">
		               				<div class="form-group mb-3">
									   <div class="input-group input-group-alternative">
									      <div class="input-group-prepend">
									         <span class="input-group-text"><i class="fas fa-wheelchair"></i></span>
									      </div>
									      <input id="number_of_priority_windows" placeholder="Number of Priority Windows" type="text" class="form-control{{ $errors->has('number_of_priority_windows') ? ' is-invalid' : '' }}" name="number_of_priority_windows" value="{{ old('number_of_priority_windows') }}" required autofocus>

									    	@if ($errors->has('number_of_priority_windows'))
										      <span class="invalid-feedback text-center" role="alert">
										         <strong><i class="fas fa-exclamation-triangle text-red"></i> {{ $errors->first('number_of_priority_windows') }}</strong>
										      </span>
									   		@endif
									   </div>
									</div>
					    		</div>
					    	</div>
				    	</div>
					</div>
					<div class="row">
						<div class="col-sm">
							<div class="row">
					    		<div class="col-sm text-muted">
					    			<caption> <small>Management</small></caption>
					    		</div>
			    			</div>

		  					<div class="row">
					    		<div class="col-sm">
					    			<div class="form-group">
						               <div class="input-group input-group-alternative">
						                  <div class="input-group-prepend">
						                     <span class="input-group-text"><i class="fas fa-id-card-alt"></i></span>
						                  </div>
						                  <select class="form-control" id="station_admin" name="station_admin">
						                     <?php foreach($users as $user): ?>
						                     <option value="<?= $user['name']; ?>"><?= $user['name']; ?></option>
						                     <?php endforeach; ?>
						                  </select>
						               </div>
						            </div>
		    					</div>
		    					<div class="col-sm">
		    					</div>
		  					</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm text-left">
							{{Form::hidden('_method', 'PUT')}}
    						<button type="submit" class="btn btn-primary"><i class="fas fa-arrow-alt-circle-right"></i> Submit</button>
    					</div>
					</div>
				</div>
	        </div>
	        {!! Form::close() !!}
     	</div>
    </div>
</div>
@endsection
