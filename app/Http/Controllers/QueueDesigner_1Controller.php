<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\QueueDesigner1;
use App\QueueDesigner2;
use App\User;
use App\queueadmins;
use App\stationadmins;
use Auth;

class QueueDesigner_1Controller extends Controller
{

  public function newQueue_submit_1(Request $request){
	$this->validate($request, [
	'queue_name' => ['required', 'string', 'max:150', 'unique:queue_designer1s', 'unique:queue_records'],
	'number_of_stations' => ['required', 'integer', 'max:20'],
	]);

	$LoggedIN = Auth::guard('queue_admin')->user()->name;
	for ($i = 1; $i < $request->input('number_of_stations')+1; $i++){
		$QueueDesigner1 = new QueueDesigner1;
		$QueueDesigner1->queue_name = $request->input('queue_name');
		$QueueDesigner1->number_of_stations = $i;
		$QueueDesigner1->created_by = $LoggedIN;
		$QueueDesigner1->save();
	}

	return redirect('/queueadmin/queues/new/modify');

	}
	public function back(){

		$QD1s = QueueDesigner1::all();
		$LoggedIN = Auth::guard('queue_admin')->user()->name;
		$QD1s=QueueDesigner1::where('created_by',$LoggedIN)->delete();
		$QD1s=QueueDesigner2::where('created_by',$LoggedIN)->delete();
		return redirect('/queueadmin/queues/new');
	}
}
