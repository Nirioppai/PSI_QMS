@extends('layouts.queueadminDashboard')

@section('title')
<title>PSI Queue | Accounts</title>
@endsection

@section('main_content')

@section('main_content')
<div class="container">
  <div class="row justify-content-center align-items-center">
    <div class="card bg-secondary shadow-lg border-0">
      <div class="card-header bg-transparent">
        <h3 class="mb-0">Station Administrators of Queue: <b>{{$record_name}}</b></h3>
      </div>
      <div class="card-body px-md-5 py-lg-4">
        <div class="container">
          @if(count($Station_Admins))

                     <table class="table align-items-center table-flush">
                                 <thead class="thead-light">
                                    <tr>
                                       <th><i class="far fa-sticky-note"></i>&nbsp;Station Admin:</th>
                                       <th><i class="fas fa-list-ol "></i>&nbsp;Stationed at:</th>
                                       <th><i class="fas fa-id-card-alt"></i>&nbsp;Monitoring</th>
                                       <th><i class="fas fa-exclamation"></i>&nbsp;Account Status:	</th>


                                    </tr>
                                 </thead>
                                 @foreach($Station_Admins as $Station_Admin)
                                 <tr>
                                    <td class="text-left"><a href="/queueadmin/accounts/{{$record_name}}/{{$Station_Admin->record_number}}">{{$Station_Admin->record_admin}}</a></td>
                                    <td class="text-left">Station <b>{{$Station_Admin->record_number}}</b>, <b>{{$Station_Admin->record_name}}</b></td>
                                    <td class="text-left"><b>{{$Station_Admin->record_number_of_windows}}</b> Windows</td>
                                    <td class="text-left">
                                        <span class="badge badge-dot">

                                          @if($Station_Admin->queue_status == 1)
                                          <i class="bg-success"></i>
                                          Active
                                          @endif
                                           @if($Station_Admin->queue_status == 0)
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

                     @endif

                      @if(!count($Station_Admins))
                      <div class="container">
                      <div class="row ">
                        <div class="col text-center"><h1><i class="fas fa-exclamation-triangle"></i> No Station Administrators Available.</h1></div>

                      </div>
                      </div>
                      @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@endsection
