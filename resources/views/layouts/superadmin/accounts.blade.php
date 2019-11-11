@extends('layouts.dashboard')

@section('title')
<title>PSI Queue | Accounts</title>
@endsection

@section('main_content')
<div class="container d-flex justify-content-center">
        <div class="row">
          <div class="col-sm">
            <a href="/superadmin/accounts/view/queue_administrators">
              <figure class="card1 hover-yellow">
              <figcaption>
                <center>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                <h2 class="text-white"> <span>Queue Administrators</span></h2>
                <p>View Queue Administrators.</p>
              </figcaption>
            </figure></a>
          <!-- partial -->
            <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
          </div>
          <div class="col-sm">
              <a href="/superadmin/accounts/view/station_administrators">
                <figure class="card2">
                <figcaption>
                  <center>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                  <h2 class="text-white"> <span>Station Administrators</span></h2>
                  <p>View Station Administrators.</p>
                </figcaption>
              </figure></a>
          <!-- partial -->
            <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
          </div>
          <div class="col-sm">
            <a href="#">
              <a href="/superadmin/accounts/new">
                <figure class="card3 hover-yellow">
                <figcaption>
                  <center>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                  <h2 class="text-white"> <span>Create new</span></h2>
                  <p>Create a new Account.</p>
                </figcaption>
              </figure></a>
          <!-- partial -->
            <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
          </div>
        </div>
      </div>
@endsection
