<?php

namespace App\Http\Controllers;

use Illuminate\Queue\Queue;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\QueueRecords;
use App\ArchiveView; // Loui Views
use App\PoolView; //
use App\T0Pools; //
use App\T1Pools; //
use App\T2Pools; //
use App\T03Pool; //
use App\T0Priority; //
use App\T1Priority; //
use App\T2Priority; //
use App\T03Priority; //


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
            ->unique('queue_number')
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

        // Priority Counters
        $counters  = PoolView::all()
            ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
            ->where('queue_station_number', '=', Auth::guard('window_admin')->user()->window_station_number);
        $PriorityCount = $counters
            ->where('queue_priority', '=', '1')
            ->count();
        $NonPriorityCount = $counters
            ->where('queue_priority', '=', '0')
            ->count();
        $OnWindowCheck = $counters
            ->where('queue_window_number', '=', Auth::guard('window_admin')->user()->window_number)
            ->where('queue_action', '=', '1')
            ->pluck('queue_priority')
            ->first();
        $priorityCheck = Auth::guard('window_admin')->user()->is_priority_window;

        // OnView Data Stations
        if($priorityCheck == 'Yes' || $NonPriorityCount == 0 )
        {
            if($OnWindowCheck == 0)
            {
                $onWindow = T1Pools::all()
                    ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                    ->where('queue_station_number', '=', Auth::guard('window_admin')->user()->window_station_number)
                    ->where('queue_window_number', '=', Auth::guard('window_admin')->user()->window_number);
                if($PriorityCount == 0)
                {
                    $onPool = T03Pool::all()
                        ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                        ->where('queue_station_number', '=', Auth::guard('window_admin')->user()->window_station_number)
                        ->take(4);
                    $onHold = T2Pools::all()
                        ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                        ->where('queue_station_number', '=', Auth::guard('window_admin')->user()->window_station_number)
                        ->take(3);
                    $onDetails = T03Pool::all()
                        ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                        ->where('queue_station_number', '=', Auth::guard('window_admin')->user()->window_station_number)
                        ->take(5);
                }
                else
                {
                    $onPool = T03Priority::all()
                        ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                        ->where('queue_station_number', '=', Auth::guard('window_admin')->user()->window_station_number)
                        ->take(4);
                    $onHold = T2Priority::all()
                        ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                        ->where('queue_station_number', '=', Auth::guard('window_admin')->user()->window_station_number)
                        ->take(3);
                    $onDetails = T03Priority::all()
                        ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                        ->where('queue_station_number', '=', Auth::guard('window_admin')->user()->window_station_number)
                        ->take(5);
                }

            }
            else
            {
                $onWindow = T1Priority::all()
                    ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                    ->where('queue_station_number', '=', Auth::guard('window_admin')->user()->window_station_number)
                    ->where('queue_window_number', '=', Auth::guard('window_admin')->user()->window_number);

                if($PriorityCount > 1)
                {
                    $onPool = T03Priority::all()
                        ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                        ->where('queue_station_number', '=', Auth::guard('window_admin')->user()->window_station_number)
                        ->take(4);
                    $onHold = T2Priority::all()
                        ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                        ->where('queue_station_number', '=', Auth::guard('window_admin')->user()->window_station_number)
                        ->take(3);
                    $onDetails = T03Priority::all()
                        ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                        ->where('queue_station_number', '=', Auth::guard('window_admin')->user()->window_station_number)
                        ->take(5);

                }
                else
                {


                    $onPool = T03Pool::all()
                        ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                        ->where('queue_station_number', '=', Auth::guard('window_admin')->user()->window_station_number)
                        ->take(4);
                    $onHold = T2Pools::all()
                        ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                        ->where('queue_station_number', '=', Auth::guard('window_admin')->user()->window_station_number)
                        ->take(3);
                    $onDetails = T03Pool::all()
                        ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                        ->where('queue_station_number', '=', Auth::guard('window_admin')->user()->window_station_number)
                        ->take(5);

                }
            }

        }

        if($priorityCheck == 'No' || $PriorityCount == 0)
        {
            $onWindow = T1Pools::all()
                ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                ->where('queue_station_number', '=', Auth::guard('window_admin')->user()->window_station_number)
                ->where('queue_window_number', '=', Auth::guard('window_admin')->user()->window_number);
            $onPool = T03Pool::all()
                ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                ->where('queue_station_number', '=', Auth::guard('window_admin')->user()->window_station_number)
                ->take(4);
            $onHold = T2Pools::all()
                ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                ->where('queue_station_number', '=', Auth::guard('window_admin')->user()->window_station_number)
                ->take(3);
            $onDetails = T03Pool::all()
                        ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                        ->where('queue_station_number', '=', Auth::guard('window_admin')->user()->window_station_number)
                        ->take(5);

        }

        $onWindowCount = $onWindow
                ->count();
        $onWindowNumber =  $onWindow
                ->pluck('queue_number')
                ->last();
        $onWindowName =  $onWindow
                ->pluck('client_name')
                ->last();
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
