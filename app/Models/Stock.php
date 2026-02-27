<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantite',
        'menu_item_id',
    ];

    /**
     * العلاقة مع عنصر القائمة
     */
    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }
}
