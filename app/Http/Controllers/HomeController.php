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

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
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
                return view('layouts.superadmin.home');
            }
            else
            {
                return view('layouts.superadmin.home');
            }
        }
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
                return view('layouts.superadmin.queues');
            }
            else
            {
                return view('layouts.superadmin.queues');
            }
        }
    }

    public function queueView()
    {
        $QueueRecord = DB::table('queue_records')->where('record_type', '=', 'Queue')->get();
        return view('layouts.superadmin.queue_view')->with('QueueRecord', $QueueRecord);
    }

    public function queueList()
    {
        return view('layouts.superadmin.queue_list');
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
                return view('layouts.superadmin.queue_new')->with('StationAdmins', $StationAdmins)->with('Status', $Status);
            }
            else
            {
                return view('layouts.superadmin.queue_new')->with('StationAdmins', $StationAdmins)->with('Status', $Status);
            }
        }
    }

    public function accounts()
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
                return view('layouts.superadmin.accounts');
            }
            else
            {
                return view('layouts.superadmin.accounts');
            }
        }
    }

    public function newAccounts()
    {
        $QueueDesigner1 = QueueDesigner1::all();
        $Status = "false";
        //if Super admin is Logged in
        if($user = Auth::user())
        {
        //if there are unfinished designs
            if(count ($QueueDesigner1) > 0)
            {
                $QueueDesigner1_Empty=QueueDesigner1::truncate();
                $QueueDesigner2_Empty=QueueDesigner2::truncate();
                return view('layouts.superadmin.account_new')->with('Status', $Status);
            }
            else
            {
                return view('layouts.superadmin.account_new')->with('Status', $Status);
            }
        }
    }

    public function newAccountSubmit(Request $request){
    $this->validate($request, [
    'name' => ['required', 'string', 'max:255'],
    'username' => ['required', 'string', 'max:25', 'unique:users','unique:queue_admins','unique:station_admins'],
    'password' => ['required', 'string', 'min:8', 'confirmed'],
    'account_type' => ['string', 'max:255'],
    ]);

    $LoggedIN = Auth::user()->name;
    $account_type = $request['account_type'];
    $Status = "true";

    if($account_type === 'Super Admin')
    {
        $SuperAdmin = new User;
        $SuperAdmin->name = $request->input('name');
        $SuperAdmin->username = $request->input('username');
        $SuperAdmin->password = Hash::make($request['password']);
        $SuperAdmin->created_by = $LoggedIN;
        $SuperAdmin->save();

        return view('layouts.superadmin.account_new')->with('Status', $Status);
    }

    if($account_type === 'Queue Admin')
    {
        $QueueAdmin = new QueueAdmins;
        $QueueAdmin->name = $request->input('name');
        $QueueAdmin->username = $request->input('username');
        $QueueAdmin->password = Hash::make($request['password']);
        $QueueAdmin->created_by = $LoggedIN;
        $QueueAdmin->save();

        return view('layouts.superadmin.account_new')->with('Status', $Status);
    }

    if($account_type === 'Station Admin')
    {
        $StationAdmin = new StationAdmins;
        $StationAdmin->name = $request->input('name');
        $StationAdmin->username = $request->input('username');
        $StationAdmin->password = Hash::make($request['password']);
        $StationAdmin->created_by = $LoggedIN;
        $StationAdmin->save();

        return view('layouts.superadmin.account_new')->with('Status', $Status);
    }


    }

    public function viewQueueAdminAccounts()
    {
      $QueueAdmins = QueueAdmins::all();
      return view('layouts.superadmin.account_view_queueAdmin')->with('QueueAdmins', $QueueAdmins);
    }

    public function viewStationAdminAccounts()
    {
      $StationAdmins = StationAdmins::all();
      return view('layouts.superadmin.account_view_stationAdmin')->with('StationAdmins', $StationAdmins);
    }

    public function archives()
    {
        $QueueRecord = DB::table('queue_records')->where('record_type', '=', 'Queue')->get();
        $QueueDesigner1 = QueueDesigner1::all();
        //if Super admin is Logged in
        if($user = Auth::user())
        {
        //if there are unfinished designs
            if(count ($QueueDesigner1) > 0)
            {
                $QueueDesigner1_Empty=QueueDesigner1::truncate();
                $QueueDesigner2_Empty=QueueDesigner2::truncate();
                return view('layouts.superadmin.archives')->with('QueueRecord', $QueueRecord);
            }
            else
            {
                return view('layouts.superadmin.archives')->with('QueueRecord', $QueueRecord);
            }
        }
    }

    public function announcements()
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
                return view('layouts.superadmin.announcements');
            }
            else
            {
                return view('layouts.superadmin.announcements');
            }
        }
    }

}
