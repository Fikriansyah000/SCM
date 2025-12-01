<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderEvent extends Model
{
    use HasFactory;

    public $timestamps = false;

    // Event type constants
    public const TYPE_PROPOSAL_CREATED = 'proposal_created';
    public const TYPE_PROPOSAL_ACCEPTED = 'proposal_accepted';
    public const TYPE_PROPOSAL_REJECTED = 'proposal_rejected';
    public const TYPE_PROPOSAL_NEGOTIATING = 'proposal_negotiating';
    public const TYPE_WORK_STARTED = 'work_started';
    public const TYPE_REVIEW_SUBMITTED = 'review_submitted';
    public const TYPE_REVISION_REQUESTED = 'revision_requested';
    public const TYPE_COMPLETED = 'completed';
    public const TYPE_CANCELLED = 'cancelled';
    public const TYPE_EXTENSION_REQUESTED = 'extension_requested';
    public const TYPE_EXTENSION_APPROVED = 'extension_approved';
    public const TYPE_EXTENSION_REJECTED = 'extension_rejected';
    public const TYPE_EXTENSION_AUTO_APPROVED = 'extension_auto_approved';
    public const TYPE_MESSAGE = 'message';

    // Actor type constants
    public const ACTOR_BUYER = 'buyer';
    public const ACTOR_SELLER = 'seller';
    public const ACTOR_SYSTEM = 'system';

    protected $fillable = [
        'order_id',
        'order_item_id',
        'service_proposal_id',
        'actor_type',
        'actor_id',
        'event_type',
        'title',
        'message',
        'metadata',
        'visible_to_buyer',
        'visible_to_seller',
        'created_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'visible_to_buyer' => 'boolean',
        'visible_to_seller' => 'boolean',
        'created_at' => 'datetime',
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function serviceProposal()
    {
        return $this->belongsTo(ServiceProposal::class);
    }

    public function actor()
    {
        return $this->belongsTo(User::class, 'actor_id');
    }

    // Helpers
    public function getActorName(): string
    {
        if ($this->actor_type === self::ACTOR_SYSTEM) {
            return 'Sistem';
        }
        
        return $this->actor?->name ?? 'Unknown';
    }

    public function isFromBuyer(): bool
    {
        return $this->actor_type === self::ACTOR_BUYER;
    }

    public function isFromSeller(): bool
    {
        return $this->actor_type === self::ACTOR_SELLER;
    }

    public function isFromSystem(): bool
    {
        return $this->actor_type === self::ACTOR_SYSTEM;
    }

    public function getIconClass(): string
    {
        return match($this->event_type) {
            self::TYPE_PROPOSAL_CREATED => 'fas fa-file-alt',
            self::TYPE_PROPOSAL_ACCEPTED => 'fas fa-check-circle',
            self::TYPE_PROPOSAL_REJECTED => 'fas fa-times-circle',
            self::TYPE_PROPOSAL_NEGOTIATING => 'fas fa-comments',
            self::TYPE_WORK_STARTED => 'fas fa-play-circle',
            self::TYPE_REVIEW_SUBMITTED => 'fas fa-paper-plane',
            self::TYPE_REVISION_REQUESTED => 'fas fa-redo',
            self::TYPE_COMPLETED => 'fas fa-check-double',
            self::TYPE_CANCELLED => 'fas fa-ban',
            self::TYPE_EXTENSION_REQUESTED => 'fas fa-clock',
            self::TYPE_EXTENSION_APPROVED, self::TYPE_EXTENSION_AUTO_APPROVED => 'fas fa-calendar-plus',
            self::TYPE_EXTENSION_REJECTED => 'fas fa-calendar-times',
            self::TYPE_MESSAGE => 'fas fa-comment',
            default => 'fas fa-info-circle',
        };
    }

    public function getColorClass(): string
    {
        return match($this->event_type) {
            self::TYPE_PROPOSAL_ACCEPTED, self::TYPE_COMPLETED, 
            self::TYPE_EXTENSION_APPROVED, self::TYPE_EXTENSION_AUTO_APPROVED => 'success',
            self::TYPE_PROPOSAL_REJECTED, self::TYPE_CANCELLED, 
            self::TYPE_EXTENSION_REJECTED => 'danger',
            self::TYPE_WORK_STARTED, self::TYPE_REVIEW_SUBMITTED => 'info',
            self::TYPE_REVISION_REQUESTED, self::TYPE_EXTENSION_REQUESTED,
            self::TYPE_PROPOSAL_NEGOTIATING => 'warning',
            default => 'secondary',
        };
    }

    // Factory method for creating events
    public static function record(
        int $orderId,
        string $eventType,
        string $title,
        string $actorType = self::ACTOR_SYSTEM,
        ?int $actorId = null,
        ?string $message = null,
        ?array $metadata = null,
        ?int $orderItemId = null,
        ?int $serviceProposalId = null,
        bool $visibleToBuyer = true,
        bool $visibleToSeller = true
    ): self {
        return self::create([
            'order_id' => $orderId,
            'order_item_id' => $orderItemId,
            'service_proposal_id' => $serviceProposalId,
            'actor_type' => $actorType,
            'actor_id' => $actorId,
            'event_type' => $eventType,
            'title' => $title,
            'message' => $message,
            'metadata' => $metadata,
            'visible_to_buyer' => $visibleToBuyer,
            'visible_to_seller' => $visibleToSeller,
            'created_at' => now(),
        ]);
    }
}
