<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $conversations = Message::where('sender_id', auth()->id())
            ->orWhere('receiver_id', auth()->id())
            ->with(['sender', 'receiver'])
            ->latest()
            ->get()
            ->unique(function ($item) {
                return $item->sender_id == auth()->id() 
                    ? $item->receiver_id 
                    : $item->sender_id;
            });

        return view('messages.index', compact('conversations'));
    }

    public function show($userId)
    {
        $otherUser = User::findOrFail($userId);

        $messages = Message::where(function($query) use ($userId) {
            $query->where('sender_id', auth()->id())
                  ->where('receiver_id', $userId);
        })->orWhere(function($query) use ($userId) {
            $query->where('sender_id', $userId)
                  ->where('receiver_id', auth()->id());
        })->orderBy('created_at', 'asc')->get();

        // Mark as read
        Message::where('sender_id', $userId)
            ->where('receiver_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('messages.show', compact('messages', 'otherUser'));
    }

    public function send(Request $request, $userId)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $userId,
            'shop_id' => $request->shop_id,
            'message' => $request->message,
        ]);

        return back();
    }
}
