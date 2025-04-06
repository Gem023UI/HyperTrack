<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture', // Allow mass assignment for profile picture
        'role', // Allow mass assignment for role
        'status', // Allow mass assignment for status
    ];

    public function getProfilePictureUrlAttribute()
{
    return $this->profile_picture ? asset('storage/'.$this->profile_picture) : null;
}

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
        'role' => 'string', // Cast role to string
        'status' => 'string', // Cast status to string
    ];

    /**
     * Check if the authenticated user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
