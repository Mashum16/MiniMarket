<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItems;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'stock',
        'description',
        'image'
    ];

        public function orderItems()
    {
        return $this->hasMany(OrderItems::class);
    }
}
