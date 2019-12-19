<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pools extends Model
{
    
    public function incrementCN($queue_name, $station_number){

    	Pools::where('queue_name', $queue_name)
    		->where('queue_station_number', $station_number)
    		->increment('queue_station_number');
    }
}
