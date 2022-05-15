<?php

use App\Http\Controllers\ProductController;
use App\Http\Livewire\FinalizeCheckout;
use App\Http\Livewire\PaymentMethod;
use App\Http\Livewire\ShowCart;
use App\Http\Livewire\ShowCheckout;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('index');
Route::get('blog', [\App\Http\Controllers\EntryController::class, 'index'])->name('blog.index');
Route::get('topic/{slug}', [\App\Http\Controllers\EntryController::class, 'category'])->name('blog.category');



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


// Shop
Route::get('catalog', [ProductController::class, 'index'])->name('product.index');
Route::get('category/{slug}', [ProductController::class, 'category'])->name('category.index');
Route::get('product/{slug}', \App\Http\Livewire\Product\ShowProduct::class)->name('product.show');
Route::get('product/{slug}/details', [ProductController::class, 'details'])->name('product.details');
Route::get('product/{slug}/reviews', [ProductController::class, 'reviews'])->name('product.reviews');

Route::post('product/{slug}/wishlist', [ProductController::class, 'storeWishlist'])->middleware('auth')->name('product.wishlist.store');


// shop cart Controller
Route::get('cart', ShowCart::class)->name('cart.index');

Route::middleware(['auth', 'verified', 'has_cart'])->group(function () {
    Route::get('checkout', ShowCheckout::class)->name('checkout.index');
    // Route::post('checkout', 'CheckoutController@store')->name('checkout.store');
    Route::get('checkout/shipping', \App\Http\Livewire\ShippingAddress::class)->name('checkout.shipping');

    Route::get('checkout/payment-method', PaymentMethod::class)->name('checkout.payment-method.index');

    Route::get('checkout/finish', FinalizeCheckout::class)->name('checkout.finish');
});

//Route::get('checkout/success/{order}', 'CheckoutController@success')->middleware(['signed','verified', 'auth'])->name('checkout.success');



Route::get('dashboard/login', [\App\Http\Controllers\Admin\DashboardController::class, 'showLogin'])->middleware('guest')->name( 'admin.login.show');
Route::post('dashboard/login', [\App\Http\Controllers\Admin\DashboardController::class, 'login'])->middleware('guest')->name( 'admin.login');

Route::prefix('account')->as('account.')->middleware(['auth','verified'])->group(function () {
    Route::get('/', [\App\Http\Controllers\Account\AccountController::class, 'index'])->name( 'index');

});

Route::prefix('dashboard')->as('admin.')->middleware(['auth','verified'])->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('index');
    Route::resource('entries', \App\Http\Controllers\Admin\EntryController::class);
    Route::resource('topics', \App\Http\Controllers\Admin\TopicsController::class);

    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::get('categories', [\App\Http\Controllers\Admin\ProductController::class, 'categories'])->name('categories.index');

    Route::post('/file-upload', [\App\Http\Controllers\Admin\DashboardController::class, 'fileUpload'])->name('file-upload');

});

require __DIR__.'/auth.php';

Route::get('/{slug?}', [\App\Http\Controllers\EntryController::class, 'show'])->where('slug', '[\w\d\-\_]+')->name('blog.show');
