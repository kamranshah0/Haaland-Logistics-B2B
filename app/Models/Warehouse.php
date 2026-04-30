<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $fillable = ['name', 'code', 'address', 'type'];

    public function rates()
    {
        return $this->hasMany(Rate::class, 'origin_id');
    }

    public function quotes()
    {
        return $this->hasMany(Quote::class, 'origin_id');
    }

    public function countryMappings()
    {
        return $this->hasMany(PoeMapping::class, 'warehouse_id');
    }

    public function countries()
    {
        return $this->belongsToMany(Country::class, 'poe_mappings', 'warehouse_id', 'country_id');
    }
}
