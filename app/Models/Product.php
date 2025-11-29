<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'name',
        'description',
        'price',
        'stock',
        'category',
        'image',
        'status',
        'product_type',
        'food_profile',
        'service_profile',
        'requires_booking',
        'booking_settings',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'food_profile' => 'array',
        'service_profile' => 'array',
        'booking_settings' => 'array',
        'requires_booking' => 'boolean',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(\App\Models\ProductReview::class);
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function serviceSlots()
    {
        return $this->hasMany(ServiceSlot::class);
    }

    public function serviceBookings()
    {
        return $this->hasMany(ServiceBooking::class);
    }
}
