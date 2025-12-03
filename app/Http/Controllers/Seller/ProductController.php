<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ServiceSlot;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $shop = auth()->user()->shop;

        if (!$shop) {
            return redirect()->route('seller.shop.create');
        }

        $filter = request('filter', 'active');

        $productsQuery = $shop->products()->latest();

        if ($filter === 'archived') {
            $productsQuery->where('status', 'unavailable');
        } elseif ($filter === 'all') {
            // keep all statuses
        } else {
            $productsQuery->where('status', 'available');
            $filter = 'active';
        }

        $products = $productsQuery->paginate(12)->appends(['filter' => $filter]);

        return view('seller.products.index', compact('products', 'filter'));
    }

    public function create()
    {
        return view('seller.products.create');
    }

    public function store(Request $request)
    {
        $shop = auth()->user()->shop;

        if (!$shop) {
            return redirect()->route('seller.shop.create');
        }

        $isService = $request->input('product_type') === 'service';

        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'product_type' => 'required|in:food,service',
        ];

        if ($isService) {
            $rules['requires_booking'] = 'nullable|boolean';
            $rules['duration_minutes'] = 'nullable|integer|min:1';
            $rules['location_type'] = 'nullable|string|in:online,onsite,flexible';
            $rules['requirements'] = 'nullable|string|max:1000';
        } else {
            $rules['stock'] = 'required|integer|min:0';
        }

        $validated = $request->validate($rules);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // Build service_profile JSON if service
        $serviceProfile = null;
        if ($isService) {
            $serviceProfile = [
                'duration_minutes' => $validated['duration_minutes'] ?? null,
                'location_type' => $validated['location_type'] ?? 'flexible',
                'requirements' => $validated['requirements'] ?? null,
            ];
        }

        $product = Product::create([
            'shop_id' => $shop->id,
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $isService ? 0 : ($validated['stock'] ?? 0),
            'category' => $validated['category'],
            'image' => $imagePath,
            'status' => 'available',
            'product_type' => $validated['product_type'],
            'requires_booking' => $isService ? ($request->boolean('requires_booking') ?? true) : false,
            'service_profile' => $serviceProfile,
        ]);

        if ($isService) {
            return redirect()->route('seller.products.edit', $product->id)
                ->with('success', 'Layanan berhasil dibuat! Silakan tambahkan jadwal/slot layanan.');
        }

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil dibuat!');
    }

    public function edit($id)
    {
        $shop = auth()->user()->shop;
        $product = Product::where('shop_id', $shop->id)->with('serviceSlots')->findOrFail($id);

        return view('seller.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $shop = auth()->user()->shop;
        $product = Product::where('shop_id', $shop->id)->findOrFail($id);

        $isService = $request->input('product_type', $product->product_type) === 'service';

        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'product_type' => 'required|in:food,service',
        ];

        if ($isService) {
            $rules['requires_booking'] = 'nullable|boolean';
            $rules['duration_minutes'] = 'nullable|integer|min:1';
            $rules['location_type'] = 'nullable|string|in:online,onsite,flexible';
            $rules['requirements'] = 'nullable|string|max:1000';
        } else {
            $rules['stock'] = 'required|integer|min:0';
        }

        $validated = $request->validate($rules);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // Build service_profile JSON if service
        $serviceProfile = null;
        if ($isService) {
            $serviceProfile = [
                'duration_minutes' => $validated['duration_minutes'] ?? null,
                'location_type' => $validated['location_type'] ?? 'flexible',
                'requirements' => $validated['requirements'] ?? null,
            ];
        }

        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $isService ? 0 : ($validated['stock'] ?? $product->stock),
            'category' => $validated['category'],
            'image' => $validated['image'] ?? $product->image,
            'product_type' => $validated['product_type'],
            'requires_booking' => $isService ? $request->boolean('requires_booking') : false,
            'service_profile' => $serviceProfile,
        ]);

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $shop = auth()->user()->shop;
        $product = Product::where('shop_id', $shop->id)->findOrFail($id);
        $product->delete();

        return back()->with('success', 'Produk berhasil dihapus!');
    }

    public function toggleArchive($id)
    {
        $shop = auth()->user()->shop;
        $product = Product::where('shop_id', $shop->id)->findOrFail($id);

        $product->status = $product->status === 'available' ? 'unavailable' : 'available';
        $product->save();

        $message = $product->status === 'available'
            ? 'Produk dipulihkan dan kembali tampil untuk pembeli.'
            : 'Produk berhasil diarsipkan.';

        return back()->with('success', $message);
    }

    // ========== SERVICE SLOT MANAGEMENT ==========

    public function storeSlot(Request $request, $productId)
    {
        $shop = auth()->user()->shop;
        $product = Product::where('shop_id', $shop->id)->findOrFail($productId);

        if ($product->product_type !== 'service') {
            return back()->with('error', 'Slot hanya untuk produk layanan.');
        }

        $validated = $request->validate([
            'slot_date' => 'nullable|date|after_or_equal:today',
            'day_of_week' => 'nullable|string|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'capacity' => 'required|integer|min:1',
            'is_recurring' => 'nullable|boolean',
        ]);

        ServiceSlot::create([
            'product_id' => $product->id,
            'slot_date' => $validated['slot_date'] ?? null,
            'day_of_week' => $validated['day_of_week'] ?? null,
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'capacity' => $validated['capacity'],
            'booked_count' => 0,
            'is_recurring' => $request->boolean('is_recurring'),
            'is_active' => true,
        ]);

        return back()->with('success', 'Slot jadwal berhasil ditambahkan!');
    }

    public function updateSlot(Request $request, $productId, $slotId)
    {
        $shop = auth()->user()->shop;
        $product = Product::where('shop_id', $shop->id)->findOrFail($productId);
        $slot = ServiceSlot::where('product_id', $product->id)->findOrFail($slotId);

        $validated = $request->validate([
            'slot_date' => 'nullable|date',
            'day_of_week' => 'nullable|string|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'capacity' => 'required|integer|min:1',
            'is_active' => 'nullable|boolean',
        ]);

        $slot->update([
            'slot_date' => $validated['slot_date'] ?? $slot->slot_date,
            'day_of_week' => $validated['day_of_week'] ?? $slot->day_of_week,
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'capacity' => $validated['capacity'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('success', 'Slot jadwal berhasil diperbarui!');
    }

    public function destroySlot($productId, $slotId)
    {
        $shop = auth()->user()->shop;
        $product = Product::where('shop_id', $shop->id)->findOrFail($productId);
        $slot = ServiceSlot::where('product_id', $product->id)->findOrFail($slotId);

        // Only allow deletion if no bookings or not booked
        if ($slot->booked_count > 0) {
            return back()->with('error', 'Tidak dapat menghapus slot yang sudah memiliki booking.');
        }

        $slot->delete();

        return back()->with('success', 'Slot jadwal berhasil dihapus!');
    }

    public function toggleSlot($productId, $slotId)
    {
        $shop = auth()->user()->shop;
        $product = Product::where('shop_id', $shop->id)->findOrFail($productId);
        $slot = ServiceSlot::where('product_id', $product->id)->findOrFail($slotId);

        $slot->update(['is_active' => !$slot->is_active]);

        $status = $slot->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Slot jadwal berhasil {$status}!");
    }
}
