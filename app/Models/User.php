<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Service;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
    */
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
        'service_id', 
        'status',
        'subscription_plan',
        'subscription_duration',
        'rating',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    // public function services()
    // {
    //     return $this->belongsToMany(Service::class, 'service_user');
    // }

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }
    
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }
    
    
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }


    public function canAccessFilament(): bool
    {
        return $this->hasRole('admin' || 'Admin');
    }

    public function serviceProviders()
    {
        return $this->hasMany(ServiceProvider::class);
    }

    


   


}
