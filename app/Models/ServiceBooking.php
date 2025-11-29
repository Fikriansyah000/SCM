<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceBooking extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'product_id',
        'service_slot_id',
        'order_item_id',
        'buyer_id',
        'scheduled_at',
        'status',
        'party_size',
        'preferences',
        'notes',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'preferences' => 'array',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function slot()
    {
        return $this->belongsTo(ServiceSlot::class, 'service_slot_id');
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
}
