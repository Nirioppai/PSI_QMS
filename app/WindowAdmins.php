<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class WindowAdmins extends Authenticatable
{
      use Notifiable;

    protected $guard = 'window_admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function addUr($queue_name, $station_number, $window_number, $is_priority ,$created_by){

        $this->username = $queue_name . 'S' . $station_number . 'W' . $window_number;
        $this->password = Hash::make($queue_name . 'S' . $station_number . 'W' . $window_number . 'pw');
        $this->queue_name = $queue_name;
        $this->window_station_number = $station_number;
        $this->window_number = $window_number;
        $this->is_priority_window = $is_priority;
        $this->queue_status = 1;
        $this->record_creator = $created_by;

        $this->save();
    }

    public function incrementUr($queue_name, $station_number, $window_number){

        $incrementStationNumber = $station_number+1;

        WindowAdmins::where('queue_name', $queue_name)
            ->where('window_station_number', $station_number)
            ->where('window_number', $window_number)
            ->update([
                'window_station_number' => $incrementStationNumber,
                'username' => $queue_name . 'S' . $incrementStationNumber . 'W' . $window_number,
                'password' => Hash::make($queue_name . 'S' . $incrementStationNumber . 'W' . $window_number . 'pw')
            ]);
    }
}
