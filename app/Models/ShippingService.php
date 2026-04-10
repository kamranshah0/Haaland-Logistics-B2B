<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingService extends Model
{
    protected $fillable = ['name', 'description'];

    public function rates()
    {
        return $this->hasMany(Rate::class);
    }
}
