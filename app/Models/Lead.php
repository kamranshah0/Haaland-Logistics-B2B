<?php

namespace App\Models;

use App\Notifications\SystemNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;
use App\Models\User;

class Lead extends Model
{
    protected $fillable = [
        'email', 'origin_id', 'country_id', 'region_id', 
        'volume_cft', 'service_type', 'message', 'status'
    ];

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

    protected static function booted()
    {
        static::created(function ($lead) {
            // Notify Admin
            $admins = User::where('role', 'admin')->get();
            Notification::send($admins, new SystemNotification([
                'title' => 'New Lead Inquiry',
                'message' => "A new shipping inquiry from {$lead->email} has been received.",
                'type' => 'info',
                'link' => route('admin.leads'),
                'icon' => 'user-group'
            ]));
        });
    }
}
