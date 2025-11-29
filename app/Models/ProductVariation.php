<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'variation_type',
        'price_adjustment',
        'stock',
        'is_default',
        'metadata',
    ];

    protected $casts = [
        'price_adjustment' => 'decimal:2',
        'metadata' => 'array',
        'is_default' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'product_variation_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_variation_id');
    }
}
