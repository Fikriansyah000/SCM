<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function dashboard()
    {
        $shop = auth()->user()->shop;

        if (!$shop) {
            return redirect()->route('seller.shop.create');
        }

        $totalProducts = $shop->products()->count();
        $totalOrders = $shop->orders()->count();
        $totalRevenue = $shop->orders()->where('status', 'completed')->sum('total_amount');
        $pendingOrders = $shop->orders()->where('status', 'pending')->count();
        // Count orders which have return requests (only those requested by buyer)
        $returnRequests = $shop->orders()->where('return_status', 'requested')->count();

        // Get revenue data for the last 12 months
        $revenueData = [];
        $labels = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $month = $date->format('M Y');
            $revenue = $shop->orders()
                ->where('status', 'completed')
                ->whereYear('updated_at', $date->year)
                ->whereMonth('updated_at', $date->month)
                ->sum('total_amount');
            
            $labels[] = $month;
            $revenueData[] = (int)$revenue;
        }

        return view('seller.dashboard', compact('shop', 'totalProducts', 'totalOrders', 'totalRevenue', 'pendingOrders', 'returnRequests', 'labels', 'revenueData'));
    }

    public function showCreateShop()
    {
        if (auth()->user()->shop) {
            return redirect()->route('seller.dashboard');
        }

        return view('seller.create-shop');
    }

    public function createShop(Request $request)
    {
        $validated = $request->validate([
            'shop_name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $logoPath = null;
        $bannerPath = null;

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('shops/logos', 'public');
        }

        if ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->store('shops/banners', 'public');
        }

        Shop::create([
            'user_id' => auth()->id(),
            'shop_name' => $validated['shop_name'],
            'description' => $validated['description'],
            'address' => $validated['address'],
            'phone' => $validated['phone'],
            'logo' => $logoPath,
            'banner' => $bannerPath,
            'status' => 'active',
        ]);

        return redirect()->route('seller.dashboard')->with('success', 'Shop created successfully!');
    }

    public function showShop()
    {
        $shop = auth()->user()->shop;

        if (!$shop) {
            return redirect()->route('seller.shop.create');
        }

        $products = $shop->products()->latest()->paginate(12);

        return view('seller.my-shop', compact('shop', 'products'));
    }

    public function editShop()
    {
        $shop = auth()->user()->shop;

        if (!$shop) {
            return redirect()->route('seller.shop.create');
        }

        return view('seller.edit-shop', compact('shop'));
    }

    public function updateShop(Request $request)
    {
        $shop = auth()->user()->shop;

        if (!$shop) {
            return redirect()->route('seller.shop.create');
        }

        $validated = $request->validate([
            'shop_name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('shops/logos', 'public');
        }

        if ($request->hasFile('banner')) {
            $validated['banner'] = $request->file('banner')->store('shops/banners', 'public');
        }

        $shop->update($validated);

        return redirect()->route('seller.shop')->with('success', 'Shop updated successfully!');
    }
}
