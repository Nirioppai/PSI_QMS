<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\QueueRecords;
use App\QueueDesigner1;
use App\QueueDesigner2;
use App\User;
use App\QueueAdmins;
use App\StationAdmins;
use App\WindowAdmins;
use App\Flashboards;
use App\Kiosks;
use App\QueueAccounts;
use DB;
use Auth;


class QueuesRecord_QueueAdmin_Controller extends Controller
{
    public function recordQueueDesign(Request $request){

    	$Queue_Designer1_all = QueueDesigner1::all();
    	$Queue_Designer2_all = QueueDesigner2::all();

    	$Queue_Designer1_all->station_name = QueueDesigner1::Select('station_name')->Where('id', '>', 0)->get();
    	$Queue_Designer1_all->number_of_stations = QueueDesigner1::Select('number_of_stations')->Where('id', '>', 0)->get();
    	$Queue_Designer1_all->number_of_windows = QueueDesigner1::Select('number_of_windows')->Where('id', '>', 0)->get();
    	$Queue_Designer1_all->station_admin = QueueDesigner1::Select('station_admin')->Where('id', '>', 0)->get();
    	$Queue_Designer1_all->created_by = QueueDesigner1::Select('created_by')->Where('id', '>', 0)->get();

    	$Queue_Designer2_all->station_name = QueueDesigner2::Select('station_name')->Where('id', '>', 0)->get();
    	$Queue_Designer2_all->station_number = QueueDesigner2::Select('station_number')->Where('id', '>', 0)->get();
    	$Queue_Designer2_all->window_number = QueueDesigner2::Select('window_number')->Where('id', '>', 0)->get();
    	$Queue_Designer2_all->created_by = QueueDesigner2::Select('created_by')->Where('id', '>', 0)->get();
      $Queue_Designer2_all->username = QueueDesigner2::Select('username')->Where('id', '>', 0)->get();
      $Queue_Designer2_all->password = QueueDesigner2::Select('password')->Where('id', '>', 0)->get();
      $Queue_Designer2_all->is_priority = QueueDesigner2::Select('is_priority')->Where('id', '>', 0)->get();

    	$StationCount = QueueDesigner1::max('number_of_stations');
    	$QueueNames = DB::table('queue_designer1s')->where('id', '>', 0)->first();
      $QueueName = $QueueNames->queue_name;
      $QueueAdmin_Logged_in = Auth::guard('queue_admin')->user()->name;

      $count = DB::table('queue_records')->distinct('queue_name')->count('queue_name') + 1;

    	$QueueRecord = new QueueRecords;

    	//Recording for Type Queue
    	$QueueRecord->queue_name =  $QueueName;
    	$QueueRecord->record_type =  'Queue';
    	$QueueRecord->record_name =  $QueueName;
    	$QueueRecord->record_number = $count;
    	$QueueRecord->record_number_of_stations =  $StationCount;
    	$QueueRecord->record_number_of_windows =  0;
    	$QueueRecord->record_admin =  $QueueAdmin_Logged_in;
    	$QueueRecord->queue_status =  1;
    	$QueueRecord->record_creator =  $QueueAdmin_Logged_in;

    	$QueueRecord->save();

    	//Recording for Type Station

    	foreach($Queue_Designer1_all as $Queue_Designer1_Entry){

    		$QueueRecord = new QueueRecords;

    		$QueueRecord->queue_name =  $QueueName;
	    	$QueueRecord->record_type =  'Station';
	    	$QueueRecord->record_name =  $Queue_Designer1_Entry->station_name;
	    	$QueueRecord->record_number = $Queue_Designer1_Entry->number_of_stations;
	    	$QueueRecord->record_number_of_stations = 0;
	    	$QueueRecord->record_number_of_windows =  $Queue_Designer1_Entry->number_of_windows;
	    	$QueueRecord->record_admin =  $Queue_Designer1_Entry->station_admin;
	    	$QueueRecord->queue_status =  1;
	    	$QueueRecord->record_creator =  $QueueAdmin_Logged_in;

	    	$QueueRecord->save();
    	}

    	//Recording for Type Window

    	foreach($Queue_Designer2_all as $Queue_Designer2_Entry){

    		$QueueRecord = new QueueRecords;

    		$QueueRecord->queue_name =  $QueueName;
    		$QueueRecord->record_type =  'Window';
    		$QueueRecord->record_name =  $QueueName;
        $QueueRecord->record_station_number =  $Queue_Designer2_Entry->station_number;
    		$QueueRecord->record_number = $Queue_Designer2_Entry->window_number;
    		$QueueRecord->record_number_of_stations = 0;
    		$QueueRecord->record_number_of_windows =  0;
        $QueueRecord->record_admin =  $Queue_Designer2_Entry->username;
        $QueueRecord->queue_status =  1;
        $QueueRecord->record_creator =  $QueueAdmin_Logged_in;

            $QueueRecord->save();
    	}

        foreach($Queue_Designer2_all as $Queue_Designer2_Entry){

            $WindowAdmins = new WindowAdmins;

            $WindowAdmins->username =  $Queue_Designer2_Entry->username;
            $WindowAdmins->password =  $Queue_Designer2_Entry->password;
            $WindowAdmins->queue_name =  $QueueName;
            $WindowAdmins->window_station_number =  $Queue_Designer2_Entry->station_number;
            $WindowAdmins->window_number = $Queue_Designer2_Entry->window_number;
            $WindowAdmins->is_priority_window = $Queue_Designer2_Entry->is_priority;
            $WindowAdmins->queue_status =  1;
            $WindowAdmins->record_creator =  $QueueAdmin_Logged_in;

            $WindowAdmins->save();
        }
      $StationAdmins = StationAdmins::all();
      $Status = "true";

      $QueueDesigner1_Empty=QueueDesigner1::truncate();
      $QueueDesigner2_Empty=QueueDesigner2::truncate();
    	return view('layouts.queueadmin.queue_new')->with('StationAdmins', $StationAdmins)->with('Status', $Status);

    }
}
