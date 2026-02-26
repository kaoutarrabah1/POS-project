<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ROLE_ADMIN = 'admin';
    const ROLE_MANAGER = 'manager';
    const ROLE_CLIENT = 'client';

    protected $fillable = ['name', 'email', 'password', 'role'];

    // ... hidden, casts

    public function isAdmin() { return $this->role === self::ROLE_ADMIN; }
    public function isManager() { return $this->role === self::ROLE_MANAGER; }
    public function isClient() { return $this->role === self::ROLE_CLIENT; }

    public function orders() { return $this->hasMany(Order::class); }
    public function reservations() { return $this->hasMany(Reservation::class); }
}
