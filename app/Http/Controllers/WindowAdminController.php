<?php

namespace App\Http\Controllers;

use Illuminate\Queue\Queue;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\QueueRecords;
use App\ArchiveView; // Loui Views
use App\T0Pools; //
use App\T1Pools; //
use App\T2Pools; //
use App\T03Pool; //



class WindowAdminController extends Controller
{
      /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
      $this->middleware('auth:window_admin');
    }

    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Contracts\Support\Renderable
    */
    public function index()
    {
        // OnView Data Station 1
        $queueDetails = ArchiveView::all()
            ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name);
        $queueCount = $queueDetails
            ->unique('queue_number')
            ->count();
        $queueLastNumber = $queueDetails
            ->max('queue_number');
        $queueCreatedNumber = $queueDetails
            ->Where('queue_window_number', '=', Auth::guard('window_admin')->user()->window_number)
            ->Where('queue_station_number', '=', 2)
            ->Where('queue_action', '=', 0)
            ->count();
        $recentCreated = $queueDetails
            ->Where('queue_window_number', '=', Auth::guard('window_admin')->user()->window_number)
            ->unique('queue_number')
            ->sortByDesc('created_at')
            ->take(5);
        $stationDetails = QueueRecords::all()
            ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
            ->where('record_type', '=', 'Station');
        $queueStations = $stationDetails
            ->where('record_number', '>', '1')
            ->pluck('record_number')
            ->unique();
        $windowNumber =  Auth::guard('window_admin')->user()->window_number;


        // OnView Data Stations
        $onWindow = T1Pools::all()
            ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
            ->where('queue_station_number', '=', Auth::guard('window_admin')->user()->window_station_number)
            ->where('queue_window_number', '=', Auth::guard('window_admin')->user()->window_number);
        $onWindowCount = $onWindow
            ->count();
        $onWindowNumber =  $onWindow
            ->pluck('queue_number')
            ->last();
        $onWindowName =  $onWindow
            ->pluck('client_name')
            ->last();
        $onPool = T03Pool::all()
            ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
            ->where('queue_station_number', '=', Auth::guard('window_admin')->user()->window_station_number)
            ->take(4);
        $onDetails = T03Pool::all()
            ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
            ->where('queue_station_number', '=', Auth::guard('window_admin')->user()->window_station_number)
            ->take(5);
        $onHold = T2Pools::all()
            ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
            ->where('queue_station_number', '=', Auth::guard('window_admin')->user()->window_station_number)
            ->take(3);
        $stationNumber =  Auth::guard('window_admin')->user()->window_station_number;


        // Default OnView Data Station 1
        if($queueLastNumber == null)
        {
            $queueLastNumber = 0;
        }

        //Get Station Name and Station Number
        $WindowStationNumber = Auth::guard('window_admin')->user()->window_station_number;
        $WindowQueueName = Auth::guard('window_admin')->user()->queue_name;
        $StationName = QueueRecords::where('record_number',$WindowStationNumber)
        ->where('record_type', 'Station')
        ->where('queue_name', $WindowQueueName)
        ->pluck('record_name')
        ->first();



        if(Auth::guard('window_admin')->user()->window_station_number == 1)
        {
            return view('layouts.windowadmin.station_1')
                ->with('queueCount', $queueCount)
                ->with('queueLastNumber', $queueLastNumber)
                ->with('queueCreatedNumber', $queueCreatedNumber)
                ->with('recentCreated', $recentCreated)
                ->with('queueStations', $queueStations)
                ->with('stationNumber', $stationNumber)
                ->with('windowNumber', $windowNumber)
                ->with('WindowStationNumber', $WindowStationNumber)
                ->with('StationName', $StationName);

        }

        if(Auth::guard('window_admin')->user()->window_station_number != 1)
        {
            return view('layouts.windowadmin.stations')
                ->with('onWindowCount', $onWindowCount)
                ->with('onWindowNumber', $onWindowNumber)
                ->with('onWindowName', $onWindowName)
                ->with('onPool', $onPool)
                ->with('onHold', $onHold)
                ->with('stationNumber', $stationNumber)
                ->with('windowNumber', $windowNumber)
                ->with('queueStations', $queueStations)
                ->with('WindowStationNumber', $WindowStationNumber)
                ->with('StationName', $StationName)
                ->with('onDetails', $onDetails);

        }


        else
        {
            return redirect('/');
        }
    }

}
