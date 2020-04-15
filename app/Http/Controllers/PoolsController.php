<?php

namespace App\Http\Controllers;


use App\T2Pools;
use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Pools;
use App\Archives;
use App\QueueRecords;
use App\WindowAdmins;
use DB;
use App\ArchiveView; // Loui Views
use App\PoolView; //
use App\T0Pools; //
use App\T1Pools; //
use App\T03Pool; //
use App\T0Priority; //
use App\T1Priority; //
use App\T2Priority; //
use App\T03Priority; //

// Archive Legend
// 0 = waiting
// 1 = on window
// 2 = returned to pool
// 3 = on hold
// 4 = finished

// Pool Legend
// 0 = waiting
// 1 = on window
// 2 = on hold
// 3 = returned to pool

class PoolsController extends Controller
{
    public function create(Request $request)
    {
        $user_id = Auth::guard('window_admin')->user()->id;
        $getName =  Auth::guard('window_admin')->user()->queue_name;
        $count = Archives::where('queue_name','=', $getName)->count();
        $window = Auth::guard('window_admin')->user()->window_number;
        $numberMax =Archives::all()->where('queue_name','=', $getName)
                ->pluck('queue_number')->max() + 1;

        $pool = new Pools;
        $pool->user_id = $user_id;
        $pool->queue_name = $getName;
        $pool->client_name = $request->input('name');
        $pool->queue_station_number = 2;
        $pool->queue_action = 0;
        $pool->queue_priority = $request->input('priority');

        if ($count == 0)
        {
            $pool->queue_number = 1;
        } else {
            $pool->queue_number = $numberMax;
        }

        if (is_null($request->input('note')))
        {
            $pool->save();
        } else {
            $pool->queue_note = $request->input('note');
            $pool->save();
        }

        $archive = new Archives;
        $archive->user_id = $user_id;
        $archive->queue_name =  $getName;
        $archive->client_name =  $request->input('name');
        $archive->queue_station_number = 2;
        $archive->queue_window_number = $window;
        $archive->queue_action = 0;
        $archive->queue_priority = $request->input('priority');

        if ($count == 0)
        {
            $archive->queue_number = 1;
        } else {
            $archive->queue_number = $numberMax;
        }

        if (is_null($request->input('note')))
        {
            $archive->save();
        } else {
            $archive->queue_note = $request->input('note');
            $archive->save();
        }

        return redirect('/windowadmin/home');
    }

    public function custom(Request $request)
    {

        $this->validate($request, [
            'custom_Name' => 'required',
            'custom_Number' => 'required', 'integer'
        ]);

        $checkNumberDuplicate = $request->input('custom_Number');
        $exists = DB::table('Archive_Views')->where('queue_number', $checkNumberDuplicate)->exists();

        if($exists == 1)
        {
            return redirect('/windowadmin/home');
        }

        if(is_null($request->input('note')))
        {
            $note = '';
        } else {
            $note = $request->input('note');
        }

        $id = Auth::guard('window_admin')->user()->id;
        $window_number = Auth::guard('window_admin')->user()->window_number;

        $archive = new Archives;
        $archive->user_id = $id;
        $archive->queue_name = Auth::guard('window_admin')->user()->queue_name;
        $archive->queue_number = $request->input('custom_Number');
        $archive->client_name = $request->input('custom_Name');
        $archive->queue_station_number = $request->get('queue_stations') + 2;
        $archive->queue_window_number = $window_number;
        $archive->queue_note = $note;
        $archive->queue_action = 0;
        $archive->queue_priority = $request->input('priority');
        $archive->save();

        $pool = new Pools;
        $pool->user_id = $id;
        $pool->queue_name = Auth::guard('window_admin')->user()->queue_name;
        $pool->queue_number = $request->input('custom_Number');
        $pool->client_name = $request->input('custom_Name');
        $pool->queue_station_number =  $request->get('queue_stations') + 2;
        $pool->queue_note = $note;
        $pool->queue_action = 0;
        $pool->queue_priority = $request->input('priority');
        $pool->save();

        return redirect('/windowadmin/home');
    }

