<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function index()
    {
        $galeris = Galeri::latest()->paginate(12);
        return view('admin.gallery', compact('galeris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpg,jpeg,png',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('galeri', 'public'); // stored in storage/app/public/galeri
                Galeri::create(['path' => $path]);
            }
        }

        return redirect()->back()->with('success', 'Images uploaded successfully');
    }

    public function destroy($id)
    {
        $galeri = Galeri::findOrFail($id);

        // Only delete file if path exists and file is there
        if (!empty($galeri->path) && Storage::disk('public')->exists($galeri->path)) {
            Storage::disk('public')->delete($galeri->path);
        }

        $galeri->delete();

        return redirect()->back()->with('success', 'Image deleted successfully');
    }
}
