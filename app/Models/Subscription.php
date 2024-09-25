<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 
        'email', 
        'address', 
        'phone', 
        'amount', 
        'status', 
        'created_at', 
        'reference_no', 
        'bank',
        'subscription_plan',
        'subscription_duration',
    ];

}
