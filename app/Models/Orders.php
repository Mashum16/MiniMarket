<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItems;
use App\Models\User; // ⬅️ WAJIB

class Orders extends Model
{
    protected $table = 'orders'; // ⬅️ aman ditulis eksplisit

    protected $fillable = [
        'user_id',
        'total_price',
        'status'
    ];

    // 🔗 relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // 🔗 relasi ke order_items
    public function items()
    {
        return $this->hasMany(OrderItems::class, 'order_id');
    }
}
