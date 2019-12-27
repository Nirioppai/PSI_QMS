@extends('layouts.superadminDashboard')

@section('title')
<title>PSI Queue | Queue List</title>
@endsection

@section('main_content')
<div class="container">
  <div class="row justify-content-center align-items-center">
    <div class="card bg-secondary shadow-lg border-0">
      <div class="card-header bg-transparent">
        <h3 class="mb-0">Queue List</h3>
      </div>
      <div class="card-body px-md-5 py-lg-4">
        <div class="container">
          @if(count($QueueRecord))

                     <table class="table align-items-center table-flush">
                                 <thead class="thead-light">
                                    <tr>
                                       <th><i class="far fa-sticky-note"></i>&nbsp;Queue Name</th>
                                       <th><i class="fas fa-list-ol "></i>&nbsp;Number of Stations</th>
                                       <th><i class="fas fa-id-card-alt"></i>&nbsp;Admin</th>
                                       <th><i class="fas fa-id-card-alt"></i>&nbsp;Action</th>
                                       <th><i class="fas fa-exclamation"></i>&nbsp;Status</th>
                                       <th><i class="fas fa-wrench"></i>&nbsp;Edit Status</th>
                                    </tr>
                                 </thead>
                                 @foreach($QueueRecord as $queue_record)
                                 <tr>
                                    <td class="text-left">{{$queue_record->record_name}}</td>
                                    <td class="text-left">{{$queue_record->record_number_of_stations}}</td>
                                    <td class="text-left">{{$queue_record->record_admin}}</td>
                                    <td>
                                      <!-- Changes Start Here -->
                                      <button type="button" data-html="true" data-toggle="modal" data-target="#reset-Queue-{{$queue_record->id}}" data-placement="right" class=" btn btn-sm btn-warning">Reset</button>
                                      <button type="button" data-html="true" data-toggle="modal" data-target="#rename-Queue-{{$queue_record->id}}" data-placement="right" class=" btn btn-sm btn-warning">Rename</button>
                                      <button type="button" data-html="true" data-toggle="modal" data-target="#delete-Queue-{{$queue_record->id}}" data-placement="right" class=" btn btn-sm btn-warning">Delete</button>
                                      <button onclick="edit_station(this)" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#edit_station" value="{{$queue_record->queue_name}}">Edit</button>
                                      
                                      <!-- Rename Modal -->
                                      <div class="modal fade" id="rename-Queue-{{$queue_record->id}}" tabindex="-1" role="dialog"
                                        aria-labelledby="rename-QueueLabel" aria-hidden="true">
                                        {!! Form::open(['url' => '/Queue/rename-'.$queue_record->id, 'class' => 'form-horizontal', 'method' => 'POST']) !!}
                                        <div class="modal-dialog" role="document">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h5 class="modal-title" id="rename-QueueLabel">Rename Queue</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                              <div class="form-group mb-3">
                                                <small>New Queue Name</small>
                                                <div class="input-group input-group-alternative">
                                                  <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                      <i class="fas fa-layer-group"></i>
                                                    </span>
                                                  </div>
                                                          {{ Form::bsText('newQueueName', '', ['placeholder' => 'New Queue Name', 'class' => 'form-control'])}}

                                                </div>
                                              </div>
                                            </div>
                                            <div class="modal-footer">
                                              {{Form::bsSubmit('Save Changes',['class' => 'btn btn-success'])}}
                                          </div>
                                        </div>
                                        {!! Form::close() !!}
                                      </div>
                                    </div>
                                      <!-- Modal Ends Here -->

                                      <!-- Delete Confirmation Modal -->
                                      <div class="modal fade" id="delete-Queue-{{$queue_record->id}}" tabindex="-1" role="dialog"
                                        aria-labelledby="delete-QueueLabel" aria-hidden="true">
                                        {!! Form::open(['url' => '/Queue/delete-'.$queue_record->id, 'class' => 'form-horizontal', 'method' => 'POST']) !!}
                                        <div class="modal-dialog" role="document">
                                          <div class="modal-content">
                                              <h5 class="modal-title" id="delete-QueueLabel"></h5>
                                            <div class="modal-body">
                                                <h5 class="text-center">Are sure you want to <b>DELETE {{$queue_record->record_name}}</b>?</h5>
                                                <div>
                                                  <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">No</span></button>
                                                  {{Form::bsSubmit('Yes',['class' => 'btn btn-success'])}}
                                                </div>
                                              </div>
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                      </div>
                                    </div>
                                      <!-- Modal Ends Here -->

                                      <!-- Reset Confirmation Modal -->
                                      <div class="modal fade" id="reset-Queue-{{$queue_record->id}}" tabindex="-1" role="dialog"
                                        aria-labelledby="reset-QueueLabel" aria-hidden="true">
                                        {!! Form::open(['url' => '/Queue/reset-'.$queue_record->id, 'class' => 'form-horizontal', 'method' => 'POST']) !!}
                                        <div class="modal-dialog" role="document">
                                          <div class="modal-content">
                                              <h5 class="modal-title" id="reset-QueueLabel"></h5>
                                            <div class="modal-body">
                                                <h5 class="text-center">Are sure you want to <b>RESET {{$queue_record->record_name}}</b>?</h5>
                                                <div>
                                                  <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">No</span></button>
                                                  {{Form::bsSubmit('Yes',['class' => 'btn btn-success'])}}
                                                </div>
                                              </div>
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                      </div>
                                    </div>
                                      <!-- Modal Ends Here -->

                                      <!-- Changes End Here -->
                                    </td>
                                    <td class="text-left">
                                        <span class="badge badge-dot">

                                          @if($queue_record->queue_status == 1)
                                          <i class="bg-success"></i>
                                          Active
                                          @endif
                                           @if($queue_record->queue_status == 0)
                                           <i class="bg-danger"></i>
                                          Inactive
                                          @endif
                                        </span>
                                    </td>
                                    <td class="text-left">
                                       @if($queue_record->queue_status == 1)
                                          <i class="bg-success"></i>
                                          <button type="button" data-html="true" data-toggle="modal" data-target="#deactivate-Queue-{{$queue_record->id}}" data-placement="right" class=" btn btn-sm btn-danger">Deactivate</button>
                                       @endif
                                       @if($queue_record->queue_status == 0)
                                          <i class="bg-success"></i>
                                          <button type="button" data-html="true" data-toggle="modal" data-target="#activate-Queue-{{$queue_record->id}}" data-placement="right" class=" btn btn-sm btn-warning">Activate</button>
                                       @endif
                                       </td>
                                       
                                        <!-- Activate Confirmation Modal -->
                                      <div class="modal fade" id="activate-Queue-{{$queue_record->id}}" tabindex="-1" role="dialog"
                                        aria-labelledby="activate-QueueLabel" aria-hidden="true">
                                        {!! Form::open(['url' => '/Queue/activate-'.$queue_record->id, 'class' => 'form-horizontal', 'method' => 'POST']) !!}
                                        <div class="modal-dialog" role="document">
                                          <div class="modal-content">
                                              <h5 class="modal-title" id="activate-QueueLabel"></h5>
                                            <div class="modal-body">
                                                <h5 class="text-center">Are sure you want to <b>Activate {{$queue_record->record_name}}</b>?</h5>
                                                <div>
                                                  <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">No</span></button>
                                                  {{Form::bsSubmit('Yes',['class' => 'btn btn-success'])}}
                                                </div>
                                              </div>
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                      </div>
                                    </div>
                                      <!-- Modal Ends Here -->

                                    <!-- Deactivate Confirmation Modal -->
                                      <div class="modal fade" id="deactivate-Queue-{{$queue_record->id}}" tabindex="-1" role="dialog"
                                        aria-labelledby="deactivate-QueueLabel" aria-hidden="true">
                                        {!! Form::open(['url' => '/Queue/deactivate-'.$queue_record->id, 'class' => 'form-horizontal', 'method' => 'POST']) !!}
                                        <div class="modal-dialog" role="document">
                                          <div class="modal-content">
                                              <h5 class="modal-title" id="deactivate-QueueLabel"></h5>
                                            <div class="modal-body">
                                                <h5 class="text-center">Are sure you want to <b>DEACTIVATE {{$queue_record->record_name}}</b>?</h5>
                                                <div>
                                                  <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">No</span></button>
                                                  {{Form::bsSubmit('Yes',['class' => 'btn btn-success'])}}
                                                </div>
                                              </div>
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                      </div>
                                    </div>
                                      <!-- Modal Ends Here -->

                                 </tr>
                                 @endforeach
                              </table>

                              <!-- Changes End Here -->
                     @endif

                    <!-- Start Edit Station Modal -->
                    <div class="modal fade" id="edit_station" role="dialog">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Edit Station</h4>
                            <h1 id="queue_name"></h1>
                          </div>

                          <div class="modal-body">
                            <div class="container">
                              <div id="accordion">
                                <div class="card">
                                  <div class="card-header">
                                    <!--  -->
                                    <a class="card-link" data-toggle="collapse" href="#add_station">Add Station</a>
                                  </div>

                                  <!-- Start Add Station Accordion -->
                                  <div id="add_station" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                      <form name="add_station" method="post" action="{{ route('SAaddStation.submit' )}}" onsubmit="return ASn_validateForm()">
                                        <div class="form-group">
                                          <input type="number" name="aS_SNr" id="aS_SNr" placeholder="Station Number" class="form-control">
                                        </div>

                                        <div class="form-group">
                                          <input type="text" name="aS_SNe" id="aS_SNe" placeholder="Station Name" class="form-control">
                                        </div>

                                        <div class="form-group">
                                          <input type="number" name="aS_NoWs" id="aS_NoWs" placeholder="Number of Windows" class="form-control">
                                        </div>

                                        <div class="form-group">
                                          <input type="number" name="aS_NoPy" id="aS_NoPy" placeholder="Number of Priority Windows" class="form-control">
                                        </div>

                                        <div class="form-group">
                                          <select name="aS_SAn" id="aS_SAn" class="form-control">
                                            <option value="" selected disabled>
                                              Select Station Admin</option>
                                            @foreach ($StationAdmins as $station_admin)
                                              <option value="{{ $station_admin->name }}">
                                                {{ $station_admin->name }}
                                              </option>
                                            @endforeach
                                          </select>
                                        </div>

                                        <input type="hidden" name="aS_QNe" id="aS_QNe" value="">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn btn-primary">Add Station</button>
                                      </form>
                                    </div>
                                  </div>
                                  <!-- End Add Station Accordion -->

                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- End Edit Station Modal -->
                      @if(!count($QueueRecord))
                      <div class="container">
                      <div class="row ">
                        <div class="col text-center"><h1><i class="fas fa-exclamation-triangle"></i> No Queues Available.</h1></div>

                      </div>
                      </div>
                      @endif
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="{{ asset('/assets/js/queue_view.js')}}"></script>
@endsection
