<?php

use App\Http\Controllers\ProductController;
use App\Http\Livewire\FinalizeCheckout;
use App\Http\Livewire\PaymentMethod;
use App\Http\Livewire\ShowCart;
use App\Http\Livewire\ShowCheckout;
use App\Notifications\Admin\AdminOrderPlaced;
use Illuminate\Support\Facades\Notification;
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


Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('index');
Route::get('blog', [\App\Http\Controllers\EntryController::class, 'index'])->name('blog.index');
Route::get('topic/{slug}', [\App\Http\Controllers\EntryController::class, 'category'])->name('blog.category');
Route::get('privacy-policy', [\App\Http\Controllers\HomeController::class, 'privacy'])->name('privacy-policy');

// Sponsored Ads
Route::get('sponsored-ads', [\App\Http\Controllers\AdsController::class, 'index'])->name('ads.index');
Route::get('sponsored-ads/{slug}', \App\Http\Livewire\ShowAds::class)->name('ads.show');

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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('special/checkout', \App\Http\Livewire\BundleCheckout::class)->name('bundle.checkout');
});

Route::get('checkout/success/{order}', function (\Illuminate\Http\Request $request, App\Models\Order $order){
    if (! $request->hasValidSignature()) {
        return redirect()->route('index');
    }

    return view('checkout-Success', [
        'order' => $order
    ]);
})->middleware(['signed','verified', 'auth'])->name('checkout.success');

Route::get('clear-cache', function (){
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    return 'Cache clear';
})->name('clear-cache');


Route::get('debit-user', function (){
    $user = App\Models\User::find(28);
//    $user->socialWallet()->withdraw(100);
    return \Illuminate\Support\Carbon::now(new DateTimeZone('Africa/Lagos'));



})->name('debit-user');

Route::get('/notification', function () {
    $order = \App\Models\Order::first();
    $user = \App\Models\User::find(1);

//    return $user->sendEmailVerificationNotification();
    Notification::route('mail', 'moriouly@gmail.com')
        ->notify(new AdminOrderPlaced($order));
});

Route::get('dashboard/login', [\App\Http\Controllers\Admin\DashboardController::class, 'showLogin'])->middleware('guest')->name( 'admin.login.show');
Route::post('dashboard/login', [\App\Http\Controllers\Admin\DashboardController::class, 'login'])->middleware('guest')->name( 'admin.login');

Route::prefix('account')->as('account.')->middleware(['auth','verified'])->group(function () {
    Route::get('/', [\App\Http\Controllers\Account\AccountController::class, 'index'])->name( 'index');

    // Order
    Route::prefix('order')->as('order.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Account\OrderController::class, 'index'])->name('index');
        Route::get('details/{order_number}', [\App\Http\Controllers\Account\OrderController::class, 'show'])->name('show');
        Route::delete('details/{orderItem}/cancel', [\App\Http\Controllers\Account\OrderController::class, 'cancelItem'])->name('cancelItem');
        Route::get('details/{order_number}/download', [\App\Http\Controllers\Account\OrderController::class, 'download'])->name('download');

        Route::get('track/{order_number}', [\App\Http\Controllers\Account\OrderController::class, 'track'])->name('track');
    });

    Route::get('wishlist', [\App\Http\Controllers\Account\AccountController::class, 'wishlist'])->name('wishlist.index');
    Route::delete('wishlist/{wishlist}', [\App\Http\Controllers\Account\AccountController::class, 'destroyWishlist'])->name('wishlist.destroy');


    Route::get('transactions', [\App\Http\Controllers\Account\TransactionsController::class, 'index'])->name('transactions.index');

    Route::get('settings', [\App\Http\Controllers\Account\AccountController::class, 'edit'])->name('settings.index');
    Route::post('settings', [\App\Http\Controllers\Account\AccountController::class, 'update'])->name('settings.store');
    Route::post('password', [\App\Http\Controllers\Account\AccountController::class, 'updatePassword'])->name('password.store');
    Route::post('bank-info', [\App\Http\Controllers\Account\AccountController::class, 'storeBank'])->name('bank.store');

    Route::get('withdraw-request', [\App\Http\Controllers\Account\AccountController::class, 'withdrawRequest'])->name('withdraw.index');

    Route::get('withdraw-request/{type}', [\App\Http\Controllers\Account\AccountController::class, 'withdrawRequest'])->whereIn('type', ['sales','social'])->name('withdraw.show');
    Route::post('withdraw-request/{type}', [\App\Http\Controllers\Account\AccountController::class, 'submitWithdrawRequest'])->whereIn('type', ['sales','social'])->name('withdraw.store');
});