    public function noteCheck(Request $request)
    {
        $this->validate($request, [
            'note' => ['max: 50']
        ]);

        if (is_null($request->input('note')))
        {
            switch ($request->input('action'))
            {
                case 'done':
                    $this->move('');
                    break;
                case 'hold':
                    $this->hold('');
                    break;
                case 'skip':
                    $this->return('');
                    break;
                case 'skipBreak':
                    $this->breakSkip('');
                    break;
                case 'moveBreak':
                    $this->breakMove('');
                    break;
            }
        } else {
            switch ($request->input('action'))
            {
                case 'done':
                    $this->move($request->input('note'));
                    break;
                case 'hold':
                    $this->hold($request->input('note'));
                    break;
                case 'skip':
                    $this->return($request->input('note'));
                    break;
                case 'skipBreak':
                    $this->breakSkip($request->input('note'));
                    break;
                case 'moveBreak':
                    $this->breakMove($request->input('note'));
                    break;
            }
        }
        return redirect('/windowadmin/home');
    }

    public function getNumber()
    {   
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

        if($priorityCheck == 'Yes' || $NonPriorityCount == 0 )
        {   
            if($OnWindowCheck == 0 && $PriorityCount == 0)
            {
                $getFrom = T03Pool::all()
                ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                ->where('queue_station_number', '=', Auth::guard('window_admin')->user()->window_station_number);
                $onWindow = T1Pools::all()
                    ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                    ->where('queue_station_number', '=', Auth::guard('window_admin')->user()->window_station_number)
                    ->where('queue_window_number','=', Auth::guard('window_admin')->user()->window_number)
                    ->count();
            }
            else
            {
                $getFrom = T03Priority::all()
                    ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                    ->where('queue_station_number', '=', Auth::guard('window_admin')->user()->window_station_number);
                $onWindow = T1Priority::all()
                    ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                    ->where('queue_station_number', '=', Auth::guard('window_admin')->user()->window_station_number)
                    ->where('queue_window_number','=', Auth::guard('window_admin')->user()->window_number)
                    ->count();
            }
        }

        if($priorityCheck == 'No' || $PriorityCount == 0)
        {
            $getFrom = T03Pool::all()
                ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                ->where('queue_station_number', '=', Auth::guard('window_admin')->user()->window_station_number);
            $onWindow = T1Pools::all()
                ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                ->where('queue_station_number', '=', Auth::guard('window_admin')->user()->window_station_number)
                ->where('queue_window_number','=', Auth::guard('window_admin')->user()->window_number)
                ->count();
        }

        $onStationPool = $getFrom
                ->count();
        $numberGot = $getFrom
                ->first();


        if($onStationPool > 0)
        {
            if($onWindow == 0)
            {
                $pool = new Pools;
                $pool->user_id =  Auth::guard('window_admin')->user()->id;
                $pool->queue_name = $getFrom
                    ->pluck('queue_name')
                    ->first();
                $pool->client_name = $getFrom
                    ->pluck('client_name')
                    ->first();
                $pool->queue_number = $getFrom
                    ->pluck('queue_number')
                    ->first();
                $pool->queue_priority = $getFrom
                    ->pluck('queue_priority')
                    ->first();
                $pool->queue_action = 1;
                $pool->queue_station_number = Auth::guard('window_admin')->user()->window_station_number;
                $pool->queue_window_number = Auth:: guard('window_admin')->user()->window_number;
                $pool->save();

                $archive = new Archives;
                $archive->user_id = Auth::guard('window_admin')->user()->id;
                $archive->queue_name = Auth::guard('window_admin')->user()->queue_name;
                $archive->client_name = $getFrom
                    ->pluck('client_name')
                    ->first();
                $archive->queue_number = $getFrom
                    ->pluck('queue_number')
                    ->first();
                $archive->queue_priority - $getFrom
                    ->pluck('queue_priority')
                    ->first();
                $archive->created_at = $getFrom
                    ->pluck('created_at')
                    ->first();
                $archive->queue_action = 0;
                $archive->queue_station_number = Auth::guard('window_admin')->user()->window_station_number;
                $archive->queue_window_number = Auth::guard('window_admin')->user()->window_number;
                $archive->save();
                $numberGot->delete();
            } else {
                return redirect('/windowadmin/home');
            }
        } else {
            return redirect('/windowadmin/home');
        }
        return redirect('/windowadmin/home');
    }

