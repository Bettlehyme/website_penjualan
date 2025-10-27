<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\BannersController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\SiteSettingsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSideController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserSideController::class, 'indexHome'])->name('home');
Route::get('/model/{id}', [UserSideController::class, 'productPage'])->name('product-page');
Route::get('/model', [UserSideController::class, 'indexProducts'])->name('products-catalogue');
Route::get('/artikel', [UserSideController::class, 'indexArticle'])->name('articles-list');
Route::get('/artikel/{id}', [UserSideController::class, 'articlePage'])->name('article-page');
Route::get('/price list', [UserSideController::class, 'indexPriceList'])->name('price-list');
Route::get('/galeri', [UserSideController::class, 'indexGallery'])->name('gallery-list');

Route::get('/view-file/{path}', function ($path) {
    $file = storage_path('app/public/' . $path);

    if (!file_exists($file)) {
        abort(404);
    }

    $mime = File::mimeType($file);

    // Force inline view, not download
    return response()->file($file, [
        'Content-Type'        => $mime,
        'Content-Disposition' => 'inline; filename="' . basename($file) . '"'
    ]);
})->where('path', '.*');

Route::get('/sign-in', [SignInController::class, 'showLoginForm'])->name('login');
Route::post('/sign-in', [SignInController::class, 'login'])->name('login.attempt');


Route::post('/sign-out', [SignInController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    Route::resource('/banners', BannersController::class)->names('banners');
    Route::resource('/product', ProductsController::class)->names('product');
    Route::resource('/article', ArticleController::class)->names('article');
    Route::resource('/gallery', GaleriController::class)->names('gallery');
    Route::get('/site-settings', [SiteSettingsController::class, 'index'])->name('site-settings.index');
    Route::put('/site-settings', [SiteSettingsController::class, 'update'])->name('site-settings.update');
    Route::resource('/user', UserController::class)->names('user');
});


Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.index');
Route::get('/sitemap-products.xml', [SitemapController::class, 'products'])->name('sitemap.products');
Route::get('/sitemap-articles.xml', [SitemapController::class, 'articles'])->name('sitemap.articles');
