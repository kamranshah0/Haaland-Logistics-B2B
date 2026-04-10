<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RateTier extends Model
{
    protected $fillable = ['rate_id', 'min_volume', 'price_per_cft'];

    public function rate()
    {
        return $this->belongsTo(Rate::class);
    }
}
