<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QueueRecords extends Model
{
    
    public static function SNC($queue_name, $station_number){

        return QueueRecords::where('queue_name', $queue_name)
            ->where('record_number', $station_number)
            ->where('record_type', 'Station')
            ->first();
    }

    public static function SMN($queue_name){

        return QueueRecords::where('queue_name', $queue_name)
            ->where('record_type', 'Station')
            ->count();
    }

    public static function WMN($queue_name, $station_number){

        return QueueRecords::where('queue_name', $queue_name)
            ->where('record_station_number', $station_number)
            ->where('record_type', 'Window')
            ->count();
    }

    public function addSn($queue_name, $station_name, $station_number, $station_admin, $number_of_windows, $created_by){

    	$this->queue_name = $queue_name;
    	$this->record_type = 'Station';
    	$this->record_name = $station_name;
    	$this->record_number = $station_number;
    	$this->record_number_of_windows = $number_of_windows;
    	$this->record_admin = $station_admin;
    	$this->queue_status = 1;
    	$this->record_creator = $created_by;

    	$this->save();
    }

    public function addWw($queue_name, $station_number, $window_number, $created_by){

    	$this->queue_name = $queue_name;
    	$this->record_type = 'Window';
    	$this->record_name = $queue_name;
    	$this->record_station_number = $station_number;
    	$this->record_number = $window_number;
    	$this->record_admin = $queue_name . 'S' . $station_number . 'W' . $window_number;
    	$this->queue_status = 1;
    	$this->record_creator = $created_by;

    	$this->save();
    }

    public function incrementSn($queue_name, $station_number){

        QueueRecords::where('queue_name', $queue_name)
            ->where('record_number', $station_number)
            ->where('record_type', 'Station')
            ->increment('record_number');
    }

    public function incrementWw($queue_name, $station_number, $window_number){

        $incrementStationNumber = $station_number+1;

        QueueRecords::where('queue_name', $queue_name)
            ->where('record_station_number', $station_number)
            ->where('record_number', $window_number)
            ->where('record_type', 'Window')
            ->update([
                'record_station_number' => $incrementStationNumber,
                'record_admin' => $queue_name . 'S' .  $incrementStationNumber . 'W' . $window_number
            ]);
    }

    public function incrementQe($queue_name){

        QueueRecords::where('queue_name', $queue_name)
            ->where('record_type', 'Queue')
            ->increment('record_number_of_stations');
    }
}
