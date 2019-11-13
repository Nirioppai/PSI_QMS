@extends('layouts.superadminDashboard')

@section('title')
<title>PSI Queue | Archive</title>
@endsection


@section('main_content')
<div class="container">
@if(!count($QueueRecord))
<div class="row justify-content-center align-items-center">
  <div class="col-sm-8">
  <a href="/superadmin/queues/new">
    <div class="alert  alert-warning alert-dismissible fade show" role="alert">
          <span class="badge badge-pill badge-warning text-white">Warning</span> &nbsp;&nbsp;&nbsp;You have no Queues available. You can create one by clicking here.
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
      </div>
      </a>
  </div>
</div>
@endif

@if(count($QueueRecord))
<div class="container">
  <div class="row justify-content-center align-items-center">
    <div class="card bg-secondary shadow-lg border-0">
      <div class="card-header bg-transparent">
        <h3 class="mb-0">Queue List - Pick a queue below to view its archived logs.</h3>
      </div>
      <div class="card-body px-md-5 py-lg-4">
        <div class="container">
          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                 <tr>
                    <th><i class="far fa-sticky-note"></i>&nbsp;Queue Name</th>
                    <th><i class="fas fa-list-ol "></i>&nbsp;Number of Stations</th>
                    <th><i class="fas fa-id-card-alt"></i>&nbsp;Admin</th>
                    <th><i class="fas fa-exclamation"></i>&nbsp;Status</th>
                 </tr>
              </thead>
              @foreach($QueueRecord as $queue_record)
              <tr>
                 <td class="text-left">{{$queue_record->record_name}}</td>
                 <td class="text-left">{{$queue_record->record_number_of_stations}}</td>
                 <td class="text-left">{{$queue_record->record_admin}}</td>
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
              </tr>
              @endforeach
           </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endif
</div>
@endsection
