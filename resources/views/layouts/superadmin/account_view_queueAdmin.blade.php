@extends('layouts.superadminDashboard')

@section('title')
<title>PSI Queue | Queue Administrators</title>
@endsection

@section('main_content')
<div class="container">
@if(!count($QueueAdmins))
<div class="row justify-content-center align-items-center">
  <div class="col-sm-8">
  <a href="/superadmin/accounts/new">
    <div class="alert  alert-warning alert-dismissible fade show" role="alert">
          <span class="badge badge-pill badge-warning text-white">Warning</span> &nbsp;&nbsp;&nbsp;You have no Queue Administrators. Click here to make one now.
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
      </div>
      </a>
  </div>
</div>
@endif

@if(count($QueueAdmins))
<div class="container">
  <div class="row justify-content-center align-items-center">
    <div class="card bg-secondary shadow-lg border-0">
      <div class="card-header bg-transparent">
        <h3 class="mb-0">List of Queue Administrators</h3>
      </div>
      <div class="card-body px-md-5 py-lg-4">
        <div class="container">
          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                 <tr>
                   <th><i class="fas fa-user-circle"></i>&nbsp;Name</th>
                   <th><i class="fas fa-id-card-alt"></i>&nbsp;Username</th>
                   <th><i class="far fa-sticky-note"></i>&nbsp;Created By</th>
                 </tr>
              </thead>
              @foreach($QueueAdmins as $QueueAdmin)
              <tr>
                 <td class="text-left">{{$QueueAdmin->name}}</td>
                 <td class="text-left">{{$QueueAdmin->username}}</td>
                 <td class="text-left">{{$QueueAdmin->created_by}}</td>
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
