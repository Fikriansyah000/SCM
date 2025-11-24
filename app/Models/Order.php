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
        'created_at',
        'updated_at'
    ];

    protected $fillable = [
        'user_id', 'shop_id', 'order_number', 'status',
        'total_amount', 'shipping_address', 'shipping_method',
        'tracking_number', 'notes', 'confirmed_at', 'shipped_at',
        'delivered_at', 'completed_at', 'cancelled_at',
        'return_status', 'return_reason', 'return_requested_at', 'return_tracking_number', 'return_shipped_at', 'return_received_at'
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
            'type' => 'order_confirmed'
        ]);
    }

    public function shipOrder($trackingNumber = null)
    {
        $this->update([
            'status' => 'shipped',
            'shipped_at' => now(),
            'tracking_number' => $trackingNumber
        ]);

        // Buat notifikasi untuk buyer
        Notification::create([
            'user_id' => $this->user_id,
            'title' => 'Pesanan Dikirim',
            'message' => 'Pesanan #' . $this->order_number . ' sedang dalam perjalanan',
            'type' => 'order_shipped',
            'data' => ['tracking_number' => $trackingNumber]
        ]);
    }

    public function deliverOrder()
    {
        $this->update([
            'status' => 'delivered',
            'delivered_at' => now()
        ]);

        // Buat notifikasi untuk buyer
        Notification::create([
            'user_id' => $this->user_id,
            'title' => 'Pesanan Diterima',
            'message' => 'Pesanan #' . $this->order_number . ' telah tiba di lokasi Anda',
            'type' => 'order_delivered'
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
            'type' => 'order_completed'
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
            'type' => 'order_cancelled'
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
            default => 'Unknown'
        };
    }
    
}