    public function next($note)
    {
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

        if($priorityCheck == 'Yes' || $NonPriorityCount == 0 )
        {   

            if($OnWindowCheck == 1)
            {   
                $getFrom = T1Priority::all()
                    ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                    ->where('queue_station_number', '=',  Auth::guard('window_admin')->user()->window_station_number)
                    ->where('queue_window_number', '=',  Auth::guard('window_admin')->user()->window_number);
            }
            else
            {
                $getFrom = T1Pools::all()
                    ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                    ->where('queue_station_number', '=',  Auth::guard('window_admin')->user()->window_station_number)
                    ->where('queue_window_number', '=',  Auth::guard('window_admin')->user()->window_number);
            }
        }

        if($priorityCheck == 'No' || $PriorityCount == 0)
        {
            $getFrom = T1Pools::all()
                ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                ->where('queue_station_number', '=',  Auth::guard('window_admin')->user()->window_station_number)
                ->where('queue_window_number', '=',  Auth::guard('window_admin')->user()->window_number);
        }

        $max = QueueRecords::all()
                ->where('record_name', '=', Auth::guard('window_admin')->user()->queue_name)
                ->where('record_type', '=', 'Queue')
                ->pluck('record_number_of_stations')
                ->first();


        if ($max >  Auth::guard('window_admin')->user()->window_station_number)
        {
            $pool = new Pools;
            $pool->queue_station_number = Auth::guard('window_admin')->user()->window_station_number + 1;
            $pool->queue_action = 0;
        } else {
            $pool = new Archives;
            $pool->queue_station_number = Auth::guard('window_admin')->user()->window_station_number;
            $pool->queue_window_number = Auth::guard('window_admin')->user()->window_number;
            $pool->queue_action = 5;
        }
        $pool->user_id = Auth::guard('window_admin')->user()->id;
        $pool->queue_name = Auth::guard('window_admin')->user()->queue_name;
        $pool->queue_number = $getFrom
            ->pluck('queue_number')
            ->last();
        $pool->client_name = $getFrom
            ->pluck('client_name')
            ->last();
        $pool->queue_priority = $getFrom
            ->pluck('queue_priority')
            ->last();
        $pool->queue_note = $note;
        $pool->save();
    }

    public function record($note)
    {   
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

        if($priorityCheck == 'Yes' || $NonPriorityCount == 0 )
        {
            if($OnWindowCheck == 1)
            {   
                $getFrom = T1Priority::all()
                    ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                    ->where('queue_station_number', '=',  Auth::guard('window_admin')->user()->window_station_number)
                    ->where('queue_window_number', '=',  Auth::guard('window_admin')->user()->window_number);
            }
            else
            {
                $getFrom = T1Pools::all()
                    ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                    ->where('queue_station_number', '=',  Auth::guard('window_admin')->user()->window_station_number)
                    ->where('queue_window_number', '=',  Auth::guard('window_admin')->user()->window_number);
            }
        }

        if($priorityCheck == 'No' || $PriorityCount == 0)
        {
            $getFrom = T1Pools::all()
                ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                ->where('queue_station_number', '=',  Auth::guard('window_admin')->user()->window_station_number)
                ->where('queue_window_number', '=',  Auth::guard('window_admin')->user()->window_number);
        }

        $archive = new Archives;
        $archive->user_id = Auth::guard('window_admin')->user()->id;
        $archive->queue_name = Auth::guard('window_admin')->user()->queue_name;
        $archive->queue_station_number = $getFrom
            ->pluck('queue_station_number')
            ->last();
        $archive->queue_window_number = $getFrom
            ->pluck('queue_window_number')
            ->last();
        $archive->client_name = $getFrom
            ->pluck('client_name')
            ->last();
        $archive->queue_number = $getFrom
            ->pluck('queue_number')
            ->last();
        $archive->queue_priority = $getFrom
            ->pluck('queue_priority')
            ->last();
        $archive->queue_action = 1;
        $archive->queue_note = $note;
        $archive->created_at = $getFrom
            ->pluck('created_at')
            ->last();
        $archive->save();

        $poolId = $getFrom
            ->last();
        $poolId->delete();
    }

