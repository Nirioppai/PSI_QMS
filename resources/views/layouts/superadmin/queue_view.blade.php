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
                                       </td>
                                 </tr>
                                 @endforeach
                              </table>

                     @endif

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
@endsection
