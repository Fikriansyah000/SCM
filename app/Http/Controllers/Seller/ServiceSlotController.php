<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ServiceSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceSlotController extends Controller
{
    /**
     * Display a listing of the service slots for a product.
     */
    public function index(Product $product)
    {
        // Verify ownership
        if ($product->shop->user_id !== Auth::id()) {
            abort(403);
        }

        $slots = $product->serviceSlots()->orderBy('slot_date', 'asc')->orderBy('start_time', 'asc')->get();
        
        return response()->json($slots);
    }

    /**
     * Store a newly created service slot.
     */
    public function store(Request $request, Product $product)
    {
        // Verify ownership
        if ($product->shop->user_id !== Auth::id()) {
            abort(403);
        }

        // Validate
        $validated = $request->validate([
            'slot_date' => 'nullable|date|after_or_equal:today',
            'day_of_week' => 'nullable|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'capacity' => 'required|integer|min:1',
            'is_recurring' => 'nullable|boolean',
        ]);

        // At least one of slot_date or day_of_week must be provided
        if (empty($validated['slot_date']) && empty($validated['day_of_week'])) {
            return redirect()->back()->withErrors(['slot_date' => 'Harap pilih tanggal atau hari untuk jadwal.']);
        }

        $slot = new ServiceSlot();
        $slot->product_id = $product->id;
        $slot->slot_date = $validated['slot_date'] ?? null;
        $slot->day_of_week = $validated['day_of_week'] ?? null;
        $slot->start_time = $validated['start_time'];
        $slot->end_time = $validated['end_time'];
        $slot->capacity = $validated['capacity'];
        $slot->booked_count = 0;
        $slot->is_active = true;
        $slot->is_recurring = $request->has('is_recurring') && !empty($validated['day_of_week']);
        $slot->save();

        return redirect()->route('seller.products.edit', $product->id)
            ->with('success', 'Jadwal berhasil ditambahkan.');
    }

    /**
     * Update the specified service slot.
     */
    public function update(Request $request, Product $product, ServiceSlot $slot)
    {
        // Verify ownership
        if ($product->shop->user_id !== Auth::id() || $slot->product_id !== $product->id) {
            abort(403);
        }

        $validated = $request->validate([
            'slot_date' => 'nullable|date',
            'day_of_week' => 'nullable|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'capacity' => 'required|integer|min:1',
            'is_active' => 'nullable|boolean',
            'is_recurring' => 'nullable|boolean',
        ]);

        // Ensure capacity is not less than booked_count
        if ($validated['capacity'] < $slot->booked_count) {
            return redirect()->back()->withErrors(['capacity' => 'Kapasitas tidak boleh kurang dari jumlah yang sudah dipesan (' . $slot->booked_count . ').']);
        }

        $slot->slot_date = $validated['slot_date'] ?? null;
        $slot->day_of_week = $validated['day_of_week'] ?? null;
        $slot->start_time = $validated['start_time'];
        $slot->end_time = $validated['end_time'];
        $slot->capacity = $validated['capacity'];
        $slot->is_active = $request->has('is_active');
        $slot->is_recurring = $request->has('is_recurring') && !empty($validated['day_of_week']);
        $slot->save();

        return redirect()->route('seller.products.edit', $product->id)
            ->with('success', 'Jadwal berhasil diperbarui.');
    }

    /**
     * Toggle the active status of a service slot.
     */
    public function toggle(Request $request, Product $product, ServiceSlot $slot)
    {
        // Verify ownership
        if ($product->shop->user_id !== Auth::id() || $slot->product_id !== $product->id) {
            abort(403);
        }

        $slot->is_active = !$slot->is_active;
        $slot->save();

        return redirect()->route('seller.products.edit', $product->id)
            ->with('success', 'Status jadwal berhasil diubah.');
    }

    /**
     * Remove the specified service slot.
     */
    public function destroy(Product $product, ServiceSlot $slot)
    {
        // Verify ownership
        if ($product->shop->user_id !== Auth::id() || $slot->product_id !== $product->id) {
            abort(403);
        }

        // Only allow deletion if no bookings
        if ($slot->booked_count > 0) {
            return redirect()->back()->withErrors(['slot' => 'Tidak dapat menghapus jadwal yang sudah memiliki pesanan.']);
        }

        $slot->delete();

        return redirect()->route('seller.products.edit', $product->id)
            ->with('success', 'Jadwal berhasil dihapus.');
    }
}
