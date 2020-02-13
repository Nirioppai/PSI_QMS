<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Flashboard;
use App\PoolView;
use Auth;

class FlashboardController extends Controller
{
      /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
      $this->middleware('auth:flashboard');
    }

    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Contracts\Support\Renderable
    */
    public function index()
    {  
      $station_number = Auth::guard('flashboard')->user()->record_station_number;

      $windows = PoolView::all()
        ->where('queue_station_number', '=', $station_number)
        ->sortBy('queue_window_number');

      return view('Flashboard')
        ->with('windows',$windows);
    }

}
