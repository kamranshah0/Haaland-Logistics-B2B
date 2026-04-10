<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $fillable = [
        'origin_id', 'country_id', 'region_id', 
        'shipping_service_id', 'service_type_id', 
        'service', 'service_type', 'rate_per_cft'
    ];

    public function shippingService()
    {
        return $this->belongsTo(ShippingService::class);
    }

    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class);
    }

    public function origin()
    {
        return $this->belongsTo(Warehouse::class, 'origin_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function tiers()
    {
        return $this->hasMany(RateTier::class);
    }
}
