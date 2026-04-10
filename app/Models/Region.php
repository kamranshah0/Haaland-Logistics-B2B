<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = ['country_id', 'name'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function rates()
    {
        return $this->hasMany(Rate::class);
    }

    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }
}
