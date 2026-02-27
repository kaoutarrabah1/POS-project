<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'methode',
        'montant',
        'statut',
        'date_paiement',
    ];

    protected $casts = [
        'date_paiement' => 'datetime',
        'montant' => 'decimal:2',
    ];

    /**
     * العلاقة العكسية مع الطلب
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}