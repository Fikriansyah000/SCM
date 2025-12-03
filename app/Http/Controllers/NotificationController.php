<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Order;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // Lihat semua notifikasi
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->latest()
            ->paginate(15);

        $notifications->getCollection()->transform(function ($notification) {
            $notification->action_url = $this->resolveNotificationLink($notification);
            return $notification;
        });

        return view('notifications.index', compact('notifications'));
    }

    // Lihat notifikasi untuk seller (uses seller layout)
    public function indexSeller()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->latest()
            ->paginate(15);

        $notifications->getCollection()->transform(function ($notification) {
            $notification->action_url = $this->resolveNotificationLink($notification);
            return $notification;
        });

        return view('seller.notifications.index', compact('notifications'));
    }

    // Tandai satu notifikasi sebagai sudah dibaca
    public function read(Notification $notification)
    {
        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }

        $notification->update(['is_read' => true]);

        return back()->with('success', 'Notifikasi ditandai sudah dibaca');
    }

    // Tandai semua notifikasi sebagai sudah dibaca
    public function readAll()
    {
        Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return back()->with('success', 'Semua notifikasi ditandai sudah dibaca');
    }

    // Hapus semua notifikasi
    public function deleteAll()
    {
        Notification::where('user_id', auth()->id())->delete();

        return back()->with('success', 'Semua notifikasi dihapus');
    }

    private function resolveNotificationLink(Notification $notification): ?string
    {
        $data = $notification->data ?? [];
        $orderId = $data['order_id'] ?? null;

        if (!$orderId && isset($data['order_number'])) {
            $orderId = Order::where('order_number', $data['order_number'])->value('id');
        }

        if (!$orderId && preg_match('/#([A-Z0-9\-]+)/', $notification->message, $matches)) {
            $orderId = Order::where('order_number', $matches[1])->value('id');
        }

        if (!$orderId) {
            return null;
        }

        if (!isset($data['order_id'])) {
            $data['order_id'] = $orderId;
            $notification->data = $data;
            $notification->save();
        }

        $user = auth()->user();

        if (method_exists($user, 'isSeller') && $user->isSeller()) {
            return route('seller.orders.show', $orderId);
        }

        return route('buyer.orders.show', $orderId);
    }
}
