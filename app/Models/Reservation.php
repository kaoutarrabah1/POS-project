<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'heure',
        'nombre_personnes',
        'statut',
        'user_id',
        'table_resto_id',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    /**
     * العلاقة مع المستخدم (صاحب الحجز)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * العلاقة مع الطاولة
     */
    public function tableResto()
    {
        return $this->belongsTo(TableResto::class);
    }
}