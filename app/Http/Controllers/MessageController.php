<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    // List all conversations
    public function index()
    {
        $conversations = Message::where('sender_id', auth()->id())
            ->orWhere('receiver_id', auth()->id())
            ->with(['sender', 'receiver', 'shop'])
            ->latest()
            ->get()
            ->unique(function ($item) {
                return $item->sender_id == auth()->id() 
                    ? ($item->shop_id ? 'shop_' . $item->shop_id : 'user_' . $item->receiver_id)
                    : ($item->shop_id ? 'shop_' . $item->shop_id : 'user_' . $item->sender_id);
            });

        return view('messages.index', compact('conversations'));
    }

    // Show chat with a user (generic or shop-specific)
    public function show($userId)
    {
        $otherUser = User::findOrFail($userId);
        $userId = (int) $userId;
        $shopId = request('shop_id');
        $shop = null;

        // If a shop_id is provided, load and verify ownership (either participant can be owner).
        if ($shopId) {
            $shop = Shop::findOrFail($shopId);
            if ($shop->user_id !== $otherUser->id && $shop->user_id !== auth()->id()) {
                Log::warning('Shop mismatch in MessageController@show', [
                    'auth_id' => auth()->id(),
                    'other_user_id' => $otherUser->id,
                    'shop_id' => $shop->id,
                    'shop_owner_id' => $shop->user_id,
                    'url' => request()->fullUrl(),
                ]);
                abort(403, 'Shop mismatch');
            }
        } else {
            // No shop specified: attempt to find the most recent shop-scoped conversation
            // between the two users and use that shop automatically (helps links without query param).
            $recentShopId = Message::where(function($q) use ($userId) {
                    $q->where('sender_id', auth()->id())->where('receiver_id', $userId);
                })->orWhere(function($q) use ($userId) {
                    $q->where('sender_id', $userId)->where('receiver_id', auth()->id());
                })->whereNotNull('shop_id')
                ->orderBy('created_at', 'desc')
                ->value('shop_id');

            if ($recentShopId) {
                $shop = Shop::find($recentShopId);
                // Ensure shop ownership still valid
                if (!($shop && ($shop->user_id === $otherUser->id || $shop->user_id === auth()->id()))) {
                    Log::info('Recent shop found but ownership invalid; ignoring', [
                        'auth_id' => auth()->id(),
                        'other_user_id' => $otherUser->id,
                        'recent_shop_id' => $recentShopId,
                    ]);
                    $shop = null;
                } else {
                    $shopId = $recentShopId;
                    Log::info('Using recent shop as fallback for conversation', [
                        'auth_id' => auth()->id(),
                        'other_user_id' => $otherUser->id,
                        'shop_id' => $shopId,
                    ]);
                }
            }
        }

        // Get messages between user and $userId, optionally filtered by shop
        $query = Message::where(function($q) use ($userId) {
            $q->where('sender_id', auth()->id())
              ->where('receiver_id', $userId);
        })->orWhere(function($q) use ($userId) {
            $q->where('sender_id', $userId)
              ->where('receiver_id', auth()->id());
        });

        if ($shopId) {
            $query->where('shop_id', $shopId);
        }

        $messages = $query->orderBy('created_at', 'asc')->get();

        // Mark as read
        Message::where('sender_id', $userId)
            ->where('receiver_id', auth()->id())
            ->where('is_read', false)
            ->when($shopId, fn($q) => $q->where('shop_id', $shopId))
            ->update(['is_read' => true]);

        return view('messages.show', compact('messages', 'otherUser', 'shop'));
    }

    // Send a message
    public function send(Request $request, $userId)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $otherUser = User::findOrFail($userId);
        $userId = (int) $userId;
        $shopId = $request->shop_id;

        if ($shopId) {
            $shop = Shop::findOrFail($shopId);
            // Allow sending in a shop-scoped conversation when either
            // the receiver or the authenticated user is the shop owner.
            if ($shop->user_id !== $userId && $shop->user_id !== auth()->id()) {
                Log::warning('Shop mismatch in MessageController@send', [
                    'auth_id' => auth()->id(),
                    'receiver_id' => $userId,
                    'shop_id' => $shop->id,
                    'shop_owner_id' => $shop->user_id,
                    'url' => request()->fullUrl(),
                ]);
                abort(403, 'Shop mismatch');
            }
        }

        $msg = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $userId,
            'shop_id' => $shopId,
            'message' => $request->message,
        ]);

        Log::info('Message sent', [
            'id' => $msg->id ?? null,
            'sender_id' => auth()->id(),
            'receiver_id' => $userId,
            'shop_id' => $shopId,
            'message_preview' => substr($request->message, 0, 120),
        ]);

        return back();
    }
}
