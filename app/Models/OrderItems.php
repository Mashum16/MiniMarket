<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Orders;
use App\Models\Product;

class OrderItems extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'qty',
        'price_at_purchase'
    ];

    public function order()
    {
        return $this->belongsTo(Orders::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

