<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use App\Models\Products;
use App\Models\viewed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Products::with('images')->paginate(10);
        return view('admin.product', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {

            $validated = $request->validate([
                'title'       => 'required|string|max:255',
                'description' => 'required|string',
                'price'       => 'required|numeric|min:0',
                'brand'       => 'required|string|max:255',
                'model'       => 'required|string|max:255',
                'year'        => 'required|string|max:4',
                'images'      => 'nullable|array',
                'images.*'    => 'nullable|image|mimes:jpg,jpeg,png',
            ]);

            DB::beginTransaction();

            $product = Products::create([
                'title'       => $validated['title'],
                'description' => $validated['description'],
                'price'       => $validated['price'],
                'brand'       => $validated['brand'],
                'model'       => $validated['model'],
                'year'        => $validated['year'],
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $path = $image->store('products', 'public');

                    ProductImage::create([
                        'product_id' => $product->product_id,
                        'path'       => $path,
                        'position'   => $index,
                    ]);
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Product created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            // Log error (optional)
            Log::error('Product store failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withInput()->withErrors([
                'error' => $e->getMessage(),
            ]);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $product = Products::findOrFail($id);
        $ip = request()->ip();

        // Check if this IP already viewed recently
        $alreadyViewed = viewed::where('product_id', $product->id)
            ->where('ip_address', $ip)
            ->where('created_at', '>', now()->subHours(1)) // prevent multiple views in 1 hour
            ->exists();

        if (! $alreadyViewed) {
            Viewed::create([
                'product_id' => $product->id,
                'ip_address' => $ip,
            ]);
        }

        return view('product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'title'       => 'required|string|max:255',
                'description' => 'required|string',
                'price'       => 'required|numeric|min:0',
                'brand'       => 'required|string|max:255',
                'model'       => 'required|string|max:255',
                'year'        => 'required|string|max:4',
                'images'      => 'nullable|array',
                'images.*'    => 'nullable|image|mimes:jpg,jpeg,png',
            ]);

            DB::beginTransaction();

            $product = Products::findOrFail($id);

            $product->update([
                'title'       => $validated['title'],
                'description' => $validated['description'],
                'price'       => $validated['price'],
                'brand'       => $validated['brand'],
                'model'       => $validated['model'],
                'year'        => $validated['year'],
            ]);

            if ($request->hasFile('images')) {
                foreach ($product->images as $oldImage) {
                    Storage::disk('public')->delete($oldImage->path);
                    $oldImage->delete();
                }

                foreach ($request->file('images') as $index => $image) {
                    $path = $image->store('products', 'public');

                    ProductImage::create([
                        'product_id' => $product->product_id,
                        'path'       => $path,
                        'position'   => $index,
                    ]);
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Product updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Product update failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withInput()->withErrors([
                'error' => $e->getMessage(),
            ]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Products $product)
    {
        try {
            DB::beginTransaction();

            // Delete related images from storage
            foreach ($product->images as $image) {
                if (Storage::disk('public')->exists($image->path)) {
                    Storage::disk('public')->delete($image->path);
                }
            }

            // Delete related records in ProductImage table
            $product->images()->delete();

            // Delete the product itself
            $product->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Product deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Product delete failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withErrors(['error' => 'Failed to delete product.']);
        }
    }
}
