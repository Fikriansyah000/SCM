<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::with('product.shop')
            ->where('user_id', auth()->id())
            ->get();

        $total = $carts->sum(function($cart) {
            return $cart->product->price * $cart->quantity;
        });

        return view('buyer.cart', compact('carts', 'total'));
    }

    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        if ($product->stock < 1) {
            return back()->with('error', 'Product out of stock!');
        }

        $quantity = $request->quantity ?? 1;

        if ($quantity > $product->stock) {
            return back()->with('error', 'Insufficient stock!');
        }

        $cart = Cart::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->first();

        if ($cart) {
            if (($cart->quantity + $quantity) > $product->stock) {
                return back()->with('error', 'Insufficient stock for this quantity!');
            }
            $cart->increment('quantity', $quantity);
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }

        return back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request, $id)
    {
        $cart = Cart::where('user_id', auth()->id())->findOrFail($id);

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($request->quantity > $cart->product->stock) {
            return back()->with('error', 'Insufficient stock!');
        }

        $cart->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Cart updated!');
    }

    public function remove($id)
    {
        Cart::where('user_id', auth()->id())->findOrFail($id)->delete();

        return back()->with('success', 'Product removed from cart!');
    }
}
