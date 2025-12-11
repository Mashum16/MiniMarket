<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItems;

class Orders extends Model
{
    protected $fillable = [
        'user_id',
        'total_price',
        'status'
    ];

    // relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // relasi ke order_items
    public function items()
    {
        return $this->hasMany(OrderItems::class);
    }
};
