<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantite',
        'prix',
        'order_id',
        'menu_item_id',
    ];

    protected $casts = [
        'prix' => 'decimal:2',
    ];

    /**
     * العلاقة مع الطلب
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * العلاقة مع عنصر القائمة
     */
    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }
}
