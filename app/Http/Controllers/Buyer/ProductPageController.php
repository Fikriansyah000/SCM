<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductPageController extends Controller
{
    public function show(Product $product)
    {
        $product->load([
            'shop',
            'variations',
            'serviceSlots' => function ($q) {
                $q->where('is_active', true)->orderByRaw('COALESCE(slot_date, 0), day_of_week, start_time');
            },
            'reviews' => function ($q) {
                $q->latest()->limit(10);
            },
        ]);

        // Derived pricing with default variation if present
        $basePrice = $product->price;
        $defaultVariation = $product->variations->firstWhere('is_default', true);
        $displayPrice = $defaultVariation ? ($basePrice + (float)$defaultVariation->price_adjustment) : $basePrice;

        return view('buyer.product-show', [
            'product' => $product,
            'displayPrice' => $displayPrice,
            'defaultVariation' => $defaultVariation,
        ]);
    }
}
