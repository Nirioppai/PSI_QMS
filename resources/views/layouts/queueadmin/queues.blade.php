@extends('layouts.queueadminDashboard')

@section('title')
<title>PSI Queue | Queues</title>
@endsection

@section('main_content')
<div class="container d-flex justify-content-center">
        <div class="row">
          <div class="col-sm">
              <a href="/queueadmin/queues/view">
                <figure class="card4">
                <figcaption>
                  <center>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                  <h2 class="text-white"> <span>View Queue</span></h2>
                  <p class="text-white">Display or Manage Available Queues.</p>
                </figcaption>
              </figure></a>
          <!-- partial -->
            <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
          </div>
          <div class="col-sm">
              <a href="/queueadmin/queues/new">
                <figure class="card5 hover-yellow">
                <figcaption>
                  <center>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                  <h2 class="text-white"> <span>Queue Designer</span></h2>
                  <p>Create a new Queue.</p>
                </figcaption>
              </figure></a>
          <!-- partial -->
            <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
          </div>
        </div>
      </div>
@endsection
