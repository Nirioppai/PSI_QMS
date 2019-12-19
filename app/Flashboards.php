<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class Flashboards extends Authenticatable
{
      use Notifiable;

    protected $guard = 'flashboard';

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

    public function addUr($queue_name, $station_name, $station_number, $number_of_windows, $created_by){

        $this->username = 'Flash_' . $queue_name . 'S' . $station_number;
        $this->password = Hash::make('Flash_' . $queue_name . 'S' . $station_number . 'pw');
        $this->queue_name = $queue_name;
        $this->record_station_name = $station_name;
        $this->record_station_number = $station_number;
        $this->record_number_of_windows = $number_of_windows;
        $this->record_creator = $created_by;

        $this->save();
    }

    public function incrementUr($queue_name, $station_number){

        $incrementStationNumber = $station_number+1;

        Flashboards::where('queue_name', $queue_name)
            ->where('record_station_number', $station_number)
            ->update([
                'record_station_number' => $incrementStationNumber,
                'username' => 'Flash_' . $queue_name . 'S' . $incrementStationNumber,
                'password' => Hash::make('Flash_' . $queue_name . 'S' . $incrementStationNumber . 'pw')
            ]);
    }
}
