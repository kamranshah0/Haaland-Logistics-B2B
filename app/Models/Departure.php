<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departure extends Model
{
    protected $fillable = [
        'vessel_name', 'voyage_number', 'cutoff_date', 'departure_date',
        'arrival_date', 'capacity_cft', 'status'
    ];

    protected $casts = [
        'cutoff_date' => 'datetime',
        'departure_date' => 'datetime',
        'arrival_date' => 'datetime',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
