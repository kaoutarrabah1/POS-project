<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * العلاقة مع عناصر القائمة (تصنيف واحد له عدة عناصر)
     */
    public function menuItems()
    {
        return $this->hasMany(MenuItem::class);
    }
}
