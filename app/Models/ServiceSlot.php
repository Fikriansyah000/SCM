<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'slot_date',
        'day_of_week',
        'start_time',
        'end_time',
        'capacity',
        'booked_count',
        'is_recurring',
        'is_active',
        'metadata',
    ];

    protected $casts = [
        'slot_date' => 'date',
        'metadata' => 'array',
        'is_recurring' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function bookings()
    {
        return $this->hasMany(ServiceBooking::class);
    }

    public function availableCapacity(): int
    {
        return max($this->capacity - $this->booked_count, 0);
    }
}
