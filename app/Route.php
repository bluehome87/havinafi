<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $fillable = ['job_id', 'vehicle_id', 'completion_time', 'distance', 'transport_time', 'waiting_time'];

    public function job()
    {
        return $this->belongsTo('App\Job');
    }

    public function vehicle()
    {
        return $this->belongsTo('App\Vehicle');
    }

    public function activities()
    {
        return $this->hasMany('App\Activity');
    }
}
