<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\QueueRecords;
use App\Flashboards;
use App\Windowadmins;
use App\HistoryLog;
use App\Archives;
use App\Pools;
use App\QueueLog;
use Auth;


class QueueController extends Controller
{
    public function renameQueue(Request $request, $id)
    {	

    	$this->validate($request, ['newQueueName' => 'required']);
    	$queueName = QueueRecords::all()
    				->where('id', '=', $id)
    				->where('record_type', '=', 'Queue')
    				->pluck('queue_name')
    				->first();


    	// History Log

    	$oldQueueName = $queueName;
    	$newQueueName = $request->input('newQueueName');

    	// $history = new HistoryLog;


    	// Queue Records 
    
    	$queueRecords = QueueRecords::all()
    				->where('queue_name', '=', $queueName);
    	$windowRecords = $queueRecords
    				->where('record_type', '!=', 'Station');

    	foreach($queueRecords as $queueRecord)
    	{
    		$queueRecord->queue_name = $newQueueName;
			$queueRecord->save();
    	}
			
		foreach($windowRecords as $windowRecord)
		{
			$windowRecord->record_name = $newQueueName;
			$windowRecord->save();
		}
	

		// Window Admins

		$queueWindows = Windowadmins::all()
    				->where('queue_name', '=', $queueName);

		foreach($queueWindows as $queueWindow)
		{
			
			$queueWindow->queue_name = $newQueueName;
			$queueWindow->username = $newQueueName.'S'.$queueWindow->window_station_number.'W'.$queueWindow->window_number;
			$queueWindow->password = Hash::make($newQueueName.'S'.$queueWindow->window_station_number.'W'.$queueWindow->window_number.'pw');
			$queueWindow->save();
		}
		

		return redirect('/superadmin/queues/view');

    }

    public function deleteQueue($id)
    {
    	$queueName = QueueRecords::all()
    				->where('id', '=', $id)
    				->where('record_type', '=', 'Queue')
    				->pluck('queue_name')
    				->first();

    	//History Logs

    	$queueDeleted = $queueName;

    	//Queue Records

    	$queueRecords = QueueRecords::where('queue_name', '=', $queueName);
    	$queueRecords->delete();

    	//Windowadmins

    	$windowRecords = Windowadmins::where('queue_name', '=', $queueName);
    	$windowRecords->delete();


		return redirect('/superadmin/queues/view');

    }

    public function resetQueue($id)
    {
    	$queueName = QueueRecords::all()
    				->where('id', '=', $id)
    				->where('record_type', '=', 'Queue')
    				->pluck('queue_name')
    				->first();

        $pools = Pools::all()
                    ->where('queue_name', '=', $queueName);

    	$archives = Archives::all()
    				->where('queue_name', '=', $queueName);

    	$archives->user_id = Archives::Select('user_id')
    						->where('queue_name', '=', $queueName)
    						->get();
        $archives->queue_name = Archives::Select('queue_name')
        					->where('queue_name', '=', $queueName)
        					->get();
        $archives->queue_number = Archives::Select('queue_number')
        					->where('queue_name', '=', $queueName)
        					->get();
        $archives->client_name = Archives::Select('client_name')
        					->where('queue_name', '=', $queueName)
        					->get();
        $archives->queue_station_number = Archives::Select('queue_station_number')
        					->where('queue_name', '=', $queueName)
        					->get();
        $archives->queue_window_number = Archives::Select('queue_window_number')
        					->where('queue_name', '=', $queueName)
        					->get();
        $archives->queue_action = Archives::Select('queue_action')
        					->where('queue_name', '=', $queueName)
        					->get();
        $archives->queue_priority = Archives::Select('queue_priority')
        					->where('queue_name', '=', $queueName)
        					->get();
        $archives->queue_note  = Archives::Select('queue_note')
        					->where('queue_name', '=', $queueName)
        					->get();
        $archives->created_at = Archives::Select('created_at')
        					->where('queue_name', '=', $queueName)
        					->get();


        foreach ($pools as $pool) 
        {
            $pool->delete();
        }


        foreach ($archives as $archive) 
        {
            $log = new QueueLog;
            $log->user_id = $archive->user_id;
            $log->queue_name = $archive->queue_name;
            $log->queue_number = $archive->queue_number;
            $log->client_name = $archive->client_name;
            $log->queue_station_number = $archive->queue_station_number;
            $log->queue_window_number = $archive->queue_window_number;
            $log->queue_action = $archive->queue_action;
            $log->queue_priority = $archive->queue_priority;
            $log->queue_note =$archive->queue_note;
            $log->created_at = $archive->created_at;
            $log->save();
            
            $archive->delete();

    	}

    	return redirect('/superadmin/queues/view');
    }

    public function deactivateQueue($id)
    {
    	$queueName = QueueRecords::all()
    				->where('id', '=', $id)
    				->where('record_type', '=', 'Queue')
    				->pluck('queue_name')
    				->first();

    	//History Logs

    	$queueDeactivated = $queueName;

    	//Queue Records

    	$queueRecords = QueueRecords::all()
    			 ->where('queue_name', '=', $queueName);
    	
    	foreach($queueRecords as $queueRecord)
    	{
    		$queueRecord->queue_status = 0;
    		$queueRecord->save();
    	}

    	//Windowadmins

    	$windowRecords = Windowadmins::all()
    			 ->where('queue_name', '=', $queueName);

    	foreach($windowRecords as $windowRecord)
    	{
    		$windowRecord->queue_status = 0;
    		$windowRecord->save();
    	}

		return redirect('/superadmin/queues/view');
    }

    public function activateQueue($id)
    {
    	$queueName = QueueRecords::all()
    				->where('id', '=', $id)
    				->where('record_type', '=', 'Queue')
    				->pluck('queue_name')
    				->first();

    	//History Logs

    	$queueDeactivated = $queueName;

    	//Queue Records

    	$queueRecords = QueueRecords::all()
    			 ->where('queue_name', '=', $queueName);
    	
    	foreach($queueRecords as $queueRecord)
    	{
    		$queueRecord->queue_status = 1;
    		$queueRecord->save();
    	}

    	//Windowadmins

    	$windowRecords = Windowadmins::all()
    			 ->where('queue_name', '=', $queueName);

    	foreach($windowRecords as $windowRecord)
    	{
    		$windowRecord->queue_status = 1;
    		$windowRecord->save();
    	}

		return redirect('/superadmin/queues/view');
    }

}