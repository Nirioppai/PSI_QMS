<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StationAdminController extends Controller
{
      /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
      $this->middleware('auth:station_admin');
    }

    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Contracts\Support\Renderable
    */
    public function index()
    {
      return view('layouts.stationadmin.home');
    }

}
