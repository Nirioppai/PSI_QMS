<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;
use App\QueueAdmins;
use App\StationAdmins;
use App\WindowAdmins;

class CustomRegisterController extends Controller
{
    // This controller handles the initial registration for the Queueing System.

    public function index()
    {
      //Check for any account in database
      $SuperAdmins = User::all();

      //Restricts Access to one time Register
      if(count ($SuperAdmins) >= 1)
      {
        return redirect('/login');
      }
      else {
        return view('welcome');
      }
    }

    //Validates Input
    public function one_time_register_submit(Request $request){
      $this->validate($request, [
          'Name' => ['required', 'string', 'max:50'],
          'Username' => ['required', 'string', 'max:25', 'unique:users','unique:queue_admins','unique:station_admins','unique:window_admins'],
          'Password' => ['required', 'string', 'max:25', 'min:8', 'confirmed'],
      ]);

      //Registers the User
      $UserDB = new User;
      $UserDB->name = $request->input('Name');
      $UserDB->username = $request->input('Username');
      $UserDB->password =  Hash::make($request->input('Password'));
      $UserDB->save();

      //Redirect to Login
      return redirect('/');
    }
}
