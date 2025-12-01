<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'shop_id',
        'message',
        'is_read',
        'context_type',
        'context_id',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    /**
     * Get the context model (Product or ServiceProposal)
     */
    public function getContextAttribute()
    {
        if (!$this->context_type || !$this->context_id) {
            return null;
        }

        if ($this->relationLoaded('context')) {
            return $this->getRelation('context');
        }

        $context = match($this->context_type) {
            'product' => Product::with('shop')->find($this->context_id),
            'proposal' => ServiceProposal::with(['product.shop', 'buyer', 'seller'])->find($this->context_id),
            default => null,
        };

        $this->setRelation('context', $context);

        return $context;
    }

    /**
     * Check if message has context
     */
    public function hasContext(): bool
    {
        return !empty($this->context_type) && !empty($this->context_id);
    }
}
