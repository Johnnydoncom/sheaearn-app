<?php

use App\Http\Controllers\ProductController;
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
Route::get('cart', 'CartController@index')->name('cart.index');
Route::post('cart', 'CartController@store')->name('cart.store');
Route::patch('cart', 'CartController@update')->middleware('has_cart')->name('cart.update');
Route::delete('cart/{id}', 'CartController@destroy')->middleware('has_cart')->name('cart.destroy');

Route::middleware(['auth', 'verified', 'has_cart'])->group(function () {
//        Route::get('cart', 'CartController@index')->name('cart.index');
//        Route::post('cart', 'CartController@store')->name('cart.store');
//        Route::patch('cart', 'CartController@update')->name('cart.update');
//        Route::delete('cart/{id}', 'CartController@destroy')->name('cart.destroy');

    Route::get('checkout', 'CheckoutController@index')->name('checkout.index');
    Route::post('checkout', 'CheckoutController@store')->name('checkout.store');
    Route::get('checkout/shipping', 'CheckoutController@shipping')->name('checkout.shipping');
    Route::get('checkout/shipping/add', 'CheckoutController@addShippingView')->name('checkout.shipping.add');
    Route::post('checkout/shipping/add', 'CheckoutController@addShipping')->name('checkout.shipping.store');
    Route::get('checkout/shipping/{address}/edit', 'CheckoutController@updateShippingView')->name('checkout.shipping.edit');
    Route::patch('checkout/shipping/{address}/edit', 'CheckoutController@updateShippingAddress')->name('checkout.shipping.update');

    Route::patch('checkout/shipping/{id}', 'CheckoutController@selectShipping')->name('checkout.shipping.select');

    Route::get('checkout/payment-method', 'CheckoutController@paymentMethod')->name('checkout.payment-method.index');
    Route::post('checkout/payment-method', 'CheckoutController@storePaymentMethod')->name('checkout.payment-method.store');

    Route::get('checkout/finish', 'CheckoutController@finish')->name('checkout.finish');
    Route::post('checkout/finish', 'CheckoutController@finalize')->name('checkout.submit');
});

Route::get('checkout/success/{order}', 'CheckoutController@success')->middleware(['signed','verified', 'auth'])->name('checkout.success');



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
