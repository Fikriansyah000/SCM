<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
     protected $dates = [
        'confirmed_at',
        'shipped_at', 
        'delivered_at',
        'completed_at',
        'cancelled_at',
        'return_requested_at',
        'return_shipped_at',
        'return_received_at',
        'estimated_delivery',
        'actual_delivery',
        'cutoff_time',
        'created_at',
        'updated_at'
    ];

    protected $fillable = [
        'user_id', 'shop_id', 'order_number', 'status',
        'total_amount', 'shipping_address', 'shipping_method',
        'shipping_mode', 'shipping_cost', 'total_weight',
        'estimated_delivery', 'actual_delivery', 'tracking_url',
        'tracking_number', 'shipping_status', 'courier_name', 
        'courier_phone', 'live_tracking_url', 'cutoff_exceeded',
        'cutoff_time', 'notes', 'confirmed_at', 'shipped_at',
        'delivered_at', 'completed_at', 'cancelled_at',
        'return_status', 'return_reason', 'return_requested_at', 
        'return_tracking_number', 'return_shipped_at', 'return_received_at',
        // Service order fields
        'is_service_order', 'service_due_at', 'service_status'
    ];

    protected $casts = [
        'cutoff_exceeded' => 'boolean',
        'shipping_cost' => 'decimal:2',
        'total_weight' => 'decimal:2',
        'is_service_order' => 'boolean',
        'service_due_at' => 'date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function serviceProposals()
    {
        return $this->hasMany(ServiceProposal::class);
    }

    public function orderEvents()
    {
        return $this->hasMany(OrderEvent::class)->orderBy('created_at', 'asc');
    }

    public function serviceExtensions()
    {
        return $this->hasMany(ServiceExtension::class);
    }

    public function pendingExtension()
    {
        return $this->hasOne(ServiceExtension::class)->where('status', ServiceExtension::STATUS_PENDING)->latest();
    }

    // Shipping Mode Methods
    public function isReguler()
    {
        return $this->shipping_mode === 'reguler';
    }

    public function isSameDay()
    {
        return $this->shipping_mode === 'same_day';
    }

    public function isInstant()
    {
        return $this->shipping_mode === 'instant';
    }

    public function getShippingModeLabel()
    {
        return match($this->shipping_mode) {
            'reguler' => 'Reguler (1-3 hari)',
            'same_day' => 'Same Day (6-12 jam)',
            'instant' => 'Instant (1-3 jam)',
            default => 'Unknown'
        };
    }

    public function getMaxWeight()
    {
        return match($this->shipping_mode) {
            'reguler' => 50,      // kg
            'same_day' => 5,      // kg
            'instant' => 3,       // kg
            default => 0
        };
    }

    public function getCutoffTime()
    {
        return match($this->shipping_mode) {
            'same_day' => now()->setHour(14)->setMinute(0)->setSecond(0),  // 14:00
            'instant' => now()->setHour(12)->setMinute(0)->setSecond(0),   // 12:00
            'reguler' => null,
            default => null
        };
    }

    // Status Checking Methods
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isProcessing()
    {
        return $this->status === 'processing';
    }

    public function isShipped()
    {
        return $this->status === 'shipped';
    }

    public function isDelivered()
    {
        return $this->status === 'delivered';
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    // Status Update Methods
    public function confirmOrder()
    {
        $this->update([
            'status' => 'processing',
            'confirmed_at' => now()
        ]);

        // Buat notifikasi untuk buyer
        Notification::create([
            'user_id' => $this->user_id,
            'title' => 'Pesanan Dikonfirmasi',
            'message' => 'Pesanan #' . $this->order_number . ' telah dikonfirmasi penjual',
            'type' => 'order_confirmed',
            'data' => $this->notificationData()
        ]);
    }

    public function shipOrder($trackingNumber = null)
    {
        $this->update([
            'status' => 'shipped',
            'shipped_at' => now(),
            'tracking_number' => $trackingNumber,
            'shipping_status' => 'picked_up'
        ]);

        // Buat notifikasi untuk buyer
        Notification::create([
            'user_id' => $this->user_id,
            'title' => 'Pesanan Dikirim',
            'message' => 'Pesanan #' . $this->order_number . ' sedang dalam perjalanan',
            'type' => 'order_shipped',
            'data' => $this->notificationData([
                'tracking_number' => $trackingNumber
            ])
        ]);
    }

    public function updateShippingStatus($status)
    {
        $this->update(['shipping_status' => $status]);

        // Notify based on status
        if ($status === 'out_for_delivery') {
            Notification::create([
                'user_id' => $this->user_id,
                'title' => 'Paket Sedang Diantar',
                'message' => 'Pesanan #' . $this->order_number . ' sedang dalam perjalanan ke alamat Anda',
                'type' => 'shipping_update',
                'data' => $this->notificationData()
            ]);
        }
    }

    public function deliverOrder()
    {
        $this->update([
            'status' => 'delivered',
            'delivered_at' => now(),
            'shipping_status' => 'delivered',
            'actual_delivery' => now()
        ]);

        // Buat notifikasi untuk buyer
        Notification::create([
            'user_id' => $this->user_id,
            'title' => 'Pesanan Diterima',
            'message' => 'Pesanan #' . $this->order_number . ' telah tiba di lokasi Anda',
            'type' => 'order_delivered',
            'data' => $this->notificationData()
        ]);
    }

    public function completeOrder()
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now()
        ]);

        // Buat notifikasi untuk buyer
        Notification::create([
            'user_id' => $this->user_id,
            'title' => 'Transaksi Selesai',
            'message' => 'Terima kasih! Transaksi #' . $this->order_number . ' telah selesai',
            'type' => 'order_completed',
            'data' => $this->notificationData()
        ]);
    }

    public function cancelOrder($reason = null)
    {
        $this->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'notes' => $reason
        ]);

        // Buat notifikasi
        Notification::create([
            'user_id' => $this->user_id,
            'title' => 'Pesanan Dibatalkan',
            'message' => 'Pesanan #' . $this->order_number . ' telah dibatalkan',
            'type' => 'order_cancelled',
            'data' => $this->notificationData([
                'cancel_reason' => $reason
            ])
        ]);
    }

    // Generate unique order number
    public static function generateOrderNumber()
    {
        do {
            $number = 'ORD-' . date('Ymd') . '-' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (self::where('order_number', $number)->exists());

        return $number;
    }

    // Get status badge color
    public function getStatusBadgeColor()
    {
        return match($this->status) {
            'pending' => 'warning',
            'processing' => 'info',
            'shipped' => 'primary',
            'delivered' => 'success',
            'completed' => 'success',
            'cancelled' => 'danger',
            default => 'secondary'
        };
    }

    // Get status label
    public function getStatusLabel()
    {
        return match($this->status) {
            'pending' => 'Menunggu Konfirmasi',
            'processing' => 'Sedang Diproses',
            'shipped' => 'Dalam Pengiriman',
            'delivered' => 'Sudah Diterima',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            // Service statuses
            'service_pending' => 'Proposal Menunggu',
            'service_accepted' => 'Diterima Seller',
            'service_in_progress' => 'Sedang Dikerjakan',
            'service_review' => 'Menunggu Review',
            'service_revision' => 'Revisi Diminta',
            'service_completed' => 'Layanan Selesai',
            default => 'Unknown'
        };
    }

    // Service order helpers
    public function isServiceOrder(): bool
    {
        return $this->is_service_order ?? false;
    }

    public function getServiceStatusLabel(): string
    {
        return match($this->service_status) {
            'pending' => 'Menunggu Konfirmasi',
            'accepted' => 'Diterima',
            'in_progress' => 'Sedang Dikerjakan',
            'review' => 'Menunggu Review',
            'revision' => 'Revisi Diminta',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => $this->service_status ?? '-'
        };
    }

    public function getServiceStatusColor(): string
    {
        return match($this->service_status) {
            'pending' => 'warning',
            'accepted', 'in_progress' => 'info',
            'review' => 'primary',
            'revision' => 'warning',
            'completed' => 'success',
            'cancelled' => 'danger',
            default => 'secondary'
        };
    }

    public function hasPendingExtension(): bool
    {
        return $this->serviceExtensions()->where('status', ServiceExtension::STATUS_PENDING)->exists();
    }

    // Get shipping status label
    public function getShippingStatusLabel()
    {
        return match($this->shipping_status) {
            'pending' => 'Menunggu Pickup',
            'picked_up' => 'Sudah Diambil Kurir',
            'in_transit' => 'Dalam Perjalanan',
            'at_delivery_hub' => 'Di Hub Lokal',
            'out_for_delivery' => 'Sedang Diantar',
            'delivered' => 'Sudah Diterima',
            'failed_delivery' => 'Gagal Kirim',
            default => 'Unknown'
        };
    }

    protected function notificationData(array $extra = []): array
    {
        return array_merge([
            'order_id' => $this->id,
            'order_number' => $this->order_number,
        ], array_filter($extra, fn($value) => !is_null($value)));
    }
}
