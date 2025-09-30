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
        $products = Products::with([
            'images' => function ($q) {
                $q->orderBy('position', 'asc');
            }
        ])->paginate(10);
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
                // accept both images & pdf
                'articleimage' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            ]);

            DB::beginTransaction();

            // Handle article image/pdf
            $articleImagePath = null;
            if ($request->hasFile('articleimage')) {
                $extension = $request->file('articleimage')->getClientOriginalExtension();

                // store PDFs in a different folder if you like
                if ($extension === 'pdf') {
                    $articleImagePath = $request->file('articleimage')->store('products/article/pdfs', 'public');
                } else {
                    $articleImagePath = $request->file('articleimage')->store('products/article/images', 'public');
                }
            }

            // Create product
            $product = Products::create([
                'title'        => $validated['title'],
                'subtitle'     => $validated['subtitle'],
                'description'  => $validated['description'],
                'price'        => $validated['price'],
                'brand'        => $validated['brand'],
                'model'        => $validated['model'],
                'year'         => $validated['year'],
                'articleimage' => $articleImagePath, // store path regardless of file type
            ]);

            // Handle gallery images
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

        // dd($request->all());
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
                'articleimage' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
                'image_order'  => 'nullable|string', // JSON from hidden input
            ]);

            DB::beginTransaction();

            $product = Products::findOrFail($id);

            // 🔹 Update base fields
            $product->update([
                'title'       => $validated['title'],
                'subtitle'    => $validated['subtitle'],
                'description' => $validated['description'],
                'price'       => $validated['price'],
                'brand'       => $validated['brand'],
                'model'       => $validated['model'],
                'year'        => $validated['year'],
            ]);

            // 🔹 Add new gallery images (don't delete old ones)
            $newFiles = $request->file('images', []);
            $newIndex = 0;

            // 🔹 Process ordering (both existing + new)
            if ($request->filled('image_order')) {
                $order = json_decode($request->input('image_order'), true);

                foreach ($order as $item) {
                    if (isset($item['id'])) {
                        // existing image → just reorder
                        ProductImage::where('id', $item['id'])
                            ->where('product_id', $product->product_id)
                            ->update(['position' => $item['position']]);
                    } elseif (isset($item['tempId']) && isset($newFiles[$newIndex])) {
                        // new image → create at correct position
                        $path = $newFiles[$newIndex]->store('products', 'public');
                        ProductImage::create([
                            'product_id' => $product->product_id,
                            'path'       => $path,
                            'position'   => $item['position'],
                        ]);
                        $newIndex++;
                    }
                }
            } else {
                // fallback: if no order info, just append new images at the end
                $lastPos = $product->images()->max('position') ?? 0;
                foreach ($newFiles as $i => $file) {
                    $path = $file->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->product_id,
                        'path'       => $path,
                        'position'   => $lastPos + $i + 1,
                    ]);
                }
            }

            // 🔹 Handle article image / PDF
            if ($request->hasFile('articleimage')) {
                if ($product->articleimage) {
                    Storage::disk('public')->delete($product->articleimage);
                }

                $extension = $request->file('articleimage')->getClientOriginalExtension();
                if ($extension === 'pdf') {
                    $articleImagePath = $request->file('articleimage')->store('products/article/pdfs', 'public');
                } else {
                    $articleImagePath = $request->file('articleimage')->store('products/article/images', 'public');
                }

                $product->update([
                    'articleimage' => $articleImagePath
                ]);
            }

            // Handle deleted images
            if ($request->filled('deleted_images')) {
                $deleted = json_decode($request->deleted_images, true);
                foreach ($deleted as $id) {
                    $img = ProductImage::find($id);
                    if ($img) {
                        Storage::disk('public')->delete($img->path);
                        $img->delete();
                    }
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
