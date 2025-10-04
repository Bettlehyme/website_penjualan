<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use App\Models\Products;
use App\Models\viewed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\PdfToImage\Pdf;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Products::with(['articleImages', 'galleryImages'])->paginate(10);
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
                'articleimage' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            ]);

            DB::beginTransaction();

            $articleImagePaths = [];

            if ($request->hasFile('articleimage')) {
                $extension = strtolower($request->file('articleimage')->getClientOriginalExtension());

                if ($extension === 'pdf') {
                    // Save temp PDF in storage
                    $pdfPath = $request->file('articleimage')->store('temp', 'public');
                    $pdfFile = Storage::disk('public')->path($pdfPath);

                    // Output directory for converted images
                    $outputDir = Storage::disk('public')->path('products/article/images');
                    if (!file_exists($outputDir)) {
                        mkdir($outputDir, 0777, true);
                    }

                    // Convert all pages of the PDF into images using Poppler
                    // Example: pdftoppm -jpeg -r 150 input.pdf output/page
                    $outputPrefix = $outputDir . '/page';
                    $command = "pdftoppm -jpeg -r 150 " . escapeshellarg($pdfFile) . " " . escapeshellarg($outputPrefix);
                    exec($command, $output, $returnCode);

                    if ($returnCode !== 0) {
                        throw new \Exception("Failed to convert PDF using Poppler (pdftoppm).");
                    }

                    // Collect generated images (page-1.jpg, page-2.jpg, etc.)
                    $generatedImages = glob($outputDir . '/page-*.jpg');
                    sort($generatedImages);

                    foreach ($generatedImages as $imagePath) {
                        // Save relative path for database (public storage)
                        $relativePath = 'products/article/images/' . basename($imagePath);
                        $articleImagePaths[] = $relativePath;
                    }

                    // Remove temp PDF
                    Storage::disk('public')->delete($pdfPath);
                } else {
                    $articleImagePaths[] = $request->file('articleimage')->store('products/article/images', 'public');
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
                'articleimage' => $articleImagePaths[0] ?? null, // save first page as preview
            ]);

            // Save article images (pdf pages or single image)
            foreach ($articleImagePaths as $index => $path) {
                ProductImage::create([
                    'product_id' => $product->product_id,
                    'path'       => $path,
                    'position'   => $index,
                    'type'       => 'article',
                ]);
            }

            // Handle gallery images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $path = $image->store('products', 'public');

                    ProductImage::create([
                        'product_id' => $product->product_id,
                        'path'       => $path,
                        'position'   => $index + count($articleImagePaths),
                        'type'       => 'gallery',
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
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
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
            ]);

            DB::beginTransaction();

            $product = Products::findOrFail($id);
            $articleImagePaths = [];

            // ✅ Handle new article image upload
            if ($request->hasFile('articleimage')) {
                // delete old article images
                $oldArticleImages = ProductImage::where('product_id', $product->product_id)
                    ->where('type', 'article')
                    ->get();

                foreach ($oldArticleImages as $oldImg) {
                    Storage::disk('public')->delete($oldImg->path);
                    $oldImg->delete();
                }

                $extension = strtolower($request->file('articleimage')->getClientOriginalExtension());
                if ($extension === 'pdf') {
                    throw new \Exception("PDF upload disabled — only images are allowed now.");
                } else {
                    $articleImagePaths[] = $request->file('articleimage')->store('products/article/images', 'public');
                }
            }

            // ✅ Update product main fields
            $product->update([
                'title'        => $validated['title'],
                'subtitle'     => $validated['subtitle'],
                'description'  => $validated['description'],
                'price'        => $validated['price'],
                'brand'        => $validated['brand'],
                'model'        => $validated['model'],
                'year'         => $validated['year'],
                'articleimage' => $articleImagePaths[0] ?? $product->articleimage,
            ]);

            // ✅ Save new article image if uploaded
            foreach ($articleImagePaths as $index => $path) {
                ProductImage::create([
                    'product_id' => $product->product_id,
                    'path'       => $path,
                    'position'   => $index,
                    'type'       => 'article',
                ]);
            }

            // ✅ Handle new gallery uploads (if any)
            if ($request->hasFile('images')) {
                $currentMaxPos = ProductImage::where('product_id', $product->product_id)
                    ->where('type', 'gallery')
                    ->max('position') ?? 0;

                foreach ($request->file('images') as $index => $image) {
                    $path = $image->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->product_id,
                        'path'       => $path,
                        'position'   => $currentMaxPos + $index + 1,
                        'type'       => 'gallery',
                    ]);
                }
            }

            // ✅ Handle image reordering (from drag & drop)
            // dd(json_decode($request->input('image_order'), true));
            if ($request->filled('image_order')) {
                $orderData = json_decode($request->input('image_order'), true);

                if (is_array($orderData)) {
                    foreach ($orderData as $item) {
                        if (!empty($item['id'])) {
                            $image = ProductImage::findOrFail($item['id']); // throws 404 if not found
                            $image->update(['position' => $item['position']]);
                        }
                    }
                }
            }


            // ✅ Handle deleted images
            if ($request->filled('deleted_images')) {
                $deletedIds = json_decode($request->input('deleted_images'), true);
                if (is_array($deletedIds) && count($deletedIds)) {
                    $images = ProductImage::whereIn('id', $deletedIds)->get();
                    foreach ($images as $img) {
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
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
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
