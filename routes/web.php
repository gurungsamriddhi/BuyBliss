<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
//using alias to avoid conflict when i call ProductController::class
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Public\ProductController as PublicProductController;
use App\Http\Controllers\Public\SellerController;
use App\Http\Controllers\CartController;



//function() ANONYMOUS
//get('routename', function());


//Public routes accessible to guest too
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about',[HomeController::class, 'about'])->name('about');
Route::get('/contact',[ContactController::class, 'index'])->name('contact');
Route::get('/become-seller', [SellerController::class, 'index'])->name('become-seller');
Route::get('/browse',[PublicProductController::class, 'index'])->name('browse');
Route::get('/product/{id}', [PublicProductController::class ,'show'])->name('product.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard/home', [AdminController::class, 'index'])->name('dashboard.home');

    // Add more admin routes
    Route::resource('products', AdminProductController::class);
    Route::resource('categories', CategoryController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add'); // Add this line
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
Route::get('/cart', [CartController::class, 'show'])->name('cart');
require __DIR__.'/auth.php';
