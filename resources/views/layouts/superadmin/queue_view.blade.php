@php
  $currentUser = Auth::user()->name;
@endphp

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
                                      <a data-html="true" data-toggle="tooltip" data-placement="right"  href="/home/Reset-{{$queue_record->id}}" class=" btn btn-sm btn-warning">Reset Queue</a>
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

                                        <input type="hidden" name="whenActive" value="0">
                                        <input type="hidden" name="whenInactive" value="1">
                                    </td>
                                    <td class="text-left">
                                       @if($queue_record->queue_status == 1)
                                          <i class="bg-success"></i>
                                          <a data-html="true" data-toggle="tooltip" data-placement="right"  href="/home/Deactivate-{{$queue_record->id}}" class=" btn btn-sm btn-danger">Deactivate</a>
                                       @endif
                                       @if($queue_record->queue_status == 0)
                                          <i class="bg-success"></i>
                                          <a data-html="true" data-toggle="tooltip" data-placement="right"  href="/home/Activate-{{$queue_record->id}}" class=" btn btn-sm btn-success">Activate</a>
                                       @endif
                                       <button onclick="edit_station(this)" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#edit_station" value="{{$queue_record->queue_name}}">Edit</button>
                                       </td>
                                 </tr>
                                 @endforeach
                              </table>

                     @endif

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
                                    <a class="card-link" data-toggle="collapse" href="#add_station">Add Station</a>
                                  </div>
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
                                        <input type="hidden" name="aS_Cb" value="{{ $currentUser }}">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn btn-primary">Add Station</button>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

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
