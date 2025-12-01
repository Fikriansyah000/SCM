<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ShippingController;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Notification;
use App\Models\ServiceBooking;
use App\Models\ServiceProposal;
use App\Models\ServiceSlot;
use App\Services\OrderNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderController extends Controller
{
    // Tampilkan form checkout
    public function checkout()
    {
        $cart = Cart::where('user_id', auth()->id())->with('product')->get();

        if ($cart->isEmpty()) {
            return redirect()->route('buyer.cart')->with('error', 'Keranjang kosong');
        }

        $flashIds = session('flash_sale_ids', []);

        $subtotal = 0;
        $discount = 0;
        $hasServices = false;

        foreach ($cart as $item) {
            $isService = ($item->product->product_type ?? 'food') === 'service';
            
            // For services, use proposed_price if available
            $unitPrice = $isService && isset($item->customizations['proposed_price'])
                ? $item->customizations['proposed_price']
                : $item->product->price;
                
            $line = $unitPrice * $item->quantity;
            $subtotal += $line;

            if (in_array($item->product_id, $flashIds)) {
                $discount += ($unitPrice * 0.10) * $item->quantity;
            }
            
            if ($isService) {
                $hasServices = true;
            }
        }

        // If only services (no physical products), no shipping needed
        $hasPhysical = $cart->contains(fn($c) => ($c->product->product_type ?? 'food') !== 'service');
        $hasFlash = $cart->contains(fn($c) => in_array($c->product_id, $flashIds));
        
        $shipping = ($hasFlash || !$hasPhysical) ? 0 : 10000;

        $total = $subtotal - $discount + $shipping;

        return view('buyer.checkout', compact('cart', 'subtotal', 'discount', 'shipping', 'total', 'hasServices', 'hasPhysical'));
    }

    // Simpan order dengan shipping mode
    public function store(Request $request)
    {
        $cart = Cart::where('user_id', auth()->id())->with('product')->get();

        if ($cart->isEmpty()) {
            return redirect()->route('buyer.cart')->with('error', 'Keranjang kosong');
        }

        // Check if there are physical products vs services only
        $hasPhysical = $cart->contains(fn($c) => ($c->product->product_type ?? 'food') !== 'service');
        $hasServices = $cart->contains(fn($c) => ($c->product->product_type ?? 'food') === 'service');
        $isServiceOnly = $hasServices && !$hasPhysical;

        // ========== SERVICE-ONLY ORDER: Create proposal first, no order yet ==========
        if ($isServiceOnly) {
            return $this->createServiceProposals($request, $cart);
        }

        // ========== PHYSICAL PRODUCT ORDER (or mixed): Normal checkout flow ==========
        return $this->createPhysicalOrder($request, $cart, $hasPhysical, $hasServices);
    }

    /**
     * Create service proposals without creating order yet.
     * Order will be created after seller accepts and buyer pays.
     */
    protected function createServiceProposals(Request $request, $cart)
    {
        $validated = $request->validate([
            'shipping_address' => 'required|string|min:10',
        ]);

        DB::beginTransaction();

        try {
            $notificationService = new OrderNotificationService();
            $proposalIds = [];

            foreach ($cart as $item) {
                $product = $item->product;
                
                // Create ServiceProposal (without order_id for now)
                $proposal = ServiceProposal::create([
                    'product_id' => $product->id,
                    'order_id' => null, // Will be set after payment
                    'order_item_id' => null,
                    'buyer_id' => auth()->id(),
                    'seller_id' => $product->shop->user_id,
                    'description' => $item->customizations['proposal_description'] ?? '',
                    'proposed_deadline' => Carbon::parse($item->customizations['proposed_deadline']),
                    'proposed_price' => $item->customizations['proposed_price'],
                    'notes' => $item->customizations['notes'] ?? null,
                    'status' => ServiceProposal::STATUS_PENDING,
                    // Store address for later order creation
                    'metadata' => [
                        'shipping_address' => $validated['shipping_address'],
                    ],
                ]);

                $proposalIds[] = $proposal->id;

                // Send notification to seller
                $notificationService->proposalCreated($proposal);
            }

            // Clear cart
            Cart::where('user_id', auth()->id())->delete();

            DB::commit();

            // Redirect to proposals page
            return redirect()->route('buyer.proposals')
                ->with('success', 'Proposal layanan berhasil diajukan! Tunggu konfirmasi dari seller. Setelah disetujui, Anda dapat melakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Create order for physical products (or mixed physical+service)
     */
    protected function createPhysicalOrder(Request $request, $cart, $hasPhysical, $hasServices)
    {
        // Validation for physical orders
        $rules = [
            'shipping_address' => 'required|string|min:10',
            'shipping_method' => 'required|in:pickup,delivery',
            'shipping_mode' => 'required|in:reguler,same_day,instant',
            'shipping_cost' => 'required|numeric|min:0',
        ];

        $validated = $request->validate($rules);

        // Cek apakah semua produk ada dari seller yang sama
        $shops = $cart->pluck('product.shop_id')->unique();
        
        if ($shops->count() > 1) {
            return back()->with('error', 'Semua produk harus dari toko yang sama');
        }

        // Hitung total weight (only physical products)
        $totalWeight = $cart->filter(fn($c) => ($c->product->product_type ?? 'food') !== 'service')
            ->sum('quantity');

        // Validasi weight limit
        $maxWeights = ['reguler' => 50, 'same_day' => 5, 'instant' => 3];
        if ($totalWeight > $maxWeights[$validated['shipping_mode']]) {
            return back()->withErrors([
                'shipping_mode' => "Berat paket ({$totalWeight}kg) melebihi batas"
            ]);
        }

        // Validasi cutoff time
        if ($validated['shipping_mode'] === 'same_day' && Carbon::now() >= Carbon::today()->setHour(14)) {
            return back()->withErrors(['shipping_mode' => 'Sudah melewati cutoff time untuk Same Day']);
        }
        if ($validated['shipping_mode'] === 'instant' && Carbon::now() >= Carbon::today()->setHour(12)) {
            return back()->withErrors(['shipping_mode' => 'Sudah melewati cutoff time untuk Instant']);
        }

        // Calculate totals
        $flashIds = session('flash_sale_ids', []);
        $subtotal = 0;
        $discount = 0;

        foreach ($cart as $item) {
            $unitPrice = $item->product->price;
            $line = $unitPrice * $item->quantity;
            $subtotal += $line;
            
            if (in_array($item->product_id, $flashIds)) {
                $discount += ($unitPrice * 0.10) * $item->quantity;
            }
        }

        $hasFlash = $cart->contains(fn($c) => in_array($c->product_id, $flashIds));
        
        // Shipping cost
        $shippingCost = $validated['shipping_cost'] ?? 0;
        if ($validated['shipping_method'] === 'pickup') {
            $shippingCost = 0;
        } elseif ($hasFlash && $validated['shipping_mode'] === 'reguler') {
            $shippingCost = 0;
        }

        $total = $subtotal - $discount + $shippingCost;

        // Estimated delivery
        $shippingController = new ShippingController();
        $estimatedDelivery = $shippingController->getEstimatedDelivery($validated['shipping_mode']);

        DB::beginTransaction();

        try {
            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'shop_id' => $cart->first()->product->shop_id,
                'order_number' => Order::generateOrderNumber(),
                'status' => 'pending',
                'total_amount' => $total,
                'shipping_address' => $validated['shipping_address'],
                'shipping_method' => $validated['shipping_method'],
                'shipping_mode' => $validated['shipping_mode'],
                'shipping_cost' => $shippingCost,
                'total_weight' => $totalWeight,
                'estimated_delivery' => $estimatedDelivery,
                'shipping_status' => 'pending',
                'cutoff_exceeded' => false,
                'is_service_order' => false,
                'service_status' => null,
            ]);

            // Create order items
            foreach ($cart as $item) {
                $price = $item->product->price;
                
                if (in_array($item->product_id, $flashIds)) {
                    $price = round($price * 0.90);
                }

                $order->items()->create([
                    'product_id' => $item->product_id,
                    'product_variation_id' => $item->product_variation_id,
                    'quantity' => $item->quantity,
                    'price' => $price,
                ]);

                // Decrement stock
                $item->product->decrement('stock', $item->quantity);
            }

            // Clear cart
            Cart::where('user_id', auth()->id())->delete();

            // Notify seller
            Notification::create([
                'user_id' => $order->shop->user_id,
                'title' => 'Pesanan Baru! 📦',
                'message' => 'Pesanan #' . $order->order_number . ' dari ' . auth()->user()->name . ' via ' . $order->getShippingModeLabel(),
                'type' => 'new_order',
                'data' => ['order_id' => $order->id]
            ]);

            DB::commit();

            return redirect()->route('buyer.orders.show', $order)
                ->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Allow confirmation if status is 'shipped' or already 'delivered' (idempotent)
        if (!in_array($order->status, ['shipped', 'delivered'])) {
            return back()->with('error', 'Pesanan tidak dapat dikonfirmasi pada status ini');
        }

        // Only update if not already delivered
        if ($order->status !== 'delivered') {
            $order->update([
                'status' => 'delivered',
                'delivered_at' => now(),
                'shipping_status' => 'delivered',
                'actual_delivery' => now()
            ]);
            
            // Notifikasi ke seller
            Notification::create([
                'user_id' => $order->shop->user_id,
                'title' => 'Pesanan Diterima Pembeli',
                'message' => 'Pesanan #' . $order->order_number . ' telah diterima pembeli',
                'type' => 'order_delivered',
                'data' => ['order_id' => $order->id]
            ]);

            return back()->with('success', 'Barang dikonfirmasi diterima.');
        }

        return back()->with('info', 'Pesanan sudah dikonfirmasi diterima sebelumnya.');
    }

    // Buyer menyelesaikan pesanan (DELIVERED → COMPLETED)
    public function complete(Order $order)
    {
        if ($order->user_id !== auth()->id() || $order->status !== 'delivered') {
            abort(403);
        }
        $order->update([
            'status' => 'completed',
            'completed_at' => now()
        ]);

        // Mark all related service bookings as completed
        foreach ($order->items as $item) {
            if ($item->serviceBooking) {
                $item->serviceBooking->update([
                    'status' => ServiceBooking::STATUS_COMPLETED
                ]);
            }
        }

        // Notifikasi ke seller
        Notification::create([
            'user_id' => $order->shop->user_id,
            'title' => 'Pesanan Selesai',
            'message' => 'Pesanan #' . $order->order_number . ' telah selesai',
            'type' => 'order_completed',
            'data' => ['order_id' => $order->id]
        ]);

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

        // Kembalikan stok / kapasitas slot
        foreach ($order->items as $item) {
            $isService = ($item->product->product_type ?? 'food') === 'service';
            
            if ($isService && $item->serviceBooking) {
                // Cancel the service booking
                $item->serviceBooking->update([
                    'status' => ServiceBooking::STATUS_CANCELLED
                ]);
                
                // Release slot capacity
                if ($item->serviceBooking->slot) {
                    $partySize = $item->serviceBooking->party_size ?? 1;
                    $item->serviceBooking->slot->decrement('booked_count', $partySize);
                }
            } else {
                // Physical product - restore stock
                $item->product->increment('stock', $item->quantity);
            }
        }

        Notification::create([
            'user_id' => $order->shop->user_id,
            'title' => 'Pesanan Dibatalkan',
            'message' => 'Pembeli membatalkan Pesanan #' . $order->order_number,
            'type' => 'order_cancelled',
            'data' => ['order_id' => $order->id]
        ]);

        return back()->with('success', 'Pesanan berhasil dibatalkan');
    }
}
