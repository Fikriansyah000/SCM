<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceProposal extends Model
{
    use HasFactory;

    // Status constants
    public const STATUS_PENDING = 'pending';
    public const STATUS_NEGOTIATING = 'negotiating';
    public const STATUS_ACCEPTED = 'accepted';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_REVIEW = 'review';
    public const STATUS_REVISION = 'revision';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'product_id',
        'buyer_id',
        'seller_id',
        'order_id',
        'order_item_id',
        'description',
        'proposed_deadline',
        'proposed_price',
        'offered_price', // Alias for proposed_price
        'deadline', // Alias for proposed_deadline
        'agreed_price',
        'agreed_deadline',
        'seller_notes',
        'notes',
        'responded_at',
        'status',
        'accepted_at',
        'started_at',
        'submitted_at',
        'completed_at',
        'cancelled_at',
        'cancellation_reason',
        'metadata',
    ];

    protected $casts = [
        'proposed_deadline' => 'date',
        'agreed_deadline' => 'date',
        'proposed_price' => 'decimal:2',
        'agreed_price' => 'decimal:2',
        'accepted_at' => 'datetime',
        'responded_at' => 'datetime',
        'started_at' => 'datetime',
        'submitted_at' => 'datetime',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'metadata' => 'array',
    ];

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function events()
    {
        return $this->hasMany(OrderEvent::class);
    }

    public function extensions()
    {
        return $this->hasMany(ServiceExtension::class);
    }

    // Accessors for alternate column names
    public function getOfferedPriceAttribute()
    {
        return $this->proposed_price;
    }

    public function setOfferedPriceAttribute($value)
    {
        $this->attributes['proposed_price'] = $value;
    }

    public function getDeadlineAttribute()
    {
        return $this->proposed_deadline;
    }

    public function setDeadlineAttribute($value)
    {
        $this->attributes['proposed_deadline'] = $value;
    }

    // Helpers
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isActive(): bool
    {
        return in_array($this->status, [
            self::STATUS_ACCEPTED,
            self::STATUS_IN_PROGRESS,
            self::STATUS_REVIEW,
            self::STATUS_REVISION,
        ]);
    }

    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    public function canBeAccepted(): bool
    {
        return in_array($this->status, [self::STATUS_PENDING, self::STATUS_NEGOTIATING]);
    }

    public function canStartWork(): bool
    {
        return $this->status === self::STATUS_ACCEPTED;
    }

    public function canSubmitForReview(): bool
    {
        return in_array($this->status, [self::STATUS_IN_PROGRESS, self::STATUS_REVISION]);
    }

    public function canRequestRevision(): bool
    {
        return $this->status === self::STATUS_REVIEW;
    }

    public function canComplete(): bool
    {
        return $this->status === self::STATUS_REVIEW;
    }

    public function getFinalPrice(): float
    {
        return $this->agreed_price ?? $this->proposed_price;
    }

    public function getFinalDeadline()
    {
        return $this->agreed_deadline ?? $this->proposed_deadline;
    }

    public function getStatusLabel(): string
    {
        return match($this->status) {
            self::STATUS_PENDING => 'Menunggu Konfirmasi',
            self::STATUS_NEGOTIATING => 'Negosiasi',
            self::STATUS_ACCEPTED => 'Diterima',
            self::STATUS_REJECTED => 'Ditolak',
            self::STATUS_IN_PROGRESS => 'Sedang Dikerjakan',
            self::STATUS_REVIEW => 'Menunggu Review',
            self::STATUS_REVISION => 'Revisi Diminta',
            self::STATUS_COMPLETED => 'Selesai',
            self::STATUS_CANCELLED => 'Dibatalkan',
            default => $this->status,
        };
    }

    public function getStatusColor(): string
    {
        return match($this->status) {
            self::STATUS_PENDING, self::STATUS_NEGOTIATING => 'warning',
            self::STATUS_ACCEPTED, self::STATUS_IN_PROGRESS => 'info',
            self::STATUS_REVIEW => 'primary',
            self::STATUS_REVISION => 'warning',
            self::STATUS_COMPLETED => 'success',
            self::STATUS_REJECTED, self::STATUS_CANCELLED => 'danger',
            default => 'secondary',
        };
    }
}
