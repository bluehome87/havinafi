<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'name', 'type', 'max_speed', 'passenger_delivery', 'package_delivery', 'from_city', 'from_address',
        'from_time', 'to_city', 'to_address', 'to_time', 'max_passengers', 'invalid_seats', 'trunk_length', 'trunk_width',
        'trunk_height', 'trunk_volume', 'max_weight', 'weather_protection', 'food_accepted', 'temp_control', 'temp_min',
        'temp_max', 'crane', 'rear_lift', 'cost_eur_task', 'cost_eur_km', 'cost_eur_h', 'notes',
    ];

    public function vehicleType()
    {
        return $this->belongsTo('App\VehicleType');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function routes()
    {
        return $this->hasMany('App\Route');
    }
}
