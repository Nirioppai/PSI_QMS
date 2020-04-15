<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\QueueAdmins;
use App\StationAdmins;
use App\QueueDesigner1;
use App\QueueDesigner2;
use Illuminate\Support\Facades\Hash;
use Auth;
use DB;

class QueueAdminController extends Controller
{
      /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
      $this->middleware('auth:queue_admin');
    }

    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Contracts\Support\Renderable
    */
    public function index()
    {
      return view('layouts.queueadmin.home');
    }

    public function queues()
    {
        $QueueDesigner1 = QueueDesigner1::all();

        //if Super admin is Logged in
        if($user = Auth::user())
        {
        //if there are unfinished designs
            if(count ($QueueDesigner1) > 0)
            {
                $QueueDesigner1_Empty=QueueDesigner1::truncate();
                $QueueDesigner2_Empty=QueueDesigner2::truncate();
                return view('layouts.queueadmin.queues');
            }
            else
            {
                return view('layouts.queueadmin.queues');
            }
        }
    }

    public function queueView()
    {
        $LoggedIN = Auth::user()->name;
        $QueueRecord = DB::table('queue_records')
        ->where('record_type', '=', 'Queue')
        ->where('record_admin', '=', $LoggedIN)->get();
        return view('layouts.queueadmin.queue_view')->with('QueueRecord', $QueueRecord);
    }

    public function queueList()
    {
        return view('layouts.queueadmin.queue_list');
    }

    public function newQueue()
    {
        $QueueDesigner1 = QueueDesigner1::all();
        $StationAdmins = StationAdmins::all();
        $Status = "false";

        //if Super admin is Logged in
        if($user = Auth::user())
        {
        //if there are unfinished designs
            if(count ($QueueDesigner1) > 0)
            {
                $QueueDesigner1_Empty=QueueDesigner1::truncate();
                $QueueDesigner2_Empty=QueueDesigner2::truncate();
                return view('layouts.queueadmin.queue_new')->with('StationAdmins', $StationAdmins)->with('Status', $Status);
            }
            else
            {
                return view('layouts.queueadmin.queue_new')->with('StationAdmins', $StationAdmins)->with('Status', $Status);
            }
        }
    }

    public function accounts()
    {
        $LoggedIN = Auth::user()->name;
        $QueueRecord = DB::table('queue_records')
        ->where('record_type', '=', 'Queue')
        ->where('record_admin', '=', $LoggedIN)->get();


        $QueueDesigner1 = QueueDesigner1::all();
        //if Super admin is Logged in
        if($user = Auth::user())
        {
        //if there are unfinished designs
            if(count ($QueueDesigner1) > 0)
            {
                $QueueDesigner1_Empty=QueueDesigner1::truncate();
                $QueueDesigner2_Empty=QueueDesigner2::truncate();
                return view('layouts.queueadmin.accounts_1')->with('QueueRecord', $QueueRecord);
            }
            else
            {
                return view('layouts.queueadmin.accounts_1')->with('QueueRecord', $QueueRecord);
            }
        }
    }

    //picks a queue from a table, returns station admins
    public function pick_queue_from_table($record_name)
    {
        $QueueName = $record_name;
        $Station_Admins = DB::table('queue_records')
        ->where('record_type', '=', 'Station')
        ->where('queue_name', '=', $QueueName)->get();

        $QueueDesigner1 = QueueDesigner1::all();
        //if Super admin is Logged in
        if($user = Auth::user())
        {
        //if there are unfinished designs
            if(count ($QueueDesigner1) > 0)
            {
                $QueueDesigner1_Empty=QueueDesigner1::truncate();
                $QueueDesigner2_Empty=QueueDesigner2::truncate();
                return view('layouts.queueadmin.accounts_2')
                ->with('Station_Admins', $Station_Admins)
                ->with('record_name', $record_name);
            }
            else
            {
                return view('layouts.queueadmin.accounts_2')
                ->with('Station_Admins', $Station_Admins)
                ->with('record_name', $record_name);
            }
        }
    }

    //picks a station admin from a table, returns window admins
    public function pick_station_admin_from_table($record_name,$record_number)
    {
      $QueueName = $record_name;
      $Window_Admins = DB::table('queue_records')
      ->where('record_type', '=', 'Window')
      ->where('queue_name', '=', $QueueName)
      ->where('record_station_number', '=', $record_number)->get();

      $QueueDesigner1 = QueueDesigner1::all();
      //if Super admin is Logged in
      if($user = Auth::user())
      {
      //if there are unfinished designs
          if(count ($QueueDesigner1) > 0)
          {
              $QueueDesigner1_Empty=QueueDesigner1::truncate();
              $QueueDesigner2_Empty=QueueDesigner2::truncate();
              return view('layouts.queueadmin.accounts_3')
              ->with('Window_Admins', $Window_Admins)
              ->with('record_name', $record_name);
          }
          else
          {
              return view('layouts.queueadmin.accounts_3')
              ->with('Window_Admins', $Window_Admins)
              ->with('record_name', $record_name);
          }
      }
    }

}
