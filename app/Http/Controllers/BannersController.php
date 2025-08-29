<?php

namespace App\Http\Controllers;

use App\Models\Banners;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BannersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activeBanners = Banners::where('is_active', true)->get();
        $banners = Banners::orderBy('order')->get();
        return view('admin.banners', ['banners' => $banners, 'activeBanners' => $activeBanners]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'banners.*.image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
                'banners.*.title' => 'nullable|string|max:255',
                'banners.*.order' => 'nullable|integer',
                'banners.*.is_active' => 'nullable|boolean',
            ]);

            foreach ($request->banners ?? [] as $bannerData) {
                // Skip if no image uploaded
                if (empty($bannerData['image'])) {
                    continue;
                }

                $path = $bannerData['image']->store('banners', 'public');

                Banners::create([
                    'title' => $bannerData['title'] ?? null,
                    'image' => $path,
                    'order' => $bannerData['order'] ?? 0,
                    'is_active' => $bannerData['is_active'] ?? true,
                ]);
            }

            return redirect()->back()->with('success', 'Banners created successfully!');
        } catch (\Exception $e) {
            // Optional: log the error
            Log::error('Banner store failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->withInput()->withErrors([
                'error' => 'Failed to save banners: ' . $e->getMessage(),
            ]);
        }
    }




    /**
     * Display the specified resource.
     */
    public function show(Banners $banners)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banners $banners)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banners $banners)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banners $banner)
    {
        try {
            // Delete the image file from storage if it exists
            if ($banner->image && Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }

            // Delete the banner record
            $banner->delete();

            return redirect()->back()->with('success', 'Banner deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Banner delete failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->withErrors([
                'error' => 'Failed to delete banner: ' . $e->getMessage(),
            ]);
        }
    }
}