Route::prefix('dashboard')->as('admin.')->middleware(['auth','verified', 'admin_auth'])->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('index');
    Route::resource('entries', \App\Http\Controllers\Admin\EntryController::class)->middleware('role:'.\App\Enums\UserRole::ADMIN.'|'.\App\Enums\UserRole::SUPERADMIN);
    Route::resource('topics', \App\Http\Controllers\Admin\TopicsController::class)->middleware('role:'.\App\Enums\UserRole::ADMIN.'|'.\App\Enums\UserRole::SUPERADMIN);

    Route::resource('ads', \App\Http\Controllers\Admin\AdsController::class)->middleware('role:'.\App\Enums\UserRole::ADMIN.'|'.\App\Enums\UserRole::SUPERADMIN);

    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class);

    Route::post('users/{user}/upgrade', [\App\Http\Controllers\Admin\UserController::class, 'upgrade'])->middleware('role:'.\App\Enums\UserRole::ADMIN.'|'.\App\Enums\UserRole::SUPERADMIN)->name('users.upgrade');
    Route::post('users/{user}/credit', [\App\Http\Controllers\Admin\UserController::class, 'credit'])->middleware('role:'.\App\Enums\UserRole::ADMIN.'|'.\App\Enums\UserRole::SUPERADMIN)->name('users.credit');

    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->middleware('role:'.\App\Enums\UserRole::ADMIN.'|'.\App\Enums\UserRole::SUPERADMIN);

    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);

    Route::get('categories', \App\Http\Livewire\Admin\CategoryController::class)->middleware('role:'.\App\Enums\UserRole::ADMIN.'|'.\App\Enums\UserRole::SUPERADMIN)->name('categories.index');


    Route::get('brands', \App\Http\Livewire\Admin\BrandsController::class)->middleware('role:'.\App\Enums\UserRole::ADMIN.'|'.\App\Enums\UserRole::SUPERADMIN)->name('brands.index');


    Route::post('/file-upload', [\App\Http\Controllers\Admin\DashboardController::class, 'fileUpload'])->name('file-upload');

    // Settings
    Route::get('settings', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->middleware('role:'.\App\Enums\UserRole::ADMIN.'|'.\App\Enums\UserRole::SUPERADMIN)->name('settings.index');
    Route::get('settings/earnings', [\App\Http\Controllers\Admin\SettingsController::class, 'earnings'])->middleware('role:'.\App\Enums\UserRole::ADMIN.'|'.\App\Enums\UserRole::SUPERADMIN)->name('settings.earnings');
    Route::get('settings/product', [\App\Http\Controllers\Admin\SettingsController::class, 'product'])->name('settings.shop');
    Route::post('settings', [\App\Http\Controllers\Admin\SettingsController::class, 'update'])->middleware('role:'.\App\Enums\UserRole::ADMIN.'|'.\App\Enums\UserRole::SUPERADMIN)->name('settings.store');

    // Coupons
    Route::get('coupons', \App\Http\Livewire\Admin\CouponCodes::class)->name('coupons.index');

    // Withdrawal
    Route::get('withdraw-requests', [\App\Http\Controllers\Admin\WithdrawController::class, 'index'])->name('withdraw.index');
    Route::patch('withdraw-requests/{withdrawRequest}', [\App\Http\Controllers\Admin\WithdrawController::class, 'update'])->name('withdraw.update');
});

require __DIR__.'/auth.php';

Route::get('/{slug?}', [\App\Http\Controllers\EntryController::class, 'show'])->where('slug', '[\w\d\-\_]+')->name('blog.show');
