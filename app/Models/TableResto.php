<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableResto extends Model
{
    use HasFactory;

    protected $table = 'table_restos'; // لأن اسم الجدول جمع

    protected $fillable = [
        'numero',
        'capacite',
        'statut',
    ];

    /**
     * العلاقة مع الحجوزات (طاولة واحدة لها عدة حجوزات)
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
