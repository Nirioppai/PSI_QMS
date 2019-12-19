<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\QueueAdmins;
use App\StationAdmins;
use App\QueueDesigner1;
use App\QueueDesigner2;
use App\QueueRecords;
use App\WindowAdmins;
use App\Flashboards;
use App\Pools;
use Illuminate\Support\Facades\Hash;
use Auth;
use DB;
use Illuminate\Support\Facades\Redirect;

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
        $StationAdmins = DB::table('station_admins')->select('name')->get();
        $QueueRecord = DB::table('queue_records')->where('record_type', '=', 'Queue')->get();
        return view('layouts.superadmin.queue_view')->with('QueueRecord', $QueueRecord)->with('StationAdmins', $StationAdmins);
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

    public function addStation(Request $request){

        $SNC_QR = QueueRecords::SNC($request->input('aS_QNe'), $request->input('aS_SNr'));
        
        if ($SNC_QR != null) {
            
            $SMN_QR = QueueRecords::SMN($request->input('aS_QNe'));

            for ($update_SN = $SMN_QR; $update_SN >= $SNC_QR->record_number; $update_SN--) {

                $WMN_QR = QueueRecords::WMN($request->input('aS_QNe'), $update_SN);

                $updateUr_Fd = new Flashboards;
                $updateUr_Fd->incrementUr($request->input('aS_QNe'), $update_SN);

                $updateSn_QR = new QueueRecords;
                $updateSn_QR->incrementSn($request->input('aS_QNe'), $update_SN);

                $updateCN_PL = new Pools;
                $updateCN_PL->incrementCN($request->input('aS_QNe'), $update_SN);

                for ($update_WN = $WMN_QR; $update_WN >= 1; $update_WN--) {

                    $updateWw_QR = new QueueRecords;
                    $updateWw_QR->incrementWw($request->input('aS_QNe'),  $update_SN, $update_WN);

                    $updateWw_WA = new WindowAdmins;
                    $updateWw_WA->incrementUr($request->input('aS_QNe'), $update_SN, $update_WN);
                }
            }
        }


        $addUr_Fd = new Flashboards;
        $addUr_Fd->addUr($request->input('aS_QNe'), $request->input('aS_SNe'), $request->input('aS_SNr'), $request->input('aS_NoWs'), $request->input('aS_Cb'));

        $addSn_QR = new QueueRecords;
        $addSn_QR->addSn($request->input('aS_QNe'), $request->input('aS_SNe'), $request->input('aS_SNr'), $request->input('aS_SAn'), $request->input('aS_NoWs'), $request->input('aS_Cb'));

        for ($add_WN = 1; $add_WN <= $request->input('aS_NoWs'); $add_WN++) { 
           
            if ($add_WN <= $request->input('aS_NoPy') + 1) {

                $is_priority =  'Yes';
            } elseif ($add_WN > $request->input('aS_NoPy') + 1) {

                $is_priority =  'No';
            }

            $addWw_QR = new QueueRecords;
            $addWw_QR->addWw($request->input('aS_QNe'), $request->input('aS_SNr'), $add_WN, $request->input('aS_Cb'));

            $addUr_WA = new WindowAdmins;
            $addUr_WA->addUr($request->input('aS_QNe'), $request->input('aS_SNr'), $add_WN, $is_priority, $request->input('aS_Cb'));
        }

        $updateQe_QR = new QueueRecords;
        $updateQe_QR->incrementQe($request->input('aS_QNe'));
 
        return redirect("/superadmin/queues/view");
    }

}
