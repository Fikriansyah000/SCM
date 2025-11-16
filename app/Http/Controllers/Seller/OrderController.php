<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Shop;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Lihat semua pesanan untuk seller
    public function index(Request $request)
    {
        $shop = Shop::where('user_id', auth()->id())->first();

        if (!$shop) {
            return redirect()->route('seller.shop.create')
                ->with('error', 'Buat toko terlebih dahulu');
        }

        $query = Order::where('shop_id', $shop->id);

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(10);

        // Stats
        $stats = [
            'pending' => Order::where('shop_id', $shop->id)->where('status', 'pending')->count(),
            'processing' => Order::where('shop_id', $shop->id)->where('status', 'processing')->count(),
            'shipped' => Order::where('shop_id', $shop->id)->where('status', 'shipped')->count(),
            'completed' => Order::where('shop_id', $shop->id)->where('status', 'completed')->count(),
        ];

        return view('seller.orders.index', compact('orders', 'stats'));
    }

    // Lihat detail pesanan
    public function show(Order $order)
    {
        $shop = Shop::where('user_id', auth()->id())->first();

        if (!$shop || $order->shop_id !== $shop->id) {
            abort(403, 'Unauthorized');
        }

        $order->load('items.product', 'user');

        return view('seller.orders.show', compact('order'));
    }

    // Konfirmasi pesanan
    public function confirm(Order $order)
    {
        $shop = Shop::where('user_id', auth()->id())->first();

        if (!$shop || $order->shop_id !== $shop->id) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            return back()->with('error', 'Status pesanan tidak valid');
        }

        $order->confirmOrder();

        return back()->with('success', 'Pesanan dikonfirmasi! Silakan siapkan barang untuk pengiriman.');
    }

    // Kirim pesanan
    public function ship(Request $request, Order $order)
    {
        $shop = Shop::where('user_id', auth()->id())->first();

        if (!$shop || $order->shop_id !== $shop->id) {
            abort(403);
        }

        if ($order->status !== 'processing') {
            return back()->with('error', 'Status pesanan tidak valid untuk operasi ini');
        }

        $validated = $request->validate([
            'tracking_number' => 'nullable|string|max:50'
        ]);

        $order->shipOrder($validated['tracking_number'] ?? null);

        return back()->with('success', 'Pesanan dikirim! Pembeli akan menerima notifikasi.');
    }
}
