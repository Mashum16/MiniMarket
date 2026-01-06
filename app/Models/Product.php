<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItems;

class Product extends Model
{
    protected $fillable = [
        'category_id',
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

        public function category()
    {
        return $this->belongsTo(Category::class);
    }

        public function images()
    {
       return $this->hasMany(ProductImage::class);
    }

}
