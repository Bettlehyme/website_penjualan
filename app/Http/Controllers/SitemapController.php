<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Models\Products;
use App\Models\Article;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = [
            route('home'),
            route('articles-list'),
            route('products-catalogue'),
            route('price-list'),
            route('gallery-list'),
        ];

        return response()
            ->view('sitemaps.index', compact('urls'))
            ->header('Content-Type', 'application/xml');
    }

    public function products(): Response
    {
        $items = Products::latest()->get();

        return response()
            ->view('sitemaps.products', compact('items'))
            ->header('Content-Type', 'application/xml');
    }

    public function articles(): Response
    {
        $items = Article::latest()->get();

        return response()
            ->view('sitemaps.articles', compact('items'))
            ->header('Content-Type', 'application/xml');
    }
}
