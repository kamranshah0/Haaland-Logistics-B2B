<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $fillable = ['name', 'code', 'address'];

    public function rates()
    {
        return $this->hasMany(Rate::class, 'origin_id');
    }

    public function quotes()
    {
        return $this->hasMany(Quote::class, 'origin_id');
    }
}
