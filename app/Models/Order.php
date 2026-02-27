<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_commande',
        'statut',
        'total',
        'date_commande',
        'user_id',
    ];

    protected $casts = [
        'date_commande' => 'datetime',
        'total' => 'decimal:2',
    ];

    /**
     * العلاقة مع المستخدم (صاحب الطلب)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * العلاقة مع عناصر الطلب
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * العلاقة مع الدفع (كل طلب له دفعة واحدة)
     */
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}