<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Banners;
use App\Models\Galeri;
use App\Models\Products;
use Illuminate\Http\Request;

class UserSideController extends Controller
{
    public function indexHome()
    {
        $products = Products::with('images')->limit(4)->get();
        $articles = Article::limit(4)->get();
        $gallery = Galeri::limit(4)->get();

        $activeBanners = Banners::where('is_active', true)->get();
        $banners = Banners::orderBy('order')->get();
        return view('user.home', ['banners' => $banners, 'activeBanners' => $activeBanners, 'products' => $products, 'products' => $products, 'articles' => $articles, 'gallery' => $gallery]);
    }

    public function indexPriceList()
    {
        return view('user.price-list');
    }

    public function indexArticle(Request $request)
    {
        $query = Article::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $articles = $query->latest()->paginate(8)->withQueryString();

        return view('user.articles', compact('articles'));
    }

    public function indexGallery()
    {
        $gallery = Galeri::get();
        return view('user.gallery', ['gallery' => $gallery]);
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
    public function productPage($id)
    {
        $products = Products::with('images')->limit(4)->get();
        $articles = Article::limit(4)->get();
        $product = Products::with(['images' => function ($q) {
            $q->orderBy('position', 'asc'); // or 'desc' if you want reverse order
        }])
            ->where('product_id', decrypt($id))
            ->firstOrFail();


        return view('user.product-page', ['product' => $product, 'products' => $products, 'articles' => $articles]);
    }
    public function articlePage($id)
    {
        $products = Products::with('images')->limit(4)->get();
        $articles = Article::limit(4)->get();
        $article = Article::where('id', decrypt($id))
            ->firstOrFail();

        return view('user.article-page', ['article' => $article, 'products' => $products, 'articles' => $articles]);
    }
}
