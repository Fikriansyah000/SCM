<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ServiceExtension extends Model
{
    use HasFactory;

    // Status constants
    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_AUTO_APPROVED = 'auto_approved';

    // Auto-approve after 24 hours
    public const AUTO_APPROVE_HOURS = 24;

    protected $fillable = [
        'order_id',
        'service_proposal_id',
        'requested_by',
        'extension_days',
        'reason',
        'original_deadline',
        'new_deadline',
        'status',
        'responded_by',
        'response_message',
        'responded_at',
        'auto_approve_at',
    ];

    protected $casts = [
        'original_deadline' => 'date',
        'new_deadline' => 'date',
        'responded_at' => 'datetime',
        'auto_approve_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($extension) {
            // Set auto-approve time when creating
            if (!$extension->auto_approve_at) {
                $extension->auto_approve_at = now()->addHours(self::AUTO_APPROVE_HOURS);
            }
        });
    }

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function serviceProposal()
    {
        return $this->belongsTo(ServiceProposal::class);
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function responder()
    {
        return $this->belongsTo(User::class, 'responded_by');
    }

    // Helpers
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isApproved(): bool
    {
        return in_array($this->status, [self::STATUS_APPROVED, self::STATUS_AUTO_APPROVED]);
    }

    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }

    public function shouldAutoApprove(): bool
    {
        return $this->status === self::STATUS_PENDING 
            && $this->auto_approve_at 
            && now()->gte($this->auto_approve_at);
    }

    public function getTimeUntilAutoApprove(): ?string
    {
        if (!$this->isPending() || !$this->auto_approve_at) {
            return null;
        }

        $diff = now()->diff($this->auto_approve_at);
        
        if ($diff->invert) {
            return 'Segera di-approve otomatis';
        }

        if ($diff->h > 0) {
            return $diff->h . ' jam ' . $diff->i . ' menit lagi';
        }
        
        return $diff->i . ' menit lagi';
    }

    public function approve(?int $userId = null, ?string $message = null): bool
    {
        $this->update([
            'status' => self::STATUS_APPROVED,
            'responded_by' => $userId,
            'response_message' => $message,
            'responded_at' => now(),
        ]);

        // Update order deadline
        if ($this->order) {
            $this->order->update(['service_due_at' => $this->new_deadline]);
        }

        return true;
    }

    public function autoApprove(): bool
    {
        $this->update([
            'status' => self::STATUS_AUTO_APPROVED,
            'responded_at' => now(),
        ]);

        // Update order deadline
        if ($this->order) {
            $this->order->update(['service_due_at' => $this->new_deadline]);
        }

        return true;
    }

    public function reject(?int $userId = null, ?string $message = null): bool
    {
        $this->update([
            'status' => self::STATUS_REJECTED,
            'responded_by' => $userId,
            'response_message' => $message,
            'responded_at' => now(),
        ]);

        return true;
    }

    public function getStatusLabel(): string
    {
        return match($this->status) {
            self::STATUS_PENDING => 'Menunggu Persetujuan',
            self::STATUS_APPROVED => 'Disetujui',
            self::STATUS_REJECTED => 'Ditolak',
            self::STATUS_AUTO_APPROVED => 'Disetujui Otomatis',
            default => $this->status,
        };
    }

    public function getStatusColor(): string
    {
        return match($this->status) {
            self::STATUS_PENDING => 'warning',
            self::STATUS_APPROVED, self::STATUS_AUTO_APPROVED => 'success',
            self::STATUS_REJECTED => 'danger',
            default => 'secondary',
        };
    }

    // Scope for pending extensions that should be auto-approved
    public function scopeReadyForAutoApproval($query)
    {
        return $query->where('status', self::STATUS_PENDING)
            ->where('auto_approve_at', '<=', now());
    }
}
