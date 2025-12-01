<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BuyerController extends Controller
{
    public function home(Request $request)
    {
        $tab = $request->get('tab', 'all'); // all, products, services

        $query = Product::with('shop')
            ->where('status', 'available');

        // Filter by product type
        if ($tab === 'products') {
            $query->where('product_type', 'food');
        } elseif ($tab === 'services') {
            $query->where('product_type', 'service');
        }

        $products = $query->orderBy('created_at', 'desc')
            ->paginate(12)
            ->appends(['tab' => $tab]); // Preserve tab on pagination

        // Select a few random products for FlashSale (only physical products)
        $flashProducts = Product::with('shop')
            ->where('status', 'available')
            ->where('product_type', 'food')
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

        return view('buyer.home', compact('products', 'flashProducts', 'flashEnds', 'tab'));
    }

    public function search(Request $request)
    {
        $search = $request->get('q');
        $tab = $request->get('tab', 'all');

        $query = Product::with('shop')
            ->where('status', 'available')
            ->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%")
                  ->orWhere('category', 'like', "%$search%");
            });

        // Filter by product type
        if ($tab === 'products') {
            $query->where('product_type', 'food');
        } elseif ($tab === 'services') {
            $query->where('product_type', 'service');
        }

        $products = $query->paginate(12)->appends(['q' => $search, 'tab' => $tab]);

        return view('buyer.home', compact('products', 'search', 'tab'));
    }

    public function visitShop($id)
    {
        $shop = Shop::with(['products' => function($query) {
            $query->where('status', 'available');
        }])->findOrFail($id);

        return view('buyer.visit-shop', compact('shop'));
    }
}
