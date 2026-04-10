<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    protected $fillable = ['name', 'description'];

    public function rates()
    {
        return $this->hasMany(Rate::class);
    }

    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }
}
