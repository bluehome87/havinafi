<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'name', 'passenger_delivery', 'package_delivery', 'one_stop_task', 'from_city', 'from_address',
        'from_time_start', 'from_time_end', 'to_city', 'to_address', 'to_time_start', 'to_time_end', 'loading_time',
        'passengers', 'invalids', 'total_packages',  'total_volume', 'weight', 'fragile', 'weather_protection', 'food',
        'temp_control', 'temp_min', 'temp_max', 'crane', 'rear_lift', 'notes',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function activities()
    {
        return $this->hasMany('App\Activity');
    }
}
