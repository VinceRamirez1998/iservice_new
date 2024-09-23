<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
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
        'image'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'service_user');
    }
}
