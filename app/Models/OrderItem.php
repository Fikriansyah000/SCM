<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_variation_id',
        'quantity',
        'price',
        'option_snapshot',
        'service_start_at',
        'service_end_at',
        'service_details',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'option_snapshot' => 'array',
        'service_details' => 'array',
        'service_start_at' => 'datetime',
        'service_end_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variation()
    {
        return $this->belongsTo(ProductVariation::class, 'product_variation_id');
    }

    public function serviceBooking()
    {
        return $this->hasOne(ServiceBooking::class);
    }
}
