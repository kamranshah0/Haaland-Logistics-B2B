<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = ['quote_id', 'user_id', 'booking_number', 'drop_off_date', 'status', 'departure_id'];

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function departure()
    {
        return $this->belongsTo(Departure::class);
    }
}