    public function move($note)
    {   
        $counters  = PoolView::all()
            ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
            ->where('queue_station_number', '=', Auth::guard('window_admin')->user()->window_station_number);
        $PriorityCount = $counters
            ->where('queue_priority', '=', '1')
            ->count();
        $NonPriorityCount = $counters
            ->where('queue_priority', '=', '0')
            ->count();
        
        $this->next($note);
        $this->record($note);
        
        if ($PriorityCount != 0 || $NonPriorityCount != 0)
        {
            return $this->getNumber();
        } 
        else 
        {
            return redirect('/windowadmin/home');
        }
    }

    public function breakMove($note)
    {
        $this->next($note);
        $this->record($note);
        return redirect('/windowadmin/home');
    }

    public function newRecord($note)
    {
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

        if($priorityCheck == 'Yes' || $NonPriorityCount == 0 )
        {
            if($OnWindowCheck == 1)
            {   
                $getFrom = T1Priority::all()
                    ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                    ->where('queue_station_number', '=',  Auth::guard('window_admin')->user()->window_station_number)
                    ->where('queue_window_number', '=',  Auth::guard('window_admin')->user()->window_number);
            }
            else
            {
                $getFrom = T1Pools::all()
                    ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                    ->where('queue_station_number', '=',  Auth::guard('window_admin')->user()->window_station_number)
                    ->where('queue_window_number', '=',  Auth::guard('window_admin')->user()->window_number);
            }
        }

        if($priorityCheck == 'No' || $PriorityCount == 0)
        {
            $getFrom = T1Pools::all()
                ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                ->where('queue_station_number', '=',  Auth::guard('window_admin')->user()->window_station_number)
                ->where('queue_window_number', '=',  Auth::guard('window_admin')->user()->window_number);
        }

        $archive = new Archives;
        $archive->user_id = Auth::guard('window_admin')->user()->id;
        $archive->queue_name = Auth::guard('window_admin')->user()->queue_name;
        $archive->queue_station_number = $getFrom
            ->pluck('queue_station_number')
            ->last();
        $archive->queue_window_number = $getFrom
            ->pluck('queue_window_number')
            ->last();
        $archive->client_name = $getFrom
            ->pluck('client_name')
            ->last();
        $archive->queue_number = $getFrom
            ->pluck('queue_number')
            ->last();
        $archive->queue_priority = $getFrom
            ->pluck('queue_priority')
            ->last();
        $archive->queue_action = 2;
        $archive->queue_note = $note;
        $archive->created_at = $getFrom
            ->pluck('created_at')
            ->last();
        $archive->save();
    }

    public function update($note)
    {
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

        if($priorityCheck == 'Yes' || $NonPriorityCount == 0 )
        {
            if($OnWindowCheck == 1)
            {   
                $getFrom = T1Priority::all()
                    ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                    ->where('queue_station_number', '=',  Auth::guard('window_admin')->user()->window_station_number)
                    ->where('queue_window_number', '=',  Auth::guard('window_admin')->user()->window_number);
            }
            else
            {
                $getFrom = T1Pools::all()
                    ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                    ->where('queue_station_number', '=',  Auth::guard('window_admin')->user()->window_station_number)
                    ->where('queue_window_number', '=',  Auth::guard('window_admin')->user()->window_number);
            }
        }

        if($priorityCheck == 'No' || $PriorityCount == 0)
        {
            $getFrom = T1Pools::all()
                ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                ->where('queue_station_number', '=',  Auth::guard('window_admin')->user()->window_station_number)
                ->where('queue_window_number', '=',  Auth::guard('window_admin')->user()->window_number);
        }

        $pool = new Pools;
        $pool->queue_station_number = Auth::guard('window_admin')->user()->window_station_number;
        $pool->queue_action = 3;
        $pool->user_id = Auth::guard('window_admin')->user()->id;
        $pool->queue_name = Auth::guard('window_admin')->user()->queue_name;
        $pool->queue_number = $getFrom
            ->pluck('queue_number')
            ->last();
        $pool->client_name = $getFrom
            ->pluck('client_name')
            ->last();
        $pool->queue_priority = $getFrom
            ->pluck('queue_priority')
            ->last();
        $pool->queue_note = $note;
        $pool->save();
    }

