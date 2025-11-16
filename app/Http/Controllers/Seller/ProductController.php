<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $shop = auth()->user()->shop;

        if (!$shop) {
            return redirect()->route('seller.shop.create');
        }

        $products = $shop->products()->latest()->paginate(12);

        return view('seller.products.index', compact('products'));
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

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'shop_id' => $shop->id,
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'category' => $validated['category'],
            'image' => $imagePath,
            'status' => 'available',
        ]);

        return redirect()->route('seller.products.index')->with('success', 'Product created successfully!');
    }

    public function edit($id)
    {
        $shop = auth()->user()->shop;
        $product = Product::where('shop_id', $shop->id)->findOrFail($id);

        return view('seller.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $shop = auth()->user()->shop;
        $product = Product::where('shop_id', $shop->id)->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('seller.products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $shop = auth()->user()->shop;
        $product = Product::where('shop_id', $shop->id)->findOrFail($id);
        $product->delete();

        return back()->with('success', 'Product deleted successfully!');
    }
}
