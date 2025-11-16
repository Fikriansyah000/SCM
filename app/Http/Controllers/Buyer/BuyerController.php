<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;

class BuyerController extends Controller
{
    public function home()
    {
        $products = Product::with('shop')
            ->where('status', 'available')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('buyer.home', compact('products'));
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
