<?php

namespace App\Http\Controllers;

use App\Models\Banners;
use App\Models\Products;
use Illuminate\Http\Request;

class UserSideController extends Controller
{
    public function indexHome()
    {
        $products = Products::with('images')->limit(3)->get();
        // dd($products);
        $activeBanners = Banners::where('is_active', true)->get();
        $banners = Banners::orderBy('order')->get();
        return view('user.home', ['banners' => $banners, 'activeBanners' => $activeBanners, 'products' => $products]);
    }

    public function productPage($id)
    {
        $products = Products::with('images')->limit(3)->get();

        $product = Products::with('images')
            ->where('product_id', decrypt($id))
            ->firstOrFail();

        return view('user.product-page', ['product' => $product, 'products' => $products]);
    }

    public function indexProducts(Request $request)
    {
        $query = Products::with('images');

 
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

      
        $products = $query->paginate(8)->withQueryString();

        return view('user.products-catalogue', compact('products'));
    }
}
