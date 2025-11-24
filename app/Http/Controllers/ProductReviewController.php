<?php

namespace App\Http\Controllers;

use App\Models\ProductReview;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'order_id' => 'nullable|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'review' => 'nullable|string|max:2000'
        ]);

        $user = $request->user();

        // Prevent duplicate review for the same product+order by same user
        $exists = ProductReview::where('product_id', $validated['product_id'])
            ->where('user_id', $user->id)
            ->where('order_id', $validated['order_id'] ?? null)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk produk ini pada pesanan ini.');
        }

        $review = ProductReview::create([
            'product_id' => $validated['product_id'],
            'user_id' => $user->id,
            'order_id' => $validated['order_id'] ?? null,
            'rating' => $validated['rating'],
            'title' => $validated['title'] ?? null,
            'review' => $validated['review'] ?? null
        ]);

        // (Optional) If you want to calculate product average rating, implement here

        return back()->with('success', 'Terima kasih atas ulasan Anda.');
    }
}
