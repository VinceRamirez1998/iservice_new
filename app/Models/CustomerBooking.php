<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerBooking extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'image',
        'email',
        'password',
        'phone',
        'complete_address',
        'role',
        'permission',
        'primary_id',
        'secondary_id',
        'service',
        'certification',
        'gender',
        'subscription_plan',
        'subscription_duration',
        'user_id', // Ensure user_id is fillable
        'rating',
        'schedule',
        'approval'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function serviceProvider()
    {
        return $this->belongsTo(ServiceProvider::class, 'service_provider_id'); // Relationship to service provider
    }
}
