<?php

use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\BannersController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSideController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserSideController::class, 'indexHome'])->name('home');
Route::get('/product-page/{id}', [UserSideController::class, 'productPage'])->name('product-page');
Route::get('/products-catalogue', [UserSideController::class, 'indexProducts'])->name('products-catalogue');

Route::get('/sign-in', [SignInController::class, 'showLoginForm'])->name('login');
Route::post('/sign-in', [SignInController::class, 'login'])->name('login.attempt');
Route::post('/sign-out', [SignInController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('/banners', BannersController::class)->names('banners');
    Route::resource('/product', ProductsController::class)->names('product');
    Route::resource('/user', UserController::class)->names('user');
});
