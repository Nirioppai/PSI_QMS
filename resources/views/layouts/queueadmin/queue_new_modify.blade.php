@extends('layouts.queueadminDashboard')

@section('title')
<title>PSI Queue | New Queue</title>
@endsection

@section('main_content')
<div class="container d-flex justify-content-center">
  <!-- Modal -->
  <div class="modal fade finalizeModal py-6" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h2 class="modal-title" id="exampleModalLabel">Review your queue, so we can <b>finalize</b> it.</h2>
        </div>
        <div class="modal-body">
          <div class="container">
            <div class="row">
              <div class="col-sm">
                You created a queue named "<?php echo '<b>' . $QueueName . '</b>';?>" with <?php echo '<b>' . $number_of_stations . '</b>'; ?> Stations. Save this current design?
              </div>
            </div>
            <div class="row">
              <div class="col-sm">
                <br>
                <div class="table-responsive">
                <table class="table align-items-center table-flush">
                  <thead class="thead-light">
                  <tr>
                    <th scope="row"><i class="fas fa-sort-numeric-up"></i>&nbsp;Station Number</th>
                    <th><i class="far fa-sticky-note"></i>&nbsp;Station Name</th>
                    <th><i class="fas fa-list-ol "></i>&nbsp;Number of Windows</th>
                    <th><i class="fas fa-user-circle"></i>&nbsp;Station Admin</th>
                  </tr>
                </thead>
                  @foreach($queue_designer1s as $queue_designer1)
                  <tr>
                    <td>Station {{$queue_designer1->number_of_stations}}</td>
                    <td>{{$queue_designer1->station_name}}</td>
                    <td>{{$queue_designer1->number_of_windows}}</td>
                    <td>{{$queue_designer1->station_admin}}</td>
                  </tr>
                  @endforeach
                </table>
              </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="container">
            <div class="row">
              <div class="col-sm text-left">
                <a href="/queueadmin/queues/new" data-html="true" data-toggle="tooltip" data-placement="top" title="Create your queue <b>from the start</b>." class="btn btn-primary"><i class="fas fa-undo-alt"></i> Reset Queue</a>
              </div>
              <div class="col-sm text-right">
                {!! Form::open(['url' => '/queueadmin/queues/new/modify/save']) !!}
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times-circle"></i> Close</button>
                @csrf
                <button type="submit" data-html="true" data-toggle="tooltip" data-placement="top" title="<b> Save</b> this Queue Design." class="btn btn-primary"><i class="fas fa-check-circle"></i> Save changes</button>
                {!! Form::close() !!}
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid mt--6">
    <div class="card bg-secondary shadow-lg border-0">
      <div class="card-header bg-transparent">
        <h2 class="mb-0">Next,<b> edit</b> your Queue Details.</h2>
      </div>
      {!! Form::open(['url' => '/queueadmin/queue/new/submit_1']) !!}
      @csrf
      <div class="card-body px-md-5 py-lg-4">
        <div class="container">
          <div class="row">
            <div class="col-sm">

              <div class="table-responsive">
                <table class="table align-items-center table-flush">
                  <thead class="thead-light">
                  <tr>
                    <th scope="row"><i class="fas fa-sort-numeric-up"></i>&nbsp;Station Number</th>
                    <th><i class="far fa-sticky-note"></i>&nbsp;Station Name</th>
                    <th><i class="fas fa-list-ol "></i>&nbsp;Number of Windows</th>
                    <th><i class="fas fa-user-circle"></i>&nbsp;Station Admin</th>
                    <th><i class="far fa-plus-square"></i>&nbsp;Add Data</th>
                  </tr>
                </thead>
                  @foreach($queue_designer1s as $queue_designer1)
                  <tr>
                    <td>Station {{$queue_designer1->number_of_stations}}</td>
                    <td>{{$queue_designer1->station_name}}</td>
                    <td>{{$queue_designer1->number_of_windows}}</td>
                    <td>{{$queue_designer1->station_admin}}</td>
                    <td><a data-html="true" data-toggle="tooltip" data-placement="top" title="Edit Station Details." href="/queueadmin/queues/new/modify/{{$queue_designer1->id}}/edit" class="btn btn-primary"><i class="fas fa-edit"></i> Edit</a></td>
                  </tr>
                  @endforeach
                </table>
              </div>

            </div>
          </div>
          <div class="row">
            <div class="col-sm text-left">
              <a href="/queueadmin/queues/new" class="btn btn-primary"><i class="fas fa-arrow-alt-circle-left"></i> Back</a>
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".finalizeModal"><i class="fas fa-check-circle"></i> Finalize Queue</button>
            </div>
          </div>
        </div>
    </div>
  {!! Form::close() !!}
  </div>
</div>
</div>
@endsection
