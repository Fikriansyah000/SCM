<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BuyerController extends Controller
{
    public function home()
    {
        $products = Product::with('shop')
            ->where('status', 'available')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        // Select a few random products for FlashSale
        $flashProducts = Product::with('shop')
            ->where('status', 'available')
            ->inRandomOrder()
            ->limit(4)
            ->get();

        // Store flash product ids in session so checkout/cart can apply discounts
        session(['flash_sale_ids' => $flashProducts->pluck('id')->toArray()]);

        // Set flash sale end time (1 hour) if not set or expired
        $flashEnds = session('flash_sale_ends_at');
        if (!$flashEnds || Carbon::parse($flashEnds)->isPast()) {
            $flashEnds = Carbon::now()->addHour()->toIso8601String();
            session(['flash_sale_ends_at' => $flashEnds]);
        }

        return view('buyer.home', compact('products', 'flashProducts', 'flashEnds'));
    }

    public function search(Request $request)
    {
        $search = $request->get('q');

        $products = Product::with('shop')
            ->where('status', 'available')
            ->where(function($query) use ($search) {
                $query->where('name', 'like', "%$search%")
                      ->orWhere('description', 'like', "%$search%")
                      ->orWhere('category', 'like', "%$search%");
            })
            ->paginate(12);

        return view('buyer.home', compact('products', 'search'));
    }

    public function visitShop($id)
    {
        $shop = Shop::with(['products' => function($query) {
            $query->where('status', 'available');
        }])->findOrFail($id);

        return view('buyer.visit-shop', compact('shop'));
    }
}
