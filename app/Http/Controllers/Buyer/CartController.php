<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ServiceSlot;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::with(['product.shop', 'variation'])
            ->where('user_id', auth()->id())
            ->get();

        $flashIds = session('flash_sale_ids', []);

        $subtotal = 0;
        $discount = 0;

        foreach ($carts as $cart) {
            // For services, use proposed_price if available
            $isService = ($cart->product->product_type ?? 'food') === 'service';
            $unitPrice = $isService && isset($cart->customizations['proposed_price'])
                ? $cart->customizations['proposed_price']
                : $cart->product->price;
            
            $line = $unitPrice * $cart->quantity;
            $subtotal += $line;

            if (in_array($cart->product_id, $flashIds)) {
                $discount += ($unitPrice * 0.10) * $cart->quantity;
            }
        }

        // Shipping: free if any flash sale item exists or all items are services
        $hasFlash = $carts->contains(fn($c) => in_array($c->product_id, $flashIds));
        $allServices = $carts->every(fn($c) => ($c->product->product_type ?? 'food') === 'service');
        $shipping = ($hasFlash || $allServices) ? 0 : 10000;

        $total = $subtotal - $discount + $shipping;

        return view('buyer.cart', compact('carts', 'subtotal', 'discount', 'shipping', 'total'));
    }

    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $isService = ($product->product_type ?? 'food') === 'service';

        // ========== SERVICE PRODUCT (PROPOSAL-BASED) ==========
        if ($isService) {
            $request->validate([
                'proposal_description' => 'required|string|min:20|max:5000',
                'proposed_deadline' => 'required|date|after:today',
                'proposed_price' => 'required|numeric|min:10000',
                'notes' => 'nullable|string|max:1000',
            ], [
                'proposal_description.required' => 'Deskripsi pekerjaan wajib diisi.',
                'proposal_description.min' => 'Deskripsi minimal 20 karakter agar seller dapat memahami kebutuhan Anda.',
                'proposed_deadline.required' => 'Target deadline wajib diisi.',
                'proposed_deadline.after' => 'Deadline harus minimal H+1 dari hari ini.',
                'proposed_price.required' => 'Harga yang Anda tawarkan wajib diisi.',
                'proposed_price.min' => 'Harga minimal Rp10.000.',
            ]);

            // Check if same product already in cart (only one proposal per product)
            $existingCart = Cart::where('user_id', auth()->id())
                ->where('product_id', $productId)
                ->first();

            if ($existingCart) {
                return back()->with('error', 'Anda sudah memiliki proposal untuk layanan ini di keranjang. Hapus terlebih dahulu jika ingin mengajukan proposal baru.');
            }

            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $productId,
                'product_variation_id' => null,
                'quantity' => 1,
                'customizations' => [
                    'proposal_description' => $request->proposal_description,
                    'proposed_deadline' => $request->proposed_deadline,
                    'proposed_price' => (float) $request->proposed_price,
                    'notes' => $request->notes,
                ],
            ]);

            return back()->with('success', 'Proposal layanan berhasil ditambahkan ke keranjang!');
        }

        // ========== PHYSICAL PRODUCT (FOOD) ==========
        if ($product->stock < 1) {
            return back()->with('error', 'Produk habis!');
        }

        $quantity = max(1, (int) ($request->quantity ?? 1));

        if ($quantity > $product->stock) {
            return back()->with('error', 'Stok tidak mencukupi!');
        }

        $cart = Cart::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->whereNull('customizations->proposal_description')
            ->first();

        if ($cart) {
            if (($cart->quantity + $quantity) > $product->stock) {
                return back()->with('error', 'Stok tidak mencukupi untuk jumlah ini!');
            }
            $cart->increment('quantity', $quantity);
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, $id)
    {
        $cart = Cart::with('product')->where('user_id', auth()->id())->findOrFail($id);
        $product = $cart->product;

        $isService = ($product->product_type ?? 'food') === 'service';

        if ($isService) {
            // Service proposals cannot be quantity-updated, only edited via proposal
            return back()->with('info', 'Untuk mengubah proposal layanan, hapus dan ajukan ulang.');
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Physical product
        if ($request->quantity > $product->stock) {
            return back()->with('error', 'Stok tidak mencukupi!');
        }

        $cart->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Keranjang diperbarui!');
    }

    public function remove($id)
    {
        Cart::where('user_id', auth()->id())->findOrFail($id)->delete();

        return back()->with('success', 'Item dihapus dari keranjang!');
    }
}
