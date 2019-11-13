@extends('WindowAdmin')

@section('title')

<title>PSI Queue | Window Administrator {{ $windowNumber }}</title>
@endsection

@section('link')

<small class="text-white">Station {{$WindowStationNumber}} - {{$StationName}} </small>
@endsection

@section('main_content')
<!-- Custom Number Modal -->
<div class="modal fade" id="customNumberModal" tabindex="-1" role="dialog" aria-labelledby="customNumberModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-secondary modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="customNumberModalLabel">Get a Queue Number.</h4>
        <button type="button" class="close " data-dismiss="modal" aria-label="Close">
          <i class="far fa-times-circle"></i>
        </button>
      </div>
      <div class="modal-body">

        <div class="container">
          <div class="row">
            <div class="col-sm">
              <div class="text-left">
          <h5 class="card-title">Setting up a Custom Number</h5>
           <small>Enter basic customer details.</small>
        </div>
                {!! Form::open(['url' => '/Queue/custom', 'class' => 'form-horizontal', 'method' => 'POST']) !!}
        <div class="form-group mb-3">
          <div class="input-group input-group-alternative">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <i class="fas fa-user-circle"></i>
              </span>
            </div>
            <input id="custom_Name" type="text" placeholder="Customer Name" class="form-control{{ $errors->has('custom_Name') ? ' is-invalid' : '' }}" name="custom_Name" value="{{ old('custom_Name') }}" required autofocus>
            </div>
          </div>
          <div class="form-group mb-3">
            <div class="input-group input-group-alternative">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="fas fa-sort-numeric-down"></i>
                </span>
              </div>
              <input id="custom_Number" type="text" placeholder="Customer Number" class="form-control{{ $errors->has('custom_Number') ? ' is-invalid' : '' }}" name="custom_Number" value="{{ old('custom_Number') }}" required autofocus>
              </div>
            </div>
            </div>
            <div class="col-sm">
              <div class="text-left">
                <h5 class="card-title">Additional customer details</h5>
                <small>Is Person with Disablity?</small>
              </div>
              <div class="form-group mb-3">
                <div class="input-group input-group-alternative">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-wheelchair"></i>
                    </span>
                  </div>
                          {{Form::select('priority', ['No' , 'Yes'], null, ['class' => 'form-control custom-select']) }}

                </div>
              </div>
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
            </div>
            <div class="col-sm" data-toggle="tooltip" data-placement="right" title="You can <b>send</b> this custom number <b>in any station in the Queue</b>." data-html="true">
              <div class="text-left">
                  <h5 class="card-title">Station Handling</h5>
                  <small>Transfer Number to Station:</small>
                </div>
                <div class="form-group mb-3">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="fas fa-layer-group"></i>
                      </span>
                    </div>
                         {{Form::select('queue_stations', $queueStations, null, ['class' => 'form-control custom-select']) }}
                  </div>
                </div>
            </div>
          </div>
        </div>

              </div>
              <div class="modal-footer">
                  {{Form::bsSubmit('Proceed',['class' => 'btn btn-primary'])}}
              </div>
            </div>
          </div>
        </div>
        {!! Form::close() !!}
        <!-- Table Modal -->
        <div class="modal fade" id="TableModal" tabindex="-1" role="dialog" aria-labelledby="table_Modal" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h2 class="modal-title" id="table_Modal">Detailed queue line display</h2>
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
                          <th class="text-left text-dark">Priority</th>
                          <th class="text-left text-dark" data-toggle="tooltip" data-placement="left" title="'
                            <span class='badge badge-dot'>
                              <i class='bg-success'></i>
                            </span>
                            <i class='fas fa-check-circle'></i> ' indicates that a number
                            <b>has a note</b>." data-html="true">
                            <i class="fas fa-info-circle"></i> Note
                          </th>
                        </tr>
                      </thead>
                    @foreach($recentCreated as $recent)

                      <tr>
                        <td class="text-left">{{ $recent->queue_number }}</td>
                        <td class="text-left">{{ $recent->client_name }}</td>
                        @if($recent->queue_priority == 0)

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
                        @if($recent->queue_note)

                        <td class="text-left">
                          <span class="badge badge-dot">
                            <i class="bg-success"></i>
                          </span>{{ $recent->queue_note }}
                        </td>
                      </tr>
                        @else

                      <td class="text-left">
                        <span class="badge badge-dot">
                          <i class="bg-danger"></i>
                        </span> None
                      </td>
                    </tr>
                        @endif
                        @endforeach

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
        {!! Form::open(['action' => 'PoolsController@create', 'method' => 'GET' ]) !!}

      <div class="row justify-content-center">
        <div class="container">
          <div class="row">
            <div class="col-sm-4 mt-3">
              <div class="card_Gray text-center">
                <div class="card-header-gray text-dark">
                  Get a Queue number.
                </div>
                <div class="card-body">
                  <h5 class="card-title text-left">Enter basic customer details</h5>
                  <div class="form-group mb-3">
                    <div class="input-group input-group-alternative">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="fas fa-user-circle"></i>
                        </span>
                      </div>
                      <input id="name" type="text" placeholder="Customer Name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                      </div>
                    </div>
                    <hr>
                      <div class="text-left">
                        <h5 class="card-title">Additional customer details</h5>
                        <small>Is Person with Disablity?</small>
                      </div>
                      <div class="form-group mb-3">
                        <div class="input-group input-group-alternative">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="fas fa-wheelchair"></i>
                            </span>
                          </div>
                          {{Form::select('priority', ['No' , 'Yes'], null, ['class' => 'form-control custom-select']) }}

                        </div>
                      </div>
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
                      <div class="container">
                        <div class="row">
                          <div class="col-sm">
                          {{Form::bsSubmit('Proceed',['class' => 'btn btn-primary'
                                              ,'data-html' => 'true'
                                              ,'data-placement' => 'top'
                                              ,'title' => 'Generate a queue number.'
                                              ,'data-toggle' => 'tooltip' ])}}
                        </div>
                          <div class="col-sm">
                            <!-- Button trigger modal -->
                            <div data-toggle="tooltip" data-placement="right" title="Enables you to create a number with <b>custom details</b>." data-html="true">
                                <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#customNumberModal">
                                  Custom
                                </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              {!! Form::close() !!}

                <div class="col-sm-4 mt-3">
                  <div class="card_Gray text-center">
                    <div class="card-header-gray text-dark">
                  Queue Details
                </div>
                    <div class="card-body">
                      <div class="card card-stats" data-toggle="tooltip" data-placement="right" title="This
                        <b>displays</b> the
                        <b> total count of numbers created in the Queue</b>." data-html="true">
                        <div class="card-body">
                          <div class="row">
                            <div class="col">
                              <h5 class="card-title text-left text-muted">Queue Count</h5>
                              <h2 class="text-left">
                                  {{ $queueCount }}
                              </h2>
                            </div>
                            <div class="col-auto">
                              <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                                <i class="fas fa-sort-numeric-up"></i>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="card card-stats mt-2" data-toggle="tooltip" data-placement="right" title="This
                        <b>displays</b> the
                        <b>last number created</b> by this specific window." data-html="true">
                        <div class="card-body">
                          <div class="row">
                            <div class="col">
                              <h5 class="card-title text-left text-muted">Last number created</h5>
                              <h2 class="text-left">
                             {{ $queueLastNumber }}
                          </h2>
                            </div>
                            <div class="col-auto">
                              <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                                <i class="fas fa-undo-alt"></i>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="card card-stats mt-2" data-toggle="tooltip" data-placement="right" title="This
                        <b>tracks the total numbers created by this specific window</b>." data-html="true">
                        <div class="card-body">
                          <div class="row">
                            <div class="col">
                              <h5 class="card-title text-left text-muted">Numbers created count</h5>
                              <h2 class="text-left">
                              {{ $queueCreatedNumber }}
                          </h2>
                            </div>
                            <div class="col-auto">
                              <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                                <i class="fas fa-plus-circle"></i>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <br>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4 mt-3">
                    <div class="card_Gray text-center">
                      <div class="card-header-gray text-dark">
                  Recent Numbers
                </div>
                      <div class="card-body">
                    @if(!count($recentCreated))

                        <i class="fas fa-exclamation-circle"></i>
                        <b>No numbers are recently created.</b>
                    @endif
                    @if(count($recentCreated))

                        <div class="table-responsive">
                          <table class="table align-items-center table-flush white-container">
                            <thead class="thead-light ">
                              <tr>
                                <th class="text-left text-dark">Number</th>
                                <th class="text-left text-dark">Name</th>
                                <th class="text-left text-dark" data-toggle="tooltip" data-placement="top" title="'
                                  <span class='badge badge-dot'>
                                    <i class='bg-success'></i>
                                  </span>
                                  <i class='fas fa-check-circle'></i> ' indicates that a number
                                  <b>has a note</b>." data-html="true">
                                  <i class="fas fa-info-circle"></i> Note
                                </th>
                              </tr>
                            </thead>
                        @foreach($recentCreated as $recent)

                            <tr>
                              <td class="text-left">{{ $recent->queue_number }}</td>
                              <td class="text-left">{{ $recent->client_name }}</td>
                                @if(!$recent->queue_note)

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

                            </tr>
                        @endforeach

                          </table>
                        </div>
                        <span data-toggle="modal" data-target="#TableModal">
                          <a class="btn btn-outline-primary" href="#" data-toggle="tooltip" data-html="true" data-placement="left" title="Displays a
                            <b>more detailed</b> table of the Queue Numbers." onclick="return false;">Further Details
                          </a>
                        </span> @endif

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
@endsection
