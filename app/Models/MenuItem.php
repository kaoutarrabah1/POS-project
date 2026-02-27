<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'availability',
        'category_id',
    ];

    protected $casts = [
        'availability' => 'boolean',
        'price' => 'decimal:2',
    ];

    /**
     * العلاقة مع التصنيف
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * العلاقة مع المخزون (عنصر واحد له مخزون واحد)
     */
    public function stock()
    {
        return $this->hasOne(Stock::class);
    }

    /**
     * العلاقة مع عناصر الطلبات
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
