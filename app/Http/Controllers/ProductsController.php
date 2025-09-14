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


    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title'        => 'required|string|max:255',
                'subtitle'     => 'required|string|max:255',
                'description'  => 'required|string',
                'price'        => 'required|numeric|min:0',
                'brand'        => 'required|string|max:255',
                'model'        => 'required|string|max:255',
                'year'         => 'required|string|max:4',
                'images'       => 'nullable|array',
                'images.*'     => 'nullable|image|mimes:jpg,jpeg,png',
                'articleimage' => 'nullable|image|mimes:jpg,jpeg,png',
            ]);

            DB::beginTransaction();

            // ✅ Handle article image first (optional)
            $articleImagePath = null;
            if ($request->hasFile('articleimage')) {
                $articleImagePath = $request->file('articleimage')->store('products/article', 'public');
            }

            // ✅ Create product with article image
            $product = Products::create([
                'title'         => $validated['title'],
                'subtitle'      => $validated['subtitle'],
                'description'   => $validated['description'],
                'price'         => $validated['price'],
                'brand'         => $validated['brand'],
                'model'         => $validated['model'],
                'year'          => $validated['year'],
                'articleimage' => $articleImagePath, // make sure column exists
            ]);

            // ✅ Handle gallery images
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

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'title'        => 'required|string|max:255',
                'subtitle'     => 'required|string|max:255',
                'description'  => 'required|string',
                'price'        => 'required|numeric|min:0',
                'brand'        => 'required|string|max:255',
                'model'        => 'required|string|max:255',
                'year'         => 'required|string|max:4',
                'images'       => 'nullable|array',
                'images.*'     => 'nullable|image|mimes:jpg,jpeg,png',
                'articleimage' => 'nullable|image|mimes:jpg,jpeg,png',
            ]);

            DB::beginTransaction();

            $product = Products::findOrFail($id);

            $product->update([
                'title'       => $validated['title'],
                'subtitle'    => $validated['subtitle'],
                'description' => $validated['description'],
                'price'       => $validated['price'],
                'brand'       => $validated['brand'],
                'model'       => $validated['model'],
                'year'        => $validated['year'],
            ]);

            // ✅ Handle gallery images
            if ($request->hasFile('images')) {
                // delete old gallery
                foreach ($product->images as $oldImage) {
                    Storage::disk('public')->delete($oldImage->path);
                    $oldImage->delete();
                }

                // upload new gallery
                foreach ($request->file('images') as $index => $image) {
                    $path = $image->store('products', 'public');

                    ProductImage::create([
                        'product_id' => $product->product_id,
                        'path'       => $path,
                        'position'   => $index,
                    ]);
                }
            }

            // ✅ Handle article cover image
            if ($request->hasFile('articleimage')) {
                // delete old article image if exists
                if ($product->article_image) {
                    Storage::disk('public')->delete($product->article_image);
                }

                $articleImagePath = $request->file('articleimage')->store('products', 'public');

                $product->update([
                    'articleimage' => $articleImagePath
                ]);
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
