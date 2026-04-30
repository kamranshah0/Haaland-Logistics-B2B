<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PoeMapping extends Model
{
    protected $fillable = ['warehouse_id', 'country_id'];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
