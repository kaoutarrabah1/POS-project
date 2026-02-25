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
     * ثوابت الأدوار - هادو القيم المسموح بها فـ عمود role
     */
    const ROLE_ADMIN = 'admin';
    const ROLE_MANAGER = 'manager';
    const ROLE_CLIENT = 'client';

    /**
     * الحقول اللي يمكن تعبئتها (mass assignable)
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',           // <-- هاد السطر مهم، خاص يكون فاضل
    ];

    /**
     * الحقول المخفية فاش كيرجعو JSON
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * الحقول اللي تحول لنوع معين (casting)
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // ========== دوال المساعدة للتحقق من الدور ==========

    /**
     * هل المستخدم Admin؟
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * هل المستخدم Manager؟
     */
    public function isManager(): bool
    {
        return $this->role === self::ROLE_MANAGER;
    }

    /**
     * هل المستخدم Client؟
     */
    public function isClient(): bool
    {
        return $this->role === self::ROLE_CLIENT;
    }

    // ========== العلاقات ==========

    /**
     * المستخدم عنده بزاف ديال الطلبات (orders)
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * المستخدم عنده بزاف ديال الحجوزات (reservations)
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}