    public function return($note)
    {
        $counters  = PoolView::all()
            ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
            ->where('queue_station_number', '=', Auth::guard('window_admin')->user()->window_station_number);
        $PriorityCount = $counters
            ->where('queue_priority', '=', '1')
            ->count();
        $NonPriorityCount = $counters
            ->where('queue_priority', '=', '0')
            ->count();
        
        
        $this->update($note);
        $this->newRecord($note);
        $this->record($note);

        if($PriorityCount != 0 || $NonPriorityCount != 0)
        {
            $this->getNumber();
        } else {
            return redirect('/windowadmin/home');
        }
    }

    public function breakSkip($note)
    {
        $this->update($note);
        $this->newRecord($note);
        $this->record($note);

        return redirect('/windowadmin/home');
    }

    public function transfer(Request $request)
    {

        if(is_null($request->input('note')))
        {
            $this->record('');
        } else {
            $this->record($request->input('note'));
        }

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

        if($priorityCheck == 'Yes' || $NonPriorityCount == 0 )
        {
            if($OnWindowCheck == 1)
            {   
                $getFrom = T1Priority::all()
                    ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                    ->where('queue_station_number', '=',  Auth::guard('window_admin')->user()->window_station_number)
                    ->where('queue_window_number', '=',  Auth::guard('window_admin')->user()->window_number);
            }
            else
            {
                $getFrom = T1Pools::all()
                    ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                    ->where('queue_station_number', '=',  Auth::guard('window_admin')->user()->window_station_number)
                    ->where('queue_window_number', '=',  Auth::guard('window_admin')->user()->window_number);
            }
        }

        if($priorityCheck == 'No' || $PriorityCount == 0)
        {
            $getFrom = T1Pools::all()
                ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                ->where('queue_station_number', '=',  Auth::guard('window_admin')->user()->window_station_number)
                ->where('queue_window_number', '=',  Auth::guard('window_admin')->user()->window_number);
        }

        $pool = new Pools;
        $pool->queue_name = $getFrom
            ->pluck('queue_name')
            ->last();
        $pool->client_name = $getFrom
            ->pluck('client_name')
            ->last();
        $pool->queue_number = $getFrom
            ->pluck('queue_number')
            ->last();
        $pool->queue_priority = $getFrom
            ->pluck('queue_priority')
            ->last();
        $pool->queue_station_number = $request->get('queue_stations') + 2;
        $pool->queue_action = 0;
        $pool->user_id =  Auth::guard('window_admin')->user()->id;
        if(is_null($request->input('note')))
        {
            $pool->queue_note = '';
        } else {
            $pool->queue_note = $request->input('note');
        }
        $pool->save();

        $poolId = $getFrom
            ->last();
        $poolId->delete();

        return redirect('/windowadmin/home');
    }

