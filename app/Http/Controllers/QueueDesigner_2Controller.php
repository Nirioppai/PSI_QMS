<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;
use App\StationAdmins;
use App\QueueDesigner1;
use App\QueueDesigner2;
use Auth;
use DB;

class QueueDesigner_2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $QueueDesigner1 = QueueDesigner1::all();
        $QueueNames = DB::table('queue_designer1s')->where('id', '>', 0)->first();
        $QueueName = $QueueNames->queue_name;

        $stationCount = QueueDesigner1::where('id', '>', 0)->get();
        $number_of_stations = $stationCount->count();

        return view('layouts.queueadmin.queue_new_modify')->with('queue_designer1s', $QueueDesigner1)->with('QueueName', $QueueName)->with('number_of_stations', $number_of_stations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users = StationAdmins::select('name')->where('id','>=', 1)->get();
        $queue_designer1 = QueueDesigner1::find($id);
        return view('layouts.queueadmin.queue_new_modify_edit')->with('users', $users)->with('queue_designer1', $queue_designer1);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validateWindowParameter = $request->input('number_of_windows');
        $this -> validate($request, [
        'station_name' => ['required', 'string', 'max:150'],
        'number_of_windows' => ['required', 'integer' ,'gt:0',  'max:16', 'regex:/^[0-9]+|not_in:0/'],
        'number_of_kiosks' => ['integer', 'max:16' , 'regex:/^[0-9]+|not_in:0/'],
        'number_of_priority_windows' => ['integer', 'lt:' . $validateWindowParameter, 'regex:/^[0-9]+|not_in:0/'],
        ]);

        $Queue_Designer1 = QueueDesigner1::find($id);
        $QueueDesigner2 = new QueueDesigner2;

        QueueDesigner2::where('station_number', $id)->delete();

        $windows = $request->input('number_of_windows');
        $priorities = $request->input('number_of_priority_windows');
        $QueueNames = DB::table('queue_designer1s')->where('id', '1')->first();
        $QueueName = $QueueNames->queue_name;
        $LoggedIN = Auth::guard('queue_admin')->user()->name;

        //Number of Windows conditioning

        //5 above windows, multi priority
        if($windows > 4 && $priorities != 0)
        {
            if($windows % 2)
            {
                $windows = $windows + 1;
                $total_priority_windows = $priorities + 1;
                $regular_stations = $windows - $total_priority_windows;

                for($i = 1; $i <  $priorities + 2; $i++ )
                {
                    $QueueDesigner2 = new QueueDesigner2;
                    $QueueDesigner2->queue_name = $QueueName;
                    $QueueDesigner2->station_name = $request->input('station_name');
                    $QueueDesigner2->station_number = $id;
                    $QueueDesigner2->window_number = $i;
                    $QueueDesigner2->is_priority = "Yes";
                    $QueueDesigner2->username = $QueueName.'S'.$id.'W'. $i;
                    $QueueDesigner2->password = Hash::make($QueueName.'S'.$id.'W'.$i.'pw');
                    $QueueDesigner2->created_by = $LoggedIN;
                    $QueueDesigner2->save();
                }

                for($i = $priorities + 2; $i < $regular_stations + 3; $i++)
                {
                    $QueueDesigner2 = new QueueDesigner2;
                    $QueueDesigner2->queue_name = $QueueName;
                    $QueueDesigner2->station_name = $request->input('station_name');
                    $QueueDesigner2->station_number = $id;
                    $QueueDesigner2->window_number = $i;
                    $QueueDesigner2->is_priority = "No";
                    $QueueDesigner2->username = $QueueName.'S'.$id.'W'. $i;
                    $QueueDesigner2->password = Hash::make($QueueName.'S'.$id.'W'.$i.'pw');
                    $QueueDesigner2->created_by = $LoggedIN;
                    $QueueDesigner2->save();
                }
            }
            else
            {
                $windows = $request->input('number_of_windows');
                $total_priority_windows = $priorities + 1;
                $regular_stations = $windows - $total_priority_windows;

                for($i = 1; $i <  $priorities + 2; $i++ )
                {
                    $QueueDesigner2 = new QueueDesigner2;
                    $QueueDesigner2->queue_name = $QueueName;
                    $QueueDesigner2->station_name = $request->input('station_name');
                    $QueueDesigner2->station_number = $id;
                    $QueueDesigner2->window_number = $i;
                    $QueueDesigner2->is_priority = "Yes";
                    $QueueDesigner2->username = $QueueName.'S'.$id.'W'. $i;
                    $QueueDesigner2->password = Hash::make($QueueName.'S'.$id.'W'.$i.'pw');
                    $QueueDesigner2->created_by = $LoggedIN;
                    $QueueDesigner2->save();
                }

                for($i = $priorities + 2; $i < $regular_stations + 3; $i++)
                {
                    $QueueDesigner2 = new QueueDesigner2;
                    $QueueDesigner2->queue_name = $QueueName;
                    $QueueDesigner2->station_name = $request->input('station_name');
                    $QueueDesigner2->station_number = $id;
                    $QueueDesigner2->window_number = $i;
                    $QueueDesigner2->is_priority = "No";
                    $QueueDesigner2->username = $QueueName.'S'.$id.'W'. $i;
                    $QueueDesigner2->password = Hash::make($QueueName.'S'.$id.'W'.$i.'pw');
                    $QueueDesigner2->created_by = $LoggedIN;
                    $QueueDesigner2->save();
                }
            }
        }

        //5 above windows, no priority
        if($windows > 4 && $priorities == 0)
        {
            if($windows % 2)
            {
                $windows = $windows + 1;
                $total_priority_windows = $priorities + 1;
                $regular_stations = $windows - $total_priority_windows;

                for($i = 1; $i <  $priorities + 2; $i++ )
                {
                    $QueueDesigner2 = new QueueDesigner2;
                    $QueueDesigner2->queue_name = $QueueName;
                    $QueueDesigner2->station_name = $request->input('station_name');
                    $QueueDesigner2->station_number = $id;
                    $QueueDesigner2->window_number = $i;
                    $QueueDesigner2->is_priority = "Yes";
                    $QueueDesigner2->username = $QueueName.'S'.$id.'W'. $i;
                    $QueueDesigner2->password = Hash::make($QueueName.'S'.$id.'W'.$i.'pw');
                    $QueueDesigner2->created_by = $LoggedIN;
                    $QueueDesigner2->save();
                }

                for($i = $priorities + 2; $i < $regular_stations + 2; $i++)
                {
                    $QueueDesigner2 = new QueueDesigner2;
                    $QueueDesigner2->queue_name = $QueueName;
                    $QueueDesigner2->station_name = $request->input('station_name');
                    $QueueDesigner2->station_number = $id;
                    $QueueDesigner2->window_number = $i;
                    $QueueDesigner2->is_priority = "No";
                    $QueueDesigner2->username = $QueueName.'S'.$id.'W'. $i;
                    $QueueDesigner2->password = Hash::make($QueueName.'S'.$id.'W'.$i.'pw');
                    $QueueDesigner2->created_by = $LoggedIN;
                    $QueueDesigner2->save();
                }
            }
            else
            {
                $windows = $request->input('number_of_windows');
                $total_priority_windows = $priorities + 1;
                $regular_stations = $windows - $total_priority_windows;

                for($i = 1; $i <  $priorities + 2; $i++ )
                {
                    $QueueDesigner2 = new QueueDesigner2;
                    $QueueDesigner2->queue_name = $QueueName;
                    $QueueDesigner2->station_name = $request->input('station_name');
                    $QueueDesigner2->station_number = $id;
                    $QueueDesigner2->window_number = $i;
                    $QueueDesigner2->is_priority = "Yes";
                    $QueueDesigner2->username = $QueueName.'S'.$id.'W'. $i;
                    $QueueDesigner2->password = Hash::make($QueueName.'S'.$id.'W'.$i.'pw');
                    $QueueDesigner2->created_by = $LoggedIN;
                    $QueueDesigner2->save();
                }

                for($i = $priorities + 2; $i < $regular_stations + 2; $i++)
                {
                    $QueueDesigner2 = new QueueDesigner2;
                    $QueueDesigner2->queue_name = $QueueName;
                    $QueueDesigner2->station_name = $request->input('station_name');
                    $QueueDesigner2->station_number = $id;
                    $QueueDesigner2->window_number = $i;
                    $QueueDesigner2->is_priority = "No";
                    $QueueDesigner2->username = $QueueName.'S'.$id.'W'. $i;
                    $QueueDesigner2->password = Hash::make($QueueName.'S'.$id.'W'.$i.'pw');
                    $QueueDesigner2->created_by = $LoggedIN;
                    $QueueDesigner2->save();
                }
            }
        }

        //4 and below windows, multi priority
        if($windows <= 4 && $priorities != 0)
        {
            $windows = $request->input('number_of_windows');
            $total_priority_windows = $priorities + 1;
            $regular_stations = $windows - $total_priority_windows;

            for($i = 1; $i <  $priorities + 2; $i++ )
            {
                $QueueDesigner2 = new QueueDesigner2;
                $QueueDesigner2->queue_name = $QueueName;
                $QueueDesigner2->station_name = $request->input('station_name');
                $QueueDesigner2->station_number = $id;
                $QueueDesigner2->window_number = $i;
                $QueueDesigner2->is_priority = "Yes";
                $QueueDesigner2->username = $QueueName.'S'.$id.'W'. $i;
                $QueueDesigner2->password = Hash::make($QueueName.'S'.$id.'W'.$i.'pw');
                $QueueDesigner2->created_by = $LoggedIN;
                $QueueDesigner2->save();
            }

            for($i = $priorities + 2; $i < $regular_stations + 3; $i++)
            {
                $QueueDesigner2 = new QueueDesigner2;
                $QueueDesigner2->queue_name = $QueueName;
                $QueueDesigner2->station_name = $request->input('station_name');
                $QueueDesigner2->station_number = $id;
                $QueueDesigner2->window_number = $i;
                $QueueDesigner2->is_priority = "No";
                $QueueDesigner2->username = $QueueName.'S'.$id.'W'. $i;
                $QueueDesigner2->password = Hash::make($QueueName.'S'.$id.'W'.$i.'pw');
                $QueueDesigner2->created_by = $LoggedIN;
                $QueueDesigner2->save();
            }
        }

        //4 and below windows, no priority
        if($windows <= 4 && $priorities == 0)
        {
            $windows = $request->input('number_of_windows');

            $QueueDesigner2->queue_name = $QueueName;
            $QueueDesigner2->station_name = $request->input('station_name');
            $QueueDesigner2->station_number = $id;
            $QueueDesigner2->window_number = 1;
            $QueueDesigner2->is_priority = "Yes";
            $QueueDesigner2->username = $QueueName.'S'.$id.'W'.'1';
            $QueueDesigner2->password = Hash::make($QueueName.'S'.$id.'W'.'1'.'pw');
            $QueueDesigner2->created_by = $LoggedIN;
            $QueueDesigner2->save();

            for($i = 2; $i <  $windows + 1; $i++ )
            {
                $QueueDesigner2 = new QueueDesigner2;
                $QueueDesigner2->queue_name = $QueueName;
                $QueueDesigner2->station_name = $request->input('station_name');
                $QueueDesigner2->station_number = $id;
                $QueueDesigner2->window_number = $i;
                $QueueDesigner2->is_priority = "No";
                $QueueDesigner2->username = $QueueName.'S'.$id.'W'. $i;
                $QueueDesigner2->password = Hash::make($QueueName.'S'.$id.'W'.$i.'pw');
                $QueueDesigner2->created_by = $LoggedIN;
                $QueueDesigner2->save();
            }
        }

        //only 1 window
        if($windows == 1)
        {
            $QueueDesigner2->queue_name = $QueueName;
            $QueueDesigner2->station_name = $request->input('station_name');
            $QueueDesigner2->station_number = $id;
            $QueueDesigner2->window_number = 1;
            $QueueDesigner2->is_priority = "Yes";
            $QueueDesigner2->username = $QueueName.'S'.$id.'W'.'1';
            $QueueDesigner2->password = Hash::make($QueueName.'S'.$id.'W'.'1'.'pw');
            $QueueDesigner2->created_by = $LoggedIN;
            $QueueDesigner2->save();
        }

        //Start of Editing in QueueDesigner1 Table
        $Queue_Designer1->station_name = $request->input('station_name');
        $Queue_Designer1->number_of_windows = $windows;
        $Queue_Designer1->number_of_kiosks = $request->input('number_of_kiosks');
        $Queue_Designer1->number_of_extra_pwd = $request->input('number_of_priority_windows');
        $Queue_Designer1->station_admin = $request->input('station_admin');
        $Queue_Designer1->save();

        return redirect('/queueadmin/queues/new/modify');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
