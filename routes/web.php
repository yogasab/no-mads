<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Detail\DetailController;
use App\Http\Controllers\Checkout\CheckoutController;
use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\Transaction\TransactionController;
use App\Http\Controllers\Admin\Travel\TravelPackageController;
use App\Http\Controllers\Admin\TravelGallery\TravelGalleryController;
use App\Http\Controllers\Midtrans\MidtransController;
use Illuminate\Support\Facades\Auth;

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


Route::get('', [HomeController::class, 'index'])->name('home');

Route::get('/detail/{travel_package}', [DetailController::class, 'index'])->name('detail');

Route::get('/checkout/{transaction}', [CheckoutController::class, 'index'])
    ->name('checkout');
Route::post('/checkout/{travel_package}', [CheckoutController::class, 'store'])
    ->name('checkout.store');
Route::post('/checkout/add-member/{transaction}', [CheckoutController::class, 'addMember'])
    ->name('checkout.add-member');
Route::get('/checkout/remove-member/{transaction_detail}', [CheckoutController::class, 'removeMember'])
    ->name('checkout.remove-member');
Route::get('/checkout/confirm/{transaction}', [CheckoutController::class, 'success'])
    ->name('checkout.success');


Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout-success');

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::resource('travel-package', TravelPackageController::class);
    Route::resource('travel-gallery', TravelGalleryController::class);
    Route::resource('transaction', TransactionController::class);
});

// Auth::routes(['verify' => true]);
// Midtrans Routes
Route::post('/midtrans/callback', [MidtransController::class, 'notificationHandler']);
Route::get('/midtrans/finish', [MidtransController::class, 'finishRedirect']);
Route::get('/midtrans/unfinish', [MidtransController::class, 'unfinishRedirect']);
Route::get('/midtrans/error', [MidtransController::class, 'errorRedirect']);
require __DIR__ . '/auth.php';
