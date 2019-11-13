@extends('WindowAdmin')

@section('title')
<title>PSI Queue | Window Administrator {{ $windowNumber }}</title>
@endsection

@section('link')
<a class="nav-link">Station {{ $stationNumber }} - {{$StationName}} </a>
@endsection

@section('main_content')
<div class="modal fade" id="TransferModal" tabindex="-1" role="dialog" aria-labelledby="transfer_modal" aria-hidden="true">
	<div class="modal-dialog modal-sm modal-dialog-centered" role="document">
		<div class="modal-content">
		    <div class="modal-header">
		      <h4 class="modal-title" id="table_Modal"><b>Transfer number to Another Station</b></h4>
		      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		        <span aria-hidden="true">&times;</span>
		      </button>
		    </div>

		    <div class="modal-body">
		    	<div class="text-left">
                  <h5 class="card-title">Select station for number to be transferred.</h5>
                </div>
                {!! Form::open(['url' => '/Queue/transfer', 'class' => 'form-horizontal', 'method' => 'POST']) !!}
                <div class="form-group mb-3">
                    <div class="input-group input-group-alternative">
                        <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="far fa-sticky-note"></i>
                    </span>
                        </div>
                        {{ Form::bsText('note', '', ['placeholder' => 'Leave Note'])}}

                    </div>
                </div>
                <div class="form-group mb-3">
                  <div class="input-group input-group-alternative">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-redo"></i></span>
                     </div>
                      {{Form::select('queue_stations', $queueStations, null, ['class' => 'form-control custom-select']) }}
                  </div>
                </div>

                <div class="float-right">
                    {{Form::bsSubmit('Transfer',['class' => 'btn btn-outline-primary'])}}
			    </div>
                {!! Form::close() !!}
		    </div>

	    </div>
	</div>
</div>
<div class="modal fade" id="TableModal" tabindex="-1" role="dialog" aria-labelledby="table_Modal" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
	  <div class="modal-content">
	    <div class="modal-header">
	      <h2 class="modal-title" id="table_Modal">Detailed Queue Number Display</h2>
	      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        <span aria-hidden="true">&times;</span>
	      </button>
	    </div>
	    <div class="modal-body">
	      <div class="table-responsive">
	        <div>
	          <!-- Dito pagination dapat dito -->
	          <table class="table align-items-center table-flush">
	            <thead class="thead-light">
	              <tr>
	                  <th class="text-left text-dark">Number</th>
	                  <th class="text-left text-dark">Name</th>
	                  <th class="text-left text-dark" data-toggle="tooltip" data-placement="left" title="'<b class= text-danger> Waiting </b>' indicates that a number has been <b>skipped</b>." data-html="true"><i class="fas fa-info-circle"></i> Status</th>
	                  <th class="text-left text-dark" data-toggle="tooltip" data-placement="left" title="' <span class='badge badge-dot'>
	                    <i class='bg-waiting'></i>
	                  </span>
	                  <i class='fas fa-check-circle'></i> ' indicates that a number is <b>prioritized</b>." data-html="true"><i class="fas fa-info-circle"></i> Priority</th>
	                  <th class="text-left text-dark" data-toggle="tooltip" data-placement="left" title="' <span class='badge badge-dot'>
	                    <i class='bg-waiting'></i>
	                  </span>
	                  <i class='fas fa-check-circle'></i> ' indicates that a number <b>has a note</b>." data-html="true"><i class="fas fa-info-circle"></i> Note</th>
	                </tr>
	            </thead>

	            <tr>
	              <td class="text-left">1</td>
	              <td class="text-left">Nico</td>
	              <td class="text-left text-waiting"><b>Waiting</b></td>
	              <td class="text-left">
	                  <span class="badge badge-dot">
	                    <i class="bg-waiting"></i>
	                  </span>
	                  <i class="fas fa-check-circle"></i>
	              </td>
	              <td class="text-left">
	              <span class="badge badge-dot">
	                    <i class="bg-danger"></i>
	              </span>None</td>
	            </tr>

	            <tr>
	              <td class="text-left">2</td>
	              <td class="text-left">Loui</td>
	              <td class="text-left text-danger"><b>Waiting</b></td>
	              <td class="text-left">
	                  <span class="badge badge-dot">
	                    <i class="bg-danger"></i>
	                  </span>
	                  <i class="fas fa-times-circle"></i>
	              </td>
	              <td class="text-left">
	              <span class="badge badge-dot">
	                    <i class="bg-waiting"></i>
	              </span>Nag CR lang daw</td>
	            </tr>

	          </table>
	        </div>
	      </div>
	      <div class="text-right">
	    	<a  class="btn btn-secondary" data-dismiss="modal">Close</a>
	      </div>
	    </div>
	  </div>
	</div>
