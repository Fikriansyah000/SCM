<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // Lihat semua notifikasi
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->latest()
            ->paginate(15);

        return view('notifications.index', compact('notifications'));
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
}
