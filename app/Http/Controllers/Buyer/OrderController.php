<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Notification;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Tampilkan form checkout
    public function checkout()
    {
        $cart = Cart::where('user_id', auth()->id())->with('product')->get();

        if ($cart->isEmpty()) {
            return redirect()->route('buyer.cart')->with('error', 'Keranjang kosong');
        }

        $total = $cart->sum(fn($item) => $item->product->price * $item->quantity);

        return view('buyer.checkout', compact('cart', 'total'));
    }

    // Simpan order
    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipping_address' => 'required|string|min:10',
            'shipping_method' => 'required|in:pickup,delivery'
        ]);

        $cart = Cart::where('user_id', auth()->id())->with('product')->get();

        if ($cart->isEmpty()) {
            return redirect()->route('buyer.cart')->with('error', 'Keranjang kosong');
        }

        // Cek apakah semua produk ada dari seller yang sama
        $shops = $cart->pluck('product.shop_id')->unique();
        
        if ($shops->count() > 1) {
            return back()->with('error', 'Semua produk harus dari toko yang sama');
        }

        // Hitung total
        $subtotal = $cart->sum(fn($item) => $item->product->price * $item->quantity);
        $shipping = $validated['shipping_method'] === 'delivery' ? 10000 : 0;
        $total = $subtotal + $shipping;

        // Buat order
        $order = Order::create([
            'user_id' => auth()->id(),
            'shop_id' => $cart->first()->product->shop_id,
            'order_number' => Order::generateOrderNumber(),
            'status' => 'pending',
            'total_amount' => $total,
            'shipping_address' => $validated['shipping_address'],
            'shipping_method' => $validated['shipping_method'],
        ]);

        // Buat order items
        foreach ($cart as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price
            ]);

            // Kurangi stok produk
            $item->product->decrement('stock', $item->quantity);
        }

        // Hapus cart
        Cart::where('user_id', auth()->id())->delete();

        // Buat notifikasi untuk seller (update bagian ini)
    Notification::create([
        'user_id' => $order->shop->user_id,
        'title' => 'Pesanan Baru! 📦',
        'message' => 'Pesanan #' . $order->order_number . ' dari ' . auth()->user()->name,
        'type' => 'new_order',
        'data' => ['order_id' => $order->id]  // ← TAMBAHKAN INI
    ]);

        return redirect()->route('buyer.orders.show', $order)
            ->with('success', 'Pesanan berhasil dibuat! Silakan tunggu konfirmasi dari penjual.');
    }

    // Lihat semua pesanan
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('buyer.orders.index', compact('orders'));
    }

    // Lihat detail pesanan
    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $order->load('items.product', 'shop');

        return view('buyer.orders.show', compact('order'));
    }

    // Buyer menerima barang (SHIPPED → DELIVERED)
public function confirmDelivery(Order $order)
{
    if ($order->user_id !== auth()->id() || $order->status !== 'shipped') {
        abort(403);
    }
    $order->update([
        'status' => 'delivered',
        'delivered_at' => now(),
    ]);
    // Optional: Notifikasi ke seller
    return back()->with('success', 'Barang dikonfirmasi diterima.');
}

// Buyer menyelesaikan pesanan (DELIVERED → COMPLETED)
public function complete(Order $order)
{
    if ($order->user_id !== auth()->id() || $order->status !== 'delivered') {
        abort(403);
    }
    $order->update([
        'status' => 'completed',
        'completed_at' => now(),
    ]);
    // Optional: Notifikasi ke seller
    return back()->with('success', 'Pesanan telah selesai.');
}

    // Buyer request return (only when delivered or completed)
    public function requestReturn(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id() || !in_array($order->status, ['delivered', 'completed'])) {
            abort(403);
        }

        $validated = $request->validate([
            'reason' => 'required|string|min:5|max:1000'
        ]);

        $order->update([
            'return_status' => 'requested',
            'return_reason' => $validated['reason'],
            'return_requested_at' => now()
        ]);

        // Notify seller
        Notification::create([
            'user_id' => $order->shop->user_id,
            'title' => 'Permintaan Retur Pesanan',
            'message' => 'Pembeli mengajukan retur untuk Pesanan #' . $order->order_number,
            'type' => 'return_requested',
            'data' => ['order_id' => $order->id]
        ]);

        return back()->with('success', 'Permintaan retur berhasil diajukan. Menunggu konfirmasi penjual.');
    }

    // Buyer ships the return after seller approves
    public function shipReturn(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id() || $order->return_status !== 'approved') {
            abort(403);
        }

        $validated = $request->validate([
            'return_tracking_number' => 'nullable|string|max:100'
        ]);

        $order->update([
            'return_tracking_number' => $validated['return_tracking_number'] ?? null,
            'return_shipped_at' => now(),
            'return_status' => 'shipped'
        ]);

        Notification::create([
            'user_id' => $order->shop->user_id,
            'title' => 'Retur Sedang Dikirim',
            'message' => 'Pembeli telah mengirim retur untuk Pesanan #' . $order->order_number,
            'type' => 'return_shipped',
            'data' => ['order_id' => $order->id]
        ]);

        return back()->with('success', 'Retur telah dikirim. Tunggu konfirmasi penjual saat menerima.');
    }

    // Batalkan pesanan
    public function cancel(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if (!in_array($order->status, ['pending', 'processing'])) {
            return back()->with('error', 'Pesanan tidak bisa dibatalkan pada status ini');
        }

        $reason = $request->input('reason', 'Dibatalkan oleh pembeli');

        $order->cancelOrder($reason);

        // Kembalikan stok
        foreach ($order->items as $item) {
            $item->product->increment('stock', $item->quantity);
        }

        return back()->with('success', 'Pesanan dibatalkan');
    }
}
