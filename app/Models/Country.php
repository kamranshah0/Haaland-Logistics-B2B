<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = ['name', 'has_regions'];

    public function regions()
    {
        return $this->hasMany(Region::class);
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