</div>
<div class="container">
  <div class="row">
    <div class="col-sm-6 mt-3">
      <div class="card_Gray text-center">
        <div class="card-header-gray text-dark">
         <b>Queue Handling</b>
        </div>
		    <div class="card-body">
		    	<!-- If not currently serving a number -->
                @if(!$onWindowCount)
			    <h3 class="card-title text-left">
                    <center>
                      No Current Transaction.
                    </center>
                </h3>
			    <hr>
			    <!-- If not currently serving a number end -->
                @else
			    <!-- If currently serving a number -->
			    <h3 class="card-title text-left">Now serving:</h3>

			    <div class="card card-stats" data-toggle="tooltip" data-placement="right" title="This <b>displays</b> the <b> total count of numbers created in the Queue</b>." data-html="true">
			          <div class="card-body">
			            <div class="row">

			              <div class="col">
                              <h1 class="text-left">{{ $onWindowNumber }}</h1>
			                  <h3 class="card-title text-left text-muted">{{ $onWindowName }}</h3>
			              </div>

			              <div class="col-auto">
			              	<br>
			                <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
			                    <i class="fas fa-sort-numeric-up"></i>
			                </div>
			              </div>

			            </div>
			          </div>
			     </div>
                @endif
                {!! Form::open(['url' => '/Queue/noteCheck', 'class' => 'form-horizontal', 'method' => 'POST']) !!}
                @if($onWindowCount)
                <div class="form-group mb-3">
                    <div class="input-group input-group-alternative">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="far fa-sticky-note"></i>
                            </span>
                        </div>
                        {{ Form::bsText('note', '', ['placeholder' => 'Leave Note'])}}

                    </div>
                </div>
                @endif
	            <div class="text-left">

	            	<h3 class="card-title text-left">Window Controls</h3>

	            </div>
	            <div class="container">
					<div class="row">
                        @if(!$onWindowCount)
						<div class="col-sm">
                                <a href="/Queue/getNumber" class="btn btn-outline-primary">
                                    Get Number
                                </a>
                        </div>
                            @else
                                <div class="col-sm">
                                    {{Form::button('',['class' => 'icon icon-shape bg-waiting text-white rounded-circle shadow fas fa-arrow-right text-white'
                                                               ,'data-toggle' => 'tooltip'
                                                               ,'data-html' => 'true'
                                                               ,'data-placement' => 'bottom'
                                                               ,'title' => '<b>Move</b> number'
                                                               ,'value' => 'done'
                                                               ,'name' => 'action'
                                                               ,'type' => 'submit'])}}
                                </div>
						<div class="col-sm">
                            {{Form::button('',['class' => 'icon icon-shape bg-orange text-white rounded-circle shadow fas fa-forward text-white'
                                                       ,'data-toggle' => 'tooltip'
                                                       ,'data-html' => 'true'
                                                       ,'data-placement' => 'bottom'
                                                       ,'title' => '<b>Skip</b> number'
                                                       ,'value' => 'skip'
                                                       ,'name' => 'action'
                                                       ,'type' => 'submit'])}}
						</div>
						<div class="col-sm">
						      <a href="#" onclick="bleep.play()">
	                              <div class="icon icon-shape bg-purple
	                                 text-white rounded-circle shadow" data-toggle="tooltip" data-placement="top" title="Beep">
	                                 <i class="fas fa-volume-up"></i>
	                              </div>
	                           </a>
						</div>
						<div class="col-sm">
                            {{Form::button('',['class' => 'icon icon-shape bg-yellow text-dark rounded-circle shadow far fa-hand-paper text-dark'
                                                       ,'data-toggle' => 'tooltip'
                                                       ,'data-html' => 'true'
                                                       ,'data-placement' => 'bottom'
                                                       ,'title' => '<b>Hold</b> number'
                                                       ,'value' => 'hold'
                                                       ,'name' => 'action'
                                                       ,'type' => 'submit'])}}
						</div>

						<div class="col-sm">
						      <div class="dropdown">
	                              <a  id="dropdownMenuButton" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	                                 <div class="icon icon-shape bg-danger
	                                    text-white rounded-circle shadow" data-toggle="tooltip" data-placement="top" title="Take a Break">
	                                    <i class="fas fa-clock"></i>
	                                 </div>
	                              </a>
	                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                      {{ Form::button('<b>Move number</b> then <b>Break</b>'
                                            ,['class' => 'dropdown-item'
                                            ,'value' => 'moveBreak'
                                            ,'type' => 'submit'
                                            ,'name' => 'action']) }}
                                      {{ Form::button('<b>Skip number</b> then <b>Break</b>'
                                            ,['class' => 'dropdown-item'
                                            ,'value' => 'skipBreak'
                                            ,'type' => 'submit'
                                            ,'name' => 'action']) }}
	                              </div>
	                           </div>
						</div>

						<div class="col-sm">
						      <a data-toggle="modal" data-target="#TransferModal" href="#"  onclick="return false;">
	                              <div class="icon icon-shape bg-blue text-white rounded-circle shadow" data-html="true" data-toggle="tooltip" data-placement="top" title="Transfer number to <b> Other Station</b>">
	                                 <i class="fas fa-redo"></i>
	                              </div>
	                           </a>
						</div>
                            {!! Form::close() !!}
                        @endif
					</div>
                    <hr>
				</div>

				<!-- If currently serving a number end -->
                @if($onHold)
				<!-- If there are numbers on hold -->
				<div class="text-left">
	            	<h3 class="card-title text-left">Numbers on Hold</h3>
	            </div>
	            <div class="table-responsive">
		            <table class="table align-items-center table-flush">

			            <thead class="thead-light">
			              <tr>
			                <th class="text-left text-dark">Number</th>
			                <th class="text-left text-dark">Name</th>
			                <th class="text-left text-dark">Priority</th>
			                <th class="text-left text-dark">Note</th>
                              <th class="text-left text-dark">Action</th>
			              </tr>
			            </thead>
                        @foreach($onHold as $hold)
			            <tr>
                            <td class="text-left">{{ $hold->queue_number }}</td>
			              <td class="text-left">{{ $hold->client_name }}</td>
                          @if($hold->queue_priority == 0)
			              <td class="text-left">
			                  <span class="badge badge-dot">
			                    <i class="bg-danger"></i>
			                  </span>
			                  <i class="fas fa-times-circle"></i>
			              </td>
                              @else
                                <td class="text-left">
			                  <span class="badge badge-dot">
			                    <i class="bg-success"></i>
			                  </span>
                                    <i class="fas fa-check-circle"></i>
                                </td>
                            @endif
                            @if($hold->queue_note)
			              <td class="text-left">
			              <span class="badge badge-dot">
			                    <i class="bg-waiting"></i>
			              </span>
                              {{ $hold->queue_note }}
                          </td>
                            @else
                                <td class="text-left">
			              <span class="badge badge-dot">
			                    <i class="bg-danger"></i>
			              </span>
                                    None
                                </td>
                            @endif
                            <td>
                                <a class="btn btn-sm btn-outline-primary" href="/Queue/getOnHold-{{$hold->id}}">Take</a>
                            </td>
			            </tr>
                    @endforeach
			        </table>
		    	</div>
                @else
		        <!-- If there are numbers on hold end -->

		        <!-- If there are no numbers on hold -->
				<div class="text-left">
	            	<h3 class="card-title text-left">
                        <center>
                            No Current On Hold Numbers.
                        </center>
                    </h3>
	            </div>
	            <!-- If there are no numbers on hold end -->
                @endif
        		</div>
      </div>
    </div>
    <div class="col-sm-6 mt-3">
      <div class="card_Gray text-center">

                <div class="card-header-gray text-dark">
                	<b>Queue Numbers</b>
                </div>

                <div class="card-body">
                	<div class="table-responsive">
                    <table class="table align-items-center table-flush white-container">
                      <thead class="thead-light ">
                        <tr>
                          <th class="text-left text-dark">Number</th>
                          <th class="text-left text-dark">Name</th>
                          <th class="text-left text-dark" data-toggle="tooltip" data-placement="right" title="'<b class= text-danger> Waiting </b>' indicates that a number has been <b>skipped</b>." data-html="true"><i class="fas fa-info-circle"></i> Status</th>
                          <th class="text-left text-dark" data-toggle="tooltip" data-placement="left" title="' <span class='badge badge-dot'>
                            <i class='bg-waiting'></i>
                          </span>
                          <i class='fas fa-check-circle'></i> ' indicates that a number is <b>prioritized</b>." data-html="true"><i class="fas fa-info-circle"></i> Priority</th>
                          <th class="text-left text-dark" data-toggle="tooltip" data-placement="left" title="' <span class='badge badge-dot'>
                            <i class='bg-waiting'></i>
                          </span>
                          <i class='fas fa-check-circle'></i> ' indicates that a number <b>has a note</b>." data-html="true"><i class="fas fa-info-circle"></i> Note</th>
                        </tr>
                      </thead>
                        @foreach($onPool as $pool)
                      <tr>
                        <td class="text-left">{{ $pool->queue_number }}</td>
                        <td class="text-left">{{ $pool->client_name }}</td>
                        @if($pool->queue_action == 0)
                              <td class="text-left text-waiting"><b>Waiting</b></td>
                          @else
                              <td class="text-left text-danger"><b>Waiting</b></td>
                          @endif
                            @if($pool->queue_priority == 1)
                                  <td class="text-left">
                              <span class="badge badge-dot">
                                <i class="bg-success"></i>
                              </span>
                                      <i class="fas fa-check-circle"></i>
                                  </td>
                              @else
                                  <td class="text-left">
                              <span class="badge badge-dot">
                                <i class="bg-danger"></i>
                              </span>
                                      <i class="fas fa-times-circle"></i>
                                  </td>
                              @endif
                          @if($pool->queue_note)
                              <td class="text-left">
                                  <span class="badge badge-dot">
                                    <i class="bg-success"></i>
                                  </span>
                                  <i class="fas fa-check-circle"></i>
                              </td>
                          @else
                              <td class="text-left">
                                  <span class="badge badge-dot">
                                    <i class="bg-danger"></i>
                                  </span>
                                  <i class="fas fa-times-circle"></i>
                              </td>
                          @endif

                      </tr>
                        @endforeach
                    </table>
                  </div>
                  <span data-toggle="modal" data-target="#TableModal">
					    <a class="btn btn-outline-primary" href="#" data-toggle="tooltip" data-html="true" data-placement="left" title="Displays a <b>more detailed</b> table of the Queue Numbers."  onclick="return false;">Further Details</a>
					</span>

            	</div>
        	</div>
    	</div>
	</div>
</div>
@endsection
