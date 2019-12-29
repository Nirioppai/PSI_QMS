<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\QueueRecords;
use App\Flashboards;
use App\Windowadmins;
use App\HistoryLog;
use App\ArchiveView;
use App\QueueLogs;
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

      $flashboardRecords = Flashboards::where('queue_name', '=', $queueName);
    	$flashboardRecords->delete();


		return redirect('/superadmin/queues/view');

    }

    public function resetQueue($id)
    {
    	$queueName = QueueRecords::all()
    				->where('id', '=', $id)
    				->where('record_type', '=', 'Queue')
    				->pluck('queue_name')
    				->first();

    	$archives = ArchiveView::all()
    				->where('queue_name', '=', $queueName);

    	$archives->user_id = ArchiveView::Select('user_id')
    						->where('queue_name', '=', $queueName)
    						->get();
        $archives->queue_name = ArchiveView::Select('queue_name')
        					->where('queue_name', '=', $queueName)
        					->get();
        $archives->queue_number = ArchiveView::Select('queue_number')
        					->where('queue_name', '=', $queueName)
        					->get();
        $archives->client_name = ArchiveView::Select('client_name')
        					->where('queue_name', '=', $queueName)
        					->get();
        $archives->queue_station_number = ArchiveView::Select('queue_station_number')
        					->where('queue_name', '=', $queueName)
        					->get();
        $archives->queue_window_number = ArchiveView::Select('queue_window_number')
        					->where('queue_name', '=', $queueName)
        					->get();
        $archives->queue_action = ArchiveView::Select('queue_action')
        					->where('queue_name', '=', $queueName)
        					->get();
        $archives->queue_priority = ArchiveView::Select('queue_priority')
        					->where('queue_name', '=', $queueName)
        					->get();
        $archives->queue_note  = ArchiveView::Select('queue_note')
        					->where('queue_name', '=', $queueName)
        					->get();
        $archives->created_at = ArchiveView::Select('created_at')
        					->where('queue_name', '=', $queueName)
        					->get();


        foreach ($archives as $archive)
        {
            $log = new QueueLogs;
            $log->user_id = $archive->user_id;
            $log->queue_name = $archive->queue_name;
            $log->queue_number = $archive->queue_number;
            $log->client_name = $archive->client_name;
            $log->queue_station_number = $archive->queue_station_number;
            $log->queue_window_number = $archive->queue_window_number;
            $log->queue_action = $archive->queue_action;
            $log->queue_priority = $archive->priority;
            $log->queue_note =$archive->queue_note;
            $log->created_at = $archive->created_at;
            $log->save();

            if($archive)
            {
            	$archive->delete();
          	}

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
