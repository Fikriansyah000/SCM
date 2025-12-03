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
            'serviceSlots' => function ($query) {
                $query
                    ->where('is_active', true)
                    ->whereColumn('booked_count', '<', 'capacity')
                    ->where(function ($slotQuery) {
                        $slotQuery
                            ->whereNull('slot_date')
                            ->orWhere('slot_date', '>=', now()->toDateString());
                    })
                    ->orderByRaw('COALESCE(slot_date, 0), day_of_week, start_time');
            },
        ]);

        $completedReviewsQuery = $product->reviews()
            ->with('user')
            ->whereHas('order', function ($orderQuery) {
                $orderQuery->where('status', 'completed');
            });

        $reviewCount = (clone $completedReviewsQuery)->count();
        $averageRating = (clone $completedReviewsQuery)->avg('rating');

        $completedReviews = (clone $completedReviewsQuery)
            ->latest()
            ->take(10)
            ->get();

        // Derived pricing with default variation if present
        $basePrice = $product->price;
        $defaultVariation = $product->variations->firstWhere('is_default', true);
        $displayPrice = $defaultVariation ? ($basePrice + (float)$defaultVariation->price_adjustment) : $basePrice;

        $viewData = [
            'product' => $product,
            'displayPrice' => $displayPrice,
            'defaultVariation' => $defaultVariation,
            'completedReviews' => $completedReviews,
            'reviewStats' => [
                'count' => $reviewCount,
                'average' => $reviewCount ? round($averageRating, 1) : null,
            ],
        ];

        // Route to different views based on product type
        $isService = ($product->product_type ?? 'food') === 'service';
        
        if ($isService) {
            return view('buyer.products.show-service', $viewData);
        }

        return view('buyer.products.show-product', $viewData);
    }
}