    public function hold($note)
    {
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

        if($priorityCheck == 'Yes' || $NonPriorityCount == 0 )
        {
            if($OnWindowCheck == 1)
            {   
                $getFrom = T1Priority::all()
                    ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                    ->where('queue_station_number', '=',  Auth::guard('window_admin')->user()->window_station_number)
                    ->where('queue_window_number', '=',  Auth::guard('window_admin')->user()->window_number);
            }
            else
            {
                $getFrom = T1Pools::all()
                    ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                    ->where('queue_station_number', '=',  Auth::guard('window_admin')->user()->window_station_number)
                    ->where('queue_window_number', '=',  Auth::guard('window_admin')->user()->window_number);
            }
        }

        if($priorityCheck == 'No' || $PriorityCount == 0)
        {
            $getFrom = T1Pools::all()
                ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                ->where('queue_station_number', '=',  Auth::guard('window_admin')->user()->window_station_number)
                ->where('queue_window_number', '=',  Auth::guard('window_admin')->user()->window_number);
        }

        $this->record($note);

        $archives = new Archives;
        $archives->user_id = Auth::guard('window_admin')->user()->id;
        $archives->queue_name = $getFrom
            ->pluck('queue_name')
            ->last();
        $archives->queue_number = $getFrom
            ->pluck('queue_number')
            ->last();
        $archives->client_name = $getFrom
            ->pluck('client_name')
            ->last();
        $archives->created_at = $getFrom
            ->pluck('created_at')
            ->last();
        $archives->queue_priority = $getFrom
            ->pluck('queue_priority')
            ->last();
        $archives->queue_action = 1;
        $archives->queue_station_number = Auth::guard('window_admin')->user()->window_station_number;
        $archives->queue_window_number = Auth::guard('window_admin')->user()->window_number;
        if(!$note)
        {
            $archives->queue_note = '';
        } else {
            $archives->queue_note = $note;
        }
        $archives->save();

        $pool = new Pools;
        $pool->queue_name = $getFrom
            ->pluck('queue_name')
            ->last();
        $pool->queue_number = $getFrom
            ->pluck('queue_number')
            ->last();
        $pool->client_name = $getFrom
            ->pluck('client_name')
            ->last();
        $pool->queue_priority = $getFrom
            ->pluck('queue_priority')
            ->last();
        $pool->queue_action = 2;
        $pool->user_id = Auth::guard('window_admin')->user()->id;
        $pool->queue_station_number = Auth::guard('window_admin')->user()->window_station_number;
        $pool->queue_window_number = Auth::guard('window_admin')->user()->window_number;
        if(!$note)
        {
            $pool->queue_note = '';
        } else {
            $pool->queue_note = $note;
        }
        $pool->save();

        $poolId = $getFrom
             ->last();
        $poolId->delete();

        return redirect('/windowadmin/home');
    }

    public function getOnHold($id)
    {   
        $priorityCheck = Auth::guard('window_admin')->user()->is_priority_window;
        if($priorityCheck == 'Yes')
        {
            $poolId = T2Priority::find($id);
            $getFrom = T2Priority::all()
                ->where('id', '=', $id);
            $checkWindow = T1Priority::all()
                ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                ->where('queue_station_number', '=',  Auth::guard('window_admin')->user()->window_station_number)
                ->where('queue_window_number', '=',  Auth::guard('window_admin')->user()->window_number)
                ->count();
        }
        else
        {
            $poolId = T2Pools::find($id);
            $getFrom = T2Pools::all()
                ->where('id', '=', $id);
            $checkWindow = T1Pools::all()
                ->where('queue_name', '=', Auth::guard('window_admin')->user()->queue_name)
                ->where('queue_station_number', '=',  Auth::guard('window_admin')->user()->window_station_number)
                ->where('queue_window_number', '=',  Auth::guard('window_admin')->user()->window_number)
                ->count();
        }

        if($checkWindow != 1)
        {
            $pool = new Pools;
            $pool->queue_name = $getFrom
                ->pluck('queue_name')
                ->first();
            $pool->queue_number = $getFrom
                ->pluck('queue_number')
                ->first();
            $pool->client_name = $getFrom
                ->pluck('client_name')
                ->first();
            $pool->queue_priority = $getFrom
                ->pluck('queue_priority')
                ->first();
            $pool->user_id = Auth::guard('window_admin')->user()->id;
            $pool->queue_window_number = Auth::guard('window_admin')->user()->window_number;
            $pool->queue_station_number = Auth::guard('window_admin')->user()->window_station_number;
            $pool->queue_action = 1;
            $pool->save();

            $archive = new Archives;
            $archive->queue_name = $getFrom
                ->pluck('queue_name')
                ->first();
            $archive->queue_number = $getFrom
                ->pluck('queue_number')
                ->first();
            $archive->client_name = $getFrom
                ->pluck('client_name')
                ->first();
            $archive->queue_priority = $getFrom
                ->pluck('queue_priority')
                ->first();
            $archive->created_at = $getFrom
                ->pluck('created_at')
                ->first();
            $archive->user_id = Auth::guard('window_admin')->user()->id;
            $archive->queue_window_number = Auth::guard('window_admin')->user()->window_number;
            $archive->queue_station_number = Auth::guard('window_admin')->user()->window_station_number;
            $archive->queue_action = 1;
            $archive->save();
            $poolId->delete();
        } else {
            return redirect('/windowadmin/home');
        }
        return redirect('/windowadmin/home');
    }
}